<?php


class PassengerAvatarEntity{
    const TABLE_NAME = "passengers_avatars";

    private string $id;
    private string $passengerId;
    private string $avatar;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $passengerId
     * @param string $avatar
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $passengerId, string $avatar, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->passengerId = $passengerId;
        $this->avatar = $avatar;
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
    public function getPassengerId(): string {
        return $this->passengerId;
    }

    /**
     * @param string $passengerId
     */
    public function setPassengerId(string $passengerId): void {
        $this->passengerId = $passengerId;
    }

    /**
     * @return string
     */
    public function getAvatar(): string {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void {
        $this->avatar = $avatar;
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