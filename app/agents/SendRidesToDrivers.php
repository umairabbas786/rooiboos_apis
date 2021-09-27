<?php

use Carbon\Carbon;
use Location\Coordinate;
use Location\Distance\Haversine;
use UnitConverter\UnitConverter;
use UnitConverter\Unit\Length\Metre;
use UnitConverter\Unit\Length\Mile;
use UnitConverter\Unit\Length\Kilometre;
use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use Ramsey\Uuid\Uuid;

class SendRidesToDrivers extends Cab5Api {

    // Coordinates of PASSENGER
    const PASSENGER_LONGITUDE = "lng";
    const PASSENGER_LATITUDE = "lat";
    const PICKUP_LOCATION_NAME = "pickup_loc_name";

    const RIDE_CATEGORY_ID = "ride_category_id";

    // Range To Check In or Out
    const RANGE = "range";
    // Distance Unit For Range
    const DISTANCE_UNIT = "unit";

    // Acceptable Distance Units for Range
    const METER = "METER";
    const KILOMETER = "KILOMETER";
    const MILE = "MILE";

    // Comparison for Range
    const COMPARISON = "comparison";

    // Acceptable Comparison for range
    const IN = "IN";
    const OUT = "OUT";

    private Haversine $haversineCalculator;
    private UnitConverter $unitConverter;
    private PassengerEntity $passengerEntity;


    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onAssemble() {
        $required_fields = [
            self::PASSENGER_LONGITUDE,
            self::PASSENGER_LATITUDE,
            self::PICKUP_LOCATION_NAME,
            self::RANGE,
            self::DISTANCE_UNIT,
            self::COMPARISON,
            self::RIDE_CATEGORY_ID
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }

        if (!in_array($_POST[self::DISTANCE_UNIT], [self::METER, self::KILOMETER, self::MILE])) {
            $this->killAsBadRequestWithInvalidValueForParam(self::DISTANCE_UNIT);
        }

        if (!in_array($_POST[self::COMPARISON], [self::IN, self::OUT])) {
            $this->killAsBadRequestWithInvalidValueForParam(self::COMPARISON);
        }


        $this->haversineCalculator = new Haversine();

        $this->unitConverter = UnitConverter::createBuilder()
            ->addSimpleCalculator()
            ->addRegistryWith([
                (new Metre())->setSymbol(self::METER),
                (new Mile())->setSymbol(self::MILE),
                (new Kilometre())->setSymbol(self::KILOMETER)
            ])
            ->build();
    }

    protected function onDevise() {
        $previousInCompleteRides = $this->getCab5db()->getRideDao()->getPassengerRidesWhichAreNotCompletedExcludingUserCancelledRides($this->passengerEntity->getId());

        if (count($previousInCompleteRides) >= 1) {
            $this->killAsFailure([
                'passenger_already_have_incomplete_rides' => true
            ]);
        }

        $chosen_drivers_for_rides = [];

        $all_drivers = $this->getCab5db()->getDriverDao()->getDriversForSendingRideThoseWhoHaveRideCategoryIdOf($_POST[self::RIDE_CATEGORY_ID]);
        $passenger_coordinate = new Coordinate($_POST[self::PASSENGER_LATITUDE], $_POST[self::PASSENGER_LONGITUDE]);

        $message = new FcmMessage();

        /** @var DriverEntity $driver */
        foreach($all_drivers as $driver) {
            $driver_coordinate = new Coordinate($driver->getLatitude(), $driver->getLongitude());
            $driver_distance = $passenger_coordinate->getDistance($driver_coordinate, $this->haversineCalculator); // returns in Meter

            if (self::DISTANCE_UNIT !== self::METER) {
                $driver_distance = $this->unitConverter
                    ->convert($driver_distance)
                    ->from(self::METER)
                    ->to($_POST[self::DISTANCE_UNIT]);
            }

            $range = (float) $_POST[self::RANGE];

            if ($_POST[self::COMPARISON] === self::IN ? $driver_distance <= $range : $driver_distance >= $range) {
                $message->addRecipient(new FcmDevice($driver->getFcmToken()));
                array_push($chosen_drivers_for_rides, $driver);

                $createTime = Carbon::now();

                $this->getCab5db()->getRideDao()->insertRideEntity(new RideEntity(
                    Uuid::uuid4()->toString(),
                    $this->passengerEntity->getId(),
                    $driver->getId(),
                    $_POST[self::PASSENGER_LONGITUDE],
                    $_POST[self::PASSENGER_LATITUDE],
                    $_POST[self::PICKUP_LOCATION_NAME],
                    RideState::SENT_REQUEST_TO_DRIVER,
                    null,
                    null,
                    null,
                    null,
                    $_POST[self::RIDE_CATEGORY_ID],
                    null,
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

        $this->resSendOK([
            'drivers_count' => count($chosen_drivers_for_rides),
            'rides_sent_to_drivers' => count($chosen_drivers_for_rides) >= 1,
            'rides_notifications_sent' => $rides_notification_sent
        ]);
    }
}
