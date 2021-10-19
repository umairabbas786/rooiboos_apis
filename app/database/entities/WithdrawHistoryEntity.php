<?php


class WithdrawHistoryEntity {
    const TABLE_NAME = "withdraw_history";

    private string $id;
    private string $customerId;
    private string $currencyId;
    private string $bankId;
    private string $accountHolderName;
    private string $iban;
    private string $balance;
    private bool $status;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $customerId
     * @param string $currencyId
     * @param string $bankId
     * @param string $accountHolderName
     * @param string $iban
     * @param string $balance
     * @param bool $status
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $customerId, string $currencyId, string $bankId, string $accountHolderName, string $iban, string $balance, bool $status, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->currencyId = $currencyId;
        $this->bankId = $bankId;
        $this->accountHolderName = $accountHolderName;
        $this->iban = $iban;
        $this->balance = $balance;
        $this->status = $status;
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
    public function getBalance(): string {
        return $this->balance;
    }

    /**
     * @param string $balance
     */
    public function setBalance(string $balance): void {
        $this->balance = $balance;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void {
        $this->status = $status;
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