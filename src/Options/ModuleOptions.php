<?php
namespace HtSettingsModule\Options;

use Zend\Stdlib\AbstractOptions;
use HtSettingsModule\Exception;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface, DbOptionsInterface, StorageOptionsInterface
{
    /**
     * @var CacheOptionsInterface
     */
    protected $cacheOptions;

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * @var string|\Zend\Db\Sql\TableIdentifier
     */
    protected $settingsTable = 'settings';

    /**
     * @var string
     */
    protected $parameterEntityClass = 'HtSettingsModule\Entity\Parameter';

    /**
     * @var string  Path to store settings if we want to store settings in xml, json etc.
     */
    protected $storagePath = 'data/settings';

    /**
     * Sets options of cache
     *
     * @param  array|CacheOptionsInterface $cacheOptions
     * @return self
     */
    public function setCacheOptions($cacheOptions)
    {
        if ($cacheOptions instanceof CacheOptionsInterface) {
            $this->cacheOptions = $cacheOptions;
        } elseif (is_array($cacheOptions)) {
            $this->cacheOptions = new CacheOptions($cacheOptions);
        } else {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be array or an instance of HtSettingsModule\Options\CacheOptionsInterface, %s provided instead',
                    __METHOD__,
                    is_object($cacheOptions) ? get_class($cacheOptions) : gettype($cacheOptions)
                )
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheOptions()
    {
        if (!$this->cacheOptions instanceof CacheOptionsInterface) {
            $this->cacheOptions = new CacheOptions;
        }

        return $this->cacheOptions;
    }

    /**
     * Sets namespaces
     *
     * @param  array $namespaces
     * @return void
     */
    public function setNamespaces(array $namespaces)
    {
        $this->namespaces = [];
        foreach ($namespaces as $namespace => $namespaceOptions) {
            $this->addNamespace($namespaceOptions, $namespace);
        }
    }

    /**
     * Adds new namespace
     *
     * @param  array|NamespaceOptionsInterface $namespaceOptions
     * @param  string|null                     $namespace
     * @return void
     */
    public function addNamespace($namespaceOptions, $namespace = null)
    {
        if (!$namespaceOptions instanceof NamespaceOptionsInterface) {
            if (is_array($namespaceOptions)) {
                $namespaceOptions = new NamespaceOptions($namespaceOptions);
                if ($namespace !== null) {
                    $namespaceOptions->setName($namespace);
                }
            } else {
                 throw new Exception\InvalidArgumentException(
                    sprintf(
                        '%s expects parameter 1 to be array or an instance of HtSettingsModule\Options\NamespaceOptionsInterface, %s provided instead',
                        __METHOD__,
                        is_object($namespaceOptions) ? get_class($namespaceOptions) : gettype($namespaceOptions)
                    )
                );
            }
        } else {
            if (!$namespaceOptions->getName() && $namespace) {
                $namespaceOptions->setName($namespace);
            }
        }
        if ($namespace === null) {
            $namespace = $namespaceOptions->getName();
        }
        $this->namespaces[$namespace] = $namespaceOptions;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaceOptions($namespace)
    {
        if (!isset($this->namespaces[$namespace])) {
            throw new Exception\InvalidArgumentException(
                sprintf('Options Namespace, "%s" does not exist!', $namespace)
            );
        }

        return $this->namespaces[$namespace];
    }

    /**
     * {@inheritDoc}
     */
    public function hasNamespace($namespace)
    {
        return isset($this->namespaces[$namespace]);
    }

    /**
     * Sets table name of settings
     *
     * @param  string|\Zend\Db\Sql\TableIdentifier $settingsTable
     * @return self
     */
    public function setSettingsTable($settingsTable)
    {
        $this->settingsTable = $settingsTable;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsTable()
    {
        return $this->settingsTable;
    }

    /**
     * {@inheritDoc}
     */
    public function getParameterEntityClass()
    {
        return $this->parameterEntityClass;
    }

    /**
     * Sets parameter entity class
     *
     * @param  string $parameterEntityClass
     * @return self
     */
    public function setParameterEntityClass($parameterEntityClass)
    {
        $this->parameterEntityClass = $parameterEntityClass;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * Sets storagePath
     *
     * @param  string                         $storagePath
     * @throws Exception\InvalidPathException
     * @return self
     */
    public function setStoragePath($storagePath)
    {
        $this->storagePath = $storagePath;

        return $this;
    }
}
