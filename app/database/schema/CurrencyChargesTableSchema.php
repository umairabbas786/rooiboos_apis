<?php


class CurrencyChargesTableSchema extends TableSchema {

    const ID = "id";
    const FROM = "from_id";
    const TO = "to_id";
    const RATE = "rate";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(CurrencyChargesEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::FROM . " VARCHAR(150) NOT NULL,
            " . self::TO . " VARCHAR(150) NOT NULL,
            " . self::RATE . " VARCHAR(150) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}