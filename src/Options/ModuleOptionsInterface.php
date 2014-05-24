<?php
namespace HtSettingsModule\Options;

interface ModuleOptionsInterface
{
    /**
     * Gets options of cache
     *
     * @return CacheOptionsInterface
     */
    public function getCacheOptions();

    /**
     * Gets options for available namespaces
     *
     * @return array
     */
    public function getNamespaces();

    /**
     * Gets options for a namespace
     *
     * @param  string                    $namespace
     * @return NamespaceOptionsInterface
     */
    public function getNamespaceOptions($namespace);
}
