<?php

use paragraph1\phpFCM\Client as FcmClient;
use GuzzleHttp\Client as GuzzleHttpClient;

abstract class Cab5Api {
    use Environment;

    const FCM_SERVER_API_KEY = "AAAAtUi6-F4:APA91bF3PRdNglsvFr_D_sQAWlMJcdWDjo038wusEGiUF1S4MzqYTLaIljyPyqe42ey41FXitJLeyYx-2znG21I_93_byZ6XUDbQ_1VVT5L95vMjSOli83-poLf3YdkHDt6RT6rfRNUq";

    const __ABRACADABRA__ = "__abracadabra__";
    const __AUTHORIZATION_TOKEN__ = "__authorization_token__";
    const __PASSENGER_ID__ = "__passenger_id__";
    const __DRIVER_ID__ = "__driver_id__";

    private Cab5DB $cab5db;
    private Magician $magician;

    public function __construct() {
        date_default_timezone_set("Asia/Karachi");
        header('Access-Control-Allow-Origin: *'); // To Allow xmlHttpRequests
        header('Access-Control-Allow-Methods: *'); // To Allow xmlHttpRequests
        header('Access-Control-Allow-Headers: *'); // To Allow xmlHttpRequests
        header('Content-type:application/json; charset=utf-8');
        $this->cab5db = new Cab5DB();
        $this->magician = new Magician();
    }

    /**
     * @return Cab5DB
     */
    public function getCab5db(): Cab5DB {
        return $this->cab5db;
    }

    /** @return Magician */
    public function getMagician(): Magician {
        return $this->magician;
    }

    /**
     * @return FcmClient
     */
    public function getFcmClient(): FcmClient {
        $fcmClient = new FcmClient();
        $fcmClient->setApiKey(self::FCM_SERVER_API_KEY);
        $fcmClient->injectHttpClient(new GuzzleHttpClient());
        return $fcmClient;
    }

    public function killAsUnAuthorizedRequest() {
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_UNAUTHORIZED)->send();
    }

    public function killAsGoneRequest(array $exceptions) {
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_GONE)
            ->setResponseData(Cab5Response::createDataWithExceptions($exceptions))
            ->send();
    }

    public function killAsCompromised(array $exceptions) {
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_COMPROMISED)
            ->setResponseData(Cab5Response::createDataWithExceptions($exceptions))
            ->send();
    }

    public function killAsFailure(array $exceptions) {
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_FAILURE)
            ->setResponseData(Cab5Response::createDataWithExceptions($exceptions))
            ->send();
    }

    public function resSendOK(array $data, bool $kill = true) {
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_OK)
            ->setResponseData($data)
            ->send($kill);
    }

    /**
     * @param string $token -> Token of Passenger or Driver
     * @param array $data -> Data which will be sent
     * @param bool $kill -> sends data with die if true else with echo
     */
    public function resSendOkWithAuthorizationToken(string $token, array $data, bool $kill = true) {
        $magicianPayload = $this->getMagician()->encrypt($token);
        Cab5Response::mapAuthTokenToData(
            $data,
            $magicianPayload->getAbracadabra(),
            $magicianPayload->getEncryptedPayload()
        );
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_OK)
            ->setResponseData($data)
            ->send($kill);
    }

    public function killAsBadRequest() {
        Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_BAD_REQUEST)->send();
    }

    public function killAsBadRequestWithInvalidValueForParam(string $param) {
        $cab5Response = Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_BAD_REQUEST);

        if (Manifest::DEBUG_MODE) {
            $cab5Response = $cab5Response->setResponseData(Cab5Response::createDataWithExceptions([
                'invalid_value_of_param' => $param
            ]));
        }

        $cab5Response->send();
    }

    public function killAsBadRequestWithMissingParamException(string $param) {
        $cab5Response = Cab5Response::prepare()->setResponseState(Cab5Response::RESPONSE_STATE_BAD_REQUEST);

        if (Manifest::DEBUG_MODE) {
            $cab5Response = $cab5Response->setResponseData(Cab5Response::createDataWithExceptions([
                'missing_param' => $param
            ]));
        }

        $cab5Response->send();
    }

    public function handlePassengerTokenAuthorization(): PassengerEntity {
        if (!isset($_POST[self::__PASSENGER_ID__])) {
            $this->killAsBadRequestWithMissingParamException(self::__PASSENGER_ID__);
        }

        if (!Manifest::AUTH_TOKEN_VALIDATION_ENABLED) {
            $passengerEntity =  $this->cab5db->getPassengerDao()->getPassengerWithId($_POST[self::__PASSENGER_ID__]);
            if ($passengerEntity === null) {
                $this->killAsGoneRequest([
                    'no_passenger_found' => true
                ]);
            }
            return $passengerEntity;
        }

        if (!isset($_POST[self::__ABRACADABRA__])) {
            $this->killAsBadRequestWithMissingParamException(self::__ABRACADABRA__);
        }

        if (!isset($_POST[self::__AUTHORIZATION_TOKEN__])) {
            $this->killAsBadRequestWithMissingParamException(self::__AUTHORIZATION_TOKEN__);
        }

        $passengerEntity = $this->cab5db->getPassengerDao()->getPassengerWithId($_POST[self::__PASSENGER_ID__]);

        if ($passengerEntity === null) {
            $this->killAsGoneRequest([
                'no_passenger_found' => true
            ]);
        }

        $isValid = $this->getMagician()->is_valid(
            $passengerEntity->getToken(),
            new MagicianPayload($_POST[self::__AUTHORIZATION_TOKEN__], $_POST[self::__ABRACADABRA__])
        );

        if (!$isValid) $this->killAsUnAuthorizedRequest();
        return $passengerEntity;
    }

    public function handleDriverTokenAuthorization(): DriverEntity {
        if (!isset($_POST[self::__DRIVER_ID__])) {
            $this->killAsBadRequestWithMissingParamException(self::__DRIVER_ID__);
        }

        if (!Manifest::AUTH_TOKEN_VALIDATION_ENABLED) {
            $driverEntity = $this->cab5db->getDriverDao()->getDriverWithId($_POST[self::__DRIVER_ID__]);
            if ($driverEntity === null) {
                $this->killAsGoneRequest([
                    'no_driver_found' => true
                ]);
            }
            return $driverEntity;
        }

        if (!isset($_POST[self::__ABRACADABRA__])) {
            $this->killAsBadRequestWithMissingParamException(self::__ABRACADABRA__);
        }

        if (!isset($_POST[self::__AUTHORIZATION_TOKEN__])) {
            $this->killAsBadRequestWithMissingParamException(self::__AUTHORIZATION_TOKEN__);
        }

        $driverEntity = $this->cab5db->getDriverDao()->getDriverWithId($_POST[self::__DRIVER_ID__]);

        if ($driverEntity === null) {
            $this->killAsGoneRequest([
                'no_driver_found' => true
            ]);
        }

        $isValid = $this->getMagician()->is_valid(
            $driverEntity->getToken(),
            new MagicianPayload($_POST[self::__AUTHORIZATION_TOKEN__], $_POST[self::__ABRACADABRA__])
        );

        if (!$isValid) $this->killAsUnAuthorizedRequest();
        return $driverEntity;
    }

    protected function onTokenAuthorization() {}
    protected function onAssemble() {}
    abstract protected function onDevise();

    public function launch() {
        $this->onTokenAuthorization();
        $this->onAssemble();
        $this->onDevise();
        $this->cab5db->closeConnection();
    }
}
