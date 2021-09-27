<?php


class PassengerAvatarFactory {
    /**
     * @param string[]|null|false $result
     * @return PassengerAvatarEntity
     */
    public static function mapFromDatabaseResult($result): PassengerAvatarEntity {
        return new PassengerAvatarEntity(
            $result[PassengerAvatarTableSchema::ID],
            $result[PassengerAvatarTableSchema::PASSENGER_ID],
            $result[PassengerAvatarTableSchema::AVATAR],
            $result[PassengerAvatarTableSchema::CREATED_AT],
            $result[PassengerAvatarTableSchema::UPDATED_AT]
        );
    }
}