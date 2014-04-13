<?php
namespace HtSettingsModuleTest\Controller\Plugin\Factory;

use HtSettingsModule\Controller\Plugin\Factory\SettingsProviderFactory;
use Zend\ServiceManager\ServiceManager;

class SettingsProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager();
        $plugins = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $plugins->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($serviceManager));
        $serviceManager->setService('HtSettingsModule\Service\SettingsProvider', $this->getMock('HtSettingsModule\Service\SettingsProviderInterface'));
        $this->assertInstanceOf('HtSettingsModule\Controller\Plugin\SettingsProvider', (new SettingsProviderFactory)->createService($plugins));
    }
}
