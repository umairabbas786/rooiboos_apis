<?php


class DepositHistoryEntity {
    const TABLE_NAME = "deposit_history";

    private string $id;
    private string $customerId;
    private string $currencyId;
    private string $balance;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $customerId
     * @param string $currencyId
     * @param string $balance
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $customerId, string $currencyId, string $balance, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->currencyId = $currencyId;
        $this->balance = $balance;
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