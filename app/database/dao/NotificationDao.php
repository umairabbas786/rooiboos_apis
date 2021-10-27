<?php


class NotificationDao extends TableDao {
    /**
     * NotificationDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function getNotificationsWithCustomerId(string $customerId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(NotificationEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [NotificationTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)]
            ))
            ->generate();

        $notifications = [];

        $result = mysqli_query($this->getConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($notifications, NotificationFactory::mapFromDatabaseResult($row));
        }

        return $notifications;
    }

    public function UpdateNotificationsOfCustomerAsRead(string $customerId, string $updateTime): bool {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(NotificationEntity::TABLE_NAME)
            ->updateParams([
                [NotificationTableSchema::STATE, $this->escape_string(NotificationState::READ)],
                [NotificationTableSchema::UPDATED_AT, $this->escape_string($updateTime)],
            ])
            ->whereParams([
                    [NotificationTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)],
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);

        return (bool) $result;

    }

}