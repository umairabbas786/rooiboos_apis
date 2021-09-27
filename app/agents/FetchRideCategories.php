<?php


class FetchRideCategories extends Cab5Api {

    const WHICH_ONES = "which_ones";

    const ALL= "ALL";
    const ENABLED= "ENABLED";
    const DISABLED = "DISABLED";

    /** @var array */
    private array $rideCategories;

    protected function onAssemble() {
        if (!isset($_POST[self::WHICH_ONES])) {
            $this->killAsBadRequestWithMissingParamException(self::WHICH_ONES);
        }

        switch ($_POST[self::WHICH_ONES]) {
            case self::ALL:
                $this->rideCategories = $this->getCab5db()->getRideCategoryDao()->getAllRideCategories();
                break;
            case self::ENABLED:
                $this->rideCategories = $this->getCab5db()->getRideCategoryDao()->getAllEnabledRideCategories();
                break;
            case self::DISABLED:
                $this->rideCategories = $this->getCab5db()->getRideCategoryDao()->getAllDisabledRideCategories();
                break;
            default:
                $this->killAsBadRequestWithInvalidValueForParam(self::WHICH_ONES);
        }
    }

    protected function onDevise() {
        $response = [];

        /** @var RideCategoryEntity $category */
        foreach ($this->rideCategories as $category) {
            array_push($response, [
                RideCategoryTableSchema::ID => $category->getId(),
                RideCategoryTableSchema::NAME => $category->getName(),
                RideCategoryTableSchema::ENABLED => $category->isEnabled(),
                RideCategoryTableSchema::IMAGE => $this->createLinkForRideCategoryImage($category->getImage()),
                RideCategoryTableSchema::PRICE => $category->getPrice(),
                RideCategoryTableSchema::PER_KM_COST => $category->getPerKmCost(),
                RideCategoryTableSchema::CREATED_AT => $category->getCreatedAt(),
                RideCategoryTableSchema::UPDATED_AT => $category->getUpdatedAt()
            ]);
        }

        $this->resSendOK([
            "categories" => $response
        ]);
    }
}