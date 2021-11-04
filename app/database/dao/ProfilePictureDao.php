<?php


class ProfilePictureDao extends TableDao {

    /**
     * ProfilePictureDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertProfilePicture(ProfilePictureEntity $profilePictureEntity): ?ProfilePictureEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, ProfilePictureTableSchema::ID);
        array_push($insertValues, $this->escape_string($profilePictureEntity->getId()));

        array_push($insertColumns, ProfilePictureTableSchema::CUSTOMER_ID);
        array_push($insertValues, $this->escape_string($profilePictureEntity->getCustomerId()));

        array_push($insertColumns, ProfilePictureTableSchema::PICTURE);
        array_push($insertValues, $this->escape_string($profilePictureEntity->getPicture()));

        array_push($insertColumns, ProfilePictureTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($profilePictureEntity->getCreatedAt()));

        array_push($insertColumns, ProfilePictureTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($profilePictureEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(ProfilePictureEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getProfilePictureWithId($profilePictureEntity->getId());
        }

        return null;
    }

    /**
     * @param string $profilePictureId
     * @return ProfilePictureEntity|null
     */
    public function getProfilePictureWithId(string $profilePictureId): ?ProfilePictureEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(ProfilePictureEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [ProfilePictureTableSchema::ID, '=', $this->escape_string($profilePictureId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return ProfilePictureFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $customerId
     * @return ProfilePictureEntity|null
     */
    public function getProfilePictureWithCustomerId(string $customerId): ?ProfilePictureEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(ProfilePictureEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [ProfilePictureTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return ProfilePictureFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function updateCustomerProfilePicture(string $customerId,string $picture,string $updatedAt): bool{
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(ProfilePictureEntity::TABLE_NAME)
            ->updateParams(
                [
                    [ProfilePictureTableSchema::CUSTOMER_ID, $this->escape_string($customerId)],
                    [ProfilePictureTableSchema::PICTURE, $this->escape_string($picture)],
                    [ProfilePictureTableSchema::UPDATED_AT, $this->escape_string($updatedAt)]
                ]
            )
            ->whereParams(
                array(
                    [ProfilePictureTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)]
                ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        return (bool) $result;
    }
}