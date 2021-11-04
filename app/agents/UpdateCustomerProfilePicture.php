<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class UpdateCustomerProfilePicture extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const PICTURE = "picture";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }

        if (!isset($_FILES[self::PICTURE])) {
            $this->killAsBadRequestWithMissingParamException(self::PICTURE);
        }
    }

    protected function onDevise() {

        $customerEntity = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithId($_POST[self::CUSTOMER_ID]);

        if ($customerEntity === null) {
            $this->killAsFailure([
                "customer_not_found" => true
            ]);
        }

        $pictureGeneratedName = "";
        $isProfileImageSaved = ImageUploader::withSrc($_FILES[self::PICTURE]['tmp_name'])
            ->destinationDir($this->getCustomerProfileImagesDirectory())
            ->generateUniqueName($_FILES[self::PICTURE]['name'])
            ->mapGeneratedName($pictureGeneratedName)
            ->compressQuality(75)
            ->save();

        if(!$isProfileImageSaved){
            $this->killAsFailure([
                "failed_to_save_profile_image"=> true
            ]);
        }

        $registration_time = Carbon::now();

        $customerPicture = $this->getRooiBoosDB()->getProfilePictureDao()->updateCustomerProfilePicture($_POST[self::CUSTOMER_ID],$pictureGeneratedName,$registration_time);

        if($customerPicture === false){
            $this->killAsFailure([
                "failed_to_update_customer_profile_picture" => true
            ]);
        }

        $this->resSendOK([
            'customer_profile_picture_updated'=>true
        ]);
    }
}