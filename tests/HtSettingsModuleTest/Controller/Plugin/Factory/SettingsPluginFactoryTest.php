<?php
namespace HtSettingsModuleTest\Controller\Plugin\Factory;

use HtSettingsModule\Controller\Plugin\Factory\SettingsPluginFactory;
use Zend\ServiceManager\ServiceManager;

class SettingsPluginFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager();
        $plugins = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $plugins->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($serviceManager));
        $serviceManager->setService('HtSettingsModule\Manager\SettingsManager', $this->getMock('HtSettingsModule\Manager\SettingsManagerInterface'));
        $this->assertInstanceOf('HtSettingsModule\Controller\Plugin\SettingsPlugin', (new SettingsPluginFactory)->createService($plugins));
    }
}
