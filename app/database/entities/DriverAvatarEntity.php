<?php


class DriverAvatarEntity {
    const TABLE_NAME = "drivers_avatars";

    private string $id;
    private string $driverId;
    private string $avatar;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $driverId
     * @param string $avatar
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $driverId, string $avatar, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->driverId = $driverId;
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
    public function getDriverId(): string {
        return $this->driverId;
    }

    /**
     * @param string $driverId
     */
    public function setDriverId(string $driverId): void {
        $this->driverId = $driverId;
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