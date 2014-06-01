<?php
namespace HtSettingsModuleTest\Manager;

use HtSettingsModule\Manager\SettingsManager;
use HtSettingsModuleTest\Model\Theme;

class SettingsManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $settingsManager;

    protected $settingsProvider;

    protected $settingsService;

    public function setUp()
    {
        $this->settingsProvider = $this->getMock('HtSettingsModule\Service\SettingsProviderInterface');
        $this->settingsService = $this->getMock('HtSettingsModule\Service\SettingsServiceInterface');
        $this->settingsManager = new SettingsManager($this->settingsProvider, $this->settingsService);
    }

    public function testGetSettings()
    {
        $settings = new Theme;
        $this->settingsProvider->expects($this->once())
            ->method('getSettings')
            ->with('theme')
            ->will($this->returnValue($settings));
        $this->assertEquals($settings, $this->settingsManager->getSettings('theme'));
    }

    public function testGetSettingsArray()
    {
        $settings = new Theme;
        $this->settingsProvider->expects($this->once())
            ->method('getSettingsArray')
            ->with('theme')
            ->will($this->returnValue($settings));
        $this->assertEquals($settings, $this->settingsManager->getSettingsArray('theme'));
    }

    public function testSaveSettings()
    {
        $settings = new Theme;
        $this->settingsService->expects($this->once())
            ->method('save')
            ->with($settings, 'theme');

        $this->settingsManager->save($settings, 'theme');
    }

    public function testSaveParameter()
    {
        $settings = new Theme;
        $this->settingsService->expects($this->once())
            ->method('saveParameter')
            ->with('theme', 'color', 13);

        $this->settingsManager->saveParameter('theme', 'color', 13);
    }
}
