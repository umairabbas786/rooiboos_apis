<?php

class GetInviteCodeWithCustomerId extends RooiBoosApi {

    private const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {

        $inviteEntity = $this->getRooiBoosDB()->getInviteDao()->getInviteWithCustomerId($_POST[self::CUSTOMER_ID]);


        $this->resSendOK([
            'referral_code'=>[
                InviteTableSchema::CODE => $inviteEntity->getCode()
            ]
        ]);
    }
}