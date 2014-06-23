<?php
namespace HtSettingsModuleTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Factory\XmlSettingsMapperFactory;

class XmlSettingsMapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new XmlSettingsMapperFactory;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', new ModuleOptions);
        $serviceManager->setService('HtSettingsModule\FileSystemStorage', $this->getMock('League\Flysystem\FilesystemInterface'));
        $this->assertInstanceOf('HtSettingsModule\Mapper\FileSystem\FileSystemMapper', $factory->createService($serviceManager));
    }
}
