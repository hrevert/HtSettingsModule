<?php
namespace HtSettingsModule\Service;

use HtSettingsModule\Options\ModuleOptions;
use HtSettingsModule\Mapper\SettignsMapperInterface;

class SettignsProvider implements SettingsProviderInterface
{
    /**
     * @var CacheManagerInterface
     */
    protected $cacheManager;

    /**
     * @var SettignsMapperInterface
     */
    protected $settingsMapper;

    /**
     * @var ModuleOptionsInterface
     */
    protected $options;

    /**
     * Constructor
     *
     * @param ModuleOptionsInterface $options 
     */
    public function __construct(ModuleOptionsInterface $options, SettignsMapperInterface $settingsMapper)
    {
        $this->options = $options;
        $this->settingsMapper = $settingsMapper;
    }

    /**
     * {@inheritDoc} 
     */
    public function getSettings($namespace)
    {
        if ($this->getCacheOptions()->isEnabled()) {
            if ($this->cacheManager->cacheExists($namespace)) {
                return $this->cacheManager->getCache($namespace);
            } else {
                $settings = $this->getSettingsFromRealSource($namespace);
                $this->cacheManager->createCache($namespace, $settings);
                return $settings;                
            }
        }

        return $this->getSettingsFromRealSource($namespace);
    }

    /**
     * Gets settings from real source, most probably from database
     *
     * @param string $namespace
     * @return object
     */
    protected function getSettingsFromRealSource($namespace)
    {
        $resultSet = $this->settingsMapper->findByNamespace($namespace);
        $namespaceOptions = $this->options->getNamespaceOptions($namespace);
        $entity = clone($namespaceOptions->getEntityPrototype());
        $arrayData = [];
        foreach ($resultSet as $parameter) {
            $arrayData[$parameter->getName()] = $parameter->getValue();
        }
        if (!empty($arrayData)) {
            $hydrator = $namespaceOptions->getHydrator();
            $entity = $hydrator->hydrate($arrayData, $entity);
        }

        return $entity;
    }

    /**
     * Gets cacheOptions
     *
     * @return \HtSettingsModule\Options\CacheOptionsInterface
     */
    public function getCacheOptions()
    {
        return $this->options->getCacheOptions();
    }

    /**
     * Sets cacheManager
     *
     * @param CacheManagerInterface $cacheManager
     * @return self
     */
    public function setCacheManager(CacheManagerInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;

        return $this;
    }
}
