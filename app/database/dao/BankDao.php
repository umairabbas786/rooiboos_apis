<?php


class BankDao extends TableDao {

    /**
     * BankDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertBank(BankEntity $bankEntity): ?BankEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, BankTableSchema::ID);
        array_push($insertValues, $this->escape_string($bankEntity->getId()));

        array_push($insertColumns, BankTableSchema::NAME);
        array_push($insertValues, $this->escape_string($bankEntity->getName()));

        array_push($insertColumns, BankTableSchema::CITY);
        array_push($insertValues, $this->escape_string($bankEntity->getCity()));

        array_push($insertColumns, BankTableSchema::COUNTRY);
        array_push($insertValues, $this->escape_string($bankEntity->getCountry()));

        array_push($insertColumns, BankTableSchema::STATUS);
        array_push($insertValues, $this->wrapBool($bankEntity->isStatus()));

        array_push($insertColumns, BankTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($bankEntity->getCreatedAt()));

        array_push($insertColumns, BankTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($bankEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(BankEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getBankWithId($bankEntity->getId());
        }

        return null;
    }

    /**
     * @param string $bankId
     * @return BankEntity|null
     */
    public function getBankWithId(string $bankId): ?BankEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(BankEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [BankTableSchema::ID, '=', $this->escape_string($bankId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return BankFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllBanks(): array {
        $query = 'select * from banks order by name';
//        $query = QueryBuilder::withQueryType(QueryType::SELECT)
//            ->withTableName(BankEntity::TABLE_NAME)
//            ->columns(['*'])
//            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        $banks = [];

        while($row = mysqli_fetch_assoc($result)){
            array_push($banks,BankFactory::mapFromDatabaseResult($row));
        }

        return $banks;
    }
}