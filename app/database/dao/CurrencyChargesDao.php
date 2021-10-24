<?php


class CurrencyChargesDao extends TableDao {

    /**
     * CurrencyChargesDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertCurrencyCharges(CurrencyChargesEntity $currencyChargesEntity): ?CurrencyChargesEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, CurrencyChargesTableSchema::ID);
        array_push($insertValues, $this->escape_string($currencyChargesEntity->getId()));

        array_push($insertColumns, CurrencyChargesTableSchema::FROM);
        array_push($insertValues, $this->escape_string($currencyChargesEntity->getFrom()));

        array_push($insertColumns, CurrencyChargesTableSchema::TO);
        array_push($insertValues, $this->escape_string($currencyChargesEntity->getTo()));

        array_push($insertColumns, CurrencyChargesTableSchema::RATE);
        array_push($insertValues, $this->escape_string($currencyChargesEntity->getRate()));

        array_push($insertColumns, CurrencyChargesTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($currencyChargesEntity->getCreatedAt()));

        array_push($insertColumns, CurrencyChargesTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($currencyChargesEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CurrencyChargesEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCurrencyChargesWithId($currencyChargesEntity->getId());
        }

        return null;
    }

    public function createCurrencyCharges(CurrencyChargesEntity $currencyChargesEntity): ?CurrencyChargesEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CurrencyChargesEntity::TABLE_NAME)
            ->columns([
                CurrencyChargesTableSchema::ID,
                CurrencyChargesTableSchema::FROM,
                CurrencyChargesTableSchema::TO,
                CurrencyChargesTableSchema::RATE,
                CurrencyChargesTableSchema::CREATED_AT,
                CurrencyChargesTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($currencyChargesEntity->getId()),
                $this->escape_string($currencyChargesEntity->getFrom()),
                $this->escape_string($currencyChargesEntity->getTo()),
                $this->escape_string($currencyChargesEntity->getRate()),
                $this->escape_string($currencyChargesEntity->getCreatedAt()),
                $this->escape_string($currencyChargesEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getCurrencyChargesWithId($currencyChargesEntity->getId());
        }
        return null;
    }

    /**
     * @param string $currencyChargesId
     * @return CurrencyChargesEntity|null
     */
    public function getCurrencyChargesWithId(string $currencyChargesId): ?CurrencyChargesEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CurrencyChargesEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CurrencyChargesTableSchema::ID, '=', $this->escape_string($currencyChargesId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CurrencyChargesFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getCurrencyChargesWithCurrencyIds(string $fromId,string $toId): ?CurrencyChargesEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)->withTableName(CurrencyChargesEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CurrencyChargesTableSchema::FROM, '=', $this->escape_string($fromId)],
                ['AND'],
                [CurrencyChargesTableSchema::TO, '=', $this->escape_string($toId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return CurrencyChargesFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}