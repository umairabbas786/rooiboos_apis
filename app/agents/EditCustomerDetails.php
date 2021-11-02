<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class EditCustomerDetails extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";
    const ACCOUNT_HOLDER_NAME = "account_holder_name";
    const ACCOUNT_NUMBER = "account_number";
    const ACCOUNT_NUMBER_IBAN = "account_number_iban";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID,
            self::ACCOUNT_HOLDER_NAME,
            self::ACCOUNT_NUMBER,
            self::ACCOUNT_NUMBER_IBAN
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {

        $customerEntity = $this->getRooiBoosDB()->getCustomerDao()->getCustomerWithId($_POST[self::CUSTOMER_ID]);

        if ($customerEntity === null) {
            $this->killAsFailure([
                "customer_not_found" => true
            ]);
        }

        $update_time = Carbon::now();

        $customer = $this->getRooiBoosDB()->getCustomerDao()->updateCustomerAccount($_POST[self::CUSTOMER_ID],$_POST[self::ACCOUNT_HOLDER_NAME],$_POST[self::ACCOUNT_NUMBER],$_POST[self::ACCOUNT_NUMBER_IBAN],$update_time);

        if($customer === false){
            $this->killAsFailure([
                "failed_to_update_customer_data" => true
            ]);
        }

        $this->resSendOK([
            'customer_updated'=> true
        ]);
    }
}