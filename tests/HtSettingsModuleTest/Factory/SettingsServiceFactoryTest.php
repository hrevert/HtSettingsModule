<?php
namespace HtSettingsModuleTest\Factory;

use HtSettingsModule\Factory\SettingsServiceFactory;
use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;

class SettingsServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new SettingsServiceFactory;
        $options = new ModuleOptions;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', $options);
        $serviceManager->setService('HtSettingsModule_SettingsMapper', $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface'));
        $this->assertInstanceOf('HtSettingsModule\Service\SettingsService', $factory->createService($serviceManager));
        $options->getCacheOptions()->setEnabled(true);
        $serviceManager->setService('HtSettingsModule\Service\CacheManager', $this->getMock('HtSettingsModule\Service\CacheManagerInterface'));
        $this->assertInstanceOf('HtSettingsModule\Service\SettingsService', $factory->createService($serviceManager));
    }
}
