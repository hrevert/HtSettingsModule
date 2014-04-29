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

        // check for hydrator service, and if exists, replace service name with object
        if (isset($config['namespaces'])) {
            foreach ($config['namespaces'] as $namespace => $namespaceOptions) {
                if (isset($namespaceOptions['hydrator'])) {
                    if ($serviceLocator->has($namespaceOptions['hydrator'])) {
                        $config['namespaces'][$namespace]['hydrator'] = $serviceLocator->get($namespaceOptions['hydrator']);
                    }
                }
            }
        }

        return new ModuleOptions($config);
    }
}
