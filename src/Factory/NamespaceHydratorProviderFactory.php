<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Service\NamespaceHydratorProvider;

class NamespaceHydratorProviderFactory implements FactoryInterface
{
    /**
     * Gets NamespaceHydratorProvider
     *
     * @param  ServiceLocatorInterface   $serviceLocator
     * @return NamespaceHydratorProvider
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new NamespaceHydratorProvider(
            $serviceLocator->get('HydratorManager'),
            $serviceLocator->get('HtSettingsModule\Options\ModuleOptions')
        );
    }
}
