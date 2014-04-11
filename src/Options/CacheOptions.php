<?php
namespace HtSettingsModule\Options;

use Zend\Stdlib\AbstractOptions;
use Zend\Cache\Storage\Adapter\Memory;

class CacheOptions extends AbstractOptions implements CacheOptionsInterface
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var string|\Zend\Cache\Storage\Adapter\StorageInterface|array|null
     */
    protected $adapter;

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * Enables or disables cache feature
     *
     * @param bool $flag
     * @return self
     */
    public function setEnabled($flag = true)
    {
        $this->enabled = (bool) $flag;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Sets cache adapter for caching
     *
     * @param string|\Zend\Cache\Storage\Adapter\StorageInterface $adapter
     * @return self
     */
    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAdapter()
    {
        if (!$this->adapter) {
            $this->adapter = new Memory;
        }

        return $this->adapter;
    }

    /**
     * {@inheritDoc}
     */
    public function setNamespaces(array $namespaces)
    {
        $this->namespaces = $namespaces;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }
}
