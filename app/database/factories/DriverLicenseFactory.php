<?php


class DriverLicenseFactory {
    /**
     * @param string[]|null|false $result
     * @return DriverLicenseEntity
     */
    public static function mapFromDatabaseResult($result): DriverLicenseEntity {
        return new DriverLicenseEntity(
            $result[DriverLicenseTableSchema::ID],
            $result[DriverLicenseTableSchema::DRIVER_ID],
            $result[DriverLicenseTableSchema::LICENSE_FRONT],
            $result[DriverLicenseTableSchema::LICENSE_BACK],
            $result[DriverLicenseTableSchema::CREATED_AT],
            $result[DriverLicenseTableSchema::UPDATED_AT]
        );
    }
}