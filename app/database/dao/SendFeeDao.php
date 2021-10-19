<?php


class SendFeeDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertSendFee(SendFeeEntity $sendFeeEntity): ?SendFeeEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, SendFeeTableSchema::ID);
        array_push($insertValues, $this->escape_string($sendFeeEntity->getId()));

        array_push($insertColumns, SendFeeTableSchema::SEND_FEE);
        array_push($insertValues, $this->escape_string($sendFeeEntity->getSendFee()));

        array_push($insertColumns, SendFeeTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($sendFeeEntity->getCreatedAt()));

        array_push($insertColumns, SendFeeTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($sendFeeEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(SendFeeEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getSendFeeWithId($sendFeeEntity->getId());
        }

        return null;
    }

    /**
     * @param string $sendFeeId
     * @return SendFeeEntity|null
     */
    public function getSendFeeWithId(string $sendFeeId): ?SendFeeEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(SendFeeEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [SendFeeTableSchema::ID, '=', $this->escape_string($sendFeeId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return SendFeeFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}