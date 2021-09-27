<?php


class FetchPassengers extends Cab5Api {

    /** @var array */
    private array $passengers;

    protected function onAssemble() {
        $this->passengers = $this->getCab5db()->getPassengerDao()->getAllPassengers();
    }

    protected function onDevise() {
        $response = [];

        /** @var PassengerEntity $passenger*/
        foreach ($this->passengers as $passenger) {
            $avatar = $this->getCab5db()->getPassengerAvatarDao()->getAvatarOfPassenger($passenger->getId());

            $data = [
                PassengerTableSchema::ID => $passenger->getId(),
                PassengerTableSchema::FIRST_NAME => $passenger->getFirstName(),
                PassengerTableSchema::LAST_NAME => $passenger->getLastName(),
                PassengerTableSchema::EMAIL => $passenger->getEmail(),
                PassengerTableSchema::PHONE => $passenger->getPhone(),
                PassengerTableSchema::BLOCKED => $passenger->isBlocked(),
                PassengerTableSchema::CREATED_AT => $passenger->getCreatedAt(),
                PassengerAvatarTableSchema::AVATAR => $this->createLinkForPassengerAvatarImage($avatar->getAvatar())
            ];

            $magicianPayload = $this->getMagician()->encrypt($passenger->getToken());

            Cab5Response::mapAuthTokenToData(
                $data,
                $magicianPayload->getAbracadabra(),
                $magicianPayload->getEncryptedPayload()
            );

            array_push($response, $data);
        }

        $this->resSendOK([
            "passengers" => $response
        ]);
    }
}