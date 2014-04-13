<?php
namespace HtSettingsModulerTest\Service;

use HtSettingsModule\Service\SettingsService;
use HtSettingsModule\Options\ModuleOptions;

class SettingsServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testSave()
    {
        $settingsService= new SettingsService(
            new ModuleOptions,
            $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface')
        );
    }
}
