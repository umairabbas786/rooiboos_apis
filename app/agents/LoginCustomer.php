<?php


class LoginCustomer extends RooiBoosApi {

    const EMAIL = "email";
    const PASSWORD = "password";

    protected function onAssemble() {
        if (!isset($_POST[self::EMAIL])) {
            $this->killAsBadRequestWithMissingParamException(self::EMAIL);
        }
        if (!isset($_POST[self::PASSWORD])) {
            $this->killAsBadRequestWithMissingParamException(self::PASSWORD);
        }
    }

    protected function onDevise() {
        $customer = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithEmail($_POST[self::EMAIL]);
        
        if ($customer === null) {
            $this->killAsFailure([
                'no_customer_found' => true
            ]);
        }

        if ($customer->isStatus() === true) {
            $this->killAsFailure([
                'customer_blocked' => true
            ]);
        }

        if($customer->getPassword() !== $_POST[self::PASSWORD]){
            $this->killAsFailure([
                'wrong_password' => true
            ]);
        }

        $this->resSendOK([
            'customer'=> [
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
