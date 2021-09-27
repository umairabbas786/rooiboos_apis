<?php

class Cab5DB {
    const HOSTNAME = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "cab5";

    private mysqli $conn;

    private PassengerDao $passengerDao;
    private PassengerAvatarDao $passengerAvatarDao;

    private FreeDistanceDao $freeDistanceDao;
    private RideCategoryDao $ride_category_dao;
    private DriverAvatarDao $driverAvatarDao;
    private DriverDao $driverDao;
    private DriverRideCategoryDao $driverRideCategoryDao;
    private CityDao $city_dao;
    private DriverCnicDao $driver_cnic_dao;
    private DriverLicenseDao $driver_license_dao;
    private DriverVehicleNumberPlateDao $driver_vehicle_number_plate_dao;
    private ScheduleRideDao $scheduleRideDao;

    private RideDao $rideDao;

    function __construct() {
        $temp_conn = mysqli_connect(self::HOSTNAME, self::USERNAME, self::PASSWORD, self::DATABASE);

        if (!$temp_conn) {
            die("Couldn't Connect to DB!");
        }

        $this->conn = $temp_conn;

        mysqli_query($this->conn, (new PassengerTableSchema())->getBlueprint()); // Creates Passengers Table
        $this->passengerDao = new PassengerDao($this->conn); // Initialize Passenger Dao

        mysqli_query($this->conn, (new PassengerAvatarTableSchema())->getBlueprint()); // Create Passenger Avatar Table Schema
        $this->passengerAvatarDao = new PassengerAvatarDao($this->conn); // Initialize Passenger Avatar Dao

        mysqli_query($this->conn, (new FreeDistanceTableSchema())->getBlueprint()); // Create FreeDistance Table Schema
        $this->freeDistanceDao = new FreeDistanceDao($this->conn); // Initialize FreeDistance Dao

        mysqli_query($this->conn, (new RideCategoryTableSchema())->getBlueprint()); // Create Ride Category Table
        $this->ride_category_dao = new RideCategoryDao($this->conn); // Initialize Ride Category Dao

        mysqli_query($this->conn, (new DriverAvatarTableSchema())->getBlueprint()); // Create DriverAvatar Table
        $this->driverAvatarDao = new DriverAvatarDao($this->conn); // Initialize DriverAvatar Dao

        mysqli_query($this->conn, (new DriverTableSchema())->getBlueprint()); // Create Drivers Table
        $this->driverDao = new DriverDao($this->conn); // Initialize Driver Dao

        mysqli_query($this->conn, (new DriverRideCategoryTableSchema())->getBlueprint()); // Create DriverRideCategory Table
        $this->driverRideCategoryDao = new DriverRideCategoryDao($this->conn); // Initialize DriverRideCategory Dao

        mysqli_query($this->conn, (new CityTableSchema())->getBlueprint()); // Create Cities Table
        $this->city_dao = new CityDao($this->conn); // Initialize City Dao

        mysqli_query($this->conn, (new DriverCnicTableSchema())->getBlueprint()); // Create Driver CNIC Docs Table
        $this->driver_cnic_dao = new DriverCnicDao($this->conn); // Initialize Driver CNIC Dao

        mysqli_query($this->conn, (new DriverLicenseTableSchema())->getBlueprint()); // Create Driver License Docs Table
        $this->driver_license_dao = new DriverLicenseDao($this->conn); // Initialize Driver License Dao

        mysqli_query($this->conn, (new DriverVehicleNumberPlateTableSchema())->getBlueprint()); // Create Driver Vehicle NumberPlate Table
        $this->driver_vehicle_number_plate_dao = new DriverVehicleNumberPlateDao($this->conn); // Initialize Driver Vehicle NumberPlate Dao

        mysqli_query($this->conn, (new RideTableSchema())->getBlueprint()); // Create Rides Table
        $this->rideDao = new RideDao($this->conn); // Initialize Ride Dao

        mysqli_query($this->conn, (new ScheduleRidesTableSchema())->getBlueprint()); // Create Schedule Ride Table
        $this->scheduleRideDao = new ScheduleRideDao($this->conn); // Initialize Schedule Ride Dao
    }

    public function getConnection(): mysqli {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function getPassengerDao(): PassengerDao {
        return $this->passengerDao;
    }

    public function getPassengerAvatarDao(): PassengerAvatarDao {
        return $this->passengerAvatarDao;
    }

    public function getFreeDistanceDao(): FreeDistanceDao {
        return $this->freeDistanceDao;
    }

    public function getRideCategoryDao(): RideCategoryDao {
        return $this->ride_category_dao;
    }

    public function getDriverAvatarDao(): DriverAvatarDao {
        return $this->driverAvatarDao;
    }

    public function getDriverDao(): DriverDao {
        return $this->driverDao;
    }

    public function getDriverRideCategoryDao(): DriverRideCategoryDao {
        return $this->driverRideCategoryDao;
    }

    public function getCityDao(): CityDao {
        return $this->city_dao;
    }

    public function getDriverCnicDao(): DriverCnicDao {
        return $this->driver_cnic_dao;
    }

    public function getDriverLicenseDao(): DriverLicenseDao {
        return $this->driver_license_dao;
    }

    public function getDriverVehicleNumberPlateDao(): DriverVehicleNumberPlateDao {
        return $this->driver_vehicle_number_plate_dao;
    }

    public function getRideDao(): RideDao {
        return $this->rideDao;
    }

    public function getScheduleRideDao(): ScheduleRideDao {
        return $this->scheduleRideDao;
    }
}
