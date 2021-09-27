<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UploadDriverVehicleNumberPlate extends Cab5Api {

    const NUMBER_PLATE = "number_plate";

    private DriverEntity $driverEntity;

    protected function onTokenAuthorization() {
        $this->driverEntity = $this->handleDriverTokenAuthorization();
    }

    protected function onAssemble() {
        if (!isset($_FILES[self::NUMBER_PLATE])) {
            $this->killAsBadRequestWithMissingParamException(self::NUMBER_PLATE);
        }
    }

    protected function onDevise() {
        if ($this->getCab5db()->getDriverVehicleNumberPlateDao()->getDriverVehicleNumberPlate($this->driverEntity->getId() !== null)) {
            $this->killAsFailure([
                "driver_vehicle_number_plate_already_exist" => true
            ]);
        }

        $generatedName = "";
        $isImageSaved = ImageUploader::withSrc($_FILES[self::NUMBER_PLATE]['tmp_name'])
            ->destinationDir($this->getDriverVehicleNumberPlateImagesDirectory())
            ->generateUniqueName($_FILES[self::NUMBER_PLATE]['name'])
            ->mapGeneratedName($generatedName)
            ->compressQuality(75)
            ->save();

        if (!$isImageSaved) {
            $this->killAsFailure([
                "failed_to_save_number_plate_image" => true
            ]);
        }

        $createTime = Carbon::now();

        $driverVehicleNumberPlateEntity = $this->getCab5db()
            ->getDriverVehicleNumberPlateDao()
            ->insertDriverVehicleNumberPlate(new DriverVehicleNumberPlateEntity(
                Uuid::uuid4()->toString(),
                $this->driverEntity->getId(),
                $generatedName,
                $createTime,
                $createTime
            ));

        if ($driverVehicleNumberPlateEntity === null) {
            $this->killAsFailure([
                "failed_to_persist_driver_vehicle_number_plate" => true
            ]);
        }

        $this->resSendOK([
            "number_plate" => [
                DriverVehicleNumberPlateTableSchema::NUMBER_PLATE => $this->createLinkForDriverVehicleNumberPlateImage($driverVehicleNumberPlateEntity->getNumberPlate())
            ]
        ]);
    }
}