<?php

class Manifest {
    const AUTH_TOKEN_VALIDATION_ENABLED = false; // if false, All API's won't check for abracadabra and authorization_token
    const DEBUG_MODE = true; // if true, all bad requests will show the exception

    private const COMPOSER_VENDOR = [
        'dir_path' => '../',
        'vendor' => [
            'autoload'
        ]
    ];

    private const LIBS = [
        'dir_path' => './libs',
        'magician' => [
            MagicianPayload::class,
            Magician::class
        ],
        'query_builder' => [
            QueryType::class,
            Query::class,
            InsertQuery::class,
            WhereApplicableQuery::class,
            SelectQuery::class,
            UpdateQuery::class,
            DeleteQuery::class,
            QueryBuilder::class
        ],
        'auth_mailer_assistant' => [
            AuthMailerAssistant::class
        ],
        'db_libs' => [
            TableDao::class,
            TableSchema::class
        ]
    ];

    private const DATABASE = [
        'dir_path' => './database',
        'entities' => [
            CityEntity::class,
            DriverAvatarEntity::class,
            DriverCnicEntity::class,
            DriverEntity::class,
            DriverLicenseEntity::class,
            DriverRideCategoryEntity::class,
            DriverVehicleNumberPlateEntity::class,
            FreeDistanceEntity::class,
            PassengerAvatarEntity::class,
            PassengerEntity::class,
            RideCategoryEntity::class,
            RideEntity::class,
            ScheduleRideEntity::class
        ],
        'schema' => [
            CityTableSchema::class,
            DriverAvatarTableSchema::class,
            DriverCnicTableSchema::class,
            DriverLicenseTableSchema::class,
            DriverRideCategoryTableSchema::class,
            DriverTableSchema::class,
            DriverVehicleNumberPlateTableSchema::class,
            FreeDistanceTableSchema::class,
            PassengerAvatarTableSchema::class,
            PassengerTableSchema::class,
            RideCategoryTableSchema::class,
            RideTableSchema::class,
            ScheduleRidesTableSchema::class
        ],
        'factories' => [
            CityFactory::class,
            DriverAvatarFactory::class,
            DriverCnicFactory::class,
            DriverFactory::class,
            DriverLicenseFactory::class,
            DriverRideCategoryFactory::class,
            DriverVehicleNumberPlateFactory::class,
            FreeDistanceFactory::class,
            PassengerAvatarFactory::class,
            PassengerFactory::class,
            RideCategoryFactory::class,
            RideFactory::class,
            ScheduleRideFactory::class
        ],
        'dao' => [
            CityDao::class,
            DriverAvatarDao::class,
            DriverCnicDao::class,
            DriverDao::class,
            DriverLicenseDao::class,
            DriverRideCategoryDao::class,
            DriverVehicleNumberPlateDao::class,
            FreeDistanceDao::class,
            PassengerAvatarDao::class,
            PassengerDao::class,
            RideCategoryDao::class,
            RideDao::class,
            ScheduleRideDao::class
        ],
        'db' => [
            Cab5DB::class
        ]
    ];

    private const CORE = [
        'dir_path' => './',
        'core' => [
            Environment::class,
            Cab5Response::class,
            Cab5Api::class
        ]
    ];

    private const UTILS = [
        'dir_path' => './utils',
        'image_uploader' => [
            ImageUploader::class
        ]
    ];

    private const MODELS = [
        'dir_path' => './',
        'models' => [
            UserRole::class,
            RideState::class
        ]
    ];

    private const AGENTS = [
        'dir_path' => './',
        'agents' => [
            AcceptDriverRideNotification::class,
            AddCity::class,
            AddRideCategory::class,
            CancelCurrentRide::class,
            EndRide::class,
            FetchCities::class,
            FetchDriverRideNotification::class,
            FetchDrivers::class,
            FetchRideCategories::class,
            FetchPassengers::class,
            GetDriverRideStats::class,
            GetPassengerRideStats::class,
            LoginDriver::class,
            LoginPassenger::class,
            RegisterDriver::class,
            RegisterPassenger::class,
            RejectDriverRideNotification::class,
            SendRidesToDrivers::class,
            SetRideStateArrived::class,
            SetRideStateStarted::class,
            ToggleDriverRideCategory::class,
            ToggleDriverSeekingRides::class,
            UpdateDriverFcmToken::class,
            UpdateDriverLongitudeLatitude::class,
            UpdatePassengerFcmToken::class,
            UpdatePassengerLongitudeLatitude::class,
            UploadDriverCnic::class,
            UploadDriverLicense::class,
            UploadDriverVehicleNumberPlate::class,
            GetDriverRideHistory::class,
            GetPassengerRideHistory::class,
            GetPassengerWalletAmount::class,
            GetDriverWalletAmount::class,
            AddAmountToPassengerWallet::class,
            AddAmountToDriverWallet::class,
            SchedulePassengerRide::class,
            GetPassengerScheduledRides::class,
            ToggleDriverBlock::class,
            TogglePassengerBlock::class,
            ToggleCityEnableDisable::class,
            ToggleRideCategoryEnableDisable::class,
            GetAllTripsDetail::class,
            GetAllScheduledRides::class,
            UpdateCity::class,
            SendRidesOfScheduledRide::class,
            UpdateRideCategory::class,
            AddFreeKilometersToDrivers::class
        ]
    ];

    public static function getAppSystemRoot(): string {
        return substr(self::devisePath('../'), 0, -1);
    }

    public static function devisePath($path): string {
        $root_path = explode('/', __DIR__);

        if (substr($path, 0, 2) === './') {
            $path = substr($path, 2);
        } else {
            while (substr($path, 0, 3) === '../') {
                $path = substr($path, 3);
                array_pop($root_path);
            }
        }

        return implode('/', $root_path) . '/' . $path;
    }

    private function requireItems(array $package) {
        foreach ($package as $key => $value) {
            if ($key !== 'dir_path') {
                foreach ($value as $module) {
                    $dir_path = $package['dir_path'];
                    $path = $dir_path;
                    if ($dir_path !== './' && $dir_path !== '../') {
                        $path = $path . '/';
                    }
                    $path = $path . $key . '/' . $module . '.php';
                    require self::devisePath($path) . '';
                }
            }
        }
    }

    private function loadRequirements() {
        self::requireItems(self::COMPOSER_VENDOR);
        self::requireItems(self::LIBS);
        self::requireItems(self::DATABASE);
        self::requireItems(self::CORE);
        self::requireItems(self::UTILS);
        self::requireItems(self::MODELS);
        self::requireItems(self::AGENTS);
    }

    private function __construct() {
        $this->loadRequirements();
    }

    public static function create() {
        new Manifest();
    }
}

Manifest::create();
