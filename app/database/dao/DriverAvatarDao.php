<?php


class DriverAvatarDao extends TableDao {

    /**
     * DriverAvatarDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    /**
     * @param DriverAvatarEntity $DriverAvatarEntity
     * @return DriverAvatarEntity|null
     */
    public function insertAvatar(DriverAvatarEntity $DriverAvatarEntity): ?DriverAvatarEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
                    ->withTableName(DriverAvatarEntity::TABLE_NAME)
                    ->columns([
                        DriverAvatarTableSchema::ID,
                        DriverAvatarTableSchema::DRIVER_ID,
                        DriverAvatarTableSchema::AVATAR,
                        DriverAvatarTableSchema::CREATED_AT,
                        DriverAvatarTableSchema::UPDATED_AT
                    ])
                    ->values([
                        $DriverAvatarEntity->getId(),
                        $DriverAvatarEntity->getDriverId(),
                        $this->escape_string($DriverAvatarEntity->getAvatar()),
                        $DriverAvatarEntity->getCreatedAt(),
                        $DriverAvatarEntity->getUpdatedAt()
                    ])
                    ->generate();

        mysqli_query($this->getConnection(), $query);

        return $this->getAvatarOfDriver($DriverAvatarEntity->getDriverId());
    }

    /**
     * @param string $avatar_id
     * @return DriverAvatarEntity|null
     */
    public function getAvatar(string $avatar_id): ?DriverAvatarEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverAvatarEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverAvatarTableSchema::ID, '=', $avatar_id]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return DriverAvatarFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $driverId
     * @return DriverAvatarEntity|null
     */
    public function getAvatarOfDriver(string $driverId): ?DriverAvatarEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverAvatarEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverAvatarTableSchema::DRIVER_ID, '=', $this->escape_string($driverId)]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            return DriverAvatarFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

}