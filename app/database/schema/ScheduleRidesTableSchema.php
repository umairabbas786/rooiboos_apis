<?php


class ScheduleRidesTableSchema extends TableSchema {

    const ID = "id";
    const PASSENGER_ID = "passenger_id";
    const PICKUP_LONGITUDE = "pickup_lng";
    const PICKUP_LATITUDE = "pickup_lat";
    const PICKUP_LOCATION_NAME = "pickup_location_name";
    const SCHEDULE_AT = "schedule_at";
    const SCHEDULED = "scheduled";
    const RIDE_CATEGORY_ID = "ride_category_id";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(ScheduleRideEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::PASSENGER_ID . " VARCHAR(50) NOT NULL,
            " . self::PICKUP_LONGITUDE . " VARCHAR(150) NOT NULL,
            " . self::PICKUP_LATITUDE . " VARCHAR(150) NOT NULL,
            " . self::PICKUP_LOCATION_NAME . " VARCHAR(150) NOT NULL,
            " . self::SCHEDULE_AT . " VARCHAR(100) NOT NULL,
            " . self::SCHEDULED . " INT NOT NULL,
            " . self::RIDE_CATEGORY_ID . " VARCHAR(50) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}
