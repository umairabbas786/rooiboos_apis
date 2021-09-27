<?php

class MagicianPayload {

    /**
     * @var string
     */
    private string $encrypted_payload;

    /**
     * @var string
     */
    private string $abracadabra;

    /**
     * MagicianPayload constructor.
     * @param string $encrypted_payload
     * @param string $abracadabra
     */
    public function __construct(string $encrypted_payload, string $abracadabra) {
        $this->encrypted_payload = $encrypted_payload;
        $this->abracadabra = $abracadabra;
    }

    /**
     * @return string
     */
    public function getEncryptedPayload(): string {
        return $this->encrypted_payload;
    }

    /**
     * @return string
     */
    public function getAbracadabra(): string {
        return $this->abracadabra;
    }
}
