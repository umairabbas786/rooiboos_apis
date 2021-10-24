<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddDepositHistory extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const CURRENCY_ID = "currency_id";
    const BALANCE = "balance";
    const FROM_EMAIL = "from_email";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID,
            self::CURRENCY_ID,
            self::BALANCE,
            self::FROM_EMAIL
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {

        $registration_time = Carbon::now();

        $depositHistory = new DepositHistoryEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CUSTOMER_ID],
            $_POST[self::CURRENCY_ID],
            $_POST[self::BALANCE],
            $_POST[self::FROM_EMAIL],
            $registration_time,
            $registration_time
        );

        $depositHistory = $this->getRooiBoosDB()->getDepositHistoryDao()->insertDepositHistory($depositHistory);

        if($depositHistory === null){
            $this->killAsFailure([
                "failed_to_deposit_data" => true
            ]);
        }

        $this->resSendOK([
            'deposit_history'=>[
                DepositHistoryTableSchema::ID => $depositHistory->getId(),
                DepositHistoryTableSchema::CUSTOMER_ID => $depositHistory->getCustomerId(),
                DepositHistoryTableSchema::CURRENCY_ID => $depositHistory->getCurrencyId(),
                DepositHistoryTableSchema::BALANCE => $depositHistory->getBalance(),
                DepositHistoryTableSchema::FROM_EMAIL => $depositHistory->getFromEmail(),
                DepositHistoryTableSchema::CREATED_AT => $depositHistory->getCreatedAt(),
                DepositHistoryTableSchema::UPDATED_AT => $depositHistory->getUpdatedAt()
            ]
        ]);
    }
}