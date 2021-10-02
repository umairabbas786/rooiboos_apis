<?php

class RooiBoosDB {
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "bigadmin";

    private mysqli $conn;

    private CustomerDao $customerDao;
    private CountryDao $countryDao;
    private CurrencyDao $currencyDao;
    private CustomerWalletDao $customerWalletDao;

    function __construct() {
        $temp_conn = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);

        if (!$temp_conn) {
            die("Couldn't Connect to DB!");
        }

        $this->conn = $temp_conn;

        mysqli_query($this->conn, (new CustomerTableSchema())->getBlueprint()); // Create Customer Table
        $this->customerDao = new CustomerDao($this->conn); // Initialize Customer Dao

        mysqli_query($this->conn, (new CountryTableSchema())->getBlueprint()); // Create Country Table
        $this->countryDao = new CountryDao($this->conn); // Initialize Country Dao

        mysqli_query($this->conn, (new CurrencyTableSchema())->getBlueprint()); // Create Currency Table
        $this->currencyDao = new CurrencyDao($this->conn); // Initialize Currency Dao

        mysqli_query($this->conn, (new CustomerWalletTableSchema())->getBlueprint()); // Create Customer wallet Table
        $this->customerWalletDao = new CustomerWalletDao($this->conn); // Initialize Customer wallet Dao
    }

    public function getConnection(): mysqli {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function getCustomerDao(): CustomerDao {
        return $this->customerDao;
    }

    public function getCountryDao(): CountryDao {
        return $this->countryDao;
    }

    public function getCurrencyDao(): CurrencyDao {
        return $this->currencyDao;
    }

    public function getCustomerWalletDao(): CustomerWalletDao {
        return $this->customerWalletDao;
    }
}
