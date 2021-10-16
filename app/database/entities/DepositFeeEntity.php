<?php


class DepositFeeEntity {
    const ID = "deposit-fee";
    const TABLE_NAME = "deposit_fee";

    private string $id;
    private string $depositFee;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $depositFee
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $depositFee, string $createdAt, string $updatedAt) {
        $this->id = DepositFeeEntity::ID;
        $this->depositFee = $depositFee;
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
    public function getDepositFee(): string {
        return $this->depositFee;
    }

    /**
     * @param string $depositFee
     */
    public function setDepositFee(string $depositFee): void {
        $this->depositFee = $depositFee;
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