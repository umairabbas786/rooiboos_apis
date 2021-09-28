<?php

trait Environment {

    private function getServerNameWithAvailableProtocol(): string {
        $server_name = $_SERVER["SERVER_NAME"];
        if ($server_name === "localhost" || $server_name === "192.168.43.174") {
            return "http://" . $server_name . "/rooiboosapi";
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

}
