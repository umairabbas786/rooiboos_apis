<?php


class WithdrawFeeTableSchema extends TableSchema {

    const ID = "id";
    const WITHDRAW_FEE = "withdraw_fee";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(WithdrawFeeEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::WITHDRAW_FEE . " VARCHAR(150) NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}
