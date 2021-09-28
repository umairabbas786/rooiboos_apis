<?php

trait Environment {

    private function getServerNameWithAvailableProtocol(): string {
        return 'https://rooiboos.portfoliosindepth.com';
    }

    private function getServerUrlUptoImagesDir(): string {
        return $this->getServerNameWithAvailableProtocol() . "/assets/img";
    }

    public function getDataImagesDirectory(): string {
        return Manifest::getAppSystemRoot() . '../assets/img';
    }

    /**
     * <user_cnic_image>
     */
    public function getCustomerCnicImagesDirectory(): string {
        return $this->getDataImagesDirectory() . '/users';
    }

    public function createLinkForCustomerCnicImage(string $image_name): string {
        return $this->getServerUrlUptoImagesDir() . '/users/' . $image_name;
    }
    /** ----------------- </user_cnic_image> */

}
