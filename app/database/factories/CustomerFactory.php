<?php


class CustomerFactory {
    /**
     * @param string[]|null|false $result
     * @return CustomerEntity
     */
    public static function mapFromDatabaseResult($result): CustomerEntity {
        return new CustomerEntity(
            $result[CustomerTableSchema::ID],
            $result[CustomerTableSchema::FIRST_NAME],
            $result[CustomerTableSchema::LAST_NAME],
            $result[CustomerTableSchema::EMAIL],
            $result[CustomerTableSchema::PHONE_NUMBER],
            (int) $result[CustomerTableSchema::PHONE_VERIFICATION] === 1,
            $result[CustomerTableSchema::PASSWORD],
            $result[CustomerTableSchema::CNIC_FRONT],
            $result[CustomerTableSchema::CNIC_BACK],
            $result[CustomerTableSchema::COUNTRY],
            $result[CustomerTableSchema::ACCOUNT_HOLDER_NAME],
            $result[CustomerTableSchema::ACCOUNT_NUMBER],
            $result[CustomerTableSchema::IBAN_ACCOUNT_NUMBER],
            $result[CustomerTableSchema::ACCOUNT_TYPE],
            (int) $result[CustomerTableSchema::STATUS] === 1,
            $result[CustomerTableSchema::CREATED_AT],
            $result[CustomerTableSchema::UPDATED_AT]
        );
    }
}