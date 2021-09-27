<?php


class DriverFactory {
    /**
     * @param string[]|null|false $result
     * @return DriverEntity
     */
    public static function mapFromDatabaseResult($result): DriverEntity {
        return new DriverEntity(
            $result[DriverTableSchema::ID],
            $result[DriverTableSchema::FIRST_NAME],
            $result[DriverTableSchema::LAST_NAME],
            $result[DriverTableSchema::USERNAME],
            $result[DriverTableSchema::EMAIL],
            $result[DriverTableSchema::PASSWORD],
            $result[DriverTableSchema::ABRACADABRA],
            $result[DriverTableSchema::PHONE],
            (int) $result[DriverTableSchema::VERIFIED_EMAIL] === 1,
            (int) $result[DriverTableSchema::VERIFIED_PHONE] === 1,
            $result[DriverTableSchema::TOKEN],
            (int) $result[DriverTableSchema::SEEKING_RIDES] === 1,
            $result[DriverTableSchema::CITY_ID],
            $result[DriverTableSchema::LONGITUDE] === null ? null : (float) $result[DriverTableSchema::LONGITUDE],
            $result[DriverTableSchema::LATITUDE] === null ? null : (float) $result[DriverTableSchema::LATITUDE],
            $result[DriverTableSchema::FCM_TOKEN],
            $result[DriverTableSchema::SNEAKED_AT],
            $result[DriverTableSchema::TOTAL_METERS],
            (float) $result[DriverTableSchema::WALLET],
            (int) $result[DriverTableSchema::BLOCKED] === 1,
            $result[DriverTableSchema::CREATED_AT],
            $result[DriverTableSchema::UPDATED_AT]
        );
    }
}