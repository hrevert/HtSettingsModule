<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Service\SettingsService;

class SettingsServiceFactory implements FactoryInterface
{
    /**
     * Gets settings service
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return SettingsService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SettingsService(
            $serviceLocator->get('HtSettingsModule\Options\ModuleOptions'),
            $serviceLocator->get('HtSettingsModule_SettingsMappers')
        );
    }
}
