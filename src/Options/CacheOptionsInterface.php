<?php
namespace HtSettingsModule\Options;

interface CacheOptionsInterface
{
    /**
     * Enables or disables cache feature
     *
     * @param bool $flag
     * @return self
     */
    public function setEnabled($flag = true);

    /**
     * Checks if cache is enabled
     *
     * @return bool
     */    
    public function getEnabled(); 
}
