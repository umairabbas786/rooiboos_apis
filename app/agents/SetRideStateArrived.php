<?php

use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use paragraph1\phpFCM\Notification as FcmNotification;

class SetRideStateArrived extends Cab5Api {

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

        $ride->setState(RideState::DRIVER_ARRIVED_AT_PICK_UP);

        $ride = $this->getCab5db()->getRideDao()->updateRideEntity($ride);

        if ($ride === null) {
            $this->killAsFailure([
                'failed_to_update_state' => true
            ]);
        }

        $client = $this->getCab5db()->getPassengerDao()->getPassengerWithId($ride->getPassengerId());

        if ($client->getFcmToken() !== null) {
            $fcm_notification = new FcmNotification('Ride Arrived', 'Your ride has arrived at your destination.');
            $fcm_notification->setIcon('ic_launcher');
            $fcm_notification->setColor('#ffffff');
            $fcm_notification->setBadge(1);

            $fcm_message = new FcmMessage();
            $fcm_message->addRecipient(new FcmDevice($client->getFcmToken()));
            $fcm_message->setPriority('high')
                ->setTimeToLive(4 * 3600)
                ->setData([
                    'title' => 'Ride Arrived',
                    'body' => 'Your ride has arrived at your destination.'
                ]);

            $this->getFcmClient()->send($fcm_message);
        }

        $this->resSendOK([
            'updated_to_arrival_state' => true
        ]);
    }
}