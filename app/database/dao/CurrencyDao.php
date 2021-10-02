<?php


class CurrencyDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertCustomer(CurrencyEntity $currencyEntity): ?CurrencyEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, CurrencyTableSchema::ID);
        array_push($insertValues, $this->escape_string($currencyEntity->getId()));

        array_push($insertColumns, CurrencyTableSchema::NAME);
        array_push($insertValues, $this->escape_string($currencyEntity->getName()));

        array_push($insertColumns, CurrencyTableSchema::CODE);
        array_push($insertValues, $this->escape_string($currencyEntity->getCode()));

        array_push($insertColumns, CurrencyTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($currencyEntity->getCreatedAt()));

        array_push($insertColumns, CurrencyTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($currencyEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CountryEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCurrencyWithId($currencyEntity->getId());
        }

        return null;
    }

    /**
     * @param string $currencyId
     * @return CurrencyEntity|null
     */
    public function getCurrencyWithId(string $currencyId): ?CurrencyEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CurrencyEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CurrencyTableSchema::ID, '=', $this->escape_string($currencyId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CurrencyFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllCurrency(): array {
        $query = 'select * from currency order by name';
//        $query = QueryBuilder::withQueryType(QueryType::SELECT)
//            ->withTableName(CurrencyEntity::TABLE_NAME)
//            ->columns(['*'])
//            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $currency = [];

        while($row = mysqli_fetch_assoc($result)){
            array_push($currency,CurrencyFactory::mapFromDatabaseResult($row));
        }

        return $currency;
    }
}