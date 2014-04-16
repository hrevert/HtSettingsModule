<?php
namespace HtSettingsModule\Service;

trait CacheManagerAwareTrait
{
    /**
     * @var CacheManagerInterface
     */
    protected $cacheManager;

    /**
     * Sets cacheManager
     *
     * @param  CacheManagerInterface $cacheManager
     * @return self
     */
    public function setCacheManager(CacheManagerInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;

        return $this;
    }

    /**
     * Gets cacheManager
     *
     * @return CacheManagerInterface
     */
    public function getCacheManager()
    {
        return $this->cacheManager;
    }    
}
