<?php


class WithdrawHistoryFactory {
    /**
     * @param string[]|null|false $result
     * @return WithdrawHistoryEntity
     */
    public static function mapFromDatabaseResult($result): WithdrawHistoryEntity {
        return new WithdrawHistoryEntity(
            $result[WithdrawHistoryTableSchema::ID],
            $result[WithdrawHistoryTableSchema::CUSTOMER_ID],
            $result[WithdrawHistoryTableSchema::CURRENCY_ID],
            $result[WithdrawHistoryTableSchema::BANK_ID],
            $result[WithdrawHistoryTableSchema::ACCOUNT_HOLDER_NAME],
            $result[WithdrawHistoryTableSchema::IBAN],
            (float) $result[WithdrawHistoryTableSchema::BALANCE],
            (int) $result[WithdrawHistoryTableSchema::STATUS] === 0,
            $result[WithdrawHistoryTableSchema::CREATED_AT],
            $result[WithdrawHistoryTableSchema::UPDATED_AT]
        );
    }
}