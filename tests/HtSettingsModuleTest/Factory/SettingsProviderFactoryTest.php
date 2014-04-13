<?php
namespace HtSettingsModuleTest\Factory;

use HtSettingsModule\Factory\SettingsProviderFactory;
use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;

class SettingsProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new SettingsProviderFactory;
        $options = new ModuleOptions;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', $options);
        $serviceManager->setService('HtSettingsModule_SettingsMappers', $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface'));
        $this->assertInstanceOf('HtSettingsModule\Service\SettingsProvider', $factory->createService($serviceManager));
        $options->getCacheOptions()->setEnabled(true);
        $serviceManager->setService('HtSettingsModule\Service\CacheManager', $this->getMock('HtSettingsModule\Service\CacheManagerInterface'));
        $this->assertInstanceOf('HtSettingsModule\Service\SettingsProvider', $factory->createService($serviceManager));
    }    
}
