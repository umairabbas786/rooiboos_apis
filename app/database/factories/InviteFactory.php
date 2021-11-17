<?php


class InviteFactory {
    /**
     * @param string[]|null|false $result
     * @return InviteEntity
     */
    public static function mapFromDatabaseResult($result): InviteEntity {
        return new InviteEntity(
            $result[InviteTableSchema::ID],
            $result[InviteTableSchema::CUSTOMER_ID],
            $result[InviteTableSchema::CODE],
            $result[InviteTableSchema::CREATED_AT],
            $result[InviteTableSchema::UPDATED_AT]
        );
    }
}