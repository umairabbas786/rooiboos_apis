<?php


class WithdrawFeeDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertWithdrawFee(WithdrawFeeEntity $withdrawFeeEntity): ?WithdrawFeeEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, WithdrawFeeTableSchema::ID);
        array_push($insertValues, $this->escape_string($withdrawFeeEntity->getId()));

        array_push($insertColumns, WithdrawFeeTableSchema::WITHDRAW_FEE);
        array_push($insertValues, $this->escape_string($withdrawFeeEntity->getDepositFee()));

        array_push($insertColumns, WithdrawFeeTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($withdrawFeeEntity->getCreatedAt()));

        array_push($insertColumns, WithdrawFeeTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($withdrawFeeEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(WithdrawFeeEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getWithdrawFeeWithId($withdrawFeeEntity->getId());
        }

        return null;
    }

    /**
     * @param string $withdrawFeeId
     * @return WithdrawFeeEntity|null
     */
    public function getWithdrawFeeWithId(string $withdrawFeeId): ?WithdrawFeeEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(WithdrawFeeEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [WithdrawFeeTableSchema::ID, '=', $this->escape_string($withdrawFeeId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return WithdrawFeeFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}