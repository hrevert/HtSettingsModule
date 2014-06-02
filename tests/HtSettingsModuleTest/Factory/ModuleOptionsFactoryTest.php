<?php
namespace HtSettingsModuleTest\Factory;

use Zend\ServiceManager\ServiceManager;

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
