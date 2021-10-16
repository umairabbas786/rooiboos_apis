<?php


class WithdrawFeeEntity {
    const ID = "withdraw-fee";
    const TABLE_NAME = "withdraw_fee";

    private string $id;
    private string $withdrawFee;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $withdrawFee
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $withdrawFee, string $createdAt, string $updatedAt) {
        $this->id = WithdrawFeeEntity::ID;
        $this->withdrawFee = $withdrawFee;
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
    public function getWithdrawFee(): string {
        return $this->withdrawFee;
    }

    /**
     * @param string $withdrawFee
     */
    public function setWithdrawFee(string $withdrawFee): void {
        $this->withdrawFee = $withdrawFee;
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