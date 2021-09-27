<?php


class FetchCities extends Cab5Api {

    const WHICH_ONES = "which_ones";

    const ALL= "ALL";
    const ENABLED= "ENABLED";
    const DISABLED = "DISABLED";

    /** @var array */
    private array $cities;

    protected function onAssemble() {
        if (!isset($_POST[self::WHICH_ONES])) {
            $this->killAsBadRequestWithMissingParamException(self::WHICH_ONES);
        }

        switch ($_POST[self::WHICH_ONES]) {
            case self::ALL:
                $this->cities = $this->getCab5db()->getCityDao()->getAllCities();
                break;
            case self::ENABLED:
                $this->cities = $this->getCab5db()->getCityDao()->getAllEnabledCities();
                break;
            case self::DISABLED:
                $this->cities = $this->getCab5db()->getCityDao()->getAllDisabledCities();
                break;
            default:
                $this->killAsBadRequestWithInvalidValueForParam(self::WHICH_ONES);
        }
    }

    protected function onDevise() {
        $response = [];

        /** @var CityEntity $city */
        foreach ($this->cities as $city) {
            array_push($response, [
                CityTableSchema::ID => $city->getId(),
                CityTableSchema::NAME => $city->getName(),
                CityTableSchema::ENABLED => $city->isEnabled(),
                CityTableSchema::CREATED_AT => $city->getCreatedAt(),
                CityTableSchema::UPDATED_AT => $city->getUpdatedAt()
            ]);
        }

        $this->resSendOK([
            "cities" => $response
        ]);
    }
}