<?php


class DriverRideCategoryDao extends TableDao {

    /**
     * DriverRideCategoryDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDriverRideCategory(DriverRideCategoryEntity $driverRideCategoryEntity): ?DriverRideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
                    ->withTableName(DriverRideCategoryEntity::TABLE_NAME)
                    ->columns([
                        DriverRideCategoryTableSchema::ID,
                        DriverRideCategoryTableSchema::DRIVER_ID,
                        DriverRideCategoryTableSchema::RIDE_CATEGORY_ID,
                        DriverRideCategoryTableSchema::CREATED_AT,
                        DriverRideCategoryTableSchema::UPDATED_AT
                    ])
                    ->values([
                        $this->escape_string($driverRideCategoryEntity->getId()),
                        $this->escape_string($driverRideCategoryEntity->getDriverId()),
                        $this->escape_string($driverRideCategoryEntity->getRideCategoryId()),
                        $this->escape_string($driverRideCategoryEntity->getCreatedAt()),
                        $this->escape_string($driverRideCategoryEntity->getUpdatedAt())
                    ])
                    ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDriverRideCategoryById($driverRideCategoryEntity->getId());
        }
        return null;
    }

    public function getDriverRideCategoriesByDriverId(string $driverId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverRideCategoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverRideCategoryTableSchema::DRIVER_ID, '=', $this->escape_string($driverId)]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $driverRideCategories = [];

        while ($category = mysqli_fetch_assoc($result)) {
            array_push($driverRideCategories, DriverRideCategoryFactory::mapFromDatabaseResult($category));
        }

        return $driverRideCategories;
    }

    public function getDriverRideCategoryById(string $id): ?DriverRideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DriverRideCategoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [DriverRideCategoryTableSchema::ID, '=', $id]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return DriverRideCategoryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function deleteDriverRideCategoryById(string $id): bool {
        $query = QueryBuilder::withQueryType(QueryType::DELETE)
            ->withTableName(DriverRideCategoryEntity::TABLE_NAME)
            ->whereParams(array(
                [DriverRideCategoryTableSchema::ID, '=', $this->escape_string($id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return true;
        }
        return false;
    }
}