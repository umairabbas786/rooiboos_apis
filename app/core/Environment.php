<?php

trait Environment {

    private function getServerNameWithAvailableProtocol(): string {
        $server_name = $_SERVER["SERVER_NAME"];
        if ($server_name === "localhost" || $server_name === "192.168.43.174") {
            return "http://" . $server_name . "/cab-5-server";
        }
        return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $server_name;
    }

    private function getServerUrlUptoImagesDir(): string {
        return $this->getServerNameWithAvailableProtocol() . "/data/images";
    }

    public function getDataImagesDirectory(): string {
        return Manifest::getAppSystemRoot() . '/data/images';
    }


    /**
     * <DriversAvatars>
     */
    public function getDriverAvatarImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/drivers_avatars';
    }

    public function createLinkForDriverAvatarImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/drivers_avatars/' . $image_name;
    }
    /** ----------------- </DriversAvatars> */

    /**
     * <PassengersAvatars>
     */
    public function getPassengerAvatarImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/passengers_avatars';
    }

    public function createLinkForPassengerAvatarImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/passengers_avatars/' . $image_name;
    }
    /** ----------------- </PassengersAvatars> */


    /**
     * <Driver CNIC>
     */
    public function getDriverCnicImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/driver_cnic';
    }

    public function createLinkForDriverCnicImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/driver_cnic/' . $image_name;
    }
    /**  ------------- </Driver CNIC> */


    /**
     * <Driver License>
     */
    public function getDriverLicenseImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/driver_license';
    }

    public function createLinkForDriverLicenseImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/driver_license/' . $image_name;
    }
    /** ------------- </Driver License> */


    /**
     * <Driver Vehicle Number Plate>
     */
    public function getDriverVehicleNumberPlateImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/vehicle_number_plates';
    }

    public function createLinkForDriverVehicleNumberPlateImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/vehicle_number_plates/' . $image_name;
    }
    /** ------------- </Driver Vehicle Number Plate> */


    /**
     * <Ride Category>
     */
    public function getRideCategoryImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/ride_categories';
    }

    public function createLinkForRideCategoryImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/ride_categories/' . $image_name;
    }
    /** ------------- </Ride Category> */
}
