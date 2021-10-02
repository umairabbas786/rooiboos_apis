<?php


class CountryFactory {
    /**
     * @param string[]|null|false $result
     * @return CountryEntity
     */
    public static function mapFromDatabaseResult($result): CountryEntity {
        return new CountryEntity(
            $result[CountryTableSchema::ID],
            $result[CountryTableSchema::NAME],
            $result[CountryTableSchema::CODE],
            (int) $result[CountryTableSchema::STATUS] === 1,
            $result[CountryTableSchema::CREATED_AT],
            $result[CountryTableSchema::UPDATED_AT]
        );
    }
}