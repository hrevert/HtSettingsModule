<?php
namespace HtSettingsModulerTest\Service;

use ArrayObject;
use HtSettingsModule\Service\SettingsService;
use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Entity\Parameter;
use Zend\Stdlib\Hydrator;
use Zend\Stdlib\ArrayUtils;
use HtSettingsModuleTest\Model\Theme;

class SettingsServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testInsertParameter()
    {
        $options = new ModuleOptions;
        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsService= new SettingsService(
            $options,
            $settingsMapper,
            $this->getMock('HtSettingsModule\Service\NamespaceHydratorProviderInerface')
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
            $settingsMapper,
            $this->getMock('HtSettingsModule\Service\NamespaceHydratorProviderInerface')
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

    public function testSaveSettings()
    {
        $namespace = 'some_namespace';

        $storedSettingsArray = [
            'color' => 'red',
            'interval' => 10,
            'last_update' => '2014-06-01',
        ];
        $namespaceParameters = [];
        foreach ($storedSettingsArray as $name => $value) {
            $parameter = new Parameter;
            $parameter->setName($name);
            $parameter->setValue($value);
            $parameter->setNamespace($namespace);
            $namespaceParameters[] = $parameter;
        }

        $hydrator = new Hydrator\ArraySerializable;

        $newSettingsArray = [
            'color' => 'black',
            'interval' => 12,
            'height' => 12,
            'width' => 6,
        ];
        $newSettings = new ArrayObject;
        $hydrator->hydrate($newSettingsArray, $newSettings);

        $namespaceHydratorProvider = $this->getMock('HtSettingsModule\Service\NamespaceHydratorProviderInerface');
        $namespaceHydratorProvider->expects($this->once())
            ->method('getHydrator')
            ->with($namespace)
            ->will($this->returnValue($hydrator));

        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsMapper->expects($this->at(0))
            ->method('findByNamespace')
            ->with($namespace)
            ->will($this->returnValue($namespaceParameters));//var_dump($settingsMapper->findByNamespace($namespace));exit();

        $updateParameter1 =  Parameter::create($namespace, 'color', 'black'); 
        $settingsMapper->expects($this->at(1))
            ->method('updateParameter')
            ->with($updateParameter1);

        $updateParameter2 =  Parameter::create($namespace, 'interval', 12); 
        $settingsMapper->expects($this->at(2))
            ->method('updateParameter')
            ->with($updateParameter2);

        $insertParameter1 =  Parameter::create($namespace, 'height', 12); 
        $settingsMapper->expects($this->at(3))
            ->method('insertParameter')
            ->with($insertParameter1);

        $insertParameter2 =  Parameter::create($namespace, 'width', 6); 
        $settingsMapper->expects($this->at(4))
            ->method('insertParameter')
            ->with($insertParameter2);

        $options = new ModuleOptions();

        $settingsService= new SettingsService(
            $options,
            $settingsMapper,
            $namespaceHydratorProvider
        );

        $settingsService->save($newSettings, $namespace);
    }

    public function testGetExceptionWithNamespaceIsNotDetected()
    {
        $options = new ModuleOptions;
        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsService = new SettingsService(
            $options,
            $settingsMapper,
            $this->getMock('HtSettingsModule\Service\NamespaceHydratorProviderInerface')
        );

        $this->setExpectedException('HtSettingsModule\Exception\InvalidArgumentException');

        $reflectionMethod = new \ReflectionMethod($settingsService, 'detectNamespace');
        $reflectionMethod->setAccessible(true);
        $reflectionMethod->invokeArgs($settingsService, [new ArrayObject]);
    }

    public function testDetectionNamespace()
    {
        $options = new ModuleOptions;
        $settingsMapper = $this->getMock('HtSettingsModule\Mapper\SettingsMapperInterface');
        $settingsService = new SettingsService(
            $options,
            $settingsMapper,
            $this->getMock('HtSettingsModule\Service\NamespaceHydratorProviderInerface')
        );
        
        $options->addNamespace([
            'entity_class' => 'HtSettingsModuleTest\Model\Theme',
        ], 'theme');      

        $options->addNamespace([
            'entity_class' => 'ArrayObject',
        ], 'network'); 

        $reflectionMethod = new \ReflectionMethod($settingsService, 'detectNamespace');
        $reflectionMethod->setAccessible(true);
        $this->assertEquals('network', $reflectionMethod->invokeArgs($settingsService, [new ArrayObject]));
        $this->assertEquals('theme', $reflectionMethod->invokeArgs($settingsService, [new Theme]));

        $this->setExpectedException('HtSettingsModule\Exception\InvalidArgumentException');
        $this->assertEquals('theme', $reflectionMethod->invokeArgs($settingsService, [new \stdClass]));
    }
}
