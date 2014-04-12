<?php
namespace HtSettingsModule;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements 
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src' ,
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'HtSettingsModule\Options\ModuleOptions' => 'HtSettingsModule\Factory\ModuleOptionsFactory',
                'HtSettingsModule_SettingsMappers' => 'HtSettingsModule\Factory\SettignsMapperFactory',
                'HtSettingsModule\Service\CacheManager'=> 'HtSettingsModule\Factory\CacheManagerFactory',
            ],
            'aliases' => [
                'HtSettingsModule\DbAdapter' => 'Zend\Db\Adapter\Adapter',
            ]
        ];
    }
}
