<?php

use Carbon\Carbon;
use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use paragraph1\phpFCM\Notification as FcmNotification;

class AcceptDriverRideNotification extends Cab5Api {

    const RIDE_ID = "ride_id";

    protected function onTokenAuthorization() {
        $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_POST[self::RIDE_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::RIDE_ID);
        }
    }

    protected function onDevise() {
        $rideEntity = $this->getCab5db()->getRideDao()->getRideEntityWithId($_POST[self::RIDE_ID]);

        if ($rideEntity === null) {
            $this->killAsFailure([
                'some_one_has_already_booked_the_ride' => true
            ]);
        }

        $rideEntity->setState(RideState::REQUEST_ACCEPTED_BY_DRIVER);
        $rideEntity->setUpdatedAt(Carbon::now());

        $rideEntity = $this->getCab5db()->getRideDao()->updateRideEntity($rideEntity);

        if ($rideEntity === null) {
            $this->killAsFailure([
                'failed_to_persist_as_accepted_record' => true
            ]);
        }

        $this->getCab5db()->getRideDao()->deleteAllNonAcceptedRideEntitiesRelatedWith($rideEntity);

        $passengerEntity = $this->getCab5db()->getPassengerDao()->getPassengerWithId($rideEntity->getPassengerId());

        $fcm_notification = new FcmNotification('Ride Booked', 'Your ride has been booked!');
        $fcm_notification->setIcon('ic_launcher');
        $fcm_notification->setColor('#ffffff');
        $fcm_notification->setBadge(1);

        $fcm_message = new FcmMessage();
        $fcm_message->addRecipient(new FcmDevice($passengerEntity->getFcmToken()));
        $fcm_message->setPriority('high')
            ->setTimeToLive(4 * 3600)
            ->setData([
                'title' => 'Ride Booked',
                'body' => 'Your ride has been booked!'
            ]);

        $response = $this->getFcmClient()->send($fcm_message);

        $this->resSendOK([
            'ride_accepted_successfully' => true,
            'ride_booked_notification_sent' => $response->getStatusCode() === 200
        ]);
    }
}