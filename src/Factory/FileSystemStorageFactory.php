<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

class FileSystemStorageFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtSettingsModule\Options\ModuleOptions');

        return new Filesystem(new Adapter($options->getStoragePath()));
    }
}
