<?php
namespace HtSettingsModuleTest\Entity;

use HtSettingsModule\Entity\Parameter;

class ParameterTest extends \PHPUnit_Framework_TestCase
{
    public function testSettersAndGetters()
    {
        $parameter = new Parameter('theme', 'color', 'red');
        $this->assertEquals('theme', $parameter->getNamespace());
        $this->assertEquals('color', $parameter->getName());
        $this->assertEquals('red', $parameter->getValue());
    }

    public function testCreate()
    {
        $parameter = Parameter::create('theme', 'color', 'red');
        $this->assertEquals('theme', $parameter->getNamespace());
        $this->assertEquals('color', $parameter->getName());
        $this->assertEquals('red', $parameter->getValue());
    }
}
