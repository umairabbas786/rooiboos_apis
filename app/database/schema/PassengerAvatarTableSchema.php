<?php


class PassengerAvatarTableSchema extends TableSchema {

    const ID = "id";
    const PASSENGER_ID = "passenger_id";
    const AVATAR = "avatar";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(PassengerAvatarEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::PASSENGER_ID . " VARCHAR(50) NOT NULL,
            " . self::AVATAR . " VARCHAR(150) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}