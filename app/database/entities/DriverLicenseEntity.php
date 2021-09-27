<?php


class DriverLicenseEntity {
    const TABLE_NAME = "driver_license_docs";

    private string $id;
    private string $driverId;
    private string $licenseFront;
    private string $licenseBack;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $driverId
     * @param string $licenseFront
     * @param string $licenseBack
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $driverId, string $licenseFront, string $licenseBack, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->driverId = $driverId;
        $this->licenseFront = $licenseFront;
        $this->licenseBack = $licenseBack;
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
    public function getLicenseFront(): string {
        return $this->licenseFront;
    }

    /**
     * @param string $licenseFront
     */
    public function setLicenseFront(string $licenseFront): void {
        $this->licenseFront = $licenseFront;
    }

    /**
     * @return string
     */
    public function getLicenseBack(): string {
        return $this->licenseBack;
    }

    /**
     * @param string $licenseBack
     */
    public function setLicenseBack(string $licenseBack): void {
        $this->licenseBack = $licenseBack;
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