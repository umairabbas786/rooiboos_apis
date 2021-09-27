<?php


class ScheduleRideEntity {
    const TABLE_NAME = "schedule_rides";

    private string $id;
    private string $passengerId;
    private float $pickupLongitude;
    private float $pickupLatitude;
    private string $pickupLocationName;
    private string $scheduleAt;
    private bool $scheduled;
    private string $ride_category_id;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $passengerId
     * @param float $pickupLongitude
     * @param float $pickupLatitude
     * @param string $pickupLocationName
     * @param string $scheduleAt
     * @param bool $scheduled
     * @param string $ride_category_id
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $passengerId, float $pickupLongitude, float $pickupLatitude, string $pickupLocationName, string $scheduleAt, bool $scheduled, string $ride_category_id, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->passengerId = $passengerId;
        $this->pickupLongitude = $pickupLongitude;
        $this->pickupLatitude = $pickupLatitude;
        $this->pickupLocationName = $pickupLocationName;
        $this->scheduleAt = $scheduleAt;
        $this->scheduled = $scheduled;
        $this->ride_category_id = $ride_category_id;
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
     * @return float
     */
    public function getPickupLongitude(): float {
        return $this->pickupLongitude;
    }

    /**
     * @param float $pickupLongitude
     */
    public function setPickupLongitude(float $pickupLongitude): void {
        $this->pickupLongitude = $pickupLongitude;
    }

    /**
     * @return float
     */
    public function getPickupLatitude(): float {
        return $this->pickupLatitude;
    }

    /**
     * @param float $pickupLatitude
     */
    public function setPickupLatitude(float $pickupLatitude): void {
        $this->pickupLatitude = $pickupLatitude;
    }

    /**
     * @return string
     */
    public function getPickupLocationName(): string {
        return $this->pickupLocationName;
    }

    /**
     * @param string $pickupLocationName
     */
    public function setPickupLocationName(string $pickupLocationName): void {
        $this->pickupLocationName = $pickupLocationName;
    }

    /**
     * @return string
     */
    public function getScheduleAt(): string {
        return $this->scheduleAt;
    }

    /**
     * @param string $scheduleAt
     */
    public function setScheduleAt(string $scheduleAt): void {
        $this->scheduleAt = $scheduleAt;
    }

    /**
     * @return bool
     */
    public function isScheduled(): bool {
        return $this->scheduled;
    }

    /**
     * @param bool $scheduled
     */
    public function setScheduled(bool $scheduled): void {
        $this->scheduled = $scheduled;
    }

    /**
     * @return string
     */
    public function getRideCategoryId(): string {
        return $this->ride_category_id;
    }

    /**
     * @param string $ride_category_id
     */
    public function setRideCategoryId(string $ride_category_id): void {
        $this->ride_category_id = $ride_category_id;
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