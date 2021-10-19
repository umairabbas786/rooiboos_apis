<?php

use Carbon\Carbon;

class GetSendFee extends RooiBoosApi {

    private ?SendFeeEntity $sendFeeEntity;

    protected function onAssemble() {
        $this->sendFeeEntity = $this->getRooiBoosDB()->getSendFeeDao()->getSendFeeWithId(SendFeeEntity::ID);
    }

    protected function onDevise() {
        $createTime = Carbon::now();


        if ($this->sendFeeEntity === null) {
            $this->getRooiBoosDB()->getSendFeeDao()->insertSendFee(new SendFeeEntity(
                "2", $createTime, $createTime
            ));
        }

        $this->sendFeeEntity = $this->getRooiBoosDB()->getSendFeeDao()->getSendFeeWithId(SendFeeEntity::ID);

        $this->resSendOK([
            'send_fee_percent' => (int) $this->sendFeeEntity->getSendFee()
        ]);
    }
}