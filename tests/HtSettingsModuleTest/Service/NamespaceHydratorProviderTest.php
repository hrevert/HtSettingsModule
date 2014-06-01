<?php
namespace HtSettingsModuleTest\Service;

use HtSettingsModule\Service\NamespaceHydratorProvider;

class NamespaceHydratorProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetHydratorDirectlyFromOptions()
    {
        $options = $this->getMock('HtSettingsModule\Options\ModuleOptionsInterface');

        $namespaceHydratorProvider = new NamespaceHydratorProvider(
            $this->getMock('Zend\ServiceManager\ServiceLocatorInterface'),
            $options
        );

        $hydrator = $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface');
        $namespaceOptions = $this->getMock('HtSettingsModule\Options\NamespaceOptionsInterface');
        $namespaceOptions->expects($this->once())
            ->method('getHydrator')
            ->will($this->returnValue($hydrator));

        $options->expects($this->once())
            ->method('getNamespaceOptions')
            ->with('theme')
            ->will($this->returnValue($namespaceOptions));

        $this->assertEquals($hydrator, $namespaceHydratorProvider->getHydrator('theme'));
    }

    public function testGetHydratorFromService()
    {
        $options = $this->getMock('HtSettingsModule\Options\ModuleOptionsInterface');
        $hydrators = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $namespaceHydratorProvider = new NamespaceHydratorProvider(
            $hydrators,
            $options
        );

        $hydrator = $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface');
        $namespaceOptions = $this->getMock('HtSettingsModule\Options\NamespaceOptionsInterface');
        $namespaceOptions->expects($this->once())
            ->method('getHydrator')
            ->will($this->returnValue('some_hydrator'));

        $hydrators->expects($this->once())
            ->method('get')
            ->with('some_hydrator')
            ->will($this->returnValue($hydrator));
        $hydrators->expects($this->once())
            ->method('has')
            ->will($this->returnValue(true));

        $options->expects($this->once())
            ->method('getNamespaceOptions')
            ->with('plugin')
            ->will($this->returnValue($namespaceOptions));

        $this->assertEquals($hydrator, $namespaceHydratorProvider->getHydrator('plugin'));
    }

    public function testGetHydratorFromClassName()
    {
        $options = $this->getMock('HtSettingsModule\Options\ModuleOptionsInterface');
        $hydrators = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $namespaceHydratorProvider = new NamespaceHydratorProvider(
            $hydrators,
            $options
        );

        $hydrator = $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface');
        $namespaceOptions = $this->getMock('HtSettingsModule\Options\NamespaceOptionsInterface');
        $namespaceOptions->expects($this->once())
            ->method('getHydrator')
            ->will($this->returnValue('Zend\Stdlib\Hydrator\ClassMethods'));

        $hydrators->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $options->expects($this->once())
            ->method('getNamespaceOptions')
            ->with('plugin')
            ->will($this->returnValue($namespaceOptions));

        $this->assertInstanceOf('Zend\Stdlib\Hydrator\ClassMethods', $namespaceHydratorProvider->getHydrator('plugin'));        
    }

    public function testGetExceptionWithNoHydrator()
    {
        $options = $this->getMock('HtSettingsModule\Options\ModuleOptionsInterface');
        $hydrators = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');

        $namespaceHydratorProvider = new NamespaceHydratorProvider(
            $hydrators,
            $options
        );

        $hydrator = $this->getMock('Zend\Stdlib\Hydrator\HydratorInterface');
        $namespaceOptions = $this->getMock('HtSettingsModule\Options\NamespaceOptionsInterface');
        $namespaceOptions->expects($this->once())
            ->method('getHydrator')
            ->will($this->returnValue('ClassMethods'));

        $hydrators->expects($this->once())
            ->method('has')
            ->will($this->returnValue(false));

        $options->expects($this->once())
            ->method('getNamespaceOptions')
            ->with('plugin')
            ->will($this->returnValue($namespaceOptions));

        $this->setExpectedException('HtSettingsModule\Exception\RuntimeException');
        $namespaceHydratorProvider->getHydrator('plugin');         
    }
}
