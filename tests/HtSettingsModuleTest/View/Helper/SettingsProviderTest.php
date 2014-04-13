<?php
namespace HtSettingsModuleTest\View\Helper;

use HtSettingsModule\View\Helper\SettingsProvider;

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
        $helper = new SettingsProvider($settingsProvider);
        $this->assertEquals('red', $helper('theme')['color']);
        $this->assertEquals($settings, $helper('theme'));
    }
}
