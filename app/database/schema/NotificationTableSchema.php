<?php


class NotificationTableSchema extends TableSchema {

    const ID = "id";
    const CUSTOMER_ID = "customer_id";
    const MSG = "msg";
    const STATE = "state";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(NotificationEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::CUSTOMER_ID . " VARCHAR(50) NOT NULL,
            " . self::MSG . " VARCHAR(500) NOT NULL,
            " . self::STATE . " VARCHAR(30) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}