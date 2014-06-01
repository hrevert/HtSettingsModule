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
            $options = $serviceLocator->get('HtSettingsModule\Options\ModuleOptions');
            $namespace = $this->getNamespace($requestedName);
            return $options->hasNamespace($namespace);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $settingsProvider = $serviceLocator->get('HtSettingsModule\Service\SettingsProvider');
        $namespace = $this->getNamespace($requestedName);

        return $settingsProvider->getSettings($namespace);
    }

    protected function getNamespace($requestedName)
    {
        return substr($requestedName, strlen(static::PREFIX));
    }
}
