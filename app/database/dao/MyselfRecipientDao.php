<?php


class MyselfRecipientDao extends TableDao {
    /**
     * MyselfRecipientDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertMyselfRecipient(MyselfRecipientEntity $myselfRecipientEntity): ?MyselfRecipientEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, MyselfRecipientTableSchema::ID);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getId()));

        array_push($insertColumns, MyselfRecipientTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getCustomerId()));

        array_push($insertColumns, MyselfRecipientTableSchema::CURRENCY_ID);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getCurrencyId()));

        array_push($insertColumns, MyselfRecipientTableSchema::BANK_ID);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getBankId()));

        array_push($insertColumns, MyselfRecipientTableSchema::ACCOUNT_HOLDER_NAME);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getAccountHolderName()));

        array_push($insertColumns, MyselfRecipientTableSchema::IBAN);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getIban()));

        array_push($insertColumns, MyselfRecipientTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getCreatedAt()));

        array_push($insertColumns, MyselfRecipientTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($myselfRecipientEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(MyselfRecipientEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getMyselfRecipientWithId($myselfRecipientEntity->getId());
        }

        return null;
    }


    public function createMyselfRecipient(MyselfRecipientEntity $myselfRecipientEntity): ?MyselfRecipientEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(MyselfRecipientEntity::TABLE_NAME)
            ->columns([
                MyselfRecipientTableSchema::ID,
                MyselfRecipientTableSchema::CUSTOMER_ID,
                MyselfRecipientTableSchema::CURRENCY_ID,
                MyselfRecipientTableSchema::BANK_ID,
                MyselfRecipientTableSchema::ACCOUNT_HOLDER_NAME,
                MyselfRecipientTableSchema::IBAN,
                MyselfRecipientTableSchema::CREATED_AT,
                MyselfRecipientTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($myselfRecipientEntity->getId()),
                $this->escape_string($myselfRecipientEntity->getCustomerId()),
                $this->escape_string($myselfRecipientEntity->getCurrencyId()),
                $this->escape_string($myselfRecipientEntity->getBankId()),
                $this->escape_string($myselfRecipientEntity->getAccountHolderName()),
                $this->escape_string($myselfRecipientEntity->getIban()),
                $this->escape_string($myselfRecipientEntity->getCreatedAt()),
                $this->escape_string($myselfRecipientEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getMyselfRecipientWithId($myselfRecipientEntity->getId());
        }
        return null;
    }

    /**
     * @param string $myselfId
     * @return MyselfRecipientEntity|null
     */
    public function getMyselfRecipientWithId(string $myselfId): ?MyselfRecipientEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(MyselfRecipientEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [MyselfRecipientTableSchema::ID, '=', $this->escape_string($myselfId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return MyselfRecipientFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getMyselfRecipientWithCustomerId(string $myselfId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(MyselfRecipientEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [MyselfRecipientTableSchema::CUSTOMER_ID, '=', $this->escape_string($myselfId)]
            ))
            ->generate();

        $recipients = [];

        $result = mysqli_query($this->getConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($recipients, MyselfRecipientFactory::mapFromDatabaseResult($row));
        }

        return $recipients;
    }

}