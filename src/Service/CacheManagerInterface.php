<?php
namespace HtSettingsModule\Service;

interface CacheManagerInterface
{
    /**
     * Checks if cache of settings of a namespace exists
     *
     * @param string $namespace
     * @retutn bool
     */
    public function cacheExists($namespace);

    /**
     * Gets cache of settings of a namespace
     *
     * @param string $namespace
     * @retutn mixed
     */
    public function getCache($namespace);

    /**
     * Creates new cache of settings of a namespace
     *
     * @param string $namespace
     * @return mixed $settigns
     */
    public function createCache($namespace, $settigns);
}
