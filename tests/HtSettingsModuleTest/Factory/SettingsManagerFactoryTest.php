<?php
namespace HtSettingsModule\Factory;

use HtSettingsModule\Factory\SettingsManagerFactory;
use Zend\ServiceManager\ServiceManager;

class SettingsManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new SettingsManagerFactory;
        $serviceManager->setService('HtSettingsModule\Service\SettingsProvider', $this->getMock('HtSettingsModule\Service\SettingsProviderInterface'));
        $serviceManager->setService('HtSettingsModule\Service\SettingsService', $this->getMock('HtSettingsModule\Service\SettingsServiceInterface'));
        $this->assertInstanceOf('HtSettingsModule\Manager\SettingsManager', $factory->createService($serviceManager));
    }
}
