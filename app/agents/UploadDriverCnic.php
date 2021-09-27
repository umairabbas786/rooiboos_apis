<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UploadDriverCnic extends Cab5Api {

    const CNIC_FRONT = "cnic_front";
    const CNIC_BACK = "cnic_back";

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_FILES[self::CNIC_FRONT])) {
            $this->killAsBadRequestWithMissingParamException(self::CNIC_FRONT);
        }
        if (!isset($_FILES[self::CNIC_BACK])) {
            $this->killAsBadRequestWithMissingParamException(self::CNIC_BACK);
        }
    }

    protected function onDevise() {
        if ($this->getCab5db()->getDriverCnicDao()->getCnicOfDriver($this->driverEntity->getId() !== null)) {
            $this->killAsFailure([
                "driver_cnic_already_exist" => true
            ]);
        }

        $frontCnicGeneratedName = "";
        $isFrontCnicImageSaved = ImageUploader::withSrc($_FILES[self::CNIC_FRONT]['tmp_name'])
            ->destinationDir($this->getDriverCnicImagesDirectory())
            ->generateUniqueName($_FILES[self::CNIC_FRONT]['name'])
            ->mapGeneratedName($frontCnicGeneratedName)
            ->compressQuality(75)
            ->save();

        if (!$isFrontCnicImageSaved) {
            $this->killAsFailure([
                'failed_to_save_front_image' => true
            ]);
        }

        $backCnicGeneratedName = "";
        $isBackCnicImageSaved = ImageUploader::withSrc($_FILES[self::CNIC_BACK]['tmp_name'])
            ->destinationDir($this->getDriverCnicImagesDirectory())
            ->generateUniqueName($_FILES[self::CNIC_BACK]['name'])
            ->mapGeneratedName($backCnicGeneratedName)
            ->compressQuality(75)
            ->save();

        if (!$isBackCnicImageSaved) {
            $this->killAsFailure([
                'failed_to_save_back_image' => true
            ]);
        }

        $createTime = Carbon::now();

        $cnicEntity = $this->getCab5db()->getDriverCnicDao()->insertDriverCnic(new DriverCnicEntity(
            Uuid::uuid4()->toString(),
            $this->driverEntity->getId(),
            $frontCnicGeneratedName,
            $backCnicGeneratedName,
            $createTime,
            $createTime
        ));

        if ($cnicEntity === null) {
            $this->killAsFailure([
                'failed_to_persist_driver_cnic_record' => true
            ]);
        }

        $this->resSendOK([
            "cnic" => [
                DriverCnicTableSchema::CNIC_FRONT => $this->createLinkForDriverCnicImage($cnicEntity->getCnicFront()),
                DriverCnicTableSchema::CNIC_BACK => $this->createLinkForDriverCnicImage($cnicEntity->getCnicBack()),
            ]
        ]);
    }
}