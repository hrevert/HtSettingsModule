<?php
namespace HtSettingsModulerTest\Service;

use HtSettingsModule\Service\SettingsService;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Entity\Parameter;

class SettingsServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testInsertParameter()
    {
        $options = new ModuleOptions;
        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsService= new SettingsService(
            $options,
            $settingsMapper
        );

        $namespace  = 'network_settings';
        $name       = 'ip_address';
        $value      = '192.168.1.1';

        $parameter = new Parameter;
        $parameter->setNamespace($namespace);
        $parameter->setName($name);
        $parameter->setValue($value);

        $options->getCacheOptions()->setEnabled(true);
        $cacheManager = $this->getMock('HtSettingsModule\Service\CacheManagerInterface');
        $cacheManager->expects($this->once())
            ->method('delete')
            ->with($namespace);
        $settingsService->setCacheManager($cacheManager);

        $settingsMapper->expects($this->once())
            ->method('insertParameter')
            ->with($parameter);

        $settingsService->saveParameter($namespace, $name, $value);
    }

    public function testUpdateParameter()
    {
        $options = new ModuleOptions;
        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsService= new SettingsService(
            $options,
            $settingsMapper
        );

        $namespace  = 'network_settings';
        $name       = 'ip_address';
        $value      = '192.168.1.1';
        $newValue   = '192.168.10.1';

        $orginalParameter = new Parameter;
        $orginalParameter->setNamespace($namespace);
        $orginalParameter->setName($name);
        $orginalParameter->setValue($value);

        $newParameter = clone $orginalParameter;
        $newParameter->setValue($newValue);

        $options->getCacheOptions()->setEnabled(false);

        $settingsMapper->expects($this->once())
            ->method('findParameter')
            ->with($namespace, $name)
            ->will($this->returnValue($orginalParameter));

        $settingsMapper->expects($this->once())
            ->method('updateParameter')
            ->with($newParameter);

        $settingsService->saveParameter($namespace, $name, $newValue);
    }
}
