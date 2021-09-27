<?php


class Cab5Response {
    const RESPONSE_STATE_OK = "OK";
    const RESPONSE_STATE_UNAUTHORIZED = "UNAUTHORIZED";
    const RESPONSE_STATE_COMPROMISED = "COMPROMISED";
    const RESPONSE_STATE_BAD_REQUEST = "BAD_REQUEST";
    const RESPONSE_STATE_GONE = "GONE";
    const RESPONSE_STATE_FAILURE = "FAILURE";

    private string $cab_5_response_state;
    private array $data;

    private function __construct() { }

    public function setResponseState(string $responseState): Cab5Response {
        $this->cab_5_response_state = $responseState;
        return $this;
    }

    public function setResponseData(array $data): Cab5Response {
        $this->data = $data;
        return $this;
    }

    public function send(bool $kill = true) {
        $response = array();

        if (isset($this->cab_5_response_state)) {
            $response["cab_5_response_state"] = $this->cab_5_response_state;
        }


        if (isset($this->data)) {
            $response["data"] = $this->data;
        }

        $response = json_encode($response);

        if ($kill) die($response);
        echo $response;
    }

    public static function mapAuthTokenToData(&$data, string $abracadabra, string $authorizationToken) {
        $data['authorization_token'] = [
            "abracadabra" => $abracadabra,
            "token" => $authorizationToken
        ];
    }

    public static function mapExceptionsToData(&$data, array $exceptions) {
        $data['exceptions'] = $exceptions;
    }

    public static function createDataWithExceptions(array $exceptions): array {
        $data = [];
        self::mapExceptionsToData($data, $exceptions);
        return $data;
    }

    public static function prepare(): Cab5Response {
        return new Cab5Response();
    }
}