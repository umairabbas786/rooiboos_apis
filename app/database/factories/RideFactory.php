<?php


class RideFactory {
    /**
     * @param string[]|null|false $result
     * @return RideEntity
     */
    public static function mapFromDatabaseResult($result): RideEntity {
        return new RideEntity(
            $result[RideTableSchema::ID],
            $result[RideTableSchema::PASSENGER_ID],
            $result[RideTableSchema::DRIVER_ID],
            (float) $result[RideTableSchema::PICKUP_LONGITUDE],
            (float) $result[RideTableSchema::PICKUP_LATITUDE],
            $result[RideTableSchema::PICKUP_LOCATION_NAME],
            $result[RideTableSchema::STATE],
            $result[RideTableSchema::METERS_TRAVELLED] === null ? null : (float) $result[RideTableSchema::METERS_TRAVELLED],
            $result[RideTableSchema::EXIT_LONGITUDE] === null ? null : (float) $result[RideTableSchema::EXIT_LONGITUDE],
            $result[RideTableSchema::EXIT_LATITUDE] === null ? null : (float) $result[RideTableSchema::EXIT_LATITUDE],
            $result[RideTableSchema::EXIT_LOCATION_NAME],
            $result[RideTableSchema::RIDE_CATEGORY_ID],
            $result[RideTableSchema::BILL] === null ? null : (float) $result[RideTableSchema::BILL],
            $result[RideTableSchema::CREATED_AT],
            $result[RideTableSchema::UPDATED_AT]
        );
    }
}