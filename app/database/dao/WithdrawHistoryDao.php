<?php


class WithdrawHistoryDao extends TableDao {
    /**
     * WithdrawHistoryDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertWithdrawHistory(WithdrawHistoryEntity $withdrawHistoryEntity): ?WithdrawHistoryEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, WithdrawHistoryTableSchema::ID);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getId()));

        array_push($insertColumns, WithdrawHistoryTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getCustomerId()));

        array_push($insertColumns, WithdrawHistoryTableSchema::CURRENCY_ID);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getCurrencyId()));

        array_push($insertColumns, WithdrawHistoryTableSchema::BANK_ID);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getBankId()));

        array_push($insertColumns, WithdrawHistoryTableSchema::ACCOUNT_HOLDER_NAME);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getAccountHolderName()));

        array_push($insertColumns, WithdrawHistoryTableSchema::IBAN);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getIban()));

        array_push($insertColumns, WithdrawHistoryTableSchema::BALANCE);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getBalance()));

        array_push($insertColumns, WithdrawHistoryTableSchema::STATUS);
        array_push($insertValues, $this->wrapBool($withdrawHistoryEntity->isStatus()));

        array_push($insertColumns, WithdrawHistoryTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getCreatedAt()));

        array_push($insertColumns, WithdrawHistoryTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($withdrawHistoryEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(WithdrawHistoryEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getWithdrawHistoryWithId($withdrawHistoryEntity->getId());
        }

        return null;
    }


    public function createWithdrawHistory(WithdrawHistoryEntity $withdrawHistoryEntity): ?WithdrawHistoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(WithdrawHistoryEntity::TABLE_NAME)
            ->columns([
                WithdrawHistoryTableSchema::ID,
                WithdrawHistoryTableSchema::CUSTOMER_ID,
                WithdrawHistoryTableSchema::CURRENCY_ID,
                WithdrawHistoryTableSchema::BANK_ID,
                WithdrawHistoryTableSchema::ACCOUNT_HOLDER_NAME,
                WithdrawHistoryTableSchema::IBAN,
                WithdrawHistoryTableSchema::BALANCE,
                WithdrawHistoryTableSchema::STATUS,
                WithdrawHistoryTableSchema::CREATED_AT,
                WithdrawHistoryTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($withdrawHistoryEntity->getId()),
                $this->escape_string($withdrawHistoryEntity->getCustomerId()),
                $this->escape_string($withdrawHistoryEntity->getCurrencyId()),
                $this->escape_string($withdrawHistoryEntity->getBankId()),
                $this->escape_string($withdrawHistoryEntity->getAccountHolderName()),
                $this->escape_string($withdrawHistoryEntity->getIban()),
                $this->escape_string($withdrawHistoryEntity->getBalance()),
                $this->escape_string($withdrawHistoryEntity->isStatus()),
                $this->escape_string($withdrawHistoryEntity->getCreatedAt()),
                $this->escape_string($withdrawHistoryEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getWithdrawHistoryWithId($withdrawHistoryEntity->getId());
        }
        return null;
    }

    /**
     * @param string $withdrawId
     * @return WithdrawHistoryEntity|null
     */
    public function getWithdrawHistoryWithId(string $withdrawId): ?WithdrawHistoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(WithdrawHistoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [WithdrawHistoryTableSchema::ID, '=', $this->escape_string($withdrawId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return WithdrawHistoryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getWithdrawHistoryWithCustomerId(string $customerId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(WithdrawHistoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [WithdrawHistoryTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)]
            ))
            ->generate();

        $histories = [];

        $result = mysqli_query($this->getConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($histories, WithdrawHistoryFactory::mapFromDatabaseResult($row));
        }

        return $histories;
    }

}