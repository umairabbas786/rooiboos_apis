<?php


class CustomerEntity {
    const TABLE_NAME = "customers";

    private string $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phoneNumber;
    private bool $phoneVerified;
    private string $password;
    private string $cnicFront;
    private string $cnicBack;
    private string $country;
    private string $accountHolderName;
    private string $accountNumber;
    private string $ibanAccountNumber;
    private string $accountType;
    private bool $status;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $phoneNumber
     * @param bool $phoneVerified
     * @param string $password
     * @param string $cnicFront
     * @param string $cnicBack
     * @param string $country
     * @param string $accountHolderName
     * @param string $accountNumber
     * @param string $ibanAccountNumber
     * @param string $accountType
     * @param bool $status
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(string $id, string $firstName, string $lastName, string $email, string $phoneNumber, bool $phoneVerified, string $password, string $cnicFront, string $cnicBack, string $country, string $accountHolderName, string $accountNumber, string $ibanAccountNumber, string $accountType, bool $status, string $createdAt, string $updatedAt) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->phoneVerified = $phoneVerified;
        $this->password = $password;
        $this->cnicFront = $cnicFront;
        $this->cnicBack = $cnicBack;
        $this->country = $country;
        $this->accountHolderName = $accountHolderName;
        $this->accountNumber = $accountNumber;
        $this->ibanAccountNumber = $ibanAccountNumber;
        $this->accountType = $accountType;
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
    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return bool
     */
    public function isPhoneVerified(): bool {
        return $this->phoneVerified;
    }

    /**
     * @param bool $phoneVerified
     */
    public function setPhoneVerified(bool $phoneVerified): void {
        $this->phoneVerified = $phoneVerified;
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
     * @return string
     */
    public function getAccountHolderName(): string {
        return $this->accountHolderName;
    }

    /**
     * @param string $accountHolderName
     */
    public function setAccountHolderName(string $accountHolderName): void {
        $this->accountHolderName = $accountHolderName;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string {
        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     */
    public function setAccountNumber(string $accountNumber): void {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function getIbanAccountNumber(): string {
        return $this->ibanAccountNumber;
    }

    /**
     * @param string $ibanAccountNumber
     */
    public function setIbanAccountNumber(string $ibanAccountNumber): void {
        $this->ibanAccountNumber = $ibanAccountNumber;
    }

    /**
     * @return string
     */
    public function getAccountType(): string {
        return $this->accountType;
    }

    /**
     * @param string $accountType
     */
    public function setAccountType(string $accountType): void {
        $this->accountType = $accountType;
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