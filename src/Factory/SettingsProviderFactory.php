<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Service\SettingsProvider;

class SettingsProviderFactory implements FactoryInterface
{
    /**
     * Gets settings mapper
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return SettingsMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtSettingsModule\Options\ModuleOptions');
        $settingsProvider = new SettingsProvider(
            $options,
            $serviceLocator->get('HtSettingsModule_SettingsMapper')
        );
        if ($options->getCacheOptions()->isEnabled()) {
            $settingsProvider->setCacheManager($serviceLocator->get('HtSettingsModule\Service\CacheManager'));
        }

        return $settingsProvider;
    }
}
