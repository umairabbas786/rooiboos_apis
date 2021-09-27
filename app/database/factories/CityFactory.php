<?php


class CityFactory {
    /**
     * @param string[]|null|false $result
     * @return CityEntity
     */
    public static function mapFromDatabaseResult($result): CityEntity {
        return new CityEntity(
            $result[CityTableSchema::ID],
            $result[CityTableSchema::NAME],
            $result[CityTableSchema::CREATED_AT],
            $result[CityTableSchema::UPDATED_AT],
            ((int) $result[CityTableSchema::ENABLED]) === 1
        );
    }
}