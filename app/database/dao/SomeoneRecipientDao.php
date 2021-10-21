<?php


class SomeoneRecipientDao extends TableDao {
    /**
     * SomeoneRecipientDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertSomeoneRecipient(SomeoneRecipientEntity $someoneRecipientEntity): ?SomeoneRecipientEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, SomeoneRecipientTableSchema::ID);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getId()));

        array_push($insertColumns, SomeoneRecipientTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getCustomerId()));

        array_push($insertColumns, SomeoneRecipientTableSchema::TAKER_EMAIL);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getTakerEmail()));

        array_push($insertColumns, SomeoneRecipientTableSchema::CURRENCY_ID);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getCurrencyId()));

        array_push($insertColumns, SomeoneRecipientTableSchema::BANK_ID);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getBankId()));

        array_push($insertColumns, SomeoneRecipientTableSchema::ACCOUNT_HOLDER_NAME);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getAccountHolderName()));

        array_push($insertColumns, SomeoneRecipientTableSchema::IBAN);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getIban()));

        array_push($insertColumns, SomeoneRecipientTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getCreatedAt()));

        array_push($insertColumns, SomeoneRecipientTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($someoneRecipientEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(SomeoneRecipientEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getSomeoneRecipientWithId($someoneRecipientEntity->getId());
        }

        return null;
    }


    public function createSomeoneRecipient(SomeoneRecipientEntity $someoneRecipientEntity): ?SomeoneRecipientEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(SomeoneRecipientEntity::TABLE_NAME)
            ->columns([
                SomeoneRecipientTableSchema::ID,
                SomeoneRecipientTableSchema::CUSTOMER_ID,
                SomeoneRecipientTableSchema::TAKER_EMAIL,
                SomeoneRecipientTableSchema::CURRENCY_ID,
                SomeoneRecipientTableSchema::BANK_ID,
                SomeoneRecipientTableSchema::ACCOUNT_HOLDER_NAME,
                SomeoneRecipientTableSchema::IBAN,
                SomeoneRecipientTableSchema::CREATED_AT,
                SomeoneRecipientTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($someoneRecipientEntity->getId()),
                $this->escape_string($someoneRecipientEntity->getCustomerId()),
                $this->escape_string($someoneRecipientEntity->getTakerEmail()),
                $this->escape_string($someoneRecipientEntity->getCurrencyId()),
                $this->escape_string($someoneRecipientEntity->getBankId()),
                $this->escape_string($someoneRecipientEntity->getAccountHolderName()),
                $this->escape_string($someoneRecipientEntity->getIban()),
                $this->escape_string($someoneRecipientEntity->getCreatedAt()),
                $this->escape_string($someoneRecipientEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getSomeoneRecipientWithId($someoneRecipientEntity->getId());
        }
        return null;
    }

    /**
     * @param string $someoneId
     * @return SomeoneRecipientEntity|null
     */
    public function getSomeoneRecipientWithId(string $someoneId): ?SomeoneRecipientEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(SomeoneRecipientEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [SomeoneRecipientTableSchema::ID, '=', $this->escape_string($someoneId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return SomeoneRecipientFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getSomeoneRecipientWithCustomerId(string $someoneId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(SomeoneRecipientEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [SomeoneRecipientTableSchema::CUSTOMER_ID, '=', $this->escape_string($someoneId)]
            ))
            ->generate();

        $recipients = [];

        $result = mysqli_query($this->getConnection(),$query);

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($recipients, SomeoneRecipientFactory::mapFromDatabaseResult($row));
        }

        return $recipients;
    }

}