<?php

class FetchSomeoneRecipientWithCustomerId extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $withdrawHistories = $this->getRooiBoosDB()->getSomeoneRecipientDao()
            ->getSomeoneRecipientWithCustomerId($_POST[self::CUSTOMER_ID]);

        $historiesResponse = [];

        /** @var SomeoneRecipientEntity $history */
        foreach ($withdrawHistories as $withdrawHistory) {
            array_push($historiesResponse, [
                SomeoneRecipientTableSchema::ID => $withdrawHistory->getId(),
                SomeoneRecipientTableSchema::CURRENCY_ID => $withdrawHistory->getCurrencyId(),
                SomeoneRecipientTableSchema::TAKER_EMAIL => $withdrawHistory->getTakerEmail(),
                SomeoneRecipientTableSchema::BANK_ID => $withdrawHistory->getBankId(),
                SomeoneRecipientTableSchema::ACCOUNT_HOLDER_NAME => $withdrawHistory->getAccountHolderName(),
                SomeoneRecipientTableSchema::IBAN => $withdrawHistory->getIban(),
                SomeoneRecipientTableSchema::CREATED_AT => $withdrawHistory->getCreatedAt()
            ]);
        }

        $this->resSendOK([
            'someone_recipient_of_customer' => $historiesResponse
        ]);
    }
}