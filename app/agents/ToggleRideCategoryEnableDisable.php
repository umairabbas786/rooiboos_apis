<?php

class ToggleRideCategoryEnableDisable extends Cab5Api {

    const RIDE_CATEGORY_ID = "ride_category_id";

    private ?RideCategoryEntity $rideCategoryEntity;

    protected function onAssemble() {
        if (!isset($_POST[self::RIDE_CATEGORY_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::RIDE_CATEGORY_ID);
        }

        $this->rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($_POST[self::RIDE_CATEGORY_ID]);
    }

    protected function onDevise() {

        if ($this->rideCategoryEntity === null) {
            $this->killAsGoneRequest([
                'ride_category_not_found' => true
            ]);
        }

        $this->rideCategoryEntity->setEnabled(!$this->rideCategoryEntity->isEnabled());

        $this->rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->updateRideCategoryEnableStatus(
            $this->rideCategoryEntity->getId(),
            $this->rideCategoryEntity->isEnabled()
        );

        if ($this->rideCategoryEntity === null) {
            $this->killAsFailure([
                'failed_to_toggle_ride_category' => true
            ]);
        }

        $this->resSendOK([
            'toggled' => true,
            'enabled' => $this->rideCategoryEntity->isEnabled()
        ]);
    }
}