<?php
namespace HtSettingsModuleTest\Service;

use HtSettingsModule\Service\SettingsAbstractFactory;
use Zend\ServiceManager\ServiceManager;

class SettingsAbstractFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected $settingsAbstractFactory;

    public function setUp()
    {
        $this->settingsAbstractFactory = new SettingsAbstractFactory;
    }

    public function testCanCreateService()
    {
        $serviceManager = new ServiceManager();
        $this->assertTrue($this->settingsAbstractFactory->canCreateServiceWithName($serviceManager, 'asfdsaf', 'settings.theme'));
        $this->assertFalse($this->settingsAbstractFactory->canCreateServiceWithName($serviceManager, 'asfdsaf', 'asfdsaf'));
    }

    public function testCreateService()
    {
        $serviceManager = new ServiceManager();
        $settingsProvider = $this->getMock('HtSettingsModule\Service\SettingsProviderInterface');
        $settings = new \ArrayObject(['foo' => 'bar']);
        $settingsProvider->expects($this->once())
            ->method('getSettings')
            ->with('theme')
            ->will($this->returnValue($settings));
        $serviceManager->setService('HtSettingsModule\Service\SettingsProvider', $settingsProvider);
        $this->assertEquals($settings, $this->settingsAbstractFactory->createServiceWithName($serviceManager, 'fhfgh', 'settings.theme'));
    }
}
