<?php


class CurrencyChargesEntity {
    const TABLE_NAME = "currency_charges";

    private string $id;
    private string $from;
    private string $to;
    private string $rate;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $from
     * @param string $to
     * @param string $rate
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $from, string $to, string $rate, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->from = $from;
        $this->to = $to;
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
    public function getFrom(): string {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void {
        $this->to = $to;
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