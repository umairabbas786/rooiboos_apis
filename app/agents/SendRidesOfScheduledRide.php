<?php

use Carbon\Carbon;
use Location\Coordinate;
use Location\Distance\Haversine;
use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use Ramsey\Uuid\Uuid;

class SendRidesOfScheduledRide extends Cab5Api {

    const SCHEDULED_RIDE_ID = "scheduled_ride_id";

    private Haversine $haversineCalculator;

    protected function onAssemble() {
        if (!isset($_POST[self::SCHEDULED_RIDE_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::SCHEDULED_RIDE_ID);
        }

        $this->haversineCalculator = new Haversine();
    }

    protected function onDevise() {
        $scheduledRide = $this->getCab5db()->getScheduleRideDao()->getScheduleRideEntityWithId($_POST[self::SCHEDULED_RIDE_ID]);

        if ($scheduledRide === null) {
            $this->killAsFailure([
                'no_scheduled_ride_found' => true
            ]);
        }

        $previousInCompleteRides = $this->getCab5db()->getRideDao()->getPassengerRidesWhichAreNotCompletedExcludingUserCancelledRides($scheduledRide->getPassengerId());

        if (count($previousInCompleteRides) >= 1) {
            $this->killAsFailure([
                'passenger_already_have_incomplete_rides' => true
            ]);
        }

        $chosen_drivers_for_rides = [];

        $all_drivers = $this->getCab5db()->getDriverDao()->getDriversForSendingRideThoseWhoHaveRideCategoryIdOf($scheduledRide->getRideCategoryId());
        $passenger_coordinate = new Coordinate($scheduledRide->getPickupLatitude(), $scheduledRide->getPickupLongitude());

        $message = new FcmMessage();

        /** @var DriverEntity $driver */
        foreach($all_drivers as $driver) {
            $driver_coordinate = new Coordinate($driver->getLatitude(), $driver->getLongitude());
            $driver_distance = $passenger_coordinate->getDistance($driver_coordinate, $this->haversineCalculator); // returns in Meter

            $range = 10 * 1000; // 10KM = 10000Meter

            if ($driver_distance <= $range) {
                $message->addRecipient(new FcmDevice($driver->getFcmToken()));
                array_push($chosen_drivers_for_rides, $driver);

                $createTime = Carbon::now();

                $this->getCab5db()->getRideDao()->insertRideEntity(new RideEntity(
                    Uuid::uuid4()->toString(),
                    $scheduledRide->getPassengerId(),
                    $driver->getId(),
                    $scheduledRide->getPickupLongitude(),
                    $scheduledRide->getPickupLatitude(),
                    $scheduledRide->getPickupLocationName(),
                    RideState::SENT_REQUEST_TO_DRIVER,
                    null,
                    null,
                    null,
                    null,
                    $scheduledRide->getRideCategoryId(),
                    $createTime,
                    $createTime
                ));
            }
        }

        $message->setPriority('high')
            ->setTimeToLive(4 * 3600)
            ->setData([
                'title' => 'New Ride',
                'body' => 'You got a new ride'
            ]);

        $rides_notification_sent = null;
        if (count($chosen_drivers_for_rides) >= 1) { // Sending Push Notification only if drivers are available
            $response = $this->getFcmClient()->send($message);
            $rides_notification_sent = $response->getStatusCode() === 200;
        }

        $scheduledRide = $this->getCab5db()->getScheduleRideDao()->updateScheduledRideToScheduled($scheduledRide->getId());

        if ($scheduledRide === null) {
            $this->killAsFailure([
                'failed_to_schedule_ride' => true
            ]);
        }

        $this->resSendOK([
            'drivers_count' => count($chosen_drivers_for_rides),
            'rides_sent_to_drivers' => count($chosen_drivers_for_rides) >= 1,
            'rides_notifications_sent' => $rides_notification_sent
        ]);
    }

}