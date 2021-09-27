<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ToggleCityEnableDisable extends Cab5Api {

    const CITY_ID = "city_id";

    private ?CityEntity $cityEntity;

    protected function onAssemble() {
        if (!isset($_POST[self::CITY_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CITY_ID);
        }

        $this->cityEntity = $this->getCab5db()->getCityDao()->getCityWithId($_POST[self::CITY_ID]);
    }

    protected function onDevise() {
        if ($this->cityEntity === null) {
            $this->killAsGoneRequest([
                'city_does_not_exist' => true
            ]);
        }

        $this->cityEntity->setEnabled(!$this->cityEntity->isEnabled()); // Toggling

        $this->cityEntity = $this->getCab5db()->getCityDao()
            ->updateEnabledState(
                $this->cityEntity->getId(),
                $this->cityEntity->isEnabled()
            );

        if ($this->cityEntity === null) {
            $this->killAsFailure([
                'failed_to_toggle_city_enable_disable' => true
            ]);
        }

        $this->resSendOK([
            'city' => [
                'toggled' => true,
                CityTableSchema::ENABLED => $this->cityEntity->isEnabled(),
            ]
        ]);
    }
}