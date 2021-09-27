<?php


class RideTableSchema extends TableSchema {

    const ID = "id";
    const PASSENGER_ID = "passenger_id";
    const DRIVER_ID = "driver_id";
    const PICKUP_LONGITUDE = "pickup_lng";
    const PICKUP_LATITUDE = "pickup_lat";
    const PICKUP_LOCATION_NAME = "pickup_location_name";
    const STATE = "state";
    const METERS_TRAVELLED = "meters_travelled";
    const EXIT_LONGITUDE = "exit_longitude";
    const EXIT_LATITUDE = "exit_latitude";
    const EXIT_LOCATION_NAME = "exit_location_name";
    const RIDE_CATEGORY_ID = "ride_category_id";
    const BILL = "bill";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(RideEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::PASSENGER_ID . " VARCHAR(50) NOT NULL,
            " . self::DRIVER_ID . " VARCHAR(50) NOT NULL,
            " . self::PICKUP_LONGITUDE . " VARCHAR(150) NOT NULL,
            " . self::PICKUP_LATITUDE . " VARCHAR(150) NOT NULL,
            " . self::PICKUP_LOCATION_NAME . " VARCHAR(150) NOT NULL,
            " . self::STATE . " VARCHAR(100) NOT NULL,
            " . self::METERS_TRAVELLED . " VARCHAR(100),
            " . self::EXIT_LONGITUDE . " VARCHAR(150),
            " . self::EXIT_LATITUDE . " VARCHAR(150),
            " . self::EXIT_LOCATION_NAME . " VARCHAR(150),
            " . self::RIDE_CATEGORY_ID . " VARCHAR(50) NOT NULL,
            " . self::BILL . " VARCHAR(170),
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}