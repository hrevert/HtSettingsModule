<?php
namespace HtSettingsModuleTest\Mapper;

use HtSettingsModule\Mapper\JsonSettingsMapper;
use HtSettingsModule\Entity\Parameter;
use Zend\Json\Json;
use Phine\Test\Method;

class JsonSettingsMapperTest extends \PHPUnit_Framework_TestCase
{
    public function testFindByNamespace()
    {
        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new JsonSettingsMapper($fileSystem, new Parameter);  
        
        $fileSystem->expects($this->exactly(1))
            ->method('has')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'football.json')
            ->will($this->returnValue(true));     
        $fileSystem->expects($this->exactly(1))
            ->method('read')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'football.json')
            ->will($this->returnValue(Json::encode(['team' => 'Liverpool', 'boot' => 'Addidas'])));

        $parameters = $mapper->findByNamespace('football');
        $this->assertInternalType('array', $parameters);
        $this->assertCount(2, $parameters);
    }

    public function testInsert()
    {
        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new JsonSettingsMapper($fileSystem, new Parameter);
        $parameter = new Parameter;
        $parameter->setNamespace('theme');
        $parameter->setName('color');
        $parameter->setValue('red');
        $fileSystem->expects($this->once())
            ->method('update')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'theme.json', Json::encode(['color' => 'red']));
        $mapper->insertParameter($parameter);
    }

    public function testDelete()
    {
        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new JsonSettingsMapper($fileSystem, new Parameter);
        $parameter = new Parameter;
        $parameter->setNamespace('theme');
        $parameter->setName('color');
        $fileSystem->expects($this->exactly(2))
            ->method('has')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'theme.json')
            ->will($this->returnValue(true));     
        $fileSystem->expects($this->once())
            ->method('read')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'theme.json')
            ->will($this->returnValue(Json::encode(['color' => 'red', 'font' => 'Arial'])));
        $fileSystem->expects($this->once())
            ->method('update')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'theme.json', Json::encode(['font' => 'Arial']));  
        $mapper->deleteParameter($parameter);               
    }

    public function testFindParameter()
    {
        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new JsonSettingsMapper($fileSystem, new Parameter);  
        
        $fileSystem->expects($this->exactly(2))
            ->method('has')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'football.json')
            ->will($this->returnValue(true));     
        $fileSystem->expects($this->exactly(2))
            ->method('read')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'football.json')
            ->will($this->returnValue(Json::encode(['team' => 'Liverpool', 'boot' => 'Addidas'])));  
            
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
        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new JsonSettingsMapper($fileSystem, new Parameter);  

        $this->assertEquals([], Method::invoke($mapper, 'read', 'cricket'));
        
        $fileSystem->expects($this->once())
            ->method('has')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'cricket.json')
            ->will($this->returnValue(true));     
        $fileSystem->expects($this->once())
            ->method('read')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'cricket.json')
            ->will($this->returnValue(Json::encode(['team' => 'New South Wales', 'bat' => 'Addidas'])));   
            
        $this->assertEquals(['team' => 'New South Wales', 'bat' => 'Addidas'], Method::invoke($mapper, 'read', 'cricket'));                          
    }

    public function testWrite()
    {
        $fileSystem = $this->getMock('League\Flysystem\FilesystemInterface');
        $mapper = new JsonSettingsMapper($fileSystem, new Parameter); 
        $fileSystem->expects($this->once())
            ->method('write')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'cricket.json', Json::encode(['team' => 'New South Wales', 'bat' => 'Addidas']));
        
        Method::invokeArgs($mapper, 'write', ['cricket', ['team' => 'New South Wales', 'bat' => 'Addidas']]);   
        
        $fileSystem->expects($this->once())
            ->method('has')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'cricket.json')
            ->will($this->returnValue(true));
            
        $fileSystem->expects($this->once())
            ->method('update')
            ->with(JsonSettingsMapper::FILE_PREFIX . 'cricket.json', Json::encode(['team' => 'New South Wales', 'bat' => 'Addidas']));
        
        Method::invokeArgs($mapper, 'write', ['cricket', ['team' => 'New South Wales', 'bat' => 'Addidas']]);
    }
}
