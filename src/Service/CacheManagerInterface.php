<?php
namespace HtSettingsModule\Service;

interface CacheManagerInterface
{
    /**
     * Checks if cache of settings of a namespace exists
     *
     * @param  string $namespace
     * @return bool
     */
    public function settingsExists($namespace);

    /**
     * Gets cache of settings of a namespace
     *
     * @param  string $namespace
     * @return object
     */
    public function get($namespace);

    /**
     * Creates new cache of settings of a namespace
     *
     * @param  string $namespace
     * @param  object $settings
     * @return void
     */
    public function create($namespace, $settings);

    /**
     * Deletes cache of settings of a namespace (if exists)
     *
     * @param  string $namespace
     * @return void
     */
    public function delete($namespace);
}
