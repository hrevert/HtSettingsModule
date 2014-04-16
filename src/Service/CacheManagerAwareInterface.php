<?php
namespace HtSettingsModule\Service;

interface CacheManagerAwareInterface
{
    /**
     * Sets cacheManager
     *
     * @param  CacheManagerInterface $cacheManager
     * @return self
     */
    public function setCacheManager(CacheManagerInterface $cacheManager);
    
    /**
     * Gets cacheManager
     *
     * @return CacheManagerInterface
     */
    public function getCacheManager();        
}
