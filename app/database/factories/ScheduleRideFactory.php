<?php


class ScheduleRideFactory {
    /**
     * @param string[]|null|false $result
     * @return ScheduleRideEntity
     */
    public static function mapFromDatabaseResult($result): ScheduleRideEntity {
        return new ScheduleRideEntity(
            $result[ScheduleRidesTableSchema::ID],
            $result[ScheduleRidesTableSchema::PASSENGER_ID],
            (float) $result[ScheduleRidesTableSchema::PICKUP_LONGITUDE],
            (float) $result[ScheduleRidesTableSchema::PICKUP_LATITUDE],
            $result[ScheduleRidesTableSchema::PICKUP_LOCATION_NAME],
            $result[ScheduleRidesTableSchema::SCHEDULE_AT],
            $result[ScheduleRidesTableSchema::SCHEDULED] === '1',
            $result[RideTableSchema::RIDE_CATEGORY_ID],
            $result[RideTableSchema::CREATED_AT],
            $result[RideTableSchema::UPDATED_AT]
        );
    }
}