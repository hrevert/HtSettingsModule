<?php
namespace HtSettingsModule\Factory;

use HtSettingsModule\Factory\SettingsMapperFactory;
use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;

class SettingsMapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new SettingsMapperFactory;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', new ModuleOptions);
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService('HtSettingsModule\DbAdapter', $adapter);
        $this->assertInstanceOf('HtSettingsModule\Mapper\SettingsMapper', $factory->createService($serviceManager));
    }
}
