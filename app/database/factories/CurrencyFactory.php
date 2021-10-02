<?php


class CurrencyFactory {
    /**
     * @param string[]|null|false $result
     * @return CurrencyEntity
     */
    public static function mapFromDatabaseResult($result): CurrencyEntity {
        return new CurrencyEntity(
            $result[CurrencyTableSchema::ID],
            $result[CurrencyTableSchema::NAME],
            $result[CurrencyTableSchema::CODE],
            $result[CurrencyTableSchema::CREATED_AT],
            $result[CurrencyTableSchema::UPDATED_AT]
        );
    }
}