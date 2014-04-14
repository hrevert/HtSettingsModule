<?php
namespace HtSettingsModule\Service;

interface SettingsServiceInterface
{
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
     * @param  string $value
     * @return void
     */
    public function saveParameter($namespace, $name, $value);
}
