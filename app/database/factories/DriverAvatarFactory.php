<?php


class DriverAvatarFactory {
    /**
     * @param string[]|null|false $result
     * @return DriverAvatarEntity
     */
    public static function mapFromDatabaseResult($result): DriverAvatarEntity {
        return new DriverAvatarEntity(
            $result[DriverAvatarTableSchema::ID],
            $result[DriverAvatarTableSchema::DRIVER_ID],
            $result[DriverAvatarTableSchema::AVATAR],
            $result[DriverAvatarTableSchema::CREATED_AT],
            $result[DriverAvatarTableSchema::UPDATED_AT]
        );
    }
}