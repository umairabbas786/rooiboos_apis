<?php


class SendHistoryFactory {
    /**
     * @param string[]|null|false $result
     * @return SendHistoryEntity
     */
    public static function mapFromDatabaseResult($result): SendHistoryEntity {
        return new SendHistoryEntity(
            $result[SendHistoryTableSchema::ID],
            $result[SendHistoryTableSchema::CUSTOMER_ID],
            $result[SendHistoryTableSchema::TAKER_EMAIL],
            $result[SendHistoryTableSchema::CURRENCY_ID],
            $result[SendHistoryTableSchema::BANK_ID],
            $result[SendHistoryTableSchema::ACCOUNT_HOLDER_NAME],
            $result[SendHistoryTableSchema::IBAN],
            (float) $result[SendHistoryTableSchema::BALANCE],
            $result[SendHistoryTableSchema::CREATED_AT],
            $result[SendHistoryTableSchema::UPDATED_AT]
        );
    }
}