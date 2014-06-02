<?php
namespace HtSettingsModule\Entity;

interface ParameterInterface
{
    /**
     * Sets Parameter id
     *
     * @param  int  $id
     * @return self
     */
    public function setId($id);

    /**
     * Gets Parameter id
     *
     * @return int
     */
    public function getId();

    /**
     * Get settings namespace.
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Set settings namespace.
     *
     * @param string $namespace
     */
    public function setNamespace($namespace);

    /**
     * Get parameter name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set parameter name.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get parameter value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set parameter value.
     *
     * @param mixed $value
     */
    public function setValue($value);

    /**
     * Creates a new entity
     *
     * @param  string $namespace
     * @param  string $name
     * @param  mixed  $value
     * @return static
     */
    public static function create($namespace, $name, $value);
}
