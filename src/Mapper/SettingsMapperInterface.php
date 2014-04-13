<?php
namespace HtSettingsModule\Mapper;

use HtSettingsModule\Entity\ParameterInterface;

interface SettingsMapperInterface
{
    /**
     * Gets rows of a namespace
     *
     * @param  string             $namespace
     * @return array|\Traversable
     */
    public function findByNamespace($namespace);

    /**
     * Insert new settings data
     *
     * @param  ParameterInterface             $parameter
     */
    public function insertParameter(ParameterInterface $parameter);

    /**
     * Updates one or more row
     *
     * @param  ParameterInterface             $parameter
     */
    public function updateParameter(ParameterInterface $parameter);

    /**
     * Removes a settings data
     *
     * @param  ParameterInterface             $parameter
     */
    public function deleteParameter(ParameterInterface $parameter);

    /**
     * Finds a parameter
     *
     * @param  ParameterInterface|string             $parameter
     */
    public function findParameter($parameter, $name = null);
}
