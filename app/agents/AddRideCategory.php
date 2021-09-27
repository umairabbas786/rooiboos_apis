<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddRideCategory extends Cab5Api {

    const CATEGORY_NAME = 'name';
    const ENABLED = 'enabled';
    const CATEGORY_IMAGE = 'image';
    const PRICE = 'price';
    const PER_KM_COST = 'per_km_cost';

    const Y = 'Y';
    const N = 'N';

    protected function onAssemble() {
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
        if ($this->getCab5db()->getRideCategoryDao()->getRideCategoryWithName(self::CATEGORY_NAME) !== null) {
            $this->killAsFailure([
                "ride_category_already_exist" => true
            ]);
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

        $createTime = Carbon::now();

        $rideCategoryEntity = $this->getCab5db()->getRideCategoryDao()->insertRideCategory(new RideCategoryEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CATEGORY_NAME],
            $generatedName,
            $_POST[self::PRICE],
            (int) $_POST[self::PER_KM_COST],
            $createTime,
            $createTime,
            $_POST[self::ENABLED] === self::Y
        ));

        if ($rideCategoryEntity === null) {
            $this->killAsFailure([
                "failed_to_create_ride_category" => true
            ]);
        }

        $this->resSendOK([
            "ride_category" => [
                RideCategoryTableSchema::ID => $rideCategoryEntity->getId(),
                RideCategoryTableSchema::NAME => $rideCategoryEntity->getName(),
                RideCategoryTableSchema::ENABLED => $rideCategoryEntity->isEnabled(),
                RideCategoryTableSchema::IMAGE => $this->createLinkForRideCategoryImage($rideCategoryEntity->getImage()),
                RideCategoryTableSchema::PRICE => $rideCategoryEntity->getPrice(),
                RideCategoryTableSchema::PER_KM_COST => $rideCategoryEntity->getPerKmCost(),
                RideCategoryTableSchema::CREATED_AT => $rideCategoryEntity->getCreatedAt(),
                RideCategoryTableSchema::UPDATED_AT => $rideCategoryEntity->getUpdatedAt()
            ]
        ]);
    }
}