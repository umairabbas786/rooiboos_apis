<?php


class SomeoneRecipientFactory {
    /**
     * @param string[]|null|false $result
     * @return SomeoneRecipientEntity
     */
    public static function mapFromDatabaseResult($result): SomeoneRecipientEntity {
        return new SomeoneRecipientEntity(
            $result[SomeoneRecipientTableSchema::ID],
            $result[SomeoneRecipientTableSchema::CUSTOMER_ID],
            $result[SomeoneRecipientTableSchema::TAKER_EMAIL],
            $result[SomeoneRecipientTableSchema::CURRENCY_ID],
            $result[SomeoneRecipientTableSchema::BANK_ID],
            $result[SomeoneRecipientTableSchema::ACCOUNT_HOLDER_NAME],
            $result[SomeoneRecipientTableSchema::IBAN],
            $result[SomeoneRecipientTableSchema::CREATED_AT],
            $result[SomeoneRecipientTableSchema::UPDATED_AT]
        );
    }
}