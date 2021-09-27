<?php

use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use paragraph1\phpFCM\Notification as FcmNotification;

class SetRideStateStarted extends Cab5Api {

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onDevise() {
        $ride = $this->getCab5db()->getRideDao()->getCurrentRideOfDriver($this->driverEntity->getId());

        if ($ride === null) {
            $this->killAsFailure([
                'no_ride_found' => true
            ]);
        }

        $ride->setState(RideState::USER_STARTED_RIDE);

        $ride = $this->getCab5db()->getRideDao()->updateRideEntity($ride);

        if ($ride === null) {
            $this->killAsFailure([
                'failed_to_update_state' => true
            ]);
        }

        $passenger = $this->getCab5db()->getPassengerDao()->getPassengerWithId($ride->getPassengerId());

        if ($passenger->getFcmToken() !== null) {
            $fcm_notification = new FcmNotification('Ride Started', 'Driver has started the ride.');
            $fcm_notification->setIcon('ic_launcher');
            $fcm_notification->setColor('#ffffff');
            $fcm_notification->setBadge(1);

            $fcm_message = new FcmMessage();
            $fcm_message->addRecipient(new FcmDevice($passenger->getFcmToken()));
            $fcm_message->setPriority('high')
                ->setTimeToLive(4 * 3600)
                ->setData([
                    'title' => 'Ride Started',
                    'body' => 'Driver has started the ride.'
                ]);

            $this->getFcmClient()->send($fcm_message);
        }

        $this->resSendOK([
            'updated_to_started_state' => true
        ]);
    }
}