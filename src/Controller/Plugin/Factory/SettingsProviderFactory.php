<?php
namespace HtSettingsModule\Controller\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Controller\Plugin\SettingsProvider;

class SettingsProviderFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $plugins)
    {
        return new SettingsProvider($plugins->getServiceLocator()->get('HtSettingsModule\Service\SettingsProvider'));
    }    
}
