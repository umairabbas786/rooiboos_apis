<?php


class NotificationFactory {
    /**
     * @param string[]|null|false $result
     * @return NotificationEntity
     */
    public static function mapFromDatabaseResult($result): NotificationEntity {
        return new NotificationEntity(
            $result[NotificationTableSchema::ID],
            $result[NotificationTableSchema::CUSTOMER_ID],
            $result[NotificationTableSchema::MSG],
            $result[NotificationTableSchema::STATE],
            $result[NotificationTableSchema::CREATED_AT],
            $result[NotificationTableSchema::UPDATED_AT]
        );
    }
}