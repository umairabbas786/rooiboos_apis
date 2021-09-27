<?php


class PassengerAvatarDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertAvatar(PassengerAvatarEntity $avatarEntity): ?PassengerAvatarEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
                    ->withTableName(PassengerAvatarEntity::TABLE_NAME)
                    ->columns([
                        PassengerAvatarTableSchema::ID,
                        PassengerAvatarTableSchema::PASSENGER_ID,
                        PassengerAvatarTableSchema::AVATAR,
                        PassengerAvatarTableSchema::CREATED_AT,
                        PassengerAvatarTableSchema::UPDATED_AT
                    ])
                    ->values([
                        $this->escape_string($avatarEntity->getId()),
                        $this->escape_string($avatarEntity->getPassengerId()),
                        $this->escape_string($avatarEntity->getAvatar()),
                        $this->escape_string($avatarEntity->getCreatedAt()),
                        $this->escape_string($avatarEntity->getUpdatedAt())
                    ])
                    ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getAvatarById($avatarEntity->getId());
        }
        return null;
    }

    /**
     * @param string $avatar_id
     * @return PassengerAvatarEntity|null
     */
    public function getAvatarById(string $avatar_id): ?PassengerAvatarEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(PassengerAvatarEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [PassengerAvatarTableSchema::ID, '=', $avatar_id]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return PassengerAvatarFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $passengerId
     * @return PassengerAvatarEntity|null
     */
    public function getAvatarOfPassenger(string $passengerId): ?PassengerAvatarEntity{
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(PassengerAvatarEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [PassengerAvatarTableSchema::PASSENGER_ID, '=', $passengerId]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows >= 1) {
            return PassengerAvatarFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

}