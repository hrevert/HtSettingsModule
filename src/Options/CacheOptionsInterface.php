<?php
namespace HtSettingsModule\Options;

interface CacheOptionsInterface
{
    /**
     * Checks if cache is enabled
     *
     * @return bool
     */    
    public function isEnabled(); 

    /**
     * Gets cache adapter of one or more namespaces
     *
     * @return string|\Zend\Cache\Storage\Adapter\StorageInterface|array
     */
    public function getAdapter();

    /**
     * Gets namespaces that can be cached
     *
     * @return array
     */
    public function getNamespaces();
}
