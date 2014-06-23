<?php

return [
    'ht_settings' => [],
    'service_manager' => [
        'factories' => [
            'HtSettingsModule\Options\ModuleOptions' => 'HtSettingsModule\Factory\ModuleOptionsFactory',
            'HtSettingsModule_SettingsMapper' => 'HtSettingsModule\Factory\SettingsMapperFactory',
            'HtSettingsModule\Service\CacheManager'=> 'HtSettingsModule\Factory\CacheManagerFactory',
            'HtSettingsModule\Service\SettingsProvider'=> 'HtSettingsModule\Factory\SettingsProviderFactory',
            'HtSettingsModule\Service\SettingsService'=> 'HtSettingsModule\Factory\SettingsServiceFactory',
            'HtSettingsModule\Service\NamespaceHydratorProvider'=> 'HtSettingsModule\Factory\NamespaceHydratorProviderFactory',
            'HtSettingsModule\Manager\SettingsManager'=> 'HtSettingsModule\Factory\SettingsManagerFactory',
            'HtSettingsModule\FileSystemStorage' => 'HtSettingsModule\Factory\FileSystemStorageFactory',
            'HtSettingsModule\Mapper\JsonSettingsMapper' => 'HtSettingsModule\Factory\JsonSettingsMapperFactory',
            'HtSettingsModule\Mapper\XmlSettingsMapper' => 'HtSettingsModule\Factory\XmlSettingsMapperFactory',
        ],
        'aliases' => [
            'HtSettingsModule\DbAdapter' => 'Zend\Db\Adapter\Adapter',
            'HtSettingsManager' => 'HtSettingsModule\Manager\SettingsManager',
        ]        
    ],
    'controller_plugins' => [
        'factories' => [
            'HtSettingsModule\Controller\Plugin\SettingsPlugin' => 'HtSettingsModule\Controller\Plugin\Factory\SettingsPluginFactory',
        ],
        'aliases' => [
            'settings' => 'HtSettingsModule\Controller\Plugin\SettingsPlugin',
        ]        
    ],
    'view_helpers' => [
        'factories' => [
            'HtSettingsModule\View\Helper\SettingsProvider' => 'HtSettingsModule\View\Helper\Factory\SettingsProviderFactory',
        ],
        'aliases' => [
            'settings' => 'HtSettingsModule\View\Helper\SettingsProvider',
        ]        
    ]
];
