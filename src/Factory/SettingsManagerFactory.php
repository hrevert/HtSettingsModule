<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Manager\SettingsManager;

class SettingsManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new SettingsManager(
            $serviceLocator->get('HtSettingsModule\Service\SettingsProvider'),
            $serviceLocator->get('HtSettingsModule\Service\SettingsService')
        );
    }
}
