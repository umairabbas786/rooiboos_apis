<?php


class CountryDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertCustomer(CountryEntity $countryEntity): ?CountryEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, CountryTableSchema::ID);
        array_push($insertValues, $this->escape_string($countryEntity->getId()));

        array_push($insertColumns, CountryTableSchema::NAME);
        array_push($insertValues, $this->escape_string($countryEntity->getName()));

        array_push($insertColumns, CountryTableSchema::CODE);
        array_push($insertValues, $this->escape_string($countryEntity->getCode()));

        array_push($insertColumns, CountryTableSchema::STATUS);
        array_push($insertValues, $this->wrapBool($countryEntity->isStatus()));

        array_push($insertColumns, CountryTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($countryEntity->getCreatedAt()));

        array_push($insertColumns, CountryTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($countryEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CountryEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCountryWithId($countryEntity->getId());
        }

        return null;
    }

    /**
     * @param string $countryId
     * @return CountryEntity|null
     */
    public function getCountryWithId(string $countryId): ?CountryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CountryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CountryTableSchema::ID, '=', $this->escape_string($countryId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CountryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllCountries(): array {
        $query = 'select * from countries order by name';
//        $query = QueryBuilder::withQueryType(QueryType::SELECT)
//            ->withTableName(CountryEntity::TABLE_NAME)
//            ->columns(['*'])
//            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $countries = [];

        while($row = mysqli_fetch_assoc($result)){
            array_push($countries,CountryFactory::mapFromDatabaseResult($row));
        }

        return $countries;
    }
}