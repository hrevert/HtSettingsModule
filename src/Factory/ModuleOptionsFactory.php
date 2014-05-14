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
            $hydrators = $serviceLocator->get('HydratorManager');
            foreach ($config['namespaces'] as $namespace => $namespaceOptions) {
                if (isset($namespaceOptions['hydrator'])) {
                    if ($hydrators->has($namespaceOptions['hydrator'])) {
                        $config['namespaces'][$namespace]['hydrator'] = $hydrators->get($namespaceOptions['hydrator']);
                    }
                }
            }
        }

        return new ModuleOptions($config);
    }
}
