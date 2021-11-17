<?php


class InviteDao extends TableDao {

    /**
     * InviteDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertInvite(InviteEntity $inviteEntity): ?InviteEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, InviteTableSchema::ID);
        array_push($insertValues, $this->escape_string($inviteEntity->getId()));

        array_push($insertColumns, InviteTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($inviteEntity->getCustomerId()));

        array_push($insertColumns, InviteTableSchema::CODE);
        array_push($insertValues, $this->escape_string($inviteEntity->getCode()));

        array_push($insertColumns, InviteTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($inviteEntity->getCreatedAt()));

        array_push($insertColumns, InviteTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($inviteEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(InviteEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getInviteWithId($inviteEntity->getId());
        }
        return null;
    }

    /**
     * @param string $inviteId
     * @return InviteEntity|null
     */
    public function getInviteWithId(string $inviteId): ?InviteEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(InviteEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [InviteTableSchema::ID, '=', $this->escape_string($inviteId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return InviteFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function insertInviteCode(string $code): ?InviteEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(InviteEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [InviteTableSchema::CODE, '=', $this->escape_string($code)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return InviteFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $inviteId
     * @return InviteEntity|null
     */
    public function getInviteWithCustomerId(string $inviteId): ?InviteEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(InviteEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [InviteTableSchema::CUSTOMER_ID, '=', $this->escape_string($inviteId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return InviteFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getCustomerWithInviteCode(string $code): ?InviteEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(InviteEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [InviteTableSchema::CODE, '=', $this->escape_string($code)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return InviteFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }



}