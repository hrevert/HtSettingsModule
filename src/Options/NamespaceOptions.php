<?php
namespace HtSettingsModule\Options;

use Zend\Stdlib\AbstractOptions;
use HtSettingsModule\Exception;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Stdlib\Hydrator;
use ArrayObject;

class NamespaceOptions extends AbstractOptions implements NamespaceOptionsInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var object
     */
    protected $entityPrototype;

    /**
     * @var string|HydratorInterface      Hydrator of namespace entity for converting array to namespace entity
     */
    protected $hydrator;

    /**
     * Sets name of namespace
     *
     * @param  string $name
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
     * Sets entity class of namespace entity
     *
     * @param  string $entityClass
     * @return self
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Sets entity prototype of namespace entity
     *
     * @param  object $entityPrototype
     * @return self
     */
    public function setEntityPrototype($entityPrototype)
    {
        if (!is_object($entityPrototype)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be an object, %s provided instead',
                    __METHOD__,
                    is_object($entityPrototype) ? get_class($entityPrototype) : gettype($entityPrototype)
                )
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
        if (!$this->entityPrototype) {
            if ($this->getEntityClass()) {
                $entityClass = $this->getEntityClass();
                $this->entityPrototype = new $entityClass;
            } else {
                $this->entityPrototype = new ArrayObject;
            }
        }

        return $this->entityPrototype;
    }

    /**
     * Gets entity class of namespace
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Sets hydrator of namespace entity for converting array to namespace entity
     *
     * @param  HydratorInterface|string $hydrator
     * @return self
     */
    public function setHydrator($hydrator)
    {
        if (!is_string($hydrator) && !$hydrator instanceof HydratorInterface) {
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
        if ($this->hydrator === null) {
            if ($this->getEntityPrototype() instanceof ArrayObject) {
                $hydrator = new Hydrator\ArraySerializable;
            } else {
                $hydrator = new Hydrator\ClassMethods;
            }
            $this->hydrator = $hydrator;
        }

        return $this->hydrator;
    }
}
