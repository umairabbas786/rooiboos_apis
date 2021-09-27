<?php


class DriverDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDriver(DriverEntity $driverEntity): ?DriverEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, DriverTableSchema::ID);
        array_push($insertValues, $this->escape_string($driverEntity->getId()));

        array_push($insertColumns, DriverTableSchema::FIRST_NAME);
        array_push($insertValues, $this->escape_string($driverEntity->getFirstName()));

        array_push($insertColumns, DriverTableSchema::LAST_NAME);
        array_push($insertValues, $this->escape_string($driverEntity->getLastName()));

        if ($driverEntity->getUsername() !== null) {
            array_push($insertColumns, DriverTableSchema::USERNAME);
            array_push($insertValues, $this->escape_string($driverEntity->getUsername()));
        }

        array_push($insertColumns, DriverTableSchema::EMAIL);
        array_push($insertValues, $this->escape_string($driverEntity->getEmail()));

        array_push($insertColumns, DriverTableSchema::PASSWORD);
        array_push($insertValues, $this->escape_string($driverEntity->getPassword()));

        array_push($insertColumns, DriverTableSchema::ABRACADABRA);
        array_push($insertValues, $this->escape_string($driverEntity->getAbracadabra()));

        array_push($insertColumns, DriverTableSchema::PHONE);
        array_push($insertValues, $this->escape_string($driverEntity->getPhone()));

        array_push($insertColumns, DriverTableSchema::VERIFIED_EMAIL);
        array_push($insertValues, $this->wrapBool($driverEntity->isVerifiedEmail()));

        array_push($insertColumns, DriverTableSchema::VERIFIED_PHONE);
        array_push($insertValues, $this->wrapBool($driverEntity->isVerifiedPhone()));

        array_push($insertColumns, DriverTableSchema::TOKEN);
        array_push($insertValues, $this->escape_string($driverEntity->getToken()));

        array_push($insertColumns, DriverTableSchema::SEEKING_RIDES);
        array_push($insertValues, $this->wrapBool($driverEntity->isSeekingRides()));

        array_push($insertColumns, DriverTableSchema::CITY_ID);
        array_push($insertValues, $this->escape_string($driverEntity->getCityId()));

        if ($driverEntity->getLongitude() !== null) {
            array_push($insertColumns, DriverTableSchema::LONGITUDE);
            array_push($insertValues, $this->escape_string($driverEntity->getLongitude()));
        }

        if ($driverEntity->getLatitude() !== null) {
            array_push($insertColumns, DriverTableSchema::LATITUDE);
            array_push($insertValues, $this->escape_string($driverEntity->getLatitude()));
        }

        if ($driverEntity->getFcmToken() !== null) {
            array_push($insertColumns, DriverTableSchema::FCM_TOKEN);
            array_push($insertValues, $this->escape_string($driverEntity->getFcmToken()));
        }

        array_push($insertColumns, DriverTableSchema::SNEAKED_AT);
        array_push($insertValues, $this->escape_string($driverEntity->getSneakedAt()));

        array_push($insertColumns, DriverTableSchema::TOTAL_METERS);
        array_push($insertValues, $this->escape_string($driverEntity->getTotalMeters()));

        array_push($insertColumns, DriverTableSchema::WALLET);
        array_push($insertValues, $this->escape_string($driverEntity->getWallet()));

        array_push($insertColumns, DriverTableSchema::BLOCKED);
        array_push($insertValues, $this->wrapBool($driverEntity->isBlocked()));

        array_push($insertColumns, DriverTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($driverEntity->getCreatedAt()));

        array_push($insertColumns, DriverTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($driverEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverWithId($driverEntity->getId());
        }

        return null;
    }

    /**
     * @param string $driverId
     * @return DriverEntity|null
     */
    public function getDriverWithId(string $driverId): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array([DriverTableSchema::ID, '=', $this->escape_string($driverId)]))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return DriverFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $phone
     * @return DriverEntity|null
     */
    public function getDriverWithPhone(string $phone): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverTableSchema::PHONE, '=', $this->escape_string($phone)]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return DriverFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }

        return null;
    }

    public function getDriversForSendingRideThoseWhoHaveRideCategoryIdOf(string $rideCategoryId): array {
        $query = 'SELECT ' . DriverEntity::TABLE_NAME . '.* FROM ' . DriverEntity::TABLE_NAME .
            ' INNER JOIN ' . DriverRideCategoryEntity::TABLE_NAME .
            ' ON ' . DriverRideCategoryEntity::TABLE_NAME . '.' . DriverRideCategoryTableSchema::DRIVER_ID . '=' . DriverEntity::TABLE_NAME . '.' . DriverTableSchema::ID .
            ' WHERE ' . DriverRideCategoryTableSchema::RIDE_CATEGORY_ID . '=' . '\'' . $this->escape_string($rideCategoryId) . '\'' .
            ' AND ' . DriverTableSchema::LONGITUDE . '!=\'\' ' .
            ' AND ' . DriverTableSchema::LATITUDE . '!=\'\' ' .
            ' AND ' . DriverTableSchema::FCM_TOKEN . '!=\'\' ' .
            ' AND ' . DriverTableSchema::SEEKING_RIDES . '=\'1\'';

        $result = mysqli_query($this->getConnection(), $query);

        $drivers = [];

        while ($driver = mysqli_fetch_assoc($result)) {
            array_push($drivers, DriverFactory::mapFromDatabaseResult($driver));
        }

        return $drivers;
    }

    /**
     * @return array
     */
    public function getAllOnlineDrivers(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverTableSchema::SEEKING_RIDES, '=', '1']
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $drivers = [];

        while ($driver = mysqli_fetch_assoc($result)) {
            array_push($drivers, DriverFactory::mapFromDatabaseResult($driver));
        }

        return $drivers;
    }


    /**
     * @return array
     */
    public function getAllDrivers(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->columns(['*'])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $drivers = [];

        while ($driver = mysqli_fetch_assoc($result)) {
            array_push($drivers, DriverFactory::mapFromDatabaseResult($driver));
        }

        return $drivers;
    }

    public function updateDriverFCMToken(string $driverId, string $fcm_token): bool {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::FCM_TOKEN, $this->escape_string($fcm_token)]
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }

    public function updateDriverLongitudeLatitude(string $driverId, string $longitude, string $latitude): bool {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::LONGITUDE, $this->escape_string($longitude)],
                [DriverTableSchema::LATITUDE, $this->escape_string($latitude)]
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }

    public function updateDriverWallet(string $driverId, float $newAmount): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::WALLET, $this->escape_string($newAmount)]
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverWithId($driverId);
        }
        return null;
    }

    public function updateDriverSeekingRidesStatus(DriverEntity $driverEntity): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::SEEKING_RIDES, $this->wrapBool($driverEntity->isSeekingRides())],
                [DriverTableSchema::SNEAKED_AT, $this->wrapBool($driverEntity->getSneakedAt())],
                [DriverTableSchema::TOTAL_METERS, $this->escape_string($driverEntity->getTotalMeters())]
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverEntity->getId())]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverWithId($driverEntity->getId());
        }
        return null;
    }

    public function updateDriverBlockStatus(string $driverId, bool $blocked): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::BLOCKED, $blocked ? '1' : '0']
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverWithId($driverId);
        }
        return null;
    }

    public function updateDriverTotalMetersWithSneakedAt(DriverEntity $driverEntity): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::TOTAL_METERS, $this->escape_string($driverEntity->getTotalMeters())],
                [DriverTableSchema::SNEAKED_AT, $this->escape_string($driverEntity->getSneakedAt())],
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverEntity->getId())]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverWithId($driverEntity->getId());
        }
        return null;
    }


    public function updateDriverTotalMeters(string $driverId, float $totalMeters): ?DriverEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(DriverEntity::TABLE_NAME)
            ->updateParams(array(
                [DriverTableSchema::TOTAL_METERS, $this->escape_string($totalMeters)]
            ))
            ->whereParams(array(
                [DriverTableSchema::ID, '=', $this->escape_string($driverId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverWithId($driverId);
        }
        return null;
    }
}