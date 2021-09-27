<?php


class ScheduleRideDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertScheduleRideEntity(ScheduleRideEntity $scheduleRideEntity): ?ScheduleRideEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, ScheduleRidesTableSchema::ID);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getId()));

        array_push($insertColumns, ScheduleRidesTableSchema::PASSENGER_ID);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getPassengerId()));

        array_push($insertColumns, ScheduleRidesTableSchema::PICKUP_LONGITUDE);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getPickupLongitude()));

        array_push($insertColumns, ScheduleRidesTableSchema::PICKUP_LATITUDE);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getPickupLatitude()));

        array_push($insertColumns, ScheduleRidesTableSchema::PICKUP_LOCATION_NAME);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getPickupLocationName()));

        array_push($insertColumns, ScheduleRidesTableSchema::SCHEDULE_AT);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getScheduleAt()));

        array_push($insertColumns, ScheduleRidesTableSchema::SCHEDULED);
        array_push($insertValues, $this->wrapBool($scheduleRideEntity->isScheduled()));

        array_push($insertColumns, RideTableSchema::RIDE_CATEGORY_ID);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getRideCategoryId()));

        array_push($insertColumns, RideTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getCreatedAt()));

        array_push($insertColumns, RideTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($scheduleRideEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(ScheduleRideEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);
        if ($result) {
            return $this->getScheduleRideEntityWithId($scheduleRideEntity->getId());
        }
        return null;
    }

    public function getMyScheduledRides(string $passengerId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(ScheduleRideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [ScheduleRidesTableSchema::PASSENGER_ID, '=', $this->escape_string($passengerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $scheduledRides = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($scheduledRides, ScheduleRideFactory::mapFromDatabaseResult($row));
            }
        }
        return $scheduledRides;
    }

    public function getAllScheduledRides(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(ScheduleRideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [ScheduleRidesTableSchema::SCHEDULED, '=', '0']
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $scheduledRides = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($scheduledRides, ScheduleRideFactory::mapFromDatabaseResult($row));
            }
        }
        return $scheduledRides;
    }

    public function getScheduleRideEntityWithId(string $id): ?ScheduleRideEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(ScheduleRideEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [ScheduleRidesTableSchema::ID, '=', $this->escape_string($id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return ScheduleRideFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function updateScheduledRideToScheduled(string $id): ?ScheduleRideEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(ScheduleRideEntity::TABLE_NAME)
            ->updateParams(array(
                [ScheduleRidesTableSchema::SCHEDULED, '1']
            ))
            ->whereParams(array(
                [ScheduleRidesTableSchema::ID, '=', $this->escape_string($id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return ScheduleRideFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}
