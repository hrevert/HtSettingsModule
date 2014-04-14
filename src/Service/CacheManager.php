<?php
namespace HtSettingsModule\Service;

use HtSettingsModule\Options\CacheOptionsInterface;

class CacheManager implements CacheManagerInterface
{
    /**
     * @var CacheOptionsInterface
     */
    protected $cacheOptions;

    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * Constructor
     *
     * @param CacheOptionsInterface $cacheOptions
     *
     */
    public function __construct(CacheOptionsInterface $cacheOptions)
    {
        $this->cacheOptions = $cacheOptions;
    }

    /**
     * Gets cache adapter of a settings namespace
     *
     * @param  string                                    $namespace
     * @return \Zend\Cache\Storage\StorageInterface|null
     */
    public function getCacheAdapter($namespace)
    {
        // caching is not enabled for a namespace
        if (!$this->isCacheable($namespace)) {
            return null;
        }

        // user wants to implements different adapter for different namespaces
        if (is_array($this->cacheOptions->getAdapter())) {
            // checks if adapter of a namespace exists
            if (!isset($this->cacheOptions->getAdapter()[$namespace])) {
                return null;
            }
            $adapter =  $this->cacheOptions->getAdapter()[$namespace];
        } else {
            // user want to implements one adapter for all namespaces
            $adapter = $this->cacheOptions->getAdapter();
        }

        if (is_object($adapter)) {
            return $adapter;
        }
        if ($this->getServiceLocator()->has($adapter)) {
            return $this->getServiceLocator()->get($adapter);
        }

        return new $adapter;
    }

    /**
     * {@inheritDoc}
     */
    public function settingsExists($namespace)
    {
        $cacheAdapter = $this->getCacheAdapter($namespace);
        if ($cacheAdapter === null) {
            return false;
        }

        return $cacheAdapter->hasItem($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function get($namespace)
    {
        if (!$this->settingsExists($namespace)) {
            return null;
        }
        $cacheAdapter = $this->getCacheAdapter($namespace);

        return $cacheAdapter->getItem($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function create($namespace, $settings)
    {
       if (!$this->isCacheable($namespace)) {
           return;
       }

       $cacheAdapter = $this->getCacheAdapter($namespace);
       $cacheAdapter->addItem($namespace, $settings);
    }

    /**
     * Checks if settings of a namespace can be cached
     *
     * @param  string $namespace
     * @return bool
     */
    public function isCacheable($namespace)
    {
        if (!$this->cacheOptions->isEnabled()) {
            return false;
        }

        $namespaces = $this->cacheOptions->getNamespaces();
        // user has enabled caching but has not specified namespaces to cache,
        // so we cache all the namespaces
        if (empty($namespaces)) {
            return true;
        }

        // user has enabled caching but has specified certain namespaces to cache,
        // so we cache only the specified namespaces
        return in_array($namespace, $namespaces);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($namespace)
    {
        if ($this->settingsExists($namespace)) {
            $cacheAdapter = $this->getCacheAdapter($namespace);
            $cacheAdapter->removeItem($namespace);
        }
    }
}
