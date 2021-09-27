<?php


class DriverEntity {
    const TABLE_NAME = "drivers";

    private string $id;
    private string $firstName;
    private string $lastName;
    private ?string $username;
    private string $email;
    private string $password;
    private string $abracadabra;
    private string $phone;
    private bool $verifiedEmail;
    private bool $verifiedPhone;
    private string $token;
    private bool $seekingRides;
    private string $cityId;
    private ?float $longitude;
    private ?float $latitude;
    private ?string $fcm_token;
    private string $sneakedAt;
    private float $totalMeters;
    private float $wallet;
    private bool $blocked;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string|null $username
     * @param string $email
     * @param string $password
     * @param string $abracadabra
     * @param string $phone
     * @param bool $verifiedEmail
     * @param bool $verifiedPhone
     * @param string $token
     * @param bool $seekingRides
     * @param string $cityId
     * @param float|null $longitude
     * @param float|null $latitude
     * @param string|null $fcm_token
     * @param string $sneakedAt
     * @param float $totalMeters
     * @param float $wallet
     * @param bool $blocked
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $firstName, string $lastName, ?string $username, string $email, string $password, string $abracadabra, string $phone, bool $verifiedEmail, bool $verifiedPhone, string $token, bool $seekingRides, string $cityId, ?float $longitude, ?float $latitude, ?string $fcm_token, string $sneakedAt, float $totalMeters, float $wallet, bool $blocked, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->abracadabra = $abracadabra;
        $this->phone = $phone;
        $this->verifiedEmail = $verifiedEmail;
        $this->verifiedPhone = $verifiedPhone;
        $this->token = $token;
        $this->seekingRides = $seekingRides;
        $this->cityId = $cityId;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->fcm_token = $fcm_token;
        $this->sneakedAt = $sneakedAt;
        $this->totalMeters = $totalMeters;
        $this->wallet = $wallet;
        $this->blocked = $blocked;
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
    public function getFirstName(): string {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getAbracadabra(): string {
        return $this->abracadabra;
    }

    /**
     * @param string $abracadabra
     */
    public function setAbracadabra(string $abracadabra): void {
        $this->abracadabra = $abracadabra;
    }

    /**
     * @return string
     */
    public function getPhone(): string {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    /**
     * @return bool
     */
    public function isVerifiedEmail(): bool {
        return $this->verifiedEmail;
    }

    /**
     * @param bool $verifiedEmail
     */
    public function setVerifiedEmail(bool $verifiedEmail): void {
        $this->verifiedEmail = $verifiedEmail;
    }

    /**
     * @return bool
     */
    public function isVerifiedPhone(): bool {
        return $this->verifiedPhone;
    }

    /**
     * @param bool $verifiedPhone
     */
    public function setVerifiedPhone(bool $verifiedPhone): void {
        $this->verifiedPhone = $verifiedPhone;
    }

    /**
     * @return string
     */
    public function getToken(): string {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void {
        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function isSeekingRides(): bool {
        return $this->seekingRides;
    }

    /**
     * @param bool $seekingRides
     */
    public function setSeekingRides(bool $seekingRides): void {
        $this->seekingRides = $seekingRides;
    }

    /**
     * @return string
     */
    public function getCityId(): string {
        return $this->cityId;
    }

    /**
     * @param string $cityId
     */
    public function setCityId(string $cityId): void {
        $this->cityId = $cityId;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void {
        $this->longitude = $longitude;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void {
        $this->latitude = $latitude;
    }

    /**
     * @return string|null
     */
    public function getFcmToken(): ?string {
        return $this->fcm_token;
    }

    /**
     * @param string|null $fcm_token
     */
    public function setFcmToken(?string $fcm_token): void {
        $this->fcm_token = $fcm_token;
    }

    /**
     * @return string
     */
    public function getSneakedAt(): string {
        return $this->sneakedAt;
    }

    /**
     * @param string $sneakedAt
     */
    public function setSneakedAt(string $sneakedAt): void {
        $this->sneakedAt = $sneakedAt;
    }

    /**
     * @return float
     */
    public function getTotalMeters(): float {
        return $this->totalMeters;
    }

    /**
     * @param float $totalMeters
     */
    public function setTotalMeters(float $totalMeters): void {
        $this->totalMeters = $totalMeters;
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
     * @return float
     */
    public function getWallet(): float {
        return $this->wallet;
    }

    /**
     * @param float $wallet
     */
    public function setWallet(float $wallet): void {
        $this->wallet = $wallet;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool {
        return $this->blocked;
    }

    /**
     * @param bool $blocked
     */
    public function setBlocked(bool $blocked): void {
        $this->blocked = $blocked;
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
