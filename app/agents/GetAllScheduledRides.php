<?php

class GetAllScheduledRides extends Cab5Api {

    protected function onDevise() {
        $scheduledRides = $this->getCab5db()->getScheduleRideDao()->getAllScheduledRides();

        $data = [];

        /** @var ScheduleRideEntity $scheduledRide */
        foreach ($scheduledRides as $scheduledRide) {
            $passenger = $this->getCab5db()->getPassengerDao()->getPassengerWithId($scheduledRide->getPassengerId());
            $passengerAvatar = $this->getCab5db()->getPassengerAvatarDao()->getAvatarOfPassenger($scheduledRide->getPassengerId());

            array_push($data, [
                'schedule_ride_id' => $scheduledRide->getId(),
                'passenger_first_name' => $passenger->getFirstName(),
                'passenger_last_name' => $passenger->getLastName(),
                'passenger_avatar' => $this->createLinkForPassengerAvatarImage($passengerAvatar->getAvatar()),
                'passenger_email' => $passenger->getEmail(),
                'passenger_phone' => $passenger->getPhone(),
                'schedule_at' => $scheduledRide->getScheduleAt(),
                'pickup_location' => $scheduledRide->getPickupLocationName()
            ]);
        }

        $this->resSendOK([
            'scheduled_rides' => $data
        ]);
    }
}