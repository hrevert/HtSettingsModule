<?php
namespace HtSettingsModuleTest\Service;

use HtSettingsModule\Service\CacheManager;
use HtSettingsModule\Options\CacheOptions;

class CacheManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testNamespaceIsCacheable()
    {
        $options = new CacheOptions;
        $cacheManger = new CacheManager($options);
        $this->assertFalse($cacheManger->isCacheable('hello'));
        $options->setEnabled(true);
        $this->assertTrue($cacheManger->isCacheable('hello'));
        $options->setNamespaces(['stuff']);
        $this->assertTrue($cacheManger->isCacheable('stuff'));
        $this->assertFalse($cacheManger->isCacheable('another_stuff'));
    }

    public function testGetOneCacheAdapterFromOneAdapterObject()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $adapter = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $options->setAdapter($adapter);
        $cacheManger = new CacheManager($options);
        $cacheManger->setServiceLocator($this->getMock('Zend\ServiceManager\ServiceLocatorInterface'));
        $this->assertEquals($adapter, $cacheManger->getCacheAdapter('stuff'));
    }

    public function testGetOneCacheAdapterFromOneClassName()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $options->setAdapter('Zend\Cache\Storage\Adapter\Memory');
        $cacheManger = new CacheManager($options);
        $cacheManger->setServiceLocator($this->getMock('Zend\ServiceManager\ServiceLocatorInterface'));
        $this->assertInstanceOf('Zend\Cache\Storage\Adapter\Memory', $cacheManger->getCacheAdapter('stuff'));
    }

    public function testGetCacheAdapterFromMultipleClassName()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $options->setAdapter([
            'stuff1' => 'Zend\Cache\Storage\Adapter\Memory',
            'stuff2' => 'Zend\Cache\Storage\Adapter\Filesystem',
        ]);
        $cacheManger = new CacheManager($options);
        $cacheManger->setServiceLocator($this->getMock('Zend\ServiceManager\ServiceLocatorInterface'));
        $this->assertInstanceOf('Zend\Cache\Storage\Adapter\Memory', $cacheManger->getCacheAdapter('stuff1'));
        $this->assertInstanceOf('Zend\Cache\Storage\Adapter\Filesystem', $cacheManger->getCacheAdapter('stuff2'));
        $this->assertNull($cacheManger->getCacheAdapter('stuff3'));
    }

    public function testGetCacheAdapterFromServiceLocator()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $options->setAdapter([
            'stuff1' => 'Cache\MemoryAdapter',
            'stuff2' => 'Cache\FilesystemAdapter',
        ]);
        $cacheManger = new CacheManager($options);
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $map = [
            ['Cache\MemoryAdapter', new \Zend\Cache\Storage\Adapter\Memory],
            ['Cache\FilesystemAdapter', new \Zend\Cache\Storage\Adapter\Filesystem],
        ];
        $serviceLocator->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true));
        $serviceLocator->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));
        $cacheManger->setServiceLocator($serviceLocator);
        $this->assertInstanceOf('Zend\Cache\Storage\Adapter\Memory', $cacheManger->getCacheAdapter('stuff1'));
        $this->assertInstanceOf('Zend\Cache\Storage\Adapter\Filesystem', $cacheManger->getCacheAdapter('stuff2'));
        $this->assertNull($cacheManger->getCacheAdapter('stuff3'));
    }

    public function testSettingsExists()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $cacheManger = new CacheManager($options);
        $adapter = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $options->setAdapter($adapter);
        $map = [
            ['stuff5', true],
            ['stuff6', false],
        ];
        $adapter->expects($this->any())
            ->method('hasItem')
            ->will($this->returnValueMap($map));
        $this->assertTrue($cacheManger->settingsExists('stuff5'));
        $this->assertFalse($cacheManger->settingsExists('stuff6'));
    }

    public function testGetSettingsFromCache()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $cacheManger = new CacheManager($options);
        $adapter = $this->getMock('Zend\Cache\Storage\StorageInterface');
        $options->setAdapter($adapter);
        $map1 = [
            ['stuff5', true],
            ['stuff6', false],
        ];
        $adapter->expects($this->any())
            ->method('hasItem')
            ->will($this->returnValueMap($map1));
        $adapter->expects($this->any())
            ->method('getItem')
            ->will($this->returnValue('stuff5_data'));
        $this->assertNull($cacheManger->get('stuff6'));
        $this->assertEquals('stuff5_data', $cacheManger->get('stuff5'));
    }

    public function testCreateCache()
    {
        $options = new CacheOptions;
        $cacheManger = new CacheManager($options);
        $options->setEnabled(true);
        $adapter = new \Zend\Cache\Storage\Adapter\Memory;
        $options->setAdapter($adapter);
        $settings = new \ArrayObject;
        $cacheManger->create('stuff9', $settings);
        $this->assertEquals($settings, $adapter->getItem('stuff9'));
    }

    public function testDeleteCache()
    {
        $options = new CacheOptions;
        $options->setEnabled(true);
        $cacheManger = new CacheManager($options);
        $adapter = new \Zend\Cache\Storage\Adapter\Memory;
        $options->setAdapter($adapter);
        $adapter->addItem('stuff13', new \ArrayObject);
        $this->assertTrue($adapter->hasItem('stuff13'));
        $cacheManger->delete('stuff13');
        $this->assertFalse($adapter->hasItem('stuff13'));
    }
}
