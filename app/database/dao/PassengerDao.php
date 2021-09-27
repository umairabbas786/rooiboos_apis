<?php


class PassengerDao extends TableDao {

    /**
     * PassengerDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    /**
     * @param PassengerEntity $passengerEntity
     * @return PassengerEntity|null
     */
    public function insertPassenger(PassengerEntity $passengerEntity): ?PassengerEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, PassengerTableSchema::ID);
        array_push($insertValues, $this->escape_string($passengerEntity->getId()));

        array_push($insertColumns, PassengerTableSchema::FIRST_NAME);
        array_push($insertValues, $this->escape_string($passengerEntity->getFirstName()));

        array_push($insertColumns, PassengerTableSchema::LAST_NAME);
        array_push($insertValues, $this->escape_string($passengerEntity->getLastName()));

        if ($passengerEntity->getUsername() !== null) {
            array_push($insertColumns, PassengerTableSchema::USERNAME);
            array_push($insertValues, $this->escape_string($passengerEntity->getUsername()));
        }

        array_push($insertColumns, PassengerTableSchema::EMAIL);
        array_push($insertValues, $this->escape_string($passengerEntity->getEmail()));

        array_push($insertColumns, PassengerTableSchema::PASSWORD);
        array_push($insertValues, $this->escape_string($passengerEntity->getPassword()));

        array_push($insertColumns, PassengerTableSchema::ABRACADABRA);
        array_push($insertValues, $this->escape_string($passengerEntity->getAbracadabra()));

        array_push($insertColumns, PassengerTableSchema::PHONE);
        array_push($insertValues, $this->escape_string($passengerEntity->getPhone()));

        array_push($insertColumns, PassengerTableSchema::VERIFIED_EMAIL);
        array_push($insertValues, $this->wrapBool($passengerEntity->isVerifiedEmail()));

        array_push($insertColumns, PassengerTableSchema::VERIFIED_PHONE);
        array_push($insertValues, $this->wrapBool($passengerEntity->isVerifiedPhone()));

        array_push($insertColumns, PassengerTableSchema::TOKEN);
        array_push($insertValues, $this->escape_string($passengerEntity->getToken()));

        if ($passengerEntity->getLongitude() !== null) {
            array_push($insertColumns, PassengerTableSchema::LONGITUDE);
            array_push($insertValues, $this->escape_string($passengerEntity->getLongitude()));
        }

        if ($passengerEntity->getLatitude() !== null) {
            array_push($insertColumns, PassengerTableSchema::LATITUDE);
            array_push($insertValues, $this->escape_string($passengerEntity->getLatitude()));
        }

        if ($passengerEntity->getFcmToken() !== null) {
            array_push($insertColumns, PassengerTableSchema::FCM_TOKEN);
            array_push($insertValues, $this->escape_string($passengerEntity->getFcmToken()));
        }

        array_push($insertColumns, PassengerTableSchema::WALLET);
        array_push($insertValues, $this->escape_string($passengerEntity->getWallet()));

        array_push($insertColumns, PassengerTableSchema::BLOCKED);
        array_push($insertValues, $this->wrapBool($passengerEntity->isBlocked()));

        array_push($insertColumns, PassengerTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($passengerEntity->getCreatedAt()));

        array_push($insertColumns, PassengerTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($passengerEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);
        if ($result) {
            return $this->getPassengerWithId($passengerEntity->getId());
        }
        return null;
    }

    /**
     * @param string $passengerId
     * @return PassengerEntity|null
     */
    public function getPassengerWithId(string $passengerId): ?PassengerEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [PassengerTableSchema::ID, '=', $this->escape_string($passengerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return PassengerFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $phone
     * @return PassengerEntity|null
     */
    public function getPassengerWithPhone(string $phone): ?PassengerEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [PassengerTableSchema::PHONE, '=', $this->escape_string($phone)]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return PassengerFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }

        return null;
    }

    /**
     * @return array
     */
    public function getAllPassengers(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->columns(['*'])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $passengers = [];

        while ($passenger = mysqli_fetch_assoc($result)) {
            array_push($passengers, PassengerFactory::mapFromDatabaseResult($passenger));
        }

        return $passengers;
    }

    /**
     * @param string $passenger_id
     * @param string $fcm_token
     * @return bool
     */
    public function updatePassengerFCMToken(string $passenger_id, string $fcm_token): bool {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->updateParams(array(
                [PassengerTableSchema::FCM_TOKEN, $this->escape_string($fcm_token)]
            ))
            ->whereParams(array(
                [PassengerTableSchema::ID, '=', $this->escape_string($passenger_id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }

    public function updatePassengerWallet(string $passengerId, float $newAmount): ?PassengerEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->updateParams(array(
                [PassengerTableSchema::WALLET, $this->escape_string($newAmount)]
            ))
            ->whereParams(array(
                [PassengerTableSchema::ID, '=', $this->escape_string($passengerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getPassengerWithId($passengerId);
        }
        return null;
    }

    /**
     * @param string $passenger_id
     * @param string $longitude
     * @param string $latitude
     * @return bool
     */
    public function updatePassengerLongitudeLatitude(string $passenger_id, string $longitude, string $latitude): bool {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->updateParams(array(
                [PassengerTableSchema::LONGITUDE, $this->escape_string($longitude)],
                [PassengerTableSchema::LATITUDE, $this->escape_string($latitude)]
            ))
            ->whereParams(array(
                [PassengerTableSchema::ID, '=', $this->escape_string($passenger_id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }

    public function updatePassengerBlockStatus(string $passengerId, bool $blocked): ?PassengerEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(PassengerEntity::TABLE_NAME)
            ->updateParams(array(
                [PassengerTableSchema::BLOCKED, $blocked ? '1' : '0']
            ))
            ->whereParams(array(
                [PassengerTableSchema::ID, '=', $this->escape_string($passengerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getPassengerWithId($passengerId);
        }
        return null;
    }


}