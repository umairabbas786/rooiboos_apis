<?php


class CustomerDao extends TableDao {

    /**
     * UserDao constructor.
     * @param mysqli $connection
     */
    public function __construct(mysqli $connection) { parent::__construct($connection); }

    public function insertCustomer(CustomerEntity $customerEntity): ?CustomerEntity {
        $insertColumns = [];
        $insertValues = [];

        array_push($insertColumns, CustomerTableSchema::ID);
        array_push($insertValues, $this->escape_string($customerEntity->getId()));

        array_push($insertColumns, CustomerTableSchema::FIRST_NAME);
        array_push($insertValues, $this->escape_string($customerEntity->getFirstName()));

        array_push($insertColumns, CustomerTableSchema::LAST_NAME);
        array_push($insertValues, $this->escape_string($customerEntity->getLastName()));

        array_push($insertColumns, CustomerTableSchema::EMAIL);
        array_push($insertValues, $this->escape_string($customerEntity->getEmail()));

        array_push($insertColumns, CustomerTableSchema::PHONE_NUMBER);
        array_push($insertValues, $this->escape_string($customerEntity->getPhoneNumber()));

        array_push($insertColumns, CustomerTableSchema::PHONE_VERIFICATION);
        array_push($insertValues, $this->wrapBool($customerEntity->isPhoneVerified()));

        array_push($insertColumns, CustomerTableSchema::PASSWORD);
        array_push($insertValues, $this->escape_string($customerEntity->getPassword()));

        array_push($insertColumns, CustomerTableSchema::CNIC_FRONT);
        array_push($insertValues, $this->escape_string($customerEntity->getCnicFront()));

        array_push($insertColumns, CustomerTableSchema::CNIC_BACK);
        array_push($insertValues, $this->escape_string($customerEntity->getCnicBack()));

        array_push($insertColumns, CustomerTableSchema::COUNTRY);
        array_push($insertValues, $this->escape_string($customerEntity->getCountry()));

        array_push($insertColumns, CustomerTableSchema::ACCOUNT_HOLDER_NAME);
        array_push($insertValues, $this->escape_string($customerEntity->getAccountHolderName()));

        array_push($insertColumns, CustomerTableSchema::ACCOUNT_NUMBER);
        array_push($insertValues, $this->escape_string($customerEntity->getAccountNumber()));

        array_push($insertColumns, CustomerTableSchema::IBAN_ACCOUNT_NUMBER);
        array_push($insertValues, $this->escape_string($customerEntity->getIbanAccountNumber()));

        array_push($insertColumns, CustomerTableSchema::ACCOUNT_TYPE);
        array_push($insertValues, $this->escape_string($customerEntity->getAccountType()));

        array_push($insertColumns, CustomerTableSchema::STATUS);
        array_push($insertValues, $this->wrapBool($customerEntity->isStatus()));

        array_push($insertColumns, CustomerTableSchema::CREATED_AT);
        array_push($insertValues, $this->escape_string($customerEntity->getCreatedAt()));

        array_push($insertColumns, CustomerTableSchema::UPDATED_AT);
        array_push($insertValues, $this->escape_string($customerEntity->getUpdatedAt()));

        $query = QueryBuilder::withQueryType(QueryType::INSERT)
            ->withTableName(CustomerEntity::TABLE_NAME)
            ->columns($insertColumns)
            ->values($insertValues)
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result) {
            return $this->getCustomerWithId($customerEntity->getId());
        }

        return null;
    }

    /**
     * @param string $customerId
     * @return CustomerEntity|null
     */
    public function getCustomerWithId(string $customerId): ?CustomerEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CustomerEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CustomerTableSchema::ID, '=', $this->escape_string($customerId)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CustomerFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }

    /**
     * @param string $customerEmail
     * @return CustomerEntity|null
     */
    public function getCustomerWithEmail(string $customerEmail): ?CustomerEntity {
        $query = QueryBuilder::withQueryType(QueryType::SELECT)
            ->withTableName(CustomerEntity::TABLE_NAME)
            ->columns(['*'])
            ->whereParams(array(
                [CustomerTableSchema::EMAIL, '=', $this->escape_string($customerEmail)]
            ))
            ->generate();

        $result = mysqli_query($this->getConnection(), $query);

        if ($result->num_rows === 1) {
            return CustomerFactory::mapFromDatabaseResult(mysqli_fetch_assoc($result));
        }
        return null;
    }
}