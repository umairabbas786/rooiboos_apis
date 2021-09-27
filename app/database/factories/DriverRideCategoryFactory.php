<?php


class DriverRideCategoryFactory {
    /**
     * @param string[]|null|false $result
     * @return DriverRideCategoryEntity
     */
    public static function mapFromDatabaseResult($result): DriverRideCategoryEntity {
        return new DriverRideCategoryEntity(
            $result[DriverRideCategoryTableSchema::ID],
            $result[DriverRideCategoryTableSchema::DRIVER_ID],
            $result[DriverRideCategoryTableSchema::RIDE_CATEGORY_ID],
            $result[DriverRideCategoryTableSchema::CREATED_AT],
            $result[DriverRideCategoryTableSchema::UPDATED_AT]
        );
    }
}