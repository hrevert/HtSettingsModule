<?php
namespace HtSettingsModuleTest\View\Helper\Factory;

use HtSettingsModule\View\Helper\Factory\SettingsProviderFactory;
use Zend\ServiceManager\ServiceManager;

class SettingsProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager();
        $helpers = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $helpers->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($serviceManager));
        $serviceManager->setService('HtSettingsModule\Service\SettingsProvider', $this->getMock('HtSettingsModule\Service\SettingsProviderInterface'));
        $this->assertInstanceOf('HtSettingsModule\View\Helper\SettingsProvider', (new SettingsProviderFactory)->createService($helpers));
    }
}
