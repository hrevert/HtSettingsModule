<?php
namespace HtSettingsModule;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ControllerPluginProviderInterface,
    ViewHelperProviderInterface
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
                'HtSettingsModule_SettingsMapper' => 'HtSettingsModule\Factory\SettingsMapperFactory',
                'HtSettingsModule\Service\CacheManager'=> 'HtSettingsModule\Factory\CacheManagerFactory',
                'HtSettingsModule\Service\SettingsProvider'=> 'HtSettingsModule\Factory\SettingsProviderFactory',
                'HtSettingsModule\Service\SettingsService'=> 'HtSettingsModule\Factory\SettingsServiceFactory',
                'HtSettingsModule\Service\NamespaceHydratorProvider'=> 'HtSettingsModule\Factory\NamespaceHydratorProviderFactory',
            ],
            'aliases' => [
                'HtSettingsModule\DbAdapter' => 'Zend\Db\Adapter\Adapter',
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getControllerPluginConfig()
    {
        return [
            'factories' => [
                'HtSettingsModule\Controller\Plugin\SettingsProvider' => 'HtSettingsModule\Controller\Plugin\Factory\SettingsProviderFactory',
            ],
            'aliases' => [
                'settings' => 'HtSettingsModule\Controller\Plugin\SettingsProvider',
             ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'HtSettingsModule\View\Helper\SettingsProvider' => 'HtSettingsModule\View\Helper\Factory\SettingsProviderFactory',
            ],
            'aliases' => [
                'settings' => 'HtSettingsModule\View\Helper\SettingsProvider',
             ]
        ];
    }
}
