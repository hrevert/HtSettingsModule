<?php
namespace HtSettingsModule\Manager;

interface SettingsManagerInterface
{
    /**
     * Gets settings of a namespace
     *
     * @param  string $namespace
     * @return object
     */
    public function getSettings($namespace);

    /**
     * Gets settings in array format
     *
     * @param  string $namespace
     * @return array
     */
    public function getSettingsArray($namespace);

    /**
     * Saves settings
     *
     * @param  object      $settings
     * @param  string|null $namespace Optional, but recommnded to pass. If not provided, it tries to detect itself
     * @return void
     */
    public function save($settings, $namespace = null);

    /**
     * Saves parameter of settings
     *
     * @param  string $namespace
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function saveParameter($namespace, $name, $value);
}
