<?php


class FreeDistanceFactory {
    /**
     * @param string[]|null|false $result
     * @return FreeDistanceEntity
     */
    public static function mapFromDatabaseResult($result): FreeDistanceEntity {
        return new FreeDistanceEntity(
            (float) $result[FreeDistanceTableSchema::DISTANCE_IN_METERS],
            $result[FreeDistanceTableSchema::CREATED_AT],
            $result[FreeDistanceTableSchema::UPDATED_AT]
        );
    }
}