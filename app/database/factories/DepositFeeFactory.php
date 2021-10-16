<?php


class DepositFeeFactory {
    /**
     * @param string[]|null|false $result
     * @return DepositFeeEntity
     */
    public static function mapFromDatabaseResult($result): DepositFeeEntity {
        return new DepositFeeEntity(
            $result[DepositFeeTableSchema::DEPOSIT_FEE],
            $result[DepositFeeTableSchema::CREATED_AT],
            $result[DepositFeeTableSchema::UPDATED_AT]
        );
    }
}