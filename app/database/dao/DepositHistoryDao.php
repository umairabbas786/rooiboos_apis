<?php


class DepositHistoryDao extends TableDao {

    /**
     * DepositHistoryDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDepositHistory(DepositHistoryEntity $depositHistoryEntity): ?DepositHistoryEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, DepositHistoryTableSchema::ID);
        array_push($insertValues, $this->escape_string($depositHistoryEntity->getId()));

        array_push($insertColumns, DepositHistoryTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($depositHistoryEntity->getCustomerId()));

        array_push($insertColumns, DepositHistoryTableSchema::CURRENCY_ID);
        array_push($insertValues, $this->escape_string($depositHistoryEntity->getCurrencyId()));

        array_push($insertColumns, DepositHistoryTableSchema::BALANCE);
        array_push($insertValues, $this->escape_string($depositHistoryEntity->getBalance()));

        array_push($insertColumns, DepositHistoryTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($depositHistoryEntity->getCreatedAt()));

        array_push($insertColumns, DepositHistoryTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($depositHistoryEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DepositHistoryEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDepositHistoryWithId($depositHistoryEntity->getId());
        }

        return null;
    }


    public function createDepositHistory(DepositHistoryEntity $depositHistoryEntity): ?DepositHistoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DepositHistoryEntity::TABLE_NAME)
            ->columns([
                DepositHistoryTableSchema::ID,
                DepositHistoryTableSchema::CUSTOMER_ID,
                DepositHistoryTableSchema::CURRENCY_ID,
                DepositHistoryTableSchema::BALANCE,
                DepositHistoryTableSchema::CREATED_AT,
                DepositHistoryTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($depositHistoryEntity->getId()),
                $this->escape_string($depositHistoryEntity->getCustomerId()),
                $this->escape_string($depositHistoryEntity->getCurrencyId()),
                $this->escape_string($depositHistoryEntity->getBalance()),
                $this->escape_string($depositHistoryEntity->getCreatedAt()),
                $this->escape_string($depositHistoryEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getDepositHistoryWithId($depositHistoryEntity->getId());
        }
        return null;
    }

    public function getDepositHistoryWithId(string $id): ?DepositHistoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)->withTableName(DepositHistoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [DepositHistoryTableSchema::ID, '=', $this->escape_string($id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return DepositHistoryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getDepositHistoryWithCustomerId(string $customerId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DepositHistoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [DepositHistoryTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)]
            ))
            ->generate();

        $histories = [];

        $result = mysqli_query($this->getConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($histories, DepositHistoryFactory::mapFromDatabaseResult($row));
        }

        return $histories;
    }

}