<?php


class SendHistoryDao extends TableDao {
    /**
     * SendHistoryDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertSendHistory(SendHistoryEntity $sendHistoryEntity): ?SendHistoryEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, SendHistoryTableSchema::ID);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getId()));

        array_push($insertColumns, SendHistoryTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getCustomerId()));

        array_push($insertColumns, SendHistoryTableSchema::TAKER_EMAIL);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getTakerEmail()));

        array_push($insertColumns, SendHistoryTableSchema::CURRENCY_ID);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getCurrencyId()));

        array_push($insertColumns, SendHistoryTableSchema::BANK_ID);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getBankId()));

        array_push($insertColumns, SendHistoryTableSchema::ACCOUNT_HOLDER_NAME);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getAccountHolderName()));

        array_push($insertColumns, SendHistoryTableSchema::IBAN);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getIban()));

        array_push($insertColumns, SendHistoryTableSchema::BALANCE);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getBalance()));

        array_push($insertColumns, SendHistoryTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getCreatedAt()));

        array_push($insertColumns, SendHistoryTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($sendHistoryEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(SendHistoryEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getSendHistoryWithId($sendHistoryEntity->getId());
        }

        return null;
    }


    public function createSendHistory(SendHistoryEntity $sendHistoryEntity): ?SendHistoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(SendHistoryEntity::TABLE_NAME)
            ->columns([
                SendHistoryTableSchema::ID,
                SendHistoryTableSchema::CUSTOMER_ID,
                SendHistoryTableSchema::TAKER_EMAIL,
                SendHistoryTableSchema::CURRENCY_ID,
                SendHistoryTableSchema::BANK_ID,
                SendHistoryTableSchema::ACCOUNT_HOLDER_NAME,
                SendHistoryTableSchema::IBAN,
                SendHistoryTableSchema::BALANCE,
                SendHistoryTableSchema::CREATED_AT,
                SendHistoryTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($sendHistoryEntity->getId()),
                $this->escape_string($sendHistoryEntity->getCustomerId()),
                $this->escape_string($sendHistoryEntity->getTakerEmail()),
                $this->escape_string($sendHistoryEntity->getCurrencyId()),
                $this->escape_string($sendHistoryEntity->getBankId()),
                $this->escape_string($sendHistoryEntity->getAccountHolderName()),
                $this->escape_string($sendHistoryEntity->getIban()),
                $this->escape_string($sendHistoryEntity->getBalance()),
                $this->escape_string($sendHistoryEntity->getCreatedAt()),
                $this->escape_string($sendHistoryEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getSendHistoryWithId($sendHistoryEntity->getId());
        }
        return null;
    }

    /**
     * @param string $sendId
     * @return SendHistoryEntity|null
     */
    public function getSendHistoryWithId(string $sendId): ?SendHistoryEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(SendHistoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [SendHistoryTableSchema::ID, '=', $this->escape_string($sendId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return SendHistoryFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getSendHistoryWithCustomerId(string $sendId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(SendHistoryEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [SendHistoryTableSchema::CUSTOMER_ID, '=', $this->escape_string($sendId)]
            ))
            ->generate();

        $history = [];

        $result = mysqli_query($this->getConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($history, SendHistoryFactory::mapFromDatabaseResult($row));
        }

        return $history;
    }

}