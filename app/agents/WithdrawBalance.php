<?php

use Carbon\Carbon;

class WithdrawBalance extends RooiBoosApi {

    const CURRENCY_ID = "currency_id";
    const CUSTOMER_ID = "customer_id";
    const BALANCE = "balance";

    private function killForParam(string $param) {
        if (!isset($_POST[$param])) {
            $this->killAsBadRequestWithMissingParamException($param);
        }
    }

    protected function onAssemble() {
        $this->killForParam(self::CURRENCY_ID);
        $this->killForParam(self::CUSTOMER_ID);
        $this->killForParam(self::BALANCE);
    }

    protected function onDevise() {
        $wallet = $this->getRooiBoosDB()->getCustomerWalletDao()->getCustomerWalletWithCustomerIdAndCurrencyId(
            $_POST[self::CUSTOMER_ID],
            $_POST[self::CURRENCY_ID]
        );
        if($wallet === null){
            $this->killAsFailure([
                'wallet_not_found'=>true
            ]);
        }

        $oldAmount = $wallet->getBalance();
        $withdrawAmount = (float) $_POST[self::BALANCE];
        if($withdrawAmount > $oldAmount){
            $this->killAsFailure([
                'not_enough_balance'=>true
            ]);
        }

        $wallet->setBalance($wallet->getBalance() - (float) $_POST[self::BALANCE]);
        $wallet->setUpdatedAt(Carbon::now());
        $wallet = $this->getRooiBoosDB()->getCustomerWalletDao()->updateWalletBalance($wallet);
        if($wallet === null){
            $this->killAsFailure([
                'fail_to_update_balance'=>true
            ]);
        }
        $this->resSendOK([
            'updated'=>true,
            'new_balance'=>$wallet->getBalance()
        ]);
    }
}