<?php


class DriverCnicFactory {
    /**
     * @param string[]|null|false $result
     * @return DriverCnicEntity
     */
    public static function mapFromDatabaseResult($result): DriverCnicEntity {
        return new DriverCnicEntity(
            $result[DriverCnicTableSchema::ID],
            $result[DriverCnicTableSchema::DRIVER_ID],
            $result[DriverCnicTableSchema::CNIC_FRONT],
            $result[DriverCnicTableSchema::CNIC_BACK],
            $result[DriverCnicTableSchema::CREATED_AT],
            $result[DriverCnicTableSchema::UPDATED_AT]
        );
    }
}