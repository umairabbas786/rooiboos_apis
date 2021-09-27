<?php

class FreeDistanceEntity {
    const TABLE_NAME = "free_distance";

    private float $distanceInMeters;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param float $distanceInMeters
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(float $distanceInMeters, string $createdAt, string $updatedAt) {
        $this->distanceInMeters = $distanceInMeters;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public static function getId(): string {
        return "FREE_DISTANCE";
    }

    /**
     * @return float
     */
    public function getDistanceInMeters(): float {
        return $this->distanceInMeters;
    }

    /**
     * @param float $distanceInMeters
     */
    public function setDistanceInMeters(float $distanceInMeters): void {
        $this->distanceInMeters = $distanceInMeters;
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