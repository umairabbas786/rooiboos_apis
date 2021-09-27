<?php

use Carbon\Carbon;
use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use paragraph1\phpFCM\Notification as FcmNotification;

class EndRide extends Cab5Api {

    const EXIT_LOCATION_NAME = "exit_location_name";

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::EXIT_LOCATION_NAME])) {
            $this->killAsBadRequestWithMissingParamException(self::EXIT_LOCATION_NAME);
        }
    }

    protected function onDevise() {
        $ride = $this->getCab5db()->getRideDao()->getCurrentRideOfDriver($this->driverEntity->getId());

        if ($ride === null) {
            $this->killAsFailure([
                'no_ride_found' => true
            ]);
        }

        $ride->setState(RideState::USER_REACHED_AT_DESTINATION);
        $ride->setExitLongitude($this->driverEntity->getLongitude());
        $ride->setExitLatitude($this->driverEntity->getLatitude());
        $ride->setExitLocationName($_POST[self::EXIT_LOCATION_NAME]);
        $ride->setUpdatedAt(Carbon::now());

        $passenger = $this->getCab5db()->getPassengerDao()->getPassengerWithId($ride->getPassengerId());

        $rideCategory = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithID($ride->getRideCategoryId());

        $price = (int) $rideCategory->getPrice(); // 399
        $perKmPrice = $rideCategory->getPerKmCost(); // 20
        $kilometersTravelled = $ride->getMetersTravelled() / 1000; // tour distance
        $driverFreeKilometers = $this->driverEntity->getTotalMeters() / 1000; //free km

        $bill = $price;

        $extraKmTravelled = 0;

        if($kilometersTravelled > $driverFreeKilometers) { // ride greater
            $extraKmTravelled = $kilometersTravelled - $driverFreeKilometers;
            $bill = ($extraKmTravelled * $perKmPrice) + $bill;
            $this->driverEntity->setTotalMeters(0);
        } else { // ride smaller
            $remainingKilometers = $driverFreeKilometers - $kilometersTravelled;
            $this->driverEntity->setTotalMeters($remainingKilometers * 1000);
        }

        $this->getCab5db()->getDriverDao()->updateDriverTotalMeters(
            $this->driverEntity->getId(),$this->driverEntity->getTotalMeters()
        );

        $ride->setBill($bill);
        $ride = $this->getCab5db()->getRideDao()->updateRideEntity($ride);

        if ($ride === null) {
            $this->killAsFailure([
                'failed_to_end_ride' => true
            ]);
        }

        $fcm_notification = new FcmNotification('Ride Completed', 'Your bill is Rs. ' . $bill);
        $fcm_notification->setIcon('ic_launcher');
        $fcm_notification->setColor('#ffffff');
        $fcm_notification->setBadge(1);

        $fcm_message = new FcmMessage();

        $response = null;

        if ($passenger->getFcmToken() !== null && $this->driverEntity->getFcmToken() !== null) {
            $fcm_message->addRecipient(new FcmDevice($this->driverEntity->getFcmToken()));
            $fcm_message->addRecipient(new FcmDevice($passenger->getFcmToken()));
            $fcm_message->setPriority('high')
                ->setTimeToLive(4 * 3600)
                ->setData([
                    'title' => 'Ride Completed',
                    'body' => 'Your bill is Rs. ' . $bill
                ]);

            $response = $this->getFcmClient()->send($fcm_message);
        }

        $passengerAvatar = $this->getCab5db()->getPassengerAvatarDao()->getAvatarOfPassenger($passenger->getId());

        if ($passengerAvatar === null) {
            $this->killAsCompromised([
                'passenger_avatar_not_found' => true
            ]);
        }

        $this->resSendOK([
            'bill_sent' => $response !== null && $response->getStatusCode() === 200,
            'ride_ended' => true,
            'price_per_km' => $perKmPrice,
            'ride_category_price' => (int) $rideCategory->getPrice(),
            'extra_moving_km' => $extraKmTravelled,
            'kilometers_travelled' =>  $kilometersTravelled,
            'bill' => $bill,
            'ride_category_name' => $rideCategory->getName(),
            'passenger_name' => ($passenger->getFirstName() . ' ' . $passenger->getLastName()),
            'passenger_avatar' => $this->createLinkForPassengerAvatarImage($passengerAvatar->getAvatar())
        ]);
    }
}