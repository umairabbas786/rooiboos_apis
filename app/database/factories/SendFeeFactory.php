<?php


class SendFeeFactory {
    /**
     * @param string[]|null|false $result
     * @return SendFeeEntity
     */
    public static function mapFromDatabaseResult($result): SendFeeEntity {
        return new SendFeeEntity(
            $result[SendFeeTableSchema::SEND_FEE],
            $result[SendFeeTableSchema::CREATED_AT],
            $result[SendFeeTableSchema::UPDATED_AT]
        );
    }
}