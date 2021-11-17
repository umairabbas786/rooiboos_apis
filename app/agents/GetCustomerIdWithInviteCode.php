<?php

class GetCustomerIdWithInviteCode extends RooiBoosApi {

    private const CODE = "code";

    protected function onAssemble() {
        if (!isset($_POST[self::CODE])) {
            $this->killAsBadRequestWithMissingParamException(self::CODE);
        }
    }

    protected function onDevise() {
        $inviteEntity = $this->getRooiBoosDB()->getInviteDao()->getCustomerWithInviteCode($_POST[self::CODE]);

        if ($inviteEntity === null) {
            $this->killAsFailure([
                'no_customer_found_for_given_invite_code' => true
            ]);
        }

        $this->resSendOK([
            InviteTableSchema::CUSTOMER_ID => $inviteEntity->getCustomerId()
        ]);
    }
}