<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddWithdrawHistory extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const CURRENCY_ID = "currency_id";
    const BANK_ID = "bank_id";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const IBAN = "iban";
    const BALANCE = "balance";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID,
            self::CURRENCY_ID,
            self::BANK_ID,
            self::ACCOUNT_HOLDER_NAME,
            self::IBAN,
            self::BALANCE
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {

        $registration_time = Carbon::now();

        $withdrawHistory = new WithdrawHistoryEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CUSTOMER_ID],
            $_POST[self::CURRENCY_ID],
            $_POST[self::BANK_ID],
            $_POST[self::ACCOUNT_HOLDER_NAME],
            $_POST[self::IBAN],
            $_POST[self::BALANCE],
            false,
            $registration_time,
            $registration_time
        );

        $withdrawHistory = $this->getRooiBoosDB()->getWithdrawHistoryDao()->insertWithdrawHistory($withdrawHistory);

        if($withdrawHistory === null){
            $this->killAsFailure([
                "failed_to_add_withdraw_data" => true
            ]);
        }

        $this->resSendOK([
            'withdraw_history'=>[
                WithdrawHistoryTableSchema::ID => $withdrawHistory->getId(),
                WithdrawHistoryTableSchema::CUSTOMER_ID => $withdrawHistory->getCustomerId(),
                WithdrawHistoryTableSchema::CURRENCY_ID => $withdrawHistory->getCurrencyId(),
                WithdrawHistoryTableSchema::BANK_ID => $withdrawHistory->getBankId(),
                WithdrawHistoryTableSchema::ACCOUNT_HOLDER_NAME => $withdrawHistory->getAccountHolderName(),
                WithdrawHistoryTableSchema::IBAN => $withdrawHistory->getIban(),
                WithdrawHistoryTableSchema::BALANCE => $withdrawHistory->getBalance(),
                WithdrawHistoryTableSchema::STATUS => $withdrawHistory->isStatus(),
                WithdrawHistoryTableSchema::CREATED_AT => $withdrawHistory->getCreatedAt(),
                WithdrawHistoryTableSchema::UPDATED_AT => $withdrawHistory->getUpdatedAt()
            ]
        ]);
    }
}