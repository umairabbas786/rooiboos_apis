<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddMyselfRecipient extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const CURRENCY_ID = "currency_id";
    const BANK_ID = "bank_id";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const IBAN = "iban";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID,
            self::CURRENCY_ID,
            self::BANK_ID,
            self::ACCOUNT_HOLDER_NAME,
            self::IBAN,
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {

        $registration_time = Carbon::now();

        $myselfRecipient = new MyselfRecipientEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CUSTOMER_ID],
            $_POST[self::CURRENCY_ID],
            $_POST[self::BANK_ID],
            $_POST[self::ACCOUNT_HOLDER_NAME],
            $_POST[self::IBAN],
            $registration_time,
            $registration_time
        );

        $myselfRecipient = $this->getRooiBoosDB()->getMyselfRecipientDao()->insertMyselfRecipient($myselfRecipient);

        if($myselfRecipient === null){
            $this->killAsFailure([
                "failed_to_add_myself_recipient" => true
            ]);
        }

        $this->resSendOK([
            'Myself_recipient'=>[
                MyselfRecipientTableSchema::ID => $myselfRecipient->getId(),
                MyselfRecipientTableSchema::CUSTOMER_ID => $myselfRecipient->getCustomerId(),
                MyselfRecipientTableSchema::CURRENCY_ID => $myselfRecipient->getCurrencyId(),
                MyselfRecipientTableSchema::BANK_ID => $myselfRecipient->getBankId(),
                MyselfRecipientTableSchema::ACCOUNT_HOLDER_NAME => $myselfRecipient->getAccountHolderName(),
                MyselfRecipientTableSchema::IBAN => $myselfRecipient->getIban(),
                MyselfRecipientTableSchema::CREATED_AT => $myselfRecipient->getCreatedAt(),
                MyselfRecipientTableSchema::UPDATED_AT => $myselfRecipient->getUpdatedAt()
            ]
        ]);
    }
}