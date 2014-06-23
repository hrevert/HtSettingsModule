<?php
namespace HtSettingsModuleTest\Mapper\FileSystem\Adapter;

use HtSettingsModule\Mapper\FileSystem\Adapter\Xml;
use Zend\Config\Config;

class XmlTest extends \PHPUnit_Framework_TestCase
{
    protected $adapter;

    public function setUp()
    {
        $this->adapter = new Xml;
    }

    public function testDefaltReader()
    {
        $adapter = new Xml;
        $this->assertInstanceOf('Zend\Config\Reader\Xml', $adapter->getReader());
    }

    public function testDefaltWriter()
    {
        $adapter = new Xml;
        $this->assertInstanceOf('Zend\Config\Writer\Xml', $adapter->getWriter());
    }

    public function testPrepareForWriting()
    {
        $adapter = new Xml;
        $config = ['foo' => 'bar'];
        $xmlWriter = $this->getMock('Zend\Config\Writer\Xml');
        $adapter->setWriter($xmlWriter);
        $xmlWriter->expects($this->once())
            ->method('toString')
            ->with(new Config($config))
            ->will($this->returnValue('xmlString'));
        $this->assertEquals('xmlString', $adapter->prepareForWriting($config));
    }

    public function testOnRead()
    {
        $adapter = new Xml;
        $config = ['foo' => 'bar'];
        $xmlString = 'asdfasfasf';
        $xmlReader = $this->getMock('Zend\Config\Reader\Xml');
        $adapter->setReader($xmlReader);
        $xmlReader->expects($this->once())
            ->method('fromString')
            ->with($xmlString)
            ->will($this->returnValue($config));
        $this->assertEquals($config, $adapter->onRead($xmlString));
    }
}
