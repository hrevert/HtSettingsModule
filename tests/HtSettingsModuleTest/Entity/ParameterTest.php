<?php
namespace HtSettingsModuleTest\Entity;

use HtSettingsModule\Entity\Parameter;

class ParameterTest extends \PHPUnit_Framework_TestCase
{
    public function testSettersAndGetters()
    {
        $entity = new Parameter('theme', 'color', 'red');
        $entity->setId(56);
        $this->assertEquals(56, $entity->getId());
        $this->assertEquals('theme', $entity->getNamespace());
        $this->assertEquals('color', $entity->getName());
        $this->assertEquals('red', $entity->getValue());
    }
}
