<?php
namespace HtSettingsModule\Service;

interface SettingsProviderInterface
{
    /**
     * Gets settings in array format
     *
     * @param  string $namespace
     * @return array
     */
    public function getSettingsArray($namespace);

    /**
     * Gets settings of a namespace
     *
     * @param  string $namespace
     * @return object
     */
    public function getSettings($namespace);
}
