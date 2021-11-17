<?php


class InviteEntity {
    const TABLE_NAME = "invite";

    private string $id;
    private string $customer_id;
    private string $code;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $customer_id
     * @param string $code
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $customer_id, string $code, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->code = $code;
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
        return $this->customer_id;
    }

    /**
     * @param string $customer_id
     */
    public function setCustomerId(string $customer_id): void {
        $this->customer_id = $customer_id;
    }

    /**
     * @return string
     */
    public function getCode(): string {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void {
        $this->code = $code;
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