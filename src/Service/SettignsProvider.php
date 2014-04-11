<?php
namespace HtSettingsModule\Service;

use HtSettingsModule\Options\ModuleOptions;

class SettignsProvider implements SettingsProviderInterface
{
    /**
     * @var CacheManagerInterface
     */
    protected $cacheManager;

    /**
     * @var \HtSettingsModule\Mapper\SettignsMapperInterface
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
    public function __construct(ModuleOptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritDoc} 
     */
    public function getSettings($namespace)
    {
        if ($this->getCacheOptions()->isEnabled()) {
            if ($cacheManager->cacheExists($namespace)) {
                return $cacheManager->getCache($namespace);
            } else {
                $settings = $this->getSettingsFromRealSource($namespace);
                $cacheManager->createCache($namespace, $settings);
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
        $resultSet = $this->getSettingsMapper()->findByNamespace($namespace);
        $namespaceOptions = $this->options->getNamespaceOptions($namespace);
        $entity = clone($namespaceOptions->getEntityPrototype());
        $arrayData = [];
        foreach ($resultSet as $parameter) {
            $arrayData[$parameter->getName()] = $parameter->getValue();
        }
        if (!empty($arrayData)) {
            $hydrator = $namespaceOptions->getHydrator();
            $entiy = $hydrator->hydrate($arrayData, $entity);
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
     * Gets settingsMapper
     *
     * @return \HtSettingsModule\Mapper\SettignsMapperInterface
     */
    public function getSettingsMapper()
    {
        if (!$this->settingsMapper) {
            $this->settingsMapper = $this->getServiceLocator()->get('HtSettingsModule_SettingsMapper');
        }

        return $this->settingsMapper;
    }
}
