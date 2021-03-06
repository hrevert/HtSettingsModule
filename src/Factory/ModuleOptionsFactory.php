<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Options\ModuleOptions;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     * Gets options of the module
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['ht_settings'];

        return new ModuleOptions($config);
    }
}
