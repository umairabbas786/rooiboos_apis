<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class SchedulePassengerRide extends Cab5Api {

    const PASSENGER_LONGITUDE = "lng";
    const PASSENGER_LATITUDE = "lat";
    const PICKUP_LOCATION_NAME = "pickup_loc_name";

    const RIDE_CATEGORY_ID = "ride_category_id";
    const SCHEDULE_AT = "schedule_at";

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onAssemble() {
        $required_fields = [
            self::PASSENGER_LONGITUDE,
            self::PASSENGER_LATITUDE,
            self::PICKUP_LOCATION_NAME,
            self::RIDE_CATEGORY_ID,
            self::SCHEDULE_AT
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {
        $createTime = Carbon::now();

        $scheduledRideEntity = $this->getCab5db()->getScheduleRideDao()->insertScheduleRideEntity(new ScheduleRideEntity(
            Uuid::uuid4()->toString(),
            $this->passengerEntity->getId(),
            $_POST[self::PASSENGER_LONGITUDE],
            $_POST[self::PASSENGER_LATITUDE],
            $_POST[self::PICKUP_LOCATION_NAME],
            $_POST[self::SCHEDULE_AT],
            false,
            $_POST[self::RIDE_CATEGORY_ID],
            $createTime,
            $createTime
        ));

        if ($scheduledRideEntity === null) {
            $this->killAsFailure([
                'failed_to_schedule_ride' => true
            ]);
        }

        $this->resSendOK([
            'ride_scheduled' => true
        ]);
    }
}