<?php

use Carbon\Carbon;

class UpdateNotificationsAsRead extends RooiBoosApi {

    private const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $this->resSendOK([
            'updated' => $this->getRooiBoosDB()
                ->getNotificationDao()
                ->UpdateNotificationsOfCustomerAsRead($_POST[self::CUSTOMER_ID], Carbon::now())
        ]);

    }
}