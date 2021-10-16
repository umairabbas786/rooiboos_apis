<?php


class DepositFeeDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertDepositFee(DepositFeeEntity $depositFeeEntity): ?DepositFeeEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, DepositFeeTableSchema::ID);
        array_push($insertValues, $this->escape_string($depositFeeEntity->getId()));

        array_push($insertColumns, DepositFeeTableSchema::DEPOSIT_FEE);
        array_push($insertValues, $this->escape_string($depositFeeEntity->getDepositFee()));

        array_push($insertColumns, DepositFeeTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($depositFeeEntity->getCreatedAt()));

        array_push($insertColumns, DepositFeeTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($depositFeeEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(DepositFeeEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getDepositFeeWithId($depositFeeEntity->getId());
        }

        return null;
    }

    /**
     * @param string $depositFeeId
     * @return WithdrawFeeEntity|null
     */
    public function getDepositFeeWithId(string $depositFeeId): ?DepositFeeEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(DepositFeeEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [DepositFeeTableSchema::ID, '=', $this->escape_string($depositFeeId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return DepositFeeFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}