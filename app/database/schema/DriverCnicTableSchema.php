<?php


class DriverCnicTableSchema extends TableSchema {

    const ID = "id";
    const DRIVER_ID = "driver_id";
    const CNIC_FRONT = "cnic_front";
    const CNIC_BACK = "cnic_back";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(DriverCnicEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::DRIVER_ID . " VARCHAR(50) NOT NULL,
            " . self::CNIC_FRONT . " VARCHAR(150) NOT NULL,
            " . self::CNIC_BACK . " VARCHAR(150) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}