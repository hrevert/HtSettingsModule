<?php
namespace HtSettingsModuleTest\Controller\Plugin;

use HtSettingsModule\Controller\Plugin\SettingsPlugin;

class SettingsPluginTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $settingsManager = $this->getMockBuilder('HtSettingsModule\Manager\SettingsManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $settings = new \ArrayObject(['color' => 'red']);
        $settingsManager->expects($this->any(2))
            ->method('getSettings')
            ->will($this->returnValueMap([['theme', $settings]]));
        $plugin = new SettingsPlugin($settingsManager);
        $this->assertEquals('red', $plugin('theme')['color']);
        $this->assertEquals($settings, $plugin('theme'));
        $this->assertEquals($settings, $plugin()->getSettings('theme'));
    }

    public function testSaveSettings()
    {
        $settingsManager = $this->getMockBuilder('HtSettingsModule\Manager\SettingsManagerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $settings = new \ArrayObject(['ip_address' => '123.123.123.68']);
        $settingsManager->expects($this->once())
            ->method('save')
            ->with($settings, 'network');
        $plugin = new SettingsPlugin($settingsManager);
        $plugin->save($settings, 'network');        
    }
}
