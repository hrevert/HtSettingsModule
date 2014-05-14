<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator\HydratorPluginManager;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new ModuleOptionsFactory;
        $serviceManager->setService('Config', ['ht_settings' => []]);
        $this->assertInstanceOf('HtSettingsModule\Options\ModuleOptions', $factory->createService($serviceManager));
    }

    public function testReplaceHydratorFromServiceName()
    {
        $serviceManager = new ServiceManager;
        $factory = new ModuleOptionsFactory;
        $hydrator = new ClassMethods;
        $hydrators = new HydratorPluginManager();
        $hydrators->setService('ThemeHydrator', $hydrator);
        $serviceManager->setService('HydratorManager', $hydrators);;
        $config = [
            'ht_settings' => [
                'namespaces' => [
                    'theme' => [
                        'hydrator' => 'ThemeHydrator',
                    ]
                ]
            ]
        ];
        $serviceManager->setService('Config', $config); 
        $options = $factory->createService($serviceManager); 
        $this->assertEquals($hydrator, $options->getNamespaceOptions('theme')->getHydrator());      
    }
}
