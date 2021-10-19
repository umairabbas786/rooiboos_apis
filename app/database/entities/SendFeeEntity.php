<?php


class SendFeeEntity {
    const ID = "send-fee";
    const TABLE_NAME = "send_fee";

    private string $id;
    private string $sendFee;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $sendFee
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $sendFee, string $createdAt, string $updatedAt) {
        $this->id = SendFeeEntity::ID;
        $this->sendFee = $sendFee;
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
    public function getSendFee(): string {
        return $this->sendFee;
    }

    /**
     * @param string $sendFee
     */
    public function setSendFee(string $sendFee): void {
        $this->sendFee = $sendFee;
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