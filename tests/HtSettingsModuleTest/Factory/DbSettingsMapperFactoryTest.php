<?php
namespace HtSettingsModuleTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Factory\DbSettingsMapperFactory;

class DbSettingsMapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new DbSettingsMapperFactory;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', new ModuleOptions);
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService('HtSettingsModule\DbAdapter', $adapter);
        $this->assertInstanceOf('HtSettingsModule\Mapper\DbSettingsMapper', $factory->createService($serviceManager));
    }
}
