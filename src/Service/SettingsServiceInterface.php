<?php
namespace HtSettingsModule\Service;

interface SettingsServiceInterface
{
    /**
     * Saves settings
     *
     * @param object $settings
     * @param string|null $namespace
     */
    public function save($settings, $namespace = null);
}
