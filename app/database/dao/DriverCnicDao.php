<?php


class DriverCnicDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDriverCnic(DriverCnicEntity $driverCnicEntity): ?DriverCnicEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DriverCnicEntity::TABLE_NAME)
            ->columns([
                DriverCnicTableSchema::ID,
                DriverCnicTableSchema::DRIVER_ID,
                DriverCnicTableSchema::CNIC_FRONT,
                DriverCnicTableSchema::CNIC_BACK,
                DriverCnicTableSchema::CREATED_AT,
                DriverCnicTableSchema::UPDATED_AT
            ])
            ->values([
                $driverCnicEntity->getId(),
                $driverCnicEntity->getDriverId(),
                $this->escape_string($driverCnicEntity->getCnicFront()),
                $this->escape_string($driverCnicEntity->getCnicBack()),
                $driverCnicEntity->getCreatedAt(),
                $driverCnicEntity->getUpdatedAt()
            ])
            ->generate();

        mysqli_query($this->getConnection(), $query);

        return $this->getCnicOfDriver($driverCnicEntity->getDriverId());
    }

    /**
     * @param string $driverId
     * @return DriverCnicEntity|null
     */
    public function getCnicOfDriver(string $driverId): ?DriverCnicEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverCnicEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverCnicTableSchema::DRIVER_ID, '=', $driverId]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            return DriverCnicFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}