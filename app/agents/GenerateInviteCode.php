<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class GenerateInviteCode extends RooiBoosApi {

    const CUSTOMER_ID = "customer_id";

    protected function onAssemble() {
        $required_fields = [
            self::CUSTOMER_ID
        ];

        foreach ($required_fields as $required_field) {
            if (!isset($_POST[$required_field])) {
                $this->killAsBadRequestWithMissingParamException($required_field);
            }
        }
    }

    protected function onDevise() {

        $registration_time = Carbon::now();

        $inviteEntity = $this->getRooiBoosDB()->getInviteDao()->getInviteWithCustomerId($_POST[self::CUSTOMER_ID]);

        if ($inviteEntity === null) {
            $this->killAsFailure([
                "referral_code_already_generated" => true
            ]);
        }

        $invite = new InviteEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CUSTOMER_ID],
            bin2hex(openssl_random_pseudo_bytes(3)),
            $registration_time,
            $registration_time
        );

        $invite = $this->getRooiBoosDB()->getInviteDao()->insertInvite($invite);

        if($invite === null){
            $this->killAsFailure([
                "failed_to_generate_referral_code" => true
            ]);
        }

        $this->resSendOK([
            'referral_code'=>[
                InviteTableSchema::CODE => $inviteEntity->getCode()
            ]
        ]);
    }
}