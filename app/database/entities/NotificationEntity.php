<?php


class NotificationEntity {
    const TABLE_NAME = "notification";

    private string $id;
    private string $customerId;
    private string $msg;
    private string $state;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $customerId
     * @param string $msg
     * @param string $state
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $customerId, string $msg, string $state, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->msg = $msg;
        $this->state = $state;
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
    public function getMsg(): string {
        return $this->msg;
    }

    /**
     * @param string $msg
     */
    public function setMsg(string $msg): void {
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function getState(): string {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void {
        $this->state = $state;
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