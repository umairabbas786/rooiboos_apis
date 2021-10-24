<?php


class DepositHistoryFactory {
    /**
     * @param string[]|null|false $result
     * @return DepositHistoryEntity
     */
    public static function mapFromDatabaseResult($result): DepositHistoryEntity {
        return new DepositHistoryEntity(
            $result[DepositHistoryTableSchema::ID],
            $result[DepositHistoryTableSchema::CUSTOMER_ID],
            $result[DepositHistoryTableSchema::CURRENCY_ID],
            (float) $result[DepositHistoryTableSchema::BALANCE],
            $result[DepositHistoryTableSchema::FROM_EMAIL],
            $result[DepositHistoryTableSchema::CREATED_AT],
            $result[DepositHistoryTableSchema::UPDATED_AT]
        );
    }
}