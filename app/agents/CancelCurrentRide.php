<?php

use Carbon\Carbon;
use paragraph1\phpFCM\Message as FcmMessage;
use paragraph1\phpFCM\Recipient\Device as FcmDevice;
use paragraph1\phpFCM\Notification as FcmNotification;

class CancelCurrentRide extends Cab5Api {
    private PassengerEntity $passengerEntity;

    protected function onTokenAuthorization() {
        $this->passengerEntity = $this->handlePassengerTokenAuthorization();
    }

    protected function onDevise() {
        $rides = $this->getCab5db()->getRideDao()->getAllInCompleteAndAwaitingRidesOfPassenger($this->passengerEntity->getId());

        $response = null;

        /** @var RideEntity $rideEntity */
        foreach ($rides as $rideEntity) {
            if ($rideEntity->getState() !== RideState::SENT_REQUEST_TO_DRIVER) {

                $wasDriverArrivedAtPickup = $rideEntity->getState() === RideState::DRIVER_ARRIVED_AT_PICK_UP;

                $rideEntity->setState(RideState::USER_CANCELLED_THE_RIDE);
                $rideEntity->setUpdatedAt(Carbon::now());

                $rideEntity = $this->getCab5db()->getRideDao()->updateRideEntity($rideEntity);

                if ($rideEntity === null) {
                    $this->killAsFailure([
                        'failed_to_cancel_ride' => true
                    ]);
                }

                $cancelDescription = 'User has cancelled the ride.';

                if ($wasDriverArrivedAtPickup) {
                    $fcm_notification = new FcmNotification('Ride Cancelled', 'You have been charged Rs. 80');
                    $fcm_notification->setIcon('ic_launcher');
                    $fcm_notification->setColor('#ffffff');
                    $fcm_notification->setBadge(1);

                    $client = $this->getCab5db()->getPassengerDao()->getPassengerWithId($rideEntity->getPassengerId());

                    $fcm_message = new FcmMessage();
                    $fcm_message->addRecipient(new FcmDevice($client->getFcmToken()));
                    $fcm_message->setPriority('high')
                        ->setTimeToLive(4 * 3600)
                        ->setData([
                            'title' => 'Ride Cancelled',
                            'body' => 'You have been charged Rs. 80'
                        ]);

                    $cancelDescription = 'User has been charged with Rs. 80';
                }

                $fcm_notification = new FcmNotification('Ride Cancelled', $cancelDescription);
                $fcm_notification->setIcon('ic_launcher');
                $fcm_notification->setColor('#ffffff');
                $fcm_notification->setBadge(1);

                $driver = $this->getCab5db()->getDriverDao()->getDriverWithId($rideEntity->getDriverId());

                $fcm_message = new FcmMessage();
                $fcm_message->addRecipient(new FcmDevice($driver->getFcmToken()));
                $fcm_message->setPriority('high')
                    ->setTimeToLive(4 * 3600)
                    ->setData([
                        'title' => 'Ride Cancelled',
                        'body' => $cancelDescription
                    ]);

                $response = $this->getFcmClient()->send($fcm_message);
                break;
            }
        }

        $this->getCab5db()->getRideDao()->deleteAllNonAcceptedRideEntitiesOfPassenger($this->passengerEntity->getId());

        $this->resSendOK([
            'ride_cancelled' => true,
            'ride_cancel_notification_sent' => $response === null ? null : $response->getStatusCode() === 200
        ]);
    }
}