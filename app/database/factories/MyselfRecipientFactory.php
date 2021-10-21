<?php


class MyselfRecipientFactory {
    /**
     * @param string[]|null|false $result
     * @return MyselfRecipientEntity
     */
    public static function mapFromDatabaseResult($result): MyselfRecipientEntity {
        return new MyselfRecipientEntity(
            $result[MyselfRecipientTableSchema::ID],
            $result[MyselfRecipientTableSchema::CUSTOMER_ID],
            $result[MyselfRecipientTableSchema::CURRENCY_ID],
            $result[MyselfRecipientTableSchema::BANK_ID],
            $result[MyselfRecipientTableSchema::ACCOUNT_HOLDER_NAME],
            $result[MyselfRecipientTableSchema::IBAN],
            $result[MyselfRecipientTableSchema::CREATED_AT],
            $result[MyselfRecipientTableSchema::UPDATED_AT]
        );
    }
}