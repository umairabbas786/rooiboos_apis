<?php

class Manifest {
    const DEBUG_MODE = true; // if true, all bad requests will show the exception

    private const COMPOSER_VENDOR = [
        'dir_path' => '../',
        'vendor' => [
            'autoload'
        ]
    ];

    private const LIBS = [
        'dir_path' => './libs',
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
        'db_libs' => [
            TableDao::class,
            TableSchema::class
        ]
    ];

    private const DATABASE = [
        'dir_path' => './database',
        'entities' => [
            CustomerEntity::class,
            CountryEntity::class,
            CurrencyEntity::class,
            CustomerWalletEntity::class,
            DepositFeeEntity::class,
            SendFeeEntity::class,
            WithdrawFeeEntity::class,
            CurrencyFeeEntity::class,
            BankEntity::class,
            DepositHistoryEntity::class,
            WithdrawHistoryEntity::class,
            MyselfRecipientEntity::class,
            SomeoneRecipientEntity::class,
            SendHistoryEntity::class,
            CurrencyChargesEntity::class,
            NotificationEntity::class
        ],
        'schema' => [
            CustomerTableSchema::class,
            CountryTableSchema::class,
            CurrencyTableSchema::class,
            CustomerWalletTableSchema::class,
            DepositFeeTableSchema::class,
            SendFeeTableSchema::class,
            CurrencyFeeTableSchema::class,
            WithdrawFeeTableSchema::class,
            BankTableSchema::class,
            DepositHistoryTableSchema::class,
            WithdrawHistoryTableSchema::class,
            MyselfRecipientTableSchema::class,
            SomeoneRecipientTableSchema::class,
            SendHistoryTableSchema::class,
            CurrencyChargesTableSchema::class,
            NotificationTableSchema::class
        ],
        'factories' => [
            CustomerFactory::class,
            CountryFactory::class,
            CurrencyFactory::class,
            CustomerWalletFactory::class,
            DepositFeeFactory::class,
            SendFeeFactory::class,
            CurrencyFeeFactory::class,
            WithdrawFeeFactory::class,
            BankFactory::class,
            DepositHistoryFactory::class,
            WithdrawHistoryFactory::class,
            MyselfRecipientFactory::class,
            SomeoneRecipientFactory::class,
            SendHistoryFactory::class,
            CurrencyChargesFactory::class,
            NotificationFactory::class
        ],
        'dao' => [
            CustomerDao::class,
            CountryDao::class,
            CurrencyDao::class,
            CustomerWalletDao::class,
            DepositFeeDao::class,
            SendFeeDao::class,
            CurrencyFeeDao::class,
            WithdrawFeeDao::class,
            BankDao::class,
            DepositHistoryDao::class,
            WithdrawHistoryDao::class,
            MyselfRecipientDao::class,
            SomeoneRecipientDao::class,
            SendHistoryDao::class,
            CurrencyChargesDao::class,
            NotificationDao::class
        ],
        'db' => [
            RooiBoosDB::class
        ]
    ];

    private const CORE = [
        'dir_path' => './',
        'core' => [
            Environment::class,
            RooiBoosResponse::class,
            RooiBoosApi::class
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
            NotificationState::class,
        ]
    ];

    private const AGENTS = [
        'dir_path' => './',
        'agents' => [
            FetchCustomerWithEmail::class,
            RegisterCustomer::class,
            LoginCustomer::class,
            FetchCountries::class,
            FetchCurrency::class,
            CreateCustomerWallet::class,
            ShowUserAllWallets::class,
            CheckCurrency::class,
            RemoveCustomerWallet::class,
            DepositBalance::class,
            WithdrawBalance::class,
            GetWithdrawFee::class,
            GetDepositFee::class,
            GetSendFee::class,
            FetchBanks::class,
            FetchDepositHistoryWithCustomerId::class,
            AddDepositHistory::class,
            FetchWithdrawHistoryWithCustomerId::class,
            AddWithdrawHistory::class,
            AddMyselfRecipient::class,
            AddSomeoneRecipient::class,
            FetchMyselfRecipientWithCustomerId::class,
            FetchSomeoneRecipientWithCustomerId::class,
            AddSendHistory::class,
            FetchSendHistoryWithCustomerId::class,
            GetCurrencyCharges::class,
            GetCurrencyFee::class,
            GetNotificationsWithCustomerId::class,
            UpdateNotificationsAsRead::class
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
