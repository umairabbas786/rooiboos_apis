<?php

use Carbon\Carbon;

class GetWithdrawFee extends RooiBoosApi {

    private ?WithdrawFeeEntity $withdrawFeeEntity;

    protected function onAssemble() {
        $this->withdrawFeeEntity = $this->getRooiBoosDB()->getWithdrawFeeDao()->getWithdrawFeeWithId(WithdrawFeeEntity::ID);
    }

    protected function onDevise() {
        $createTime = Carbon::now();


        if ($this->withdrawFeeEntity === null) {
            $this->getRooiBoosDB()->getWithdrawFeeDao()->insertWithdrawFee(new WithdrawFeeEntity(
                "5", $createTime, $createTime
            ));
        }

        $this->withdrawFeeEntity = $this->getRooiBoosDB()->getWithdrawFeeDao()->getWithdrawFeeWithId(WithdrawFeeEntity::ID);

        $this->resSendOK([
            'withdraw_fee_percent' => (int) $this->withdrawFeeEntity->getWithdrawFee()
        ]);
    }
}