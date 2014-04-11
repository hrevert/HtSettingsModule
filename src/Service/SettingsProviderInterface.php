<?php
namespace HtSettingsModule\Service;

interface SettingsProviderInterface
{
    /**
     * Gets settings of a namespace
     *
     * @param string $namespace
     * @return mixed
     */
    public function getSettings($namespace);
}
