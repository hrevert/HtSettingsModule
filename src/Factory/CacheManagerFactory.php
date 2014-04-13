<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Service\CacheManager;

class CacheManagerFactory implements FactoryInterface
{
    /**
     * Gets cache manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CacheManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $cacheManager = new CacheManager($serviceLocator->get('HtSettingsModule\Options\ModuleOptions')->getCacheOptions());
        $cacheManager->setServiceLocator($serviceLocator);

        return $cacheManager;
    }
}
