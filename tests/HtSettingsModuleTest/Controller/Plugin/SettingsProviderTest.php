<?php
namespace HtSettingsModuleTest\Controller\Plugin;

use HtSettingsModule\Controller\Plugin\SettingsProvider;

class SettingsProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $settingsProvider = $this->getMockBuilder('HtSettingsModule\Service\SettingsProviderInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $settings = new \ArrayObject(['color' => 'red']);
        $settingsProvider->expects($this->any())
            ->method('getSettings')
            ->will($this->returnValueMap([['theme', $settings]]));
        $plugin = new SettingsProvider($settingsProvider);
        $this->assertEquals('red', $plugin('theme')['color']);
        $this->assertEquals($settings, $plugin('theme'));
    }
}
