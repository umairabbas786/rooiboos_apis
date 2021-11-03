<?php

class FetchCustomerProfilePictureWithCustomerId extends RooiBoosApi {

    private const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        if (!isset($_POST[self::CUSTOMER_ID])) {
            $this->killAsBadRequestWithMissingParamException(self::CUSTOMER_ID);
        }
    }

    protected function onDevise() {

        $customerProfilePicture = $this->getRooiBoosDB()->getProfilePictureDao()->getProfilePictureWithCustomerId($_POST[self::CUSTOMER_ID]);

        $this->resSendOK([
            'customer_profile_picture' => $customerProfilePicture === null ? null : [
                ProfilePictureTableSchema::PICTURE => $this->createLinkForCustomerProfileImage($customerProfilePicture->getPicture())
            ]
        ]);
    }
}