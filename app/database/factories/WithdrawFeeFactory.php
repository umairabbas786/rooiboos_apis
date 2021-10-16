<?php


class WithdrawFeeFactory {
    /**
     * @param string[]|null|false $result
     * @return WithdrawFeeEntity
     */
    public static function mapFromDatabaseResult($result): WithdrawFeeEntity {
        return new WithdrawFeeEntity(
            $result[WithdrawFeeTableSchema::WITHDRAW_FEE],
            $result[WithdrawFeeTableSchema::CREATED_AT],
            $result[WithdrawFeeTableSchema::UPDATED_AT]
        );
    }
}