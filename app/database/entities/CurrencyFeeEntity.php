<?php


class CurrencyFeeEntity {
    const ID = "currency-fee";
    const TABLE_NAME = "currency_fee";

    private string $id;
    private string $currencyFee;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $currencyFee
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $currencyFee, string $createdAt, string $updatedAt) {
        $this->id = CurrencyFeeEntity::ID;
        $this->currencyFee = $currencyFee;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCurrencyFee(): string {
        return $this->currencyFee;
    }

    /**
     * @param string $currencyFee
     */
    public function setCurrencyFee(string $currencyFee): void {
        $this->currencyFee = $currencyFee;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void {
        $this->updatedAt = $updatedAt;
    }

}