<?php

class FetchSendHistoryWithCustomerId extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $withdrawHistories = $this->getRooiBoosDB()->getSendHistoryDao()
            ->getSendHistoryWithCustomerId($_POST[self::CUSTOMER_ID]);

        $historiesResponse = [];

        /** @var SendHistoryEntity $history */
        foreach ($withdrawHistories as $withdrawHistory) {
            array_push($historiesResponse, [
                SendHistoryTableSchema::ID => $withdrawHistory->getId(),
                SendHistoryTableSchema::CURRENCY_ID => $withdrawHistory->getCurrencyId(),
                SendHistoryTableSchema::TAKER_EMAIL => $withdrawHistory->getTakerEmail(),
                SendHistoryTableSchema::BANK_ID => $withdrawHistory->getBankId(),
                SendHistoryTableSchema::ACCOUNT_HOLDER_NAME => $withdrawHistory->getAccountHolderName(),
                SendHistoryTableSchema::IBAN => $withdrawHistory->getIban(),
                SendHistoryTableSchema::BALANCE => $withdrawHistory->getBalance(),
                SendHistoryTableSchema::CREATED_AT => $withdrawHistory->getCreatedAt()
            ]);
        }

        $this->resSendOK([
            'Send_history_of_customer' => $historiesResponse
        ]);
    }
}