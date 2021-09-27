<?php


class RideCategoryEntity {
    const TABLE_NAME = "ride_categories";

    private string $id;
    private string $name;
    private bool $enabled;
    private string $image;
    private string $price;
    private int $per_km_cost;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $name
     * @param bool $enabled = false
     * @param string $image
     * @param string $price
     * @param int $per_km_cost
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $name, string $image, string $price, int $per_km_cost, string $createdAt, string $updatedAt, bool $enabled = false) {
        $this->id = $id;
        $this->name = $name;
        $this->enabled = $enabled;
        $this->image = $image;
        $this->price = $price;
        $this->per_km_cost = $per_km_cost;
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
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getImage(): string {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getPrice(): string {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getPerKmCost(): int {
        return $this->per_km_cost;
    }

    /**
     * @param int $per_km_cost
     */
    public function setPerKmCost(int $per_km_cost): void {
        $this->per_km_cost = $per_km_cost;
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