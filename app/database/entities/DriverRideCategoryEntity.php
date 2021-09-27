<?php


class DriverRideCategoryEntity {
    const TABLE_NAME = "drivers_ride_categories";

    private string $id;
    private string $driverId;
    private string $rideCategoryId;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $driverId
     * @param string $rideCategoryId
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $driverId, string $rideCategoryId, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->driverId = $driverId;
        $this->rideCategoryId = $rideCategoryId;
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
    public function getRideCategoryId(): string {
        return $this->rideCategoryId;
    }

    /**
     * @param string $rideCategoryId
     */
    public function setRideCategoryId(string $rideCategoryId): void {
        $this->rideCategoryId = $rideCategoryId;
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