<?php

class GetPassengerScheduledRides extends Cab5Api {

    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $scheduledRides = $this->getCab5db()->getScheduleRideDao()->getMyScheduledRides($this->passengerEntity->getId());

        $data = [];

        /** @var ScheduleRideEntity $scheduledRide */
        foreach ($scheduledRides as $scheduledRide) {
            $rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($scheduledRide->getRideCategoryId());

            array_push($data, [
                ScheduleRidesTableSchema::ID => $scheduledRide->getId(),
                ScheduleRidesTableSchema::SCHEDULE_AT => $scheduledRide->getScheduleAt(),
                'ride_category_name' => $rideCategoryEntity->getName(),
                ScheduleRidesTableSchema::PICKUP_LOCATION_NAME => $scheduledRide->getPickupLocationName()
            ]);
        }

        $this->resSendOK([
            'scheduled_rides' => $data
        ]);
    }
}