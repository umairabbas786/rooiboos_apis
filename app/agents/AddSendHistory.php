<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddSendHistory extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const TAKER_EMAIL = "taker_email";
    const CURRENCY_ID = "currency_id";
    const BANK_ID = "bank_id";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const IBAN = "iban";
    const Balance = "balance";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID,
            self::TAKER_EMAIL,
            self::CURRENCY_ID,
            self::BANK_ID,
            self::ACCOUNT_HOLDER_NAME,
            self::IBAN,
            self::Balance
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {

        $registration_time = Carbon::now();

        $sendHistory = new SendHistoryEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CUSTOMER_ID],
            $_POST[self::TAKER_EMAIL],
            $_POST[self::CURRENCY_ID],
            $_POST[self::BANK_ID],
            $_POST[self::ACCOUNT_HOLDER_NAME],
            $_POST[self::IBAN],
            $_POST[self::Balance],
            $registration_time,
            $registration_time
        );

        $sendHistory = $this->getRooiBoosDB()->getSendHistoryDao()->insertSendHistory($sendHistory);

        if($sendHistory === null){
            $this->killAsFailure([
                "failed_to_add_send_history" => true
            ]);
        }

        $this->resSendOK([
            'Send_history'=>[
                SendHistoryTableSchema::ID => $sendHistory->getId(),
                SendHistoryTableSchema::CUSTOMER_ID => $sendHistory->getCustomerId(),
                SendHistoryTableSchema::TAKER_EMAIL => $sendHistory->getTakerEmail(),
                SendHistoryTableSchema::CURRENCY_ID => $sendHistory->getCurrencyId(),
                SendHistoryTableSchema::BANK_ID => $sendHistory->getBankId(),
                SendHistoryTableSchema::ACCOUNT_HOLDER_NAME => $sendHistory->getAccountHolderName(),
                SendHistoryTableSchema::IBAN => $sendHistory->getIban(),
                SendHistoryTableSchema::BALANCE => $sendHistory->getBalance(),
                SendHistoryTableSchema::CREATED_AT => $sendHistory->getCreatedAt(),
                SendHistoryTableSchema::UPDATED_AT => $sendHistory->getUpdatedAt()
            ]
        ]);
    }
}