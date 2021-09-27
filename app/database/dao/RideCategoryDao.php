<?php


class RideCategoryDao extends TableDao {

    public function insertRideCategory(RideCategoryEntity $rideCategoryEntity): ?RideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
                             ->withTableName(RideCategoryEntity::TABLE_NAME)
                             ->columns([
                                 RideCategoryTableSchema::ID,
                                 RideCategoryTableSchema::NAME,
                                 RideCategoryTableSchema::ENABLED,
                                 RideCategoryTableSchema::IMAGE,
                                 RideCategoryTableSchema::PRICE,
                                 RideCategoryTableSchema::PER_KM_COST,
                                 RideCategoryTableSchema::CREATED_AT,
                                 RideCategoryTableSchema::UPDATED_AT
                             ])
                             ->values([
                                 $this->escape_string($rideCategoryEntity->getId()),
                                 $this->escape_string($rideCategoryEntity->getName()),
                                 $this->wrapBool($rideCategoryEntity->isEnabled()),
                                 $this->escape_string($rideCategoryEntity->getImage()),
                                 $this->escape_string($rideCategoryEntity->getPrice()),
                                 $this->escape_string($rideCategoryEntity->getPerKmCost()),
                                 $this->escape_string($rideCategoryEntity->getCreatedAt()),
                                 $this->escape_string($rideCategoryEntity->getUpdatedAt())
                             ])
                             ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getRideCategoryWithID($rideCategoryEntity->getId());
        }
        return null;
    }


    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function getAllRideCategories(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideCategoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $categories = [];

        while ($category = mysqli_fetch_assoc($result)) {
            array_push($categories, RideCategoryFactory::mapFromDatabaseResult($category));
        }

        return $categories;
    }

    public function getRideCategoryWithName(string $name, bool $ignore_case = true): ?RideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideCategoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [
                    $ignore_case ? 'UPPER(' . RideCategoryTableSchema::NAME . ')' : RideCategoryTableSchema::NAME,
                    '=',
                    $ignore_case ? strtoupper($this->escape_string($name)) : $this->escape_string($name)
                ]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return RideCategoryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $id
     * @return RideCategoryEntity|null
     */
    public function getRideCategoryWithID(string $id): ?RideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(RideCategoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [RideCategoryTableSchema::ID, '=', $id]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return RideCategoryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllEnabledRideCategories(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
                             ->withTableName(RideCategoryEntity::TABLE_NAME)
                             ->columns(['*'])
                             ->whereParams([
                                 [RideCategoryTableSchema::ENABLED, '=', '1']
                             ])
                             ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $categories = [];

        while ($category = mysqli_fetch_assoc($result)) {
            array_push($categories, RideCategoryFactory::mapFromDatabaseResult($category));
        }

        return $categories;
    }

    public function getAllDisabledRideCategories(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
                             ->withTableName(RideCategoryEntity::TABLE_NAME)
                             ->columns(['*'])
                             ->whereParams([
                                 [RideCategoryTableSchema::ENABLED, '=', '0']
                             ])
                             ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $categories = [];

        while ($category = mysqli_fetch_assoc($result)) {
            array_push($categories, RideCategoryFactory::mapFromDatabaseResult($category));
        }

        return $categories;
    }

    public function updateRideCategoryEnableStatus(string $rideCategoryId, bool $enabled): ?RideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(RideCategoryEntity::TABLE_NAME)
            ->updateParams(array(
                [RideCategoryTableSchema::ENABLED, $enabled ? '1' : '0']
            ))
            ->whereParams(array(
                [RideCategoryTableSchema::ID, '=', $this->escape_string($rideCategoryId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);
        if ($result) {
            return $this->getRideCategoryWithID($rideCategoryId);
        }
        return null;
    }

    public function updateRideCategory(RideCategoryEntity $rideCategoryEntity): ?RideCategoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(RideCategoryEntity::TABLE_NAME)
            ->updateParams(array(
                [RideCategoryTableSchema::NAME, $this->escape_string($rideCategoryEntity->getName())],
                [RideCategoryTableSchema::ENABLED, $this->wrapBool($rideCategoryEntity->isEnabled())],
                [RideCategoryTableSchema::IMAGE, $this->escape_string($rideCategoryEntity->getImage())],
                [RideCategoryTableSchema::PRICE, $this->escape_string($rideCategoryEntity->getPrice())],
                [RideCategoryTableSchema::PER_KM_COST, $this->escape_string($rideCategoryEntity->getPerKmCost())],
                [RideCategoryTableSchema::UPDATED_AT, $this->escape_string($rideCategoryEntity->getUpdatedAt())]
            ))
            ->whereParams(array(
                [RideCategoryTableSchema::ID, '=', $this->escape_string($rideCategoryEntity->getId())]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getRideCategoryWithID($rideCategoryEntity->getId());
        }
        return null;
    }
}