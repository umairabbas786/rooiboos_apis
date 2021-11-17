<?php

class CheckTransactionWithCustomerId extends RooiBoosApi {

    private const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {
        $hasMoreThanThreeTransactions = $this->getRooiBoosDB()->getDepositHistoryDao()->hasMoreThanThreeTransactions($_POST[self::CUSTOMER_ID]);

        $this->resSendOK([
            'has_more_than_three_transactions' => $hasMoreThanThreeTransactions
        ]);
    }
}