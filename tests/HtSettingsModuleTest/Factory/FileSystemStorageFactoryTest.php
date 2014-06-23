<?php
namespace HtSettingsModuleTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Factory\FileSystemStorageFactory;

class FileSystemStorageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new FileSystemStorageFactory;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', new ModuleOptions);
        $this->assertInstanceOf('League\Flysystem\Filesystem', $factory->createService($serviceManager));
    }
}
