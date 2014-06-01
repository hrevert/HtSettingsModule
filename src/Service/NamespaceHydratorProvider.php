<?php
namespace HtSettingsModule\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use HtSettingsModule\Options\ModuleOptionsInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use HtSettingsModule\Exception;

class NamespaceHydratorProvider implements NamespaceHydratorProviderInerface
{
    protected $hydrators;

    protected $options;

    public function __construct(ServiceLocatorInterface $hydrators, ModuleOptionsInterface $options)
    {
        $this->hydrators = $hydrators;
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function getHydrator($namespace)
    {
        $namespaceOptions = $this->options->getNamespaceOptions($namespace);
        $hydrator = $namespaceOptions->getHydrator();
        if ($hydrator instanceof HydratorInterface) {
            return $hydrator;
        }
        if (is_string($hydrator)) {
            if ($this->hydrators->has($hydrator)) {
                return $this->hydrators->get($hydrator);
            }
            if (class_exists($hydrator)) {
                $hydratorObject = new $hydrator;
                if ($hydratorObject instanceof HydratorInterface) {
                    return $hydratorObject;
                }
            }            
        }

        throw new Exception\RuntimeException(sprintf(
            'Hydrator of settings namespace, %s is neither a service or class name or instanceof Zend\Stdlib\Hydrator\HydratorInterface; %s provided instead',
            $namespace,
            is_object($hydrator) ? get_class($hydrator) : gettype($hydrator)
        ));
    }
}
