<?php
namespace HtSettingsModuleTest\Options;

use HtSettingsModule\Options\NamespaceOptions; 

class NamespaceOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDefaultEntityPrototype()
    {
        $options = new NamespaceOptions;
        $this->assertInstanceOf('ArrayObject', $options->getEntityPrototype());
    }

    public function testGetDefaultHydrator()
    {
        $options = new NamespaceOptions;
        $this->assertInstanceOf('Zend\Stdlib\Hydrator\ArraySerializable', $options->getHydrator());
        $options = new NamespaceOptions;
        $options->setEntityClass('stdClass');
        $this->assertInstanceOf('Zend\Stdlib\Hydrator\ClassMethods', $options->getHydrator());
    }
}
