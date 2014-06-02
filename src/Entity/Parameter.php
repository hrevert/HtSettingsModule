<?php
namespace HtSettingsModule\Entity;

class Parameter implements ParameterInterface
{
    /**
     * Parameter id.
     *
     * @var int
     */
    protected $id;

    /**
     * Parameter settings namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Parameter name.
     *
     * @var string
     */
    protected $name;

    /**
     * Parameter value.
     *
     * @var string
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string|null $namespace
     * @param string|null $name
     * @param mixed|null  $value
     */
    public function __construct($namespace = null, $name = null, $value = null)
    {
        if ($namespace !== null) {
            $this->setNamespace($namespace);
        }
        if ($name !== null) {
            $this->setName($name);
        }
        if ($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * {@inheritdoc}
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function create($namespace, $name, $value = null, $id = null)
    {
        $parameter = new static;
        $parameter->setNamespace($namespace);
        $parameter->setName($name);
        $parameter->setValue($value);
        $parameter->setId($id);

        return $parameter;
    }
}
