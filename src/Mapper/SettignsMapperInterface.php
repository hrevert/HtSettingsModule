<?php
namespace HtSettingsModule\Mapper;

interface SettignsMapperInterface
{
    /**
     * Gets rows of a namespace
     *
     * @param string $namespace
     * @return array|\Traversable
     */
    public function findByNamespace($namespace);
}
