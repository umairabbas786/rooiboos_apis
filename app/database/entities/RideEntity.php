<?php


class RideEntity {
    const TABLE_NAME = "rides";

    private string $id;
    private string $passengerId;
    private string $driverId;
    private float $pickupLongitude;
    private float $pickupLatitude;
    private string $pickupLocationName;
    private string $state;
    private ?float $metersTravelled;
    private ?float $exitLongitude;
    private ?float $exitLatitude;
    private ?string $exitLocationName;
    private string $ride_category_id;
    private ?float $bill;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $passengerId
     * @param string $driverId
     * @param float $pickupLongitude
     * @param float $pickupLatitude
     * @param string $pickupLocationName
     * @param string $state
     * @param float|null $metersTravelled
     * @param float|null $exitLongitude
     * @param float|null $exitLatitude
     * @param string|null $exitLocationName
     * @param string $ride_category_id
     * @param float|null $bill
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $passengerId, string $driverId, float $pickupLongitude, float $pickupLatitude, string $pickupLocationName, string $state, ?float $metersTravelled, ?float $exitLongitude, ?float $exitLatitude, ?string $exitLocationName, string $ride_category_id, ?float $bill, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->passengerId = $passengerId;
        $this->driverId = $driverId;
        $this->pickupLongitude = $pickupLongitude;
        $this->pickupLatitude = $pickupLatitude;
        $this->pickupLocationName = $pickupLocationName;
        $this->state = $state;
        $this->metersTravelled = $metersTravelled;
        $this->exitLongitude = $exitLongitude;
        $this->exitLatitude = $exitLatitude;
        $this->exitLocationName = $exitLocationName;
        $this->ride_category_id = $ride_category_id;
        $this->bill = $bill;
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
     * @return float|null
     */
    public function getMetersTravelled(): ?float {
        return $this->metersTravelled;
    }

    /**
     * @param float|null $metersTravelled
     */
    public function setMetersTravelled(?float $metersTravelled): void {
        $this->metersTravelled = $metersTravelled;
    }

    /**
     * @return float|null
     */
    public function getExitLongitude(): ?float {
        return $this->exitLongitude;
    }

    /**
     * @param float|null $exitLongitude
     */
    public function setExitLongitude(?float $exitLongitude): void {
        $this->exitLongitude = $exitLongitude;
    }

    /**
     * @return float|null
     */
    public function getExitLatitude(): ?float {
        return $this->exitLatitude;
    }

    /**
     * @param float|null $exitLatitude
     */
    public function setExitLatitude(?float $exitLatitude): void {
        $this->exitLatitude = $exitLatitude;
    }

    /**
     * @return string|null
     */
    public function getExitLocationName(): ?string {
        return $this->exitLocationName;
    }

    /**
     * @param ?string $exitLocationName
     */
    public function setExitLocationName(?string $exitLocationName): void {
        $this->exitLocationName = $exitLocationName;
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
     * @return float|null
     */
    public function getBill(): ?float {
        return $this->bill;
    }

    /**
     * @param float|null $bill
     */
    public function setBill(?float $bill): void {
        $this->bill = $bill;
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