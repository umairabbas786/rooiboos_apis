<?php


class ProfilePictureFactory {
    /**
     * @param string[]|null|false $result
     * @return ProfilePictureEntity
     */
    public static function mapFromDatabaseResult($result): ProfilePictureEntity {
        return new ProfilePictureEntity(
            $result[ProfilePictureTableSchema::ID],
            $result[ProfilePictureTableSchema::CUSTOMER_ID],
            $result[ProfilePictureTableSchema::PICTURE],
            $result[ProfilePictureTableSchema::CREATED_AT],
            $result[ProfilePictureTableSchema::UPDATED_AT]
        );
    }
}