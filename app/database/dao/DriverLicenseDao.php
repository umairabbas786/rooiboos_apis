<?php


class DriverLicenseDao extends TableDao {

    /**
     * DriverLicenseDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDriverLicense(DriverLicenseEntity $driverLicenseEntity): ?DriverLicenseEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DriverLicenseEntity::TABLE_NAME)
            ->columns([
                DriverLicenseTableSchema::ID,
                DriverLicenseTableSchema::DRIVER_ID,
                DriverLicenseTableSchema::LICENSE_FRONT,
                DriverLicenseTableSchema::LICENSE_BACK,
                DriverLicenseTableSchema::CREATED_AT,
                DriverLicenseTableSchema::UPDATED_AT
            ])
            ->values([
                $driverLicenseEntity->getId(),
                $driverLicenseEntity->getDriverId(),
                $this->escape_string($driverLicenseEntity->getLicenseFront()),
                $this->escape_string($driverLicenseEntity->getLicenseBack()),
                $driverLicenseEntity->getCreatedAt(),
                $driverLicenseEntity->getUpdatedAt()
            ])
            ->generate();

        mysqli_query($this->getConnection(), $query);

        return $this->getLicenseOfDriver($driverLicenseEntity->getDriverId());
    }

    /**
     * @param string $driverId
     * @return DriverLicenseEntity|null
     */
    public function getLicenseOfDriver(string $driverId): ?DriverLicenseEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverLicenseEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverLicenseTableSchema::DRIVER_ID, '=', $driverId]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            return DriverLicenseFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}