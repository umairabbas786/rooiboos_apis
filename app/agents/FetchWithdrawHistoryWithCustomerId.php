<?php

class FetchWithdrawHistoryWithCustomerId extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $withdrawHistories = $this->getRooiBoosDB()->getWithdrawHistoryDao()
            ->getWithdrawHistoryWithCustomerId($_POST[self::CUSTOMER_ID]);

        $historiesResponse = [];

        /** @var WithdrawHistoryEntity $history */
        foreach ($withdrawHistories as $withdrawHistory) {
            array_push($historiesResponse, [
                WithdrawHistoryTableSchema::ID => $withdrawHistory->getId(),
                WithdrawHistoryTableSchema::CURRENCY_ID => $withdrawHistory->getCurrencyId(),
                WithdrawHistoryTableSchema::BANK_ID => $withdrawHistory->getBankId(),
                WithdrawHistoryTableSchema::ACCOUNT_HOLDER_NAME => $withdrawHistory->getAccountHolderName(),
                WithdrawHistoryTableSchema::IBAN => $withdrawHistory->getIban(),
                WithdrawHistoryTableSchema::BALANCE => $withdrawHistory->getBalance(),
                WithdrawHistoryTableSchema::STATUS => $withdrawHistory->isStatus(),
                WithdrawHistoryTableSchema::CREATED_AT => $withdrawHistory->getCreatedAt()
            ]);
        }

        $this->resSendOK([
            'withdraw_history_of_customer' => $historiesResponse
        ]);
    }
}