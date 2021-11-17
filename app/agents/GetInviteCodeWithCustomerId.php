<?php

class GetInviteCodeWithCustomerId extends RooiBoosApi {

    private const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $data = [];

        /** @var InviteEntity $invite */
        foreach ($this->getRooiBoosDB()->getInviteDao()->getInviteWithCustomerId($_POST[self::CUSTOMER_ID]) as $invite){
            array_push($data,[
                InviteTableSchema::CODE => $invite->getCode()
            ]);
        }

        $this->resSendOK($data);
    }
}