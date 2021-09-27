<?php


class DriverVehicleNumberPlateFactory {
    /**
     * @param string[]|null|false $result
     * @return DriverVehicleNumberPlateEntity
     */
    public static function mapFromDatabaseResult($result): DriverVehicleNumberPlateEntity {
        return new DriverVehicleNumberPlateEntity(
            $result[DriverVehicleNumberPlateTableSchema::ID],
            $result[DriverVehicleNumberPlateTableSchema::DRIVER_ID],
            $result[DriverVehicleNumberPlateTableSchema::NUMBER_PLATE],
            $result[DriverVehicleNumberPlateTableSchema::CREATED_AT],
            $result[DriverVehicleNumberPlateTableSchema::UPDATED_AT]
        );
    }
}