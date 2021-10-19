<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class RegisterCustomer extends RooiBoosApi {

    const EMAIL = "email";
    const ACCOUNT_TYPE = "account_type";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const CNIC_FRONT = "cnic_front";
    const CNIC_BACK = "cnic_back";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const ACCOUNT_NUMBER = "account_number";
    const ACCOUNT_NUMBER_IBAN = "account_number_iban";
    const COUNTRY_ID = "country_id";
    const PASSWORD = "password";
    const PHONE_NUMBER = "phone_number";

    protected function onAssemble() {
        $required_fields = [
            self::EMAIL,
            self::ACCOUNT_TYPE,
            self::FIRST_NAME,
            self::LAST_NAME,
            self::ACCOUNT_HOLDER_NAME,
            self::ACCOUNT_NUMBER,
            self::ACCOUNT_NUMBER_IBAN,
            self::COUNTRY_ID,
            self::PASSWORD,
            self::PHONE_NUMBER
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }

        if (!isset($_FILES[self::CNIC_FRONT])) {
            $this->killAsBadRequestWithMissingParamException(self::CNIC_FRONT);
        }

        if (!isset($_FILES[self::CNIC_BACK])) {
            $this->killAsBadRequestWithMissingParamException(self::CNIC_BACK);
        }
    }

    protected function onDevise() {
        $cnicFrontGeneratedName = "";
        $isCnicFrontImageSaved = ImageUploader::withSrc($_FILES[self::CNIC_FRONT]['tmp_name'])
            ->destinationDir($this->getCustomerCnicImagesDirectory())
            ->generateUniqueName($_FILES[self::CNIC_FRONT]['name'])
            ->mapGeneratedName($cnicFrontGeneratedName)
            ->compressQuality(75)
            ->save();

        if(!$isCnicFrontImageSaved){
            $this->killAsFailure([
                "failed_to_save_cnic_front_image"=> true
            ]);
        }

        $cnicBackGeneratedName = "";
        $isCnicBackImageSaved = ImageUploader::withSrc($_FILES[self::CNIC_BACK]['tmp_name'])
            ->destinationDir($this->getCustomerCnicImagesDirectory())
            ->generateUniqueName($_FILES[self::CNIC_BACK]['name'])
            ->mapGeneratedName($cnicBackGeneratedName)
            ->compressQuality(75)
            ->save();

        if(!$isCnicBackImageSaved){
            $this->killAsFailure([
                "failed_to_save_cnic_back_image"=> true
            ]);
        }

        $customerEntity = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithEmail($_POST[self::EMAIL]);

        if ($customerEntity !== null) {
            $this->killAsFailure([
                "customer_already_registered" => true
            ]);
        }

        $registration_time = Carbon::now();

        $customer = new CustomerEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::FIRST_NAME],
            $_POST[self::LAST_NAME],
            $_POST[self::EMAIL],
            $_POST[self::PHONE_NUMBER],
            true,
            $_POST[self::PASSWORD],
            $cnicFrontGeneratedName,
            $cnicBackGeneratedName,
            $_POST[self::COUNTRY_ID],
            $_POST[self::ACCOUNT_HOLDER_NAME],
            $_POST[self::ACCOUNT_NUMBER],
            $_POST[self::ACCOUNT_NUMBER_IBAN],
            $_POST[self::ACCOUNT_TYPE],
            false,
            $registration_time,
            $registration_time
        );

        $customer = $this->getRooiBoosDB()->getCustomerDao()->insertCustomer($customer);

        if($customer === null){
            $this->killAsFailure([
                "failed_to_insert_customer_data" => true
            ]);
        }

        $this->resSendOK([
            'customer'=>[
                CustomerTableSchema::ID => $customer->getId(),
                CustomerTableSchema::FIRST_NAME => $customer->getFirstName(),
                CustomerTableSchema::LAST_NAME => $customer->getLastName(),
                CustomerTableSchema::EMAIL => $customer->getEmail(),
                CustomerTableSchema::PHONE_NUMBER => $customer->getPhoneNumber(),
                CustomerTableSchema::PHONE_VERIFICATION => $customer->isPhoneVerified(),
                CustomerTableSchema::PASSWORD => $customer->getPassword(),
                CustomerTableSchema::CNIC_FRONT => $this->createLinkForCustomerCnicImage($customer->getCnicFront()),
                CustomerTableSchema::CNIC_BACK => $this->createLinkForCustomerCnicImage($customer->getCnicBack()),
                CustomerTableSchema::COUNTRY => $customer->getCountry(),
                CustomerTableSchema::ACCOUNT_HOLDER_NAME => $customer->getAccountHolderName(),
                CustomerTableSchema::ACCOUNT_NUMBER => $customer->getAccountNumber(),
                CustomerTableSchema::IBAN_ACCOUNT_NUMBER => $customer->getIbanAccountNumber(),
                CustomerTableSchema::ACCOUNT_TYPE => $customer->getAccountType(),
                CustomerTableSchema::STATUS => $customer->isStatus(),
                CustomerTableSchema::CREATED_AT => $customer->getCreatedAt(),
                CustomerTableSchema::UPDATED_AT => $customer->getUpdatedAt()
            ]
        ]);
    }
}