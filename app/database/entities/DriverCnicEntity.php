<?php


class DriverCnicEntity {
    const TABLE_NAME = "driver_cnic_docs";

    private string $id;
    private string $driverId;
    private string $cnicFront;
    private string $cnicBack;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $driverId
     * @param string $cnicFront
     * @param string $cnicBack
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $driverId, string $cnicFront, string $cnicBack, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->driverId = $driverId;
        $this->cnicFront = $cnicFront;
        $this->cnicBack = $cnicBack;
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
    public function getCnicFront(): string {
        return $this->cnicFront;
    }

    /**
     * @param string $cnicFront
     */
    public function setCnicFront(string $cnicFront): void {
        $this->cnicFront = $cnicFront;
    }

    /**
     * @return string
     */
    public function getCnicBack(): string {
        return $this->cnicBack;
    }

    /**
     * @param string $cnicBack
     */
    public function setCnicBack(string $cnicBack): void {
        $this->cnicBack = $cnicBack;
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