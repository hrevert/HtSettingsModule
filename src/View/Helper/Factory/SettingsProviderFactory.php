<?php
namespace HtSettingsModule\View\Helper\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\View\Helper\SettingsProvider;

class SettingsProviderFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $helpers)
    {
        return new SettingsProvider($helpers->getServiceLocator()->get('HtSettingsModule\Service\SettignsProvider'));
    }    
}
