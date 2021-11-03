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
    private DepositFeeDao $depositFeeDao;
    private WithdrawFeeDao $withdrawFeeDao;
    private BankDao $bankDao;
    private DepositHistoryDao $depositHistoryDao;
    private WithdrawHistoryDao $withdrawHistoryDao;
    private SendFeeDao $sendFeeDao;
    private MyselfRecipientDao $myselfRecipientDao;
    private SomeoneRecipientDao $someoneRecipientDao;
    private SendHistoryDao $sendHistoryDao;
    private CurrencyFeeDao $currencyFeeDao;
    private CurrencyChargesDao $currencyChargesDao;
    private NotificationDao $notificationDao;
    private ProfilePictureDao $profilePictureDao;

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

        mysqli_query($this->conn, (new DepositFeeTableSchema())->getBlueprint()); // Create Deposit Fee Table
        $this->depositFeeDao = new DepositFeeDao($this->conn); // Initialize Deposit Fee Dao

        mysqli_query($this->conn, (new SendFeeTableSchema())->getBlueprint()); // Create Send Fee Table
        $this->sendFeeDao = new SendFeeDao($this->conn); // Initialize Send Fee Dao

        mysqli_query($this->conn, (new WithdrawFeeTableSchema())->getBlueprint()); // Create Withdraw Fee Table
        $this->withdrawFeeDao = new WithdrawFeeDao($this->conn); // Initialize Withdraw Fee Dao

        mysqli_query($this->conn, (new BankTableSchema())->getBlueprint()); // Create Bank Table
        $this->bankDao = new BankDao($this->conn); // Initialize Bank Dao

        mysqli_query($this->conn, (new DepositHistoryTableSchema())->getBlueprint()); // Create Deposit History Table
        $this->depositHistoryDao = new DepositHistoryDao($this->conn); // Initialize Deposit History Dao

        mysqli_query($this->conn, (new WithdrawHistoryTableSchema())->getBlueprint()); // Create Withdraw History Table
        $this->withdrawHistoryDao = new WithdrawHistoryDao($this->conn); // Initialize Withdraw History Dao

        mysqli_query($this->conn, (new MyselfRecipientTableSchema())->getBlueprint()); // Create Myself Recipient Table
        $this->myselfRecipientDao = new MyselfRecipientDao($this->conn); // Initialize Myself Recipient Dao

        mysqli_query($this->conn, (new SomeoneRecipientTableSchema())->getBlueprint()); // Create Someone Recipient Table
        $this->someoneRecipientDao = new SomeoneRecipientDao($this->conn); // Initialize Someone Recipient Dao

        mysqli_query($this->conn, (new SendHistoryTableSchema())->getBlueprint()); // Create Send History Table
        $this->sendHistoryDao = new SendHistoryDao($this->conn); // Initialize Send History Dao

        mysqli_query($this->conn, (new CurrencyFeeTableSchema())->getBlueprint()); // Create Currency Fee Table
        $this->currencyFeeDao = new CurrencyFeeDao($this->conn); // Initialize Currency Fee Dao

        mysqli_query($this->conn, (new CurrencyChargesTableSchema())->getBlueprint()); // Create Currency Charges Table
        $this->currencyChargesDao = new CurrencyChargesDao($this->conn); // Initialize Currency Charges Dao

        mysqli_query($this->conn, (new NotificationTableSchema())->getBlueprint()); // Create Notification Table
        $this->notificationDao = new NotificationDao($this->conn); // Initialize Notification Dao

        mysqli_query($this->conn, (new ProfilePictureTableSchema())->getBlueprint()); // Create Profile Picture Table
        $this->profilePictureDao = new ProfilePictureDao($this->conn); // Initialize Profile Picture Dao
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

    public function getDepositFeeDao(): DepositFeeDao {
        return $this->depositFeeDao;
    }

    public function getWithdrawFeeDao(): WithdrawFeeDao {
        return $this->withdrawFeeDao;
    }

    public function getSendFeeDao(): SendFeeDao {
        return $this->sendFeeDao;
    }

    public function getBankDao(): BankDao {
        return $this->bankDao;
    }

    public function getDepositHistoryDao(): DepositHistoryDao {
        return $this->depositHistoryDao;
    }

    public function getWithdrawHistoryDao(): WithdrawHistoryDao {
        return $this->withdrawHistoryDao;
    }

    public function getMyselfRecipientDao(): MyselfRecipientDao {
        return $this->myselfRecipientDao;
    }

    public function getSomeoneRecipientDao(): SomeoneRecipientDao {
        return $this->someoneRecipientDao;
    }

    public function getSendHistoryDao(): SendHistoryDao {
        return $this->sendHistoryDao;
    }

    public function getCurrencyFeeDao(): CurrencyFeeDao {
        return $this->currencyFeeDao;
    }

    public function getCurrencyChargesDao(): CurrencyChargesDao {
        return $this->currencyChargesDao;
    }

    public function getNotificationDao(): NotificationDao {
        return $this->notificationDao;
    }

    public function getProfilePictureDao(): ProfilePictureDao {
        return $this->profilePictureDao;
    }
}
