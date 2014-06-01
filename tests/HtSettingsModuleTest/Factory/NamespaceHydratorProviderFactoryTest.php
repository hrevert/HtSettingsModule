<?php
namespace HtSettingsModuleTest\Factory;

use HtSettingsModule\Factory\NamespaceHydratorProviderFactory;
use Zend\ServiceManager\ServiceManager;

class NamespaceHydratorProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new NamespaceHydratorProviderFactory; 
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', $this->getMock('HtSettingsModule\Options\ModuleOptionsInterface'));
        $serviceManager->setService('HydratorManager', $this->getMock('Zend\ServiceManager\ServiceLocatorInterface'));
        $this->assertInstanceOf('HtSettingsModule\Service\NamespaceHydratorProvider', $factory->createService($serviceManager));
    }
}
