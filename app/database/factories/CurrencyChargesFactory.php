<?php


class CurrencyChargesFactory {
    /**
     * @param string[]|null|false $result
     * @return CurrencyChargesEntity
     */
    public static function mapFromDatabaseResult($result): CurrencyChargesEntity {
        return new CurrencyChargesEntity(
            $result[CurrencyChargesTableSchema::ID],
            $result[CurrencyChargesTableSchema::FROM],
            $result[CurrencyChargesTableSchema::TO],
            (float) $result[CurrencyChargesTableSchema::RATE],
            $result[CurrencyChargesTableSchema::CREATED_AT],
            $result[CurrencyChargesTableSchema::UPDATED_AT]
        );
    }
}