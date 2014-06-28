<?php
namespace HtSettingsModuleTest\Entity;

use HtSettingsModule\Entity\IdAwareParameter;

class IdAwareParameterTest extends \PHPUnit_Framework_TestCase
{
    public function testSetId()
    {
        $parameter = new IdAwareParameter;
        $parameter->setId(646);
        $this->assertEquals(646, $parameter->getId());
    }
}
