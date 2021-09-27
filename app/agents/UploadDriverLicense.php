<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UploadDriverLicense extends Cab5Api {

    const LICENSE_FRONT = "license_front";
    const LICENSE_BACK = "license_back";

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_FILES[self::LICENSE_FRONT])) {
            $this->killAsBadRequestWithMissingParamException(self::LICENSE_FRONT);
        }
        if (!isset($_FILES[self::LICENSE_BACK])) {
            $this->killAsBadRequestWithMissingParamException(self::LICENSE_BACK);
        }
    }

    protected function onDevise() {
        if ($this->getCab5db()->getDriverLicenseDao()->getLicenseOfDriver($this->driverEntity->getId()) !== null) {
            $this->killAsFailure([
                'driver_license_already_exist' => true
            ]);
        }

        $frontLicenseGeneratedName = "";
        $isFrontLicenseImageSaved = ImageUploader::withSrc($_FILES[self::LICENSE_FRONT]['tmp_name'])
            ->destinationDir($this->getDriverLicenseImagesDirectory())
            ->generateUniqueName($_FILES[self::LICENSE_FRONT]['name'])
            ->mapGeneratedName($frontLicenseGeneratedName)
            ->compressQuality(75)
            ->save();

        if (!$isFrontLicenseImageSaved) {
            $this->killAsFailure([
                'failed_to_save_license_front_image' => true
            ]);
        }

        $backLicenseGeneratedName = "";
        $isBackLicenseImageSaved = ImageUploader::withSrc($_FILES[self::LICENSE_BACK]['tmp_name'])
            ->destinationDir($this->getDriverLicenseImagesDirectory())
            ->generateUniqueName($_FILES[self::LICENSE_BACK]['name'])
            ->mapGeneratedName($backLicenseGeneratedName)
            ->compressQuality(75)
            ->save();

        if (!$isBackLicenseImageSaved) {
            $this->killAsFailure([
                'failed_to_save_license_back_image' => true
            ]);
        }

        $createTime = Carbon::now();

        $licenseEntity = $this->getCab5db()->getDriverLicenseDao()->insertDriverLicense(new DriverLicenseEntity(
            Uuid::uuid4()->toString(),
            $this->driverEntity->getId(),
            $frontLicenseGeneratedName,
            $backLicenseGeneratedName,
            $createTime,
            $createTime
        ));

        if ($licenseEntity === null) {
            $this->killAsFailure([
                "failed_to_upload_driver_license" => true
            ]);
        }

        $this->resSendOK([
            "license" => [
                DriverLicenseTableSchema::LICENSE_FRONT => $this->createLinkForDriverLicenseImage($licenseEntity->getLicenseFront()),
                DriverLicenseTableSchema::LICENSE_BACK => $this->createLinkForDriverLicenseImage($licenseEntity->getLicenseBack())
            ]
        ]);
    }
}