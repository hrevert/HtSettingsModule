Storage Adapters
===========================

## Zend\Db
Use this adapter if you want to use `Zend\Db` for settings persistence.

#### How
Import the MySQL schema located in `vendor/hrevert/ht-settings-module/data/schema.sql` if you use MySQL.

## XML Adapter
Use this adapter if you want to store settings in XML format.

#### How
1. Install [flysystem](https://github.com/thephpleague/flysystem) and [Zend\Config](https://github.com/zendframework/zf2/tree/master/library/Zend/Config).
2. Add the following config:
```php
return [
    'ht_settings' => [
        // This is optional.
        // You can specify this is config/autoload/ht-settings-module.global.php
        'storage_path' => 'data/settings',
    ],
    'service_manager' => [
        'aliases' => [
            'HtSettingsModule_SettingsMapper' => 'HtSettingsModule\Mapper\XmlSettingsMapper',
        ]
    ]
];
```

## JSON Adapter
Use this adapter if you want to store settings in JSON format.

#### How
1. Install [flysystem](https://github.com/thephpleague/flysystem) and [Zend\Json](https://github.com/zendframework/zf2/tree/master/library/Zend/Json).
2. Add the following config:
```php
return [
    'ht_settings' => [
        // This is optional.
        // You can specify this is config/autoload/ht-settings-module.global.php
        'storage_path' => 'data/settings',
    ],
    'service_manager' => [
        'aliases' => [
            'HtSettingsModule_SettingsMapper' => 'HtSettingsModule\Mapper\JsonSettingsMapper',
        ]
    ]
];
```