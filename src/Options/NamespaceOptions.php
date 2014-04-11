<?php
namespace HtSettingsModule\Options;

use Zend\Stdlib\AbstractOptions;
use HtSettingsModule\Exception
use Zend\Stdlib\Hydrator;

class NamespaceOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var object
     */
    protected $entityPrototype;

    /**
     * @var Hydrator\HydratorInterface      Hydrator of namespace entity for converting array to namespace entity
     */
    protected $hydrator;

    /**
     * Sets name of namespace
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets entity prototype of namespace entity
     *
     * @param object $entityPrototype
     * @return self
     */
    public function setEntityPrototype($entityPrototype)
    {
        if (!is_object($entityPrototype)) {
            throw new Exception\InvalidArgumentException(
                sprintf('%s expects parameter 1 to be object, %s provided instead', __METHOD__, gettype($entityPrototype))
            );
        }
        $this->entityPrototype = $entityPrototype;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEntityPrototype()
    {
        if (!is_object($this->entityPrototype)) {
            throw new Exception\RuntimeException('Entity prototype not set!');            
        }
        return $this->entityPrototype;
    }

    /**
     * Sets entity prototype of namespace entity from entity class
     *
     * @param string $entityClass
     * @return self
     */
    public function setEntityClass($entityClass)
    {
        return $this->setEntityPrototype(new $entityClass);
    }

    /**
     * Sets hydrator of namespace entity for converting array to namespace entity
     *
     * @param \Zend\Stdlib\Hydrator\HydratorInterface|string $hydrator
     * @return self
     */
    public function setHydrator($hydrator)
    {
        if (is_string($hydrator)) {
            $hydrator = new $hydrator;
        }
        if (!is_object($hydrator) || !$hydrator instanceof Hydrator\HydratorInterface) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be an object of instance Zend\Stdlib\Hydrator\HydratorInterface or string, %s provided instead',
                    __METHOD__, 
                    is_object($hydrator) ? get_class($hydrator) : gettype($hydrator)
                )
            ); 
        }
        $this->hydrator = $hydrator;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getHydrator()
    {
        if (!$this->hydrator instanceof Hydrator\HydratorInterface) {
            $hydrator = new Hydrator\ClassMethod;
        }

        return $this->hydrator;
    }
}
