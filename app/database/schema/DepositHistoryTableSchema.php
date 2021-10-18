<?php


class DepositHistoryTableSchema extends TableSchema {

    const ID = "id";
    const CUSTOMER_ID = "customer_id";
    const CURRENCY_ID = "currency_id";
    const BALANCE = "balance";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(DepositHistoryEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::CUSTOMER_ID . " VARCHAR(50) NOT NULL,
            " . self::CURRENCY_ID . " VARCHAR(50) NOT NULL,
            " . self::BALANCE . " VARCHAR(170) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}