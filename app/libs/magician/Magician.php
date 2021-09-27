<?php

use MiladRahimi\PhpCrypt\Symmetric;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;

class Magician {
    private const SECRET = 'ElevenDoneOneTwoMany';

    /**
     * @var int
     */
    private int $abracadabra_length = 15;

    /**
     * @param string $payload <p> What you want to encrypt </p>
     * @return MagicianPayload <p>
     * MagicianPayload contains an abracadabra and encrypted_payload
     * You need to save the abracadabra somewhere, it is required for re-validation </p>
     */
    function encrypt(string $payload): MagicianPayload {
        $abracadabra = $this->generate_abracadabra();
        $symmetric = new Symmetric(self::SECRET . $abracadabra);
        try {
           $encrypted = $symmetric->encrypt($payload);
        } catch (EncryptionException $e) {
            die("Failure while encrypting using magician.");
        }
        return new MagicianPayload($encrypted, $abracadabra);
    }

    /**
     * @return string
     */
    private function generate_abracadabra(): string {
        return bin2hex(openssl_random_pseudo_bytes($this->abracadabra_length));
    }

    /**
     * @param MagicianPayload $magicianPayload
     * @return string
     */
    function decrypt(MagicianPayload $magicianPayload): string {
        $symmetric = new Symmetric(self::SECRET . $magicianPayload->getAbracadabra());
        try {
            $decrypted = $symmetric->decrypt($magicianPayload->getEncryptedPayload());
        } catch (\MiladRahimi\PhpCrypt\Exceptions\DecryptionException $e) {
            return "";
        }
        return $decrypted;
    }

    /**
     * @param string $payload <p>Unencrypted Payload</p>
     * @param MagicianPayload $magicianPayload <p>Same One which was returned to your when you encrypted your payload.</p>
     * @return bool <p> true if valid else false </p>
     */
    function is_valid(string $payload, MagicianPayload $magicianPayload): bool {
        return $this->decrypt($magicianPayload) === $payload;
    }
}
