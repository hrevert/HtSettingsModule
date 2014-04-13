<?php
namespace HtSettingsModuleTest\Service;

use HtSettingsModule\Service\SettingsProvider;
use HtSettingsModule\Service\CacheManager;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Options\CacheOptions;
use HtSettingsModule\Options\NamespaceOptions;
use HtSettingsModule\Entity\Parameter;
use Zend\Stdlib\Hydrator;

class SettingsProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetCacheManager()
    {
        $settingsProvider = new SettingsProvider(
            new ModuleOptions,
            $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface')
        );
        $cacheManager = $this->getMock('HtSettingsModule\Service\CacheManagerInterface');
        $settingsProvider->setCacheManager($cacheManager);
        $this->assertEquals($cacheManager, $settingsProvider->getCacheManager());
    }

    public function testGetSettingsFromCache()
    {
        $options = new ModuleOptions;
        $cacheOptions = new CacheOptions(['enabled' => true]);
        $options->setCacheOptions($cacheOptions);
        $settingsProvider = new SettingsProvider(
            $options,
            $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface')
        );
        $cacheManager = $this->getMock('HtSettingsModule\Service\CacheManagerInterface');
        $settingsProvider->setCacheManager($cacheManager);        
        $cacheManager->expects($this->any())
            ->method('settingsExists')
            ->will($this->returnValue(true)); 
        $cacheManager->expects($this->any())
            ->method('get')
            ->will($this->returnValue('something')); 
        $this->assertEquals('something', $settingsProvider->getSettings('asdf'));                                
    }

    public function testGetSettingsFromRealSourceAndCreateCache()
    {
        $cacheOptions = new CacheOptions;
        $cacheManager = new CacheManager($cacheOptions);
        $cacheOptions->setEnabled(true);
        $adapter = new \Zend\Cache\Storage\Adapter\Memory;
        $cacheOptions->setAdapter($adapter);
        $options = new ModuleOptions;
        $options->setCacheOptions($cacheOptions);
        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsProvider = new SettingsProvider(
            $options,
            $settingsMapper
        );
        $namespaceOptions = new NamespaceOptions([
            'entity_class' => 'ArrayObject',
            'hydrator' => new Hydrator\ArraySerializable,
        ]);
        $options->addNamespace($namespaceOptions, 'theme');
        $settingsProvider->setCacheManager($cacheManager);
        $settingsMapper->expects($this->any())
            ->method('findByNamespace')
            ->will($this->returnValue([new Parameter('theme', 'color', 'red'), new Parameter('theme', 'font_size', 33)])); 
        $settings = $settingsProvider->getSettings('theme');
        $this->assertEquals('red', $settings['color']);    
        $this->assertEquals(33, $settings['font_size']);
        $this->assertEquals($settings, $adapter->getItem('theme'));                
    }
}
