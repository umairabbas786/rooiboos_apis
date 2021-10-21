<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddSomeoneRecipient extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const TAKER_EMAIL = "taker_email";
    const CURRENCY_ID = "currency_id";
    const BANK_ID = "bank_id";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const IBAN = "iban";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID,
            self::TAKER_EMAIL,
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

        $someoneRecipient = new SomeoneRecipientEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CUSTOMER_ID],
            $_POST[self::TAKER_EMAIL],
            $_POST[self::CURRENCY_ID],
            $_POST[self::BANK_ID],
            $_POST[self::ACCOUNT_HOLDER_NAME],
            $_POST[self::IBAN],
            $registration_time,
            $registration_time
        );

        $someoneRecipient = $this->getRooiBoosDB()->getSomeoneRecipientDao()->insertSomeoneRecipient($someoneRecipient);

        if($someoneRecipient === null){
            $this->killAsFailure([
                "failed_to_add_someone_recipient" => true
            ]);
        }

        $this->resSendOK([
            'Someone_recipient'=>[
                SomeoneRecipientTableSchema::ID => $someoneRecipient->getId(),
                SomeoneRecipientTableSchema::CUSTOMER_ID => $someoneRecipient->getCustomerId(),
                SomeoneRecipientTableSchema::TAKER_EMAIL => $someoneRecipient->getTakerEmail(),
                SomeoneRecipientTableSchema::CURRENCY_ID => $someoneRecipient->getCurrencyId(),
                SomeoneRecipientTableSchema::BANK_ID => $someoneRecipient->getBankId(),
                SomeoneRecipientTableSchema::ACCOUNT_HOLDER_NAME => $someoneRecipient->getAccountHolderName(),
                SomeoneRecipientTableSchema::IBAN => $someoneRecipient->getIban(),
                SomeoneRecipientTableSchema::CREATED_AT => $someoneRecipient->getCreatedAt(),
                SomeoneRecipientTableSchema::UPDATED_AT => $someoneRecipient->getUpdatedAt()
            ]
        ]);
    }
}