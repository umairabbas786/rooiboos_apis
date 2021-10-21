<?php

class FetchMyselfRecipientWithCustomerId extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $withdrawHistories = $this->getRooiBoosDB()->getMyselfRecipientDao()
            ->getMyselfRecipientWithCustomerId($_POST[self::CUSTOMER_ID]);

        $historiesResponse = [];

        /** @var MyselfRecipientEntity $history */
        foreach ($withdrawHistories as $withdrawHistory) {
            array_push($historiesResponse, [
                MyselfRecipientTableSchema::ID => $withdrawHistory->getId(),
                MyselfRecipientTableSchema::CURRENCY_ID => $withdrawHistory->getCurrencyId(),
                MyselfRecipientTableSchema::BANK_ID => $withdrawHistory->getBankId(),
                MyselfRecipientTableSchema::ACCOUNT_HOLDER_NAME => $withdrawHistory->getAccountHolderName(),
                MyselfRecipientTableSchema::IBAN => $withdrawHistory->getIban(),
                MyselfRecipientTableSchema::CREATED_AT => $withdrawHistory->getCreatedAt()
            ]);
        }

        $this->resSendOK([
            'myself_recipient_of_customer' => $historiesResponse
        ]);
    }
}