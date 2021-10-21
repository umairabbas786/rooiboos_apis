<?php


class CurrencyFeeDao extends TableDao {

    /**
     * CurrencyFeeDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertCurrencyFee(CurrencyFeeEntity $currencyFeeEntity): ?CurrencyFeeEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, CurrencyFeeTableSchema::ID);
        array_push($insertValues, $this->escape_string($currencyFeeEntity->getId()));

        array_push($insertColumns, CurrencyFeeTableSchema::CURRENCY_FEE);
        array_push($insertValues, $this->escape_string($currencyFeeEntity->getCurrencyFee()));

        array_push($insertColumns, CurrencyFeeTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($currencyFeeEntity->getCreatedAt()));

        array_push($insertColumns, CurrencyFeeTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($currencyFeeEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CurrencyFeeEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCurrencyFeeWithId($currencyFeeEntity->getId());
        }

        return null;
    }

    /**
     * @param string $currencyFeeId
     * @return CurrencyFeeEntity|null
     */
    public function getCurrencyFeeWithId(string $currencyFeeId): ?CurrencyFeeEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CurrencyFeeEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CurrencyFeeTableSchema::ID, '=', $this->escape_string($currencyFeeId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CurrencyFeeFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}