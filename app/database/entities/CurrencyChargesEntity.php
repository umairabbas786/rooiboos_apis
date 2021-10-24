<?php


class CurrencyChargesEntity {
    const TABLE_NAME = "currency_charges";

    private string $id;
    private string $fromId;
    private string $toId;
    private string $rate;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $fromId
     * @param string $toId
     * @param string $rate
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $fromId, string $toId, string $rate, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->fromId = $fromId;
        $this->toId = $toId;
        $this->rate = $rate;
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
    public function getFromId(): string {
        return $this->fromId;
    }

    /**
     * @param string $fromId
     */
    public function setFromId(string $fromId): void {
        $this->fromId = $fromId;
    }

    /**
     * @return string
     */
    public function getToId(): string {
        return $this->toId;
    }

    /**
     * @param string $toId
     */
    public function setToId(string $toId): void {
        $this->toId = $toId;
    }

    /**
     * @return string
     */
    public function getRate(): string {
        return $this->rate;
    }

    /**
     * @param string $rate
     */
    public function setRate(string $rate): void {
        $this->rate = $rate;
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