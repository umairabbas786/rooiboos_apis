<?php

class GetNotificationsWithCustomerId extends RooiBoosApi {

    private const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $data = [];

        /** @var NotificationEntity $notification */
        foreach ($this->getRooiBoosDB()->getNotificationDao()->getNotificationsWithCustomerId($_POST[self::CUSTOMER_ID]) as $notification){
            array_push($data,[
                NotificationTableSchema::ID => $notification->getId(),
                NotificationTableSchema::CUSTOMER_ID => $notification->getCustomerId(),
                NotificationTableSchema::MSG => $notification->getMsg(),
                NotificationTableSchema::STATE => $notification->getState(),
                NotificationTableSchema::CREATED_AT => $notification->getCreatedAt(),
                NotificationTableSchema::UPDATED_AT => $notification->getUpdatedAt()
            ]);
        }

        $this->resSendOK($data);
    }
}