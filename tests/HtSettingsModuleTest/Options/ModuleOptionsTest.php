<?php
namespace HtSettingsModuleTest\Options;

use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Options\CacheOptions;
use HtSettingsModule\Options\NamespaceOptions;

class ModuleOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testSettersAndGetters()
    {
        $options = new ModuleOptions([
            'settings_table' => 'app_settings',
            'parameter_entity_class' => 'Application\Entity\SettingsParameter',
            'namespaces' => [
                'cricket' => [
                    'entity_class' => 'HtSettingsModule\Entity\Parameter',
                    'hydrator' => 'Zend\Stdlib\Hydrator\ClassMethods',
                ],
                'football' => [
                    'entity_class' => 'ArrayObject',
                    'hydrator' => 'Zend\Stdlib\Hydrator\ArraySerializable',
                ],
            ],
            'cache_options' => [
                'enabled' => true,
                'namespaces' => ['theme'],
                'adapter' => 'Zend\Cache\Storage\Adapter\Memcached',
            ]
        ]);

        $this->assertEquals('app_settings', $options->getSettingsTable());
        $this->assertEquals('Application\Entity\SettingsParameter', $options->getParameterEntityClass());
        $cacheOptions = $options->getCacheOptions();
        $this->assertTrue($cacheOptions->isEnabled());
        $this->assertEquals(['theme'], $cacheOptions->getNamespaces());
        $this->assertEquals('Zend\Cache\Storage\Adapter\Memcached', $cacheOptions->getAdapter());
        $this->assertCount(2, $options->getNamespaces());
        $cricketOptions = $options->getNamespaceOptions('cricket');
        $this->assertInstanceOf('HtSettingsModule\Entity\Parameter', $cricketOptions->getEntityPrototype());
        $this->assertInstanceOf('Zend\Stdlib\Hydrator\ClassMethods', $cricketOptions->getHydrator());
        $this->assertEquals('cricket', $cricketOptions->getName());
        $footballOptions = $options->getNamespaceOptions('football');
        $this->assertInstanceOf('ArrayObject', $footballOptions->getEntityPrototype());
        $this->assertInstanceOf('Zend\Stdlib\Hydrator\ArraySerializable', $footballOptions->getHydrator());
        $this->assertEquals('football', $footballOptions->getName());
    }

    public function testGetExceptionWithInvalidNamespace()
    {
        $options = new ModuleOptions;
        $this->setExpectedException('HtSettingsModule\Exception\InvalidArgumentException');
        $options->getNamespaceOptions('asdfljaslfd');
    }

    public function testSetCacheOptions()
    {
        $options = new ModuleOptions;
        $cacheOptions = new CacheOptions;
        $options->setCacheOptions($cacheOptions);
        $this->assertEquals($cacheOptions, $options->getCacheOptions());
        $options->setCacheOptions(['enabled' => true]);
        $this->assertTrue(true, $options->getCacheOptions()->isEnabled());
        $this->setExpectedException('HtSettingsModule\Exception\InvalidArgumentException');
        $options->setCacheOptions(new \ArrayObject);
    }

    public function testAddNamespace()
    {
        $options = new ModuleOptions;
        $options->addNamespace([
            'name' => 'laptop',
            'entity_class' => 'HtSettingsModule\Entity\Parameter',
        ]);
        $options->addNamespace([], 'smart_phone');
        $options->addNamespace(new NamespaceOptions, 'smart_tv');
        $this->assertEquals('laptop', $options->getNamespaceOptions('laptop')->getName());
        $this->assertEquals('smart_phone', $options->getNamespaceOptions('smart_phone')->getName());
        $this->assertEquals('smart_tv', $options->getNamespaceOptions('smart_tv')->getName());
    }
}
