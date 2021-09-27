<?php


class PassengerFactory {
    /**
     * @param string[]|null|false $result
     * @return PassengerEntity
     */
    public static function mapFromDatabaseResult($result): PassengerEntity {
        return new PassengerEntity(
            $result[PassengerTableSchema::ID],
            $result[PassengerTableSchema::FIRST_NAME],
            $result[PassengerTableSchema::LAST_NAME],
            $result[PassengerTableSchema::USERNAME],
            $result[PassengerTableSchema::EMAIL],
            $result[PassengerTableSchema::PASSWORD],
            $result[PassengerTableSchema::ABRACADABRA],
            $result[PassengerTableSchema::PHONE],
            (int) $result[PassengerTableSchema::VERIFIED_EMAIL] === 1,
            (int) $result[PassengerTableSchema::VERIFIED_PHONE] === 1,
            $result[PassengerTableSchema::TOKEN],
            $result[PassengerTableSchema::LONGITUDE] === null ? null : (float) $result[PassengerTableSchema::LONGITUDE],
            $result[PassengerTableSchema::LATITUDE] === null ? null : (float) $result[PassengerTableSchema::LATITUDE],
            $result[PassengerTableSchema::FCM_TOKEN],
            (float) $result[PassengerTableSchema::WALLET],
            (int) $result[PassengerTableSchema::BLOCKED] === 1,
            $result[PassengerTableSchema::CREATED_AT],
            $result[PassengerTableSchema::UPDATED_AT]
        );
    }
}