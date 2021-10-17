<?php


class BankFactory {
    /**
     * @param string[]|null|false $result
     * @return BankEntity
     */
    public static function mapFromDatabaseResult($result): BankEntity {
        return new BankEntity(
            $result[BankTableSchema::ID],
            $result[BankTableSchema::NAME],
            $result[BankTableSchema::CITY],
            $result[BankTableSchema::COUNTRY],
            (int) $result[BankTableSchema::STATUS] === 1,
            $result[BankTableSchema::CREATED_AT],
            $result[BankTableSchema::UPDATED_AT]
        );
    }
}