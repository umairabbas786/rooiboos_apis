<?php


class CityDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertCity(CityEntity $cityEntity): ?CityEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CityEntity::TABLE_NAME)
            ->columns([
                CityTableSchema::ID,
                CityTableSchema::NAME,
                CityTableSchema::ENABLED,
                CityTableSchema::CREATED_AT,
                CityTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($cityEntity->getId()),
                $this->escape_string($cityEntity->getName()),
                $cityEntity->isEnabled() ? '1' : '0',
                $cityEntity->getCreatedAt(),
                $cityEntity->getUpdatedAt()
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCityWithId($cityEntity->getId());
        }
        return null;
    }

    public function getCityWithName(string $name, bool $ignore_case = true): ?CityEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
                             ->withTableName(CityEntity::TABLE_NAME)
                             ->columns(['*'])
                             ->whereParams([
                                 [
                                     $ignore_case ? 'UPPER(' . CityTableSchema::NAME . ')' : CityTableSchema::NAME,
                                     '=',
                                     $ignore_case ? strtoupper($this->escape_string($name)) : $this->escape_string($name)
                                 ]
                             ])
                             ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CityFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllCities(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
                             ->withTableName(CityEntity::TABLE_NAME)
                             ->columns(['*'])
                             ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $cities = [];

        while ($city = mysqli_fetch_assoc($result)) {
            array_push($cities, CityFactory::mapFromDatabaseResult($city));
        }

        return $cities;
    }

    /**
     * @param string $id
     * @return CityEntity|null
     */
    public function getCityWithId(string $id): ?CityEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CityEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [CityTableSchema::ID, '=', $id]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CityFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllEnabledCities(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CityEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [CityTableSchema::ENABLED, '=', '1']
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $cities = [];

        while ($city = mysqli_fetch_assoc($result)) {
            array_push($cities, CityFactory::mapFromDatabaseResult($city));
        }

        return $cities;
    }

    public function getAllDisabledCities(): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
                             ->withTableName(CityEntity::TABLE_NAME)
                             ->columns(['*'])
                             ->whereParams([
                                 [CityTableSchema::ENABLED, '=', '0']
                             ])
                             ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $cities = [];

        while ($city = mysqli_fetch_assoc($result)) {
            array_push($cities, CityFactory::mapFromDatabaseResult($city));
        }

        return $cities;
    }

    public function updateEnabledState(string $cityId, bool $enabled): ?CityEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(CityEntity::TABLE_NAME)
            ->updateParams(array(
                [CityTableSchema::ENABLED, $enabled ? '1' : '0']
            ))
            ->whereParams(array(
                [CityTableSchema::ID, '=', $this->escape_string($cityId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCityWithId($cityId);
        }
        return null;
    }

    public function updateCityEntity(CityEntity $cityEntity): ?CityEntity {
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(CityEntity::TABLE_NAME)
            ->updateParams(array(
                [CityTableSchema::NAME, $this->escape_string($cityEntity->getName())],
                [CityTableSchema::ENABLED, $cityEntity->isEnabled() ? '1' : '0'],
                [CityTableSchema::UPDATED_AT, $this->escape_string($cityEntity->getUpdatedAt())]
            ))
            ->whereParams(array(
                [CityTableSchema::ID, '=', $this->escape_string($cityEntity->getId())]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCityWithId($cityEntity->getId());
        }
        return null;
    }

}