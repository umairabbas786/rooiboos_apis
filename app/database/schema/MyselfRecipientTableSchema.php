<?php


class MyselfRecipientTableSchema extends TableSchema {

    const ID = "id";
    const CUSTOMER_ID = "customer_id";
    const CURRENCY_ID = "currency_id";
    const BANK_ID = "bank_id";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const IBAN = "iban";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(MyselfRecipientEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::CUSTOMER_ID . " VARCHAR(50) NOT NULL,
            " . self::CURRENCY_ID . " VARCHAR(50) NOT NULL,
            " . self::BANK_ID . " VARCHAR(50) NOT NULL,
            " . self::ACCOUNT_HOLDER_NAME . " VARCHAR(150) NOT NULL,
            " . self::IBAN . " VARCHAR(50) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}