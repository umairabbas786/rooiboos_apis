<?php


class ProfilePictureEntity {
    const TABLE_NAME = "profile_picture";

    private string $id;
    private string $customerId;
    private string $picture;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $customerId
     * @param string $picture
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $customerId, string $picture, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->picture = $picture;
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
    public function getPicture(): string {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture): void {
        $this->picture = $picture;
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