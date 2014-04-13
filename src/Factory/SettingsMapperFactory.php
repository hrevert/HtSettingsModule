<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Mapper\SettingsMapper;

class SettingsMapperFactory implements FactoryInterface
{
    /**
     * Gets settings mapper
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return SettingsMapper
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtSettingsModule\Options\ModuleOptions');
        $mapper = new SettingsMapper();
        $mapper->setDbAdapter($serviceLocator->get('HtSettingsModule\DbAdapter'));
        $entityClass = $options->getParameterEntityClass();
        $mapper->setEntityPrototype(new $entityClass);
        $mapper->setTableName($options->getSettingsTable());

        return $mapper;
    }
}
