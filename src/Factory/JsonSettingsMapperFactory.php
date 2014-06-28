<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Mapper\FileSystem\FileSystemMapper;
use HtSettingsModule\Mapper\FileSystem\Adapter\Json as  JsonAdapter;

class JsonSettingsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtSettingsModule\Options\ModuleOptions');
        $entityClass = $options->getParameterEntityClass();

        return new FileSystemMapper(
            $serviceLocator->get('HtSettingsModule\FileSystemStorage'),
            new $entityClass,
            new JsonAdapter
        );
    }
}
