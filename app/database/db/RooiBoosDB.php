<?php

class RooiBoosDB {
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "bigadmin";

    private mysqli $conn;

    private CustomerDao $customerDao;

    function __construct() {
        $temp_conn = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);

        if (!$temp_conn) {
            die("Couldn't Connect to DB!");
        }

        $this->conn = $temp_conn;

        mysqli_query($this->conn, (new CustomerTableSchema())->getBlueprint()); // Create Customer Table
        $this->customerDao = new CustomerDao($this->conn); // Initialize Customer Dao
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
}
