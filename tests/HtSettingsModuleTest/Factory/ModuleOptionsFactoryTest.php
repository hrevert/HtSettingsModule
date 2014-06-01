<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new ModuleOptionsFactory;
        $serviceManager->setService('Config', ['ht_settings' => []]);
        $this->assertInstanceOf('HtSettingsModule\Options\ModuleOptions', $factory->createService($serviceManager));
    }
}
