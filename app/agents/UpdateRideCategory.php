<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UpdateRideCategory extends Cab5Api {

    const RIDE_CATEGORY_ID = "ride_category_id";
    const CATEGORY_NAME = 'name';
    const ENABLED = 'enabled';
    const CATEGORY_IMAGE = 'image';
    const PRICE = 'price';
    const PER_KM_COST = 'per_km_cost';

    const Y = 'Y';
    const N = 'N';

    protected function onAssemble() {
        if (!isset($_POST[self::RIDE_CATEGORY_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::RIDE_CATEGORY_ID);
        }
        if (!isset($_POST[self::CATEGORY_NAME])) {
            $this->killAsBadRequestWithMissingParamException(self::CATEGORY_NAME);
        }
        if (!isset($_POST[self::ENABLED])) {
            $this->killAsBadRequestWithMissingParamException(self::ENABLED);
        }

        if (!isset($_FILES[self::CATEGORY_IMAGE])) {
            $this->killAsBadRequestWithMissingParamException(self::CATEGORY_IMAGE);
        }

        if (!isset($_POST[self::PRICE])) {
            $this->killAsBadRequestWithMissingParamException(self::PRICE);
        }

        if (!isset($_POST[self::PER_KM_COST])) {
            $this->killAsBadRequestWithMissingParamException(self::PER_KM_COST);
        }

        if (!in_array($_POST[self::ENABLED], [self::Y, self::N])) {
            $this->killAsBadRequestWithInvalidValueForParam(self::ENABLED);
        }
    }

    protected function onDevise() {
        $rideCategory = $this->getCab5db()->getRideCategoryDao()->getRideCategoryWithName($_POST[self::RIDE_CATEGORY_ID]);

        if ($rideCategory === null) {
            $this->killAsFailure([
                'ride_category_not_found' => true
            ]);
        }

        if ($rideCategory->getName() !== $_POST[self::CATEGORY_NAME]) {
            if ($this->getCab5db()->getRideCategoryDao()->getRideCategoryWithName(self::CATEGORY_NAME) !== null) {
                $this->killAsFailure([
                    "ride_category_already_exist" => true
                ]);
            }
        }

        $generatedName = "";
        $isImageSaved = ImageUploader::withSrc($_FILES[self::CATEGORY_IMAGE]['tmp_name'])
                                     ->destinationDir($this->getRideCategoryImagesDirectory())
                                     ->generateUniqueName($_FILES[self::CATEGORY_IMAGE]['name'])
                                     ->mapGeneratedName($generatedName)
                                     ->compressQuality(75)
                                     ->save();

        if (!$isImageSaved) {
            $this->killAsFailure([
                "failed_to_save_image" => true
            ]);
        }

        $rideCategory->setName($_POST[self::CATEGORY_NAME]);
        $rideCategory->setImage($generatedName);
        $rideCategory->setPrice($_POST[self::PRICE]);
        $rideCategory->setPerKmCost($_POST[self::PER_KM_COST]);
        $rideCategory->setUpdatedAt(Carbon::now());
        $rideCategory->setEnabled($_POST[self::ENABLED] === self::Y);

        $rideCategory = $this->getCab5db()->getRideCategoryDao()->updateRideCategory($rideCategory);

        if ($rideCategory === null) {
            $this->killAsFailure([
                "failed_to_create_ride_category" => true
            ]);
        }

        $this->resSendOK([
            "ride_category" => [
                RideCategoryTableSchema::ID => $rideCategory->getId(),
                RideCategoryTableSchema::NAME => $rideCategory->getName(),
                RideCategoryTableSchema::ENABLED => $rideCategory->isEnabled(),
                RideCategoryTableSchema::IMAGE => $this->createLinkForRideCategoryImage($rideCategory->getImage()),
                RideCategoryTableSchema::PRICE => $rideCategory->getPrice(),
                RideCategoryTableSchema::PER_KM_COST => $rideCategory->getPerKmCost(),
                RideCategoryTableSchema::CREATED_AT => $rideCategory->getCreatedAt(),
                RideCategoryTableSchema::UPDATED_AT => $rideCategory->getUpdatedAt()
            ]
        ]);
    }
}