<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UpdateCity extends Cab5Api {

    const CITY_ID = "city_id";
    const CITY_NAME = "city_name";
    const ENABLED = "enabled";

    const Y = "Y";
    const N = "N";

    protected function onAssemble() {
        if (!isset($_POST[self::CITY_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CITY_ID);
        }
        if (!isset($_POST[self::CITY_NAME])) {
            $this->killAsBadRequestWithMissingParamException(self::CITY_NAME);
        }
        if (!isset($_POST[self::ENABLED])) {
            $this->killAsBadRequestWithMissingParamException(self::ENABLED);
        }
        if (!in_array($_POST[self::ENABLED], [self::Y, self::N])) {
            $this->killAsBadRequestWithInvalidValueForParam(self::ENABLED);
        }
    }

    protected function onDevise() {
        $cityEntity = $this->getCab5db()->getCityDao()->getCityWithId($_POST[self::CITY_ID]);

        if ($cityEntity === null) {
            $this->killAsFailure([
                'no_city_found' => true
            ]);
        }

        if ($cityEntity->getName() !== $_POST[self::CITY_NAME]) {
            if ($this->getCab5db()->getCityDao()->getCityWithName($_POST[self::CITY_NAME]) !== null) {
                $this->killAsFailure([
                    "city_already_exist" => true
                ]);
            }
        }

        $cityEntity->setName($_POST[self::CITY_NAME]);
        $cityEntity->setEnabled($_POST[self::ENABLED] === self::Y);
        $cityEntity->setUpdatedAt(Carbon::now());

        $cityEntity = $this->getCab5db()->getCityDao()->updateCityEntity($cityEntity);

        if ($cityEntity === null) {
            $this->killAsFailure([
                'failed_to_updated_city' => true
            ]);
        }

        $this->resSendOK([
            'city' => [
                CityTableSchema::ID => $cityEntity->getId(),
                CityTableSchema::NAME => $cityEntity->getName(),
                CityTableSchema::ENABLED => $cityEntity->isEnabled(),
                CityTableSchema::CREATED_AT => $cityEntity->getCreatedAt(),
                CityTableSchema::UPDATED_AT => $cityEntity->getUpdatedAt()
            ]
        ]);
    }
}