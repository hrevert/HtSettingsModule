<?php
namespace HtSettingsModule\Options;

interface StorageOptionsInterface
{
    /**
     * Gets Path to store settings if we want to store settings in xml, json etc.
     *
     * @return string
     */
    public function getStoragePath();    
}
