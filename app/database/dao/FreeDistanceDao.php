<?php


class FreeDistanceDao extends TableDao {

    /**
     * FreeDistanceDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertFreeDistance(FreeDistanceEntity $freeDistanceEntity): ?FreeDistanceEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(FreeDistanceEntity::TABLE_NAME)
            ->columns([
                FreeDistanceTableSchema::ID,
                FreeDistanceTableSchema::DISTANCE_IN_METERS,
                FreeDistanceTableSchema::CREATED_AT,
                FreeDistanceTableSchema::UPDATED_AT
            ])
            ->values([
                FreeDistanceEntity::getId(),
                $freeDistanceEntity->getDistanceInMeters(),
                $freeDistanceEntity->getCreatedAt(),
                $freeDistanceEntity->getUpdatedAt()
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getFreeDistanceEntity();
        }
        return null;
    }

    public function getFreeDistanceEntity(): ?FreeDistanceEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(FreeDistanceEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams([
                [FreeDistanceTableSchema::ID, '=', FreeDistanceEntity::getId()]
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return FreeDistanceFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }

        return null;
    }
}