<?php


class CurrencyFeeFactory {
    /**
     * @param string[]|null|false $result
     * @return CurrencyFeeEntity
     */
    public static function mapFromDatabaseResult($result): CurrencyFeeEntity {
        return new CurrencyFeeEntity(
            $result[CurrencyFeeTableSchema::CURRENCY_FEE],
            $result[CurrencyFeeTableSchema::CREATED_AT],
            $result[CurrencyFeeTableSchema::UPDATED_AT]
        );
    }
}