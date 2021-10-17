<?php


class BankEntity {
    const TABLE_NAME = "banks";

    private string $id;
    private string $name;
    private string $city;
    private string $country;
    private bool $status;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $name
     * @param string $city
     * @param string $country
     * @param bool $status
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $name, string $city, string $country, bool $status, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->country = $country;
        $this->status = $status;
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
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void {
        $this->country = $country;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void {
        $this->status = $status;
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