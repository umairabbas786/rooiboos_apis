<?php


class DriverVehicleNumberPlateEntity {
    const TABLE_NAME = "driver_vehicle_number_plates";

    private string $id;
    private string $driverId;
    private string $numberPlate;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $driverId
     * @param string $numberPlate
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $driverId, string $numberPlate, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->driverId = $driverId;
        $this->numberPlate = $numberPlate;
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
    public function getNumberPlate(): string {
        return $this->numberPlate;
    }

    /**
     * @param string $numberPlate
     */
    public function setNumberPlate(string $numberPlate): void {
        $this->numberPlate = $numberPlate;
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