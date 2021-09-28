<?php


class CustomerTableSchema extends TableSchema {

    const ID = "id";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const EMAIL = "email";
    const PHONE_NUMBER = "phone_number";
    const PHONE_VERIFICATION = "phone_verification";
    const PASSWORD = "password";
    const CNIC_FRONT = "cnic_front";
    const CNIC_BACK = "cnic_back";
    const COUNTRY = "country";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const ACCOUNT_NUMBER = "account_number";
    const IBAN_ACCOUNT_NUMBER = "iban_account_number";
    const ACCOUNT_TYPE = "account_type";
    const STATUS = "status";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    public function __construct() { parent::__construct(CustomerEntity::TABLE_NAME); }

    public function getBlueprint(): string {
        return "CREATE TABLE IF NOT EXISTS " . $this->getTableName() . "(
            " . self::ID . " VARCHAR(50) PRIMARY KEY NOT NULL,
            " . self::FIRST_NAME . " VARCHAR(150) NOT NULL,
            " . self::LAST_NAME . " VARCHAR(150) NOT NULL,
            " . self::EMAIL . " VARCHAR(150) NOT NULL,
            " . self::PHONE_NUMBER . " VARCHAR(150) NOT NULL,
            " . self::PHONE_VERIFICATION . " INT NOT NULL,
            " . self::PASSWORD . " VARCHAR(150) NOT NULL,
            " . self::CNIC_FRONT . " VARCHAR(150) NOT NULL,
            " . self::CNIC_BACK . " VARCHAR(150) NOT NULL,
            " . self::COUNTRY . " VARCHAR(100) NOT NULL,
            " . self::ACCOUNT_HOLDER_NAME . " VARCHAR(100) NOT NULL,
            " . self::ACCOUNT_NUMBER . " VARCHAR(150) NOT NULL,
            " . self::IBAN_ACCOUNT_NUMBER . " VARCHAR(100) NOT NULL,
            " . self::ACCOUNT_TYPE . " VARCHAR(50) NOT NULL, 
            " . self::STATUS . " INT NOT NULL,
            " . self::CREATED_AT . " VARCHAR(100) NOT NULL,
            " . self::UPDATED_AT . " VARCHAR(100) NOT NULL
        )";
    }
}