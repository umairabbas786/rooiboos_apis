<?php


class RideCategoryTableSchema extends TableSchema {

    const ID = "id";
    const NAME = "name";
    const ENABLED = "enabled";
    const IMAGE = "image";
    const PRICE = "price";
    const PER_KM_COST = "per_km_cost";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(RideCategoryEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::NAME . " VARCHAR(150) NOT NULL,
            " . self::ENABLED . " INT NOT NULL,
            " . self::IMAGE . " VARCHAR(150) NOT NULL,
            " . self::PRICE . " VARCHAR(150) NOT NULL,
            " . self::PER_KM_COST . " VARCHAR(150) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}