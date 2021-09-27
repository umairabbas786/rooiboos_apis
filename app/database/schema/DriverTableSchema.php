<?php


class DriverTableSchema extends TableSchema {

    const ID = "id";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const USERNAME = "username";
    const EMAIL = "email";
    const PASSWORD = "password";
    const ABRACADABRA = "abracadabra";
    const PHONE = "phone";
    const VERIFIED_EMAIL = "verified_email";
    const VERIFIED_PHONE = "verified_phone";
    const TOKEN = "token";
    const SEEKING_RIDES = "seeking_rides";
    const CITY_ID = "city_id";
    const LONGITUDE = "lng";
    const LATITUDE = "lat";
    const FCM_TOKEN = "fcm_token";
    const SNEAKED_AT = "sneaked_at";
    const TOTAL_METERS = "total_meters";
    const WALLET = "wallet";
    const BLOCKED = "blocked";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(DriverEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::FIRST_NAME . " VARCHAR(150) NOT NULL,
            " . self::LAST_NAME . " VARCHAR(150) NOT NULL,
            " . self::USERNAME . " VARCHAR(150),
            " . self::EMAIL . " VARCHAR(150) NOT NULL,
            " . self::PASSWORD . " VARCHAR(150) NOT NULL,
            " . self::ABRACADABRA . " VARCHAR(150) NOT NULL,
            " . self::PHONE . " VARCHAR(100) NOT NULL,
            " . self::VERIFIED_EMAIL . " INT NOT NULL,
            " . self::VERIFIED_PHONE . " INT NOT NULL,
            " . self::TOKEN . " VARCHAR(150) NOT NULL,
            " . self::SEEKING_RIDES . " INT NOT NULL,
            " . self::CITY_ID . " VARCHAR(50) NOT NULL, 
            " . self::LONGITUDE . " VARCHAR(150),
            " . self::LATITUDE . " VARCHAR(150),
            " . self::FCM_TOKEN . " VARCHAR(170),
            " . self::SNEAKED_AT . " VARCHAR(170) NOT NULL,
            " . self::TOTAL_METERS . " VARCHAR(170) NOT NULL,
            " . self::WALLET . " VARCHAR(170) NOT NULL,
            " . self::BLOCKED . " INT NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}