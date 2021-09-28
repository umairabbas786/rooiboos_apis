<?php

use paragraph1\phpFCM\Client as FcmClient;
use GuzzleHttp\Client as GuzzleHttpClient;

abstract class RooiBoosApi {
    use Environment;

    const FCM_SERVER_API_KEY = "";

    private RooiBoosDB $rooiBoosDB;

    public function __construct() {
        date_default_timezone_set("Asia/Karachi");
        header('Access-Control-Allow-Origin: *'); // To Allow xmlHttpRequests
        header('Access-Control-Allow-Methods: *'); // To Allow xmlHttpRequests
        header('Access-Control-Allow-Headers: *'); // To Allow xmlHttpRequests
        header('Content-type:application/json; charset=utf-8');
        $this->rooiBoosDB = new RooiBoosDB();
    }

    public function getRooiBoosDB(): RooiBoosDB {
        return $this->rooiBoosDB;
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

    public function killAsFailure(array $exceptions) {
        RooiBoosResponse::prepare()->setResponseState(RooiBoosResponse::RESPONSE_STATE_FAILURE)
            ->setResponseData(RooiBoosResponse::createDataWithExceptions($exceptions))
            ->send();
    }

    public function resSendOK(array $data, bool $kill = true) {
        RooiBoosResponse::prepare()->setResponseState(RooiBoosResponse::RESPONSE_STATE_OK)
            ->setResponseData($data)
            ->send($kill);
    }

    public function killAsBadRequest() {
        RooiBoosResponse::prepare()->setResponseState(RooiBoosResponse::RESPONSE_STATE_BAD_REQUEST)->send();
    }

    public function killAsBadRequestWithInvalidValueForParam(string $param) {
        $RooiBoosResponse = RooiBoosResponse::prepare()->setResponseState(RooiBoosResponse::RESPONSE_STATE_BAD_REQUEST);

        if (Manifest::DEBUG_MODE) {
            $RooiBoosResponse = $RooiBoosResponse->setResponseData(RooiBoosResponse::createDataWithExceptions([
                'invalid_value_of_param' => $param
            ]));
        }

        $RooiBoosResponse->send();
    }

    public function killAsBadRequestWithMissingParamException(string $param) {
        $RooiBoosResponse = RooiBoosResponse::prepare()->setResponseState(RooiBoosResponse::RESPONSE_STATE_BAD_REQUEST);

        if (Manifest::DEBUG_MODE) {
            $RooiBoosResponse = $RooiBoosResponse->setResponseData(RooiBoosResponse::createDataWithExceptions([
                'missing_param' => $param
            ]));
        }

        $RooiBoosResponse->send();
    }

    protected function onAssemble() {}
    abstract protected function onDevise();

    public function launch() {
        $this->onAssemble();
        $this->onDevise();
        $this->rooiBoosDB->closeConnection();
    }
}
