<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ToggleDriverRideCategory extends Cab5Api {

    const RIDE_CATEGORY_ID = "ride_category_id";

    private ?DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::RIDE_CATEGORY_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::RIDE_CATEGORY_ID);
        }
    }

    protected function onDevise() {
        $driver_ride_categories = $this->getCab5db()->getDriverRideCategoryDao()->getDriverRideCategoriesByDriverId($this->driverEntity->getId());

        /** @var DriverRideCategoryEntity $target */
        $target = null;

        /** @var DriverRideCategoryEntity $driver_ride_category */
        foreach ($driver_ride_categories as $driver_ride_category) {
            if ($driver_ride_category->getRideCategoryId() === $_POST[self::RIDE_CATEGORY_ID]) {
                $target = $driver_ride_category;
                break;
            }
        }

        $toggleState = false;

        if ($target !== null) { // if target exist in db, then deleting it
            if (!$this->getCab5db()->getDriverRideCategoryDao()->deleteDriverRideCategoryById($target->getId())) {
                $this->killAsFailure([
                    'failed_to_delete_existing_target' => true
                ]);
            }
        } else { // inserting it
            $createTime = Carbon::now();

            $driverRideCategory = $this->getCab5db()->getDriverRideCategoryDao()->insertDriverRideCategory(new DriverRideCategoryEntity(
                Uuid::uuid4()->toString(),
                $this->driverEntity->getId(),
                $_POST[self::RIDE_CATEGORY_ID],
                $createTime,
                $createTime
            ));

            if ($driverRideCategory === null) {
                $this->killAsFailure([
                    'failed_to_insert_new_target' => true
                ]);
            }

            $toggleState = true;
        }

        $this->resSendOK([
            'toggled' => $toggleState
        ]);
    }
}