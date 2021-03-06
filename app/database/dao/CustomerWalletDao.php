<?php


class CustomerWalletDao extends TableDao {

    /**
     * CustomerWalletDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function createWallet(CustomerWalletEntity $customerWalletEntity): ?CustomerWalletEntity {
        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CustomerWalletEntity::TABLE_NAME)
            ->columns([
                CustomerWalletTableSchema::ID,
                CustomerWalletTableSchema::CUSTOMER_ID,
                CustomerWalletTableSchema::CURRENCY_ID,
                CustomerWalletTableSchema::BALANCE,
                CustomerWalletTableSchema::CREATED_AT,
                CustomerWalletTableSchema::UPDATED_AT
            ])
            ->values([
                $this->escape_string($customerWalletEntity->getId()),
                $this->escape_string($customerWalletEntity->getCustomerId()),
                $this->escape_string($customerWalletEntity->getCurrencyId()),
                $this->escape_string($customerWalletEntity->getBalance()),
                $this->escape_string($customerWalletEntity->getCreatedAt()),
                $this->escape_string($customerWalletEntity->getUpdatedAt())
            ])
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getCustomerWalletWithId($customerWalletEntity->getId());
        }
        return null;
    }

    public function getCustomerWalletWithId(string $id): ?CustomerWalletEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)->withTableName(CustomerWalletEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CustomerWalletTableSchema::ID, '=', $this->escape_string($id)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return CustomerWalletFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getCustomerWalletWithCustomerIdAndCurrencyId(string $customerId,string $currencyId): ?CustomerWalletEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)->withTableName(CustomerWalletEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CustomerWalletTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)],
                ['AND'],
                [CustomerWalletTableSchema::CURRENCY_ID, '=', $this->escape_string($currencyId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($result->num_rows === 1){
            return CustomerWalletFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    public function getAllCustomerWallets(string $customerId): array {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CustomerWalletEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CustomerWalletTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(),$query);

        $wallets = [];

        while ($row = mysqli_fetch_assoc($result)) {
            array_push($wallets, CustomerWalletFactory::mapFromDatabaseResult($row));
        }

        return $wallets;
    }

    public function removeCustomerWallet(string $customerId,string $currencyId){
        $query = QueryBuilder::withQueryType(QueryType::DELETE)->withTableName(CustomerWalletEntity::TABLE_NAME)
                ->whereParams(
                    array(
                        [CustomerWalletTableSchema::CUSTOMER_ID, '=', $this->escape_string($customerId)],
                        ['AND'],
                        [CustomerWalletTableSchema::CURRENCY_ID, '=', $this->escape_string($currencyId)]
                    )
                )
                ->generate();

        $result = mysqli_query($this->getConnection(),$query);
        if($this->getConnection() -> affected_rows > 0){
            return true;
        }
        return null;
    }

    public function updateWalletBalance(CustomerWalletEntity $wallet){
        $query = QueryBuilder::withQueryType(QueryType::UPDATE)
            ->withTableName(CustomerWalletEntity::TABLE_NAME)
            ->updateParams([
                [CustomerWalletTableSchema::BALANCE, $this->escape_string($wallet->getBalance())],
                [CustomerWalletTableSchema::UPDATED_AT, $this->escape_string($wallet->getUpdatedAt())]
            ])
            ->whereParams(array(
                [CustomerWalletTableSchema::ID, '=', $this->escape_string($wallet->getId())]
            ))
            ->generate();
        $result = mysqli_query($this->getConnection(),$query);
        if($result){
            return $this->getCustomerWalletWithId($wallet->getId());
        }
        return null;
    }

}