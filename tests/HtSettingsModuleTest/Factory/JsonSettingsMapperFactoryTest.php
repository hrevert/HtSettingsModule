<?php
namespace HtSettingsModuleTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Factory\JsonSettingsMapperFactory;

class JsonSettingsMapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new JsonSettingsMapperFactory;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', new ModuleOptions);
        $serviceManager->setService('HtSettingsModule\FileSystemStorage', $this->getMock('League\Flysystem\FilesystemInterface'));
        $this->assertInstanceOf('HtSettingsModule\Mapper\FileSystem\FileSystemMapper', $factory->createService($serviceManager));
    }
}
