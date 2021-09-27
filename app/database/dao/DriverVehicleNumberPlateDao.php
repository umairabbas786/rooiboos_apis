<?php


class DriverVehicleNumberPlateDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDriverVehicleNumberPlate(DriverVehicleNumberPlateEntity $driverVehicleNumberPlateEntity): ?DriverVehicleNumberPlateEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DriverVehicleNumberPlateEntity::TABLE_NAME)
            ->columns([
                DriverVehicleNumberPlateTableSchema::ID,
                DriverVehicleNumberPlateTableSchema::DRIVER_ID,
                DriverVehicleNumberPlateTableSchema::NUMBER_PLATE,
                DriverVehicleNumberPlateTableSchema::CREATED_AT,
                DriverVehicleNumberPlateTableSchema::UPDATED_AT
            ])
            ->values([
                $driverVehicleNumberPlateEntity->getId(),
                $driverVehicleNumberPlateEntity->getDriverId(),
                $this->escape_string($driverVehicleNumberPlateEntity->getNumberPlate()),
                $driverVehicleNumberPlateEntity->getCreatedAt(),
                $driverVehicleNumberPlateEntity->getUpdatedAt()
            ])
            ->generate();

        mysqli_query($this->getConnection(), $query);

        return $this->getDriverVehicleNumberPlate($driverVehicleNumberPlateEntity->getDriverId());
    }

    /**
     * @param string $driverId
     * @return DriverVehicleNumberPlateEntity|null
     */
    public function getDriverVehicleNumberPlate(string $driverId): ?DriverVehicleNumberPlateEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverVehicleNumberPlateEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverVehicleNumberPlateTableSchema::DRIVER_ID, '=', $driverId]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            return DriverVehicleNumberPlateFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}