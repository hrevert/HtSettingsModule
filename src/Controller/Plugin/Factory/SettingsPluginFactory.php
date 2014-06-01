<?php
namespace HtSettingsModule\Controller\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Controller\Plugin\SettingsPlugin;

class SettingsPluginFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $plugins)
    {
        return new SettingsPlugin($plugins->getServiceLocator()->get('HtSettingsModule\Manager\SettingsManager'));
    }
}
