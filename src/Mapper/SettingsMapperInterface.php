<?php
namespace HtSettingsModule\Mapper;

interface SettingsMapperInterface
{
    /**
     * Gets rows of a namespace
     *
     * @param  string             $namespace
     * @return array|\Traversable
     */
    public function findByNamespace($namespace);

    public function insertParameter($parameter);
}
