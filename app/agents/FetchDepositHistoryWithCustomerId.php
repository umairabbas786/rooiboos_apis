<?php

class FetchDepositHistoryWithCustomerId extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $depositHistories = $this->getRooiBoosDB()->getDepositHistoryDao()
            ->getDepositHistoryWithCustomerId($_POST[self::CUSTOMER_ID]);

        $historiesResponse = [];

        /** @var DepositHistoryEntity $history */
        foreach ($depositHistories as $depositHistory) {
            array_push($historiesResponse, [
                DepositHistoryTableSchema::ID => $depositHistory->getId(),
                DepositHistoryTableSchema::CURRENCY_ID => $depositHistory->getCurrencyId(),
                DepositHistoryTableSchema::BALANCE => $depositHistory->getBalance(),
                DepositHistoryTableSchema::CREATED_AT => $depositHistory->getCreatedAt()
            ]);
        }

        $this->resSendOK([
            'deposit_history_of_customer' => $historiesResponse
        ]);
    }
}