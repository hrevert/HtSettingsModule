<?php
namespace HtSettingsModuleTest\Mapper\FileSystem;

use HtSettingsModule\Mapper\FileSystem\FileSystemMapper;
use HtSettingsModule\Entity\Parameter;
use Zend\Json\Json;
use Phine\Test\Method;

class FileSystemMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testFindByNamespace()
    {
        $adapter = $this->getMock('HtSettingsModule\Mapper\FileSystem\Adapter\AdapterInterface');
        $adapter->expects($this->any())
            ->method('getFileName')
            ->will($this->returnValue('football.json'));

        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new FileSystemMapper($fileSystem, new Parameter, $adapter);

        $fileSystem->expects($this->exactly(1))
            ->method('has')
            ->with('football.json')
            ->will($this->returnValue(true));
        $arrData = ['team' => 'Liverpool', 'boot' => 'Addidas'];
        $jsonData = Json::encode($arrData);
        $fileSystem->expects($this->exactly(1))
            ->method('read')
            ->with('football.json')
            ->will($this->returnValue($jsonData));

        $adapter->expects($this->once())
            ->method('onRead')
            ->with($jsonData)
            ->will($this->returnValue($arrData));

        $parameters = $mapper->findByNamespace('football');
        $this->assertInternalType('array', $parameters);
        $this->assertCount(2, $parameters);
        foreach ($parameters as $i => $parameter) {
            $name = array_keys($arrData)[$i];
            $this->assertEquals($name, $parameter->getName());
            $this->assertEquals($arrData[$name], $parameter->getValue());
        }
    }

    public function testInsert()
    {
        $adapter = $this->getMock('HtSettingsModule\Mapper\FileSystem\Adapter\AdapterInterface');
        $adapter->expects($this->any())
            ->method('getFileName')
            ->will($this->returnValue('theme.json'));

        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new FileSystemMapper($fileSystem, new Parameter, $adapter);
        $contents = 'foo:bar';
        $adapter->expects($this->once())
            ->method('prepareForWriting')
            ->with(['color' => 'red'])
            ->will($this->returnValue($contents));
        $parameter = new Parameter;
        $parameter->setNamespace('theme');
        $parameter->setName('color');
        $parameter->setValue('red');
        $fileSystem->expects($this->once())
            ->method('update')
            ->with('theme.json', $contents);
        $mapper->insertParameter($parameter);
    }

    public function testDeleteParameter()
    {
        $adapter = $this->getMock('HtSettingsModule\Mapper\FileSystem\Adapter\AdapterInterface');
        $adapter->expects($this->any())
            ->method('getFileName')
            ->will($this->returnValue('theme.json'));

        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new FileSystemMapper($fileSystem, new Parameter, $adapter);
        $parameter = new Parameter;
        $parameter->setNamespace('theme');
        $parameter->setName('color');
        $fileSystem->expects($this->exactly(2))
            ->method('has')
            ->with('theme.json')
            ->will($this->returnValue(true));
        $arrData = ['color' => 'red', 'font' => 'Arial'];
        $jsonContents = Json::encode($arrData);
        $fileSystem->expects($this->once())
            ->method('read')
            ->with('theme.json')
            ->will($this->returnValue($jsonContents));
        $adapter->expects($this->once())
            ->method('onRead')
            ->with($jsonContents)
            ->will($this->returnValue($arrData));
        $writeArr = ['font' => 'Arial'];
        $writeJsonContents = Json::encode($writeArr);
        $adapter->expects($this->once())
            ->method('prepareForWriting')
            ->with($writeArr)
            ->will($this->returnValue($writeJsonContents));
        $fileSystem->expects($this->once())
            ->method('update')
            ->with('theme.json', $writeJsonContents);
        $mapper->deleteParameter($parameter);
    }

    public function testFindParameter()
    {
        $adapter = $this->getMock('HtSettingsModule\Mapper\FileSystem\Adapter\AdapterInterface');
        $adapter->expects($this->any())
            ->method('getFileName')
            ->will($this->returnValue('football.json'));

        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new FileSystemMapper($fileSystem, new Parameter, $adapter);

        $fileSystem->expects($this->exactly(2))
            ->method('has')
            ->with('football.json')
            ->will($this->returnValue(true));
        $arrData = ['team' => 'Liverpool', 'boot' => 'Addidas'];
        $jsonContents = Json::encode($arrData);
        $fileSystem->expects($this->exactly(2))
            ->method('read')
            ->with('football.json')
            ->will($this->returnValue($jsonContents));
        $adapter->expects($this->exactly(2))
            ->method('onRead')
            ->with($jsonContents)
            ->will($this->returnValue($arrData));

        $parameter = new Parameter;
        $parameter->setName('team');
        $parameter->setNamespace('football');

        $newParameter = $mapper->findParameter($parameter);
        $this->assertEquals('Liverpool', $parameter->getValue());

        $newParameter = $mapper->findParameter('football', 'team');
        $this->assertEquals('Liverpool', $parameter->getValue());

        $this->setExpectedException('HtSettingsModule\Exception\InvalidArgumentException');
        $mapper->findParameter([]);
    }

    public function testRead()
    {
        $adapter = $this->getMock('HtSettingsModule\Mapper\FileSystem\Adapter\AdapterInterface');
        $adapter->expects($this->any())
            ->method('getFileName')
            ->will($this->returnValue('cricket.json'));

        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new FileSystemMapper($fileSystem, new Parameter, $adapter);

        $this->assertEquals([], Method::invoke($mapper, 'read', 'cricket'));

        $fileSystem->expects($this->once())
            ->method('has')
            ->with('cricket.json')
            ->will($this->returnValue(true));

        $arrData = ['team' => 'New South Wales', 'bat' => 'Addidas'];
        $jsonContents = Json::encode($arrData);
        $fileSystem->expects($this->once())
            ->method('read')
            ->with('cricket.json')
            ->will($this->returnValue($jsonContents));
        $adapter->expects($this->once())
            ->method('onRead')
            ->with($jsonContents)
            ->will($this->returnValue($arrData));

        $this->assertEquals($arrData, Method::invoke($mapper, 'read', 'cricket'));
    }

    public function testWrite()
    {
        $adapter = $this->getMock('HtSettingsModule\Mapper\FileSystem\Adapter\AdapterInterface');
        $adapter->expects($this->any())
            ->method('getFileName')
            ->will($this->returnValue('cricket.json'));

        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new FileSystemMapper($fileSystem, new Parameter, $adapter);

        $arrData = ['team' => 'New South Wales', 'bat' => 'Addidas'];
        $contents = Json::encode($arrData);

        $adapter->expects($this->exactly(2))
            ->method('prepareForWriting')
            ->with($arrData)
            ->will($this->returnValue($contents));

        $fileSystem->expects($this->once())
            ->method('write')
            ->with('cricket.json', $contents);

        Method::invokeArgs($mapper, 'write', ['cricket', $arrData]);

        $fileSystem->expects($this->once())
            ->method('has')
            ->with('cricket.json')
            ->will($this->returnValue(true));

        $fileSystem->expects($this->once())
            ->method('update')
            ->with('cricket.json', $contents);

        Method::invokeArgs($mapper, 'write', ['cricket', ['team' => 'New South Wales', 'bat' => 'Addidas']]);
    }
}
