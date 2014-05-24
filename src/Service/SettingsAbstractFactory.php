<?php
namespace HtSettingsModule\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\AbstractFactoryInterface;

class SettingsAbstractFactory implements AbstractFactoryInterface
{
    const PREFIX = 'settings.';

    /**
     * {@inheritDoc}
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (strpos($requestedName, static::PREFIX) === 0) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $settingsProvider = $serviceLocator->get('HtSettingsModule\Service\SettingsProvider');
        $namespace = substr($requestedName, strlen(static::PREFIX));

        return $settingsProvider->getSettings($namespace);
    }
}
