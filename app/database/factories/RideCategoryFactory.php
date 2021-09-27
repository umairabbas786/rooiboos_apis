<?php


class RideCategoryFactory {
    /**
     * @param string[]|null|false $result
     * @return RideCategoryEntity
     */
    public static function mapFromDatabaseResult($result): RideCategoryEntity {
        return new RideCategoryEntity(
            $result[RideCategoryTableSchema::ID],
            $result[RideCategoryTableSchema::NAME],
            $result[RideCategoryTableSchema::IMAGE],
            $result[RideCategoryTableSchema::PRICE],
            (int) $result[RideCategoryTableSchema::PER_KM_COST],
            $result[RideCategoryTableSchema::CREATED_AT],
            $result[RideCategoryTableSchema::UPDATED_AT],
            (int) $result[RideCategoryTableSchema::ENABLED] === 1
        );
    }
}