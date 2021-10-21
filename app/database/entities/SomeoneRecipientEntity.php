<?php


class SomeoneRecipientEntity {
    const TABLE_NAME = "someone_recipient";

    private string $id;
    private string $customerId;
    private string $takerEmail;
    private string $currencyId;
    private string $bankId;
    private string $accountHolderName;
    private string $iban;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $customerId
     * @param string $takerEmail
     * @param string $currencyId
     * @param string $bankId
     * @param string $accountHolderName
     * @param string $iban
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $customerId, string $takerEmail, string $currencyId, string $bankId, string $accountHolderName, string $iban, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->takerEmail = $takerEmail;
        $this->currencyId = $currencyId;
        $this->bankId = $bankId;
        $this->accountHolderName = $accountHolderName;
        $this->iban = $iban;
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
     * @param string $id
     */
    public function setId(string $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCustomerId(): string {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId(string $customerId): void {
        $this->customerId = $customerId;
    }

    /**
     * @return string
     */
    public function getTakerEmail(): string {
        return $this->takerEmail;
    }

    /**
     * @param string $takerEmail
     */
    public function setTakerEmail(string $takerEmail): void {
        $this->takerEmail = $takerEmail;
    }

    /**
     * @return string
     */
    public function getCurrencyId(): string {
        return $this->currencyId;
    }

    /**
     * @param string $currencyId
     */
    public function setCurrencyId(string $currencyId): void {
        $this->currencyId = $currencyId;
    }

    /**
     * @return string
     */
    public function getBankId(): string {
        return $this->bankId;
    }

    /**
     * @param string $bankId
     */
    public function setBankId(string $bankId): void {
        $this->bankId = $bankId;
    }

    /**
     * @return string
     */
    public function getAccountHolderName(): string {
        return $this->accountHolderName;
    }

    /**
     * @param string $accountHolderName
     */
    public function setAccountHolderName(string $accountHolderName): void {
        $this->accountHolderName = $accountHolderName;
    }

    /**
     * @return string
     */
    public function getIban(): string {
        return $this->iban;
    }

    /**
     * @param string $iban
     */
    public function setIban(string $iban): void {
        $this->iban = $iban;
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