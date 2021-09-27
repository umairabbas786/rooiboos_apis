<?php


class RideDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertRideEntity(RideEntity $rideEntity): ?RideEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, RideTableSchema::ID);
        array_push($insertValues, $this->escape_string($rideEntity->getId()));

        array_push($insertColumns, RideTableSchema::PASSENGER_ID);
        array_push($insertValues, $this->escape_string($rideEntity->getPassengerId()));

        array_push($insertColumns, RideTableSchema::DRIVER_ID);
        array_push($insertValues, $this->escape_string($rideEntity->getDriverId()));

        array_push($insertColumns, RideTableSchema::PICKUP_LONGITUDE);
        array_push($insertValues, $this->escape_string($rideEntity->getPickupLongitude()));

        array_push($insertColumns, RideTableSchema::PICKUP_LATITUDE);
        array_push($insertValues, $this->escape_string($rideEntity->getPickupLatitude()));

        array_push($insertColumns, RideTableSchema::PICKUP_LOCATION_NAME);
        array_push($insertValues, $this->escape_string($rideEntity->getPickupLocationName()));

        array_push($insertColumns, RideTableSchema::STATE);
        array_push($insertValues, $this->escape_string($rideEntity->getState()));

        if ($rideEntity->getMetersTravelled() !== null) {
            array_push($insertColumns, RideTableSchema::METERS_TRAVELLED);
            array_push($insertValues, $this->escape_string($rideEntity->getMetersTravelled()));
        }

        if ($rideEntity->getExitLongitude() !== null) {
            array_push($insertColumns, RideTableSchema::EXIT_LONGITUDE);
            array_push($insertValues, $this->escape_string($rideEntity->getExitLongitude()));
        }

        if ($rideEntity->getExitLatitude() !== null) {
            array_push($insertColumns, RideTableSchema::EXIT_LATITUDE);
            array_push($insertValues, $this->escape_string($rideEntity->getExitLatitude()));
        }

        if ($rideEntity->getExitLocationName() !== null) {
            array_push($insertColumns, RideTableSchema::EXIT_LOCATION_NAME);
            array_push($insertValues, $this->escape_string($rideEntity->getExitLocationName()));
        }

        array_push($insertColumns, RideTableSchema::RIDE_CATEGORY_ID);
        array_push($insertValues, $this->escape_string($rideEntity->getRideCategoryId()));

        if ($rideEntity->getBill() !== null) {
            array_push($insertColumns, RideTableSchema::BILL);
            array_push($insertValues, $this->escape_string($rideEntity->getBill()));
        }

        array_push($insertColumns, RideTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($rideEntity->getCreatedAt()));

        array_push($insertColumns, RideTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($rideEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);
        if ($result) {
            return $this->getRideEntityWithId($rideEntity->getId());
        }
        return null;
    }

    public function getRideEntityWithId(string $id): ?RideEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [RideTableSchema::ID, '=', $this->escape_string($id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return RideFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $passenger_id
     * @return array
     */
    public function getPassengerRidesWhichAreNotCompletedExcludingUserCancelledRides(string $passenger_id): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [RideTableSchema::PASSENGER_ID, '=', $passenger_id],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_REACHED_AT_DESTINATION],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_CANCELLED_THE_RIDE]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $rides = [];
        while ($ride = mysqli_fetch_assoc($result)) {
            array_push($rides, RideFactory::mapFromDatabaseResult($ride));
        }
        return $rides;
    }

    public function getNewAvailableRidesForDriver(string $driver_id): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [RideTableSchema::DRIVER_ID, '=', $this->escape_string($driver_id)],
                ['AND'],
                [RideTableSchema::STATE, '=', RideState::SENT_REQUEST_TO_DRIVER]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $rides = [];
        while ($ride = mysqli_fetch_assoc($result)) {
            array_push($rides, RideFactory::mapFromDatabaseResult($ride));
        }
        return $rides;
    }

    /**
     * @param RideEntity $rideEntity
     * @return RideEntity|null
     */
    public function updateRideEntity(RideEntity $rideEntity): ?RideEntity {
        $updateValues = [];

        array_push($updateValues,
            [RideTableSchema::PASSENGER_ID, $this->escape_string($rideEntity->getPassengerId())],
            [RideTableSchema::DRIVER_ID, $this->escape_string($rideEntity->getDriverId())],
            [RideTableSchema::PICKUP_LONGITUDE, $this->escape_string($rideEntity->getPickupLongitude())],
            [RideTableSchema::PICKUP_LATITUDE, $this->escape_string($rideEntity->getPickupLatitude())],
            [RideTableSchema::STATE, $this->escape_string($rideEntity->getState())]
        );

        if ($rideEntity->getBill() !== null) {
            array_push($updateValues, [
                RideTableSchema::BILL, $this->escape_string($rideEntity->getBill())
            ]);
        }

        if ($rideEntity->getMetersTravelled() !== null) {
            array_push($updateValues, [
                RideTableSchema::METERS_TRAVELLED, $this->escape_string($rideEntity->getMetersTravelled())
            ]);
        }

        if ($rideEntity->getExitLongitude() !== null) {
            array_push($updateValues, [
                RideTableSchema::EXIT_LONGITUDE, $this->escape_string($rideEntity->getExitLongitude())
            ]);
        }

        if ($rideEntity->getExitLatitude() !== null) {
            array_push($updateValues, [
                RideTableSchema::EXIT_LATITUDE, $this->escape_string($rideEntity->getExitLatitude())
            ]);
        }

        if ($rideEntity->getExitLocationName() !== null) {
            array_push($updateValues, [
                RideTableSchema::EXIT_LOCATION_NAME, $this->escape_string($rideEntity->getExitLocationName())
            ]);
        }

        array_push($updateValues,
            [RideTableSchema::CREATED_AT, $this->escape_string($rideEntity->getCreatedAt())],
            [RideTableSchema::UPDATED_AT, $this->escape_string($rideEntity->getUpdatedAt())]
        );

        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(RideEntity::TABLE_NAME)
            ->updateParams($updateValues)
            ->whereParams([
                [RideTableSchema::ID, '=', $this->escape_string($rideEntity->getId())]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getRideEntityWithId($rideEntity->getId());
        }
        return null;
    }

    public function deleteAllNonAcceptedRideEntitiesRelatedWith(RideEntity $rideEntity): bool {
        $query = QueryBuilder::withQueryType(QueryType::DELETE)
            ->withTableName(RideEntity::TABLE_NAME)
            ->whereParams(array(
                [RideTableSchema::ID, '!=', $this->escape_string($rideEntity->getId())],
                ['AND'],
                [RideTableSchema::PASSENGER_ID, '=', $this->escape_string($rideEntity->getPassengerId())],
                ['AND'],
                [RideTableSchema::STATE, '=', RideState::SENT_REQUEST_TO_DRIVER]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }

    public function deleteAllNonAcceptedRideEntitiesOfPassenger(string $passenger_id): bool {
        $query = QueryBuilder::withQueryType(QueryType::DELETE)
            ->withTableName(RideEntity::TABLE_NAME)
            ->whereParams(array(
                [RideTableSchema::PASSENGER_ID, '=', $this->escape_string($passenger_id)],
                ['AND'],
                [RideTableSchema::STATE, '=', RideState::SENT_REQUEST_TO_DRIVER]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }


    public function deleteRideWithRideId(string $ride_id): bool {
        $query = QueryBuilder::withQueryType(QueryType::DELETE)
            ->withTableName(RideEntity::TABLE_NAME)
            ->whereParams(array(
                [RideTableSchema::ID, '=', $this->escape_string($ride_id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }

    public function getAllInCompleteAndAwaitingRidesOfPassenger(string $passenger_id): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideTableSchema::PASSENGER_ID, '=', $this->escape_string($passenger_id)],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_CANCELLED_THE_RIDE],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_REACHED_AT_DESTINATION]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $rides = [];
        while ($ride = mysqli_fetch_assoc($result)) {
            array_push($rides, RideFactory::mapFromDatabaseResult($ride));
        }
        return $rides;
    }

    public function getCurrentRideOfDriver(string $driver_id): ?RideEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideTableSchema::DRIVER_ID, '=', $this->escape_string($driver_id)],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_REACHED_AT_DESTINATION],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::SENT_REQUEST_TO_DRIVER],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_CANCELLED_THE_RIDE]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            return RideFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getPassengerCompletedRides(string $passengerId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideTableSchema::PASSENGER_ID, '=', $this->escape_string($passengerId)],
                ['AND'],
                [RideTableSchema::STATE, '=', RideState::USER_REACHED_AT_DESTINATION]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $rides = [];

        if ($result) {
            while ($ride = mysqli_fetch_assoc($result)) {
                array_push($rides, RideFactory::mapFromDatabaseResult($ride));
            }
        }

        return $rides;
    }

    public function getDriverCompletedRides(string $driverId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideTableSchema::DRIVER_ID, '=', $this->escape_string($driverId)],
                ['AND'],
                [RideTableSchema::STATE, '=', RideState::USER_REACHED_AT_DESTINATION]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $rides = [];

        if ($result) {
            while ($ride = mysqli_fetch_assoc($result)) {
                array_push($rides, RideFactory::mapFromDatabaseResult($ride));
            }
        }

        return $rides;
    }

    public function getAllCompletedRides(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideTableSchema::STATE, '=', RideState::USER_REACHED_AT_DESTINATION]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $rides = [];

        if ($result) {
            while ($ride = mysqli_fetch_assoc($result)) {
                array_push($rides, RideFactory::mapFromDatabaseResult($ride));
            }
        }

        return $rides;
    }

    public function getCurrentRideOfPassengerIfAwaitingMapIt(&$awaiting, string $passenger_id): ?RideEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideTableSchema::PASSENGER_ID, '=', $this->escape_string($passenger_id)],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_REACHED_AT_DESTINATION],
                ['AND'],
                [RideTableSchema::STATE, '!=', RideState::USER_CANCELLED_THE_RIDE]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            $currentRide = RideFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
            if ($currentRide->getState() === RideState::SENT_REQUEST_TO_DRIVER) {
                $awaiting = true;
            } else {
                return $currentRide;
            }
        }

        return null;
    }
}
