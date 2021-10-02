<?php


class CustomerWalletFactory {
    /**
     * @param string[]|null|false $result
     * @return CustomerWalletEntity
     */
    public static function mapFromDatabaseResult($result): CustomerWalletEntity {
        return new CustomerWalletEntity(
            $result[CustomerWalletTableSchema::ID],
            $result[CustomerWalletTableSchema::CUSTOMER_ID],
            $result[CustomerWalletTableSchema::CURRENCY_ID],
            (float) $result[CustomerWalletTableSchema::BALANCE],
            $result[CustomerWalletTableSchema::CREATED_AT],
            $result[CustomerWalletTableSchema::UPDATED_AT]
        );
    }
}