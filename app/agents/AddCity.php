<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class AddCity extends Cab5Api {

    const CITY_NAME = "city_name";
    const ENABLED = "enabled";

    const Y = "Y";
    const N = "N";

    protected function onAssemble() {
        if (!isset($_POST[self::CITY_NAME])) {
            $this->killAsBadRequestWithMissingParamException(self::CITY_NAME);
        }
        if (!isset($_POST[self::ENABLED])) {
            $this->killAsBadRequestWithMissingParamException(self::ENABLED);
        }
        if (!in_array($_POST[self::ENABLED], [self::Y, self::N])) {
            $this->killAsBadRequestWithInvalidValueForParam(self::ENABLED);
        }
    }

    protected function onDevise() {
        if ($this->getCab5db()->getCityDao()->getCityWithName($_POST[self::CITY_NAME]) !== null) {
            $this->killAsFailure([
                "city_already_exist" => true
            ]);
        }

        $createTime = Carbon::now();

        $cityEntity = $this->getCab5db()->getCityDao()->insertCity(new CityEntity(
            Uuid::uuid4()->toString(),
            $_POST[self::CITY_NAME],
            $createTime,
            $createTime,
            $_POST[self::ENABLED] === self::Y
        ));

        if ($cityEntity === null) {
            $this->killAsFailure([
                'failed_to_insert_city_in_db' => true
            ]);
        }

        $this->resSendOK([
            'city' => [
                CityTableSchema::ID => $cityEntity->getId(),
                CityTableSchema::NAME => $cityEntity->getName(),
                CityTableSchema::ENABLED => $cityEntity->isEnabled(),
                CityTableSchema::CREATED_AT => $cityEntity->getCreatedAt(),
                CityTableSchema::UPDATED_AT => $cityEntity->getUpdatedAt()
            ]
        ]);
    }
}