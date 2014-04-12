<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Service\SettignsProvider;

class SettignsProviderFactory implements FactoryInterface
{
    /**
     * Gets settings mapper
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return SettignsMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtSettingsModule\Options\ModuleOptions');
        $settingsProvider = new SettignsProvider(
            $options,
            $serviceLocator->get('HtSettingsModule_SettingsMappers')
        );
        if ($options->getCacheOptions()->isEnabled()) {
            $settingsProvider->setCacheManager($serviceLocator->get('HtSettingsModule\Service\CacheManager'));
        }

        return $settingsProvider;
    }    
}
