<?php


class BankTableSchema extends TableSchema {

    const ID = "id";
    const NAME = "name";
    const CITY = "city";
    const COUNTRY = "country";
    const STATUS = "status";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(BankEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::NAME . " VARCHAR(150) NOT NULL,
            " . self::CITY . " VARCHAR(150) NOT NULL,
            " . self::COUNTRY . " VARCHAR(150) NOT NULL,
            " . self::STATUS . " INT NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}