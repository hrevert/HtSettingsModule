<?php
namespace HtSettingsModule\Service;

use HtSettingsModule\Mapper\SettingsMapperInterface;
use HtSettingsModule\Options\ModuleOptionsInterface;

class SettingsProvider implements SettingsProviderInterface, CacheManagerAwareInterface
{
    /**
     * @var SettingsMapperInterface
     */
    protected $settingsMapper;

    /**
     * @var ModuleOptionsInterface
     */
    protected $options;

    use CacheManagerAwareTrait;

    /**
     * Constructor
     *
     * @param ModuleOptionsInterface $options
     */
    public function __construct(ModuleOptionsInterface $options, SettingsMapperInterface $settingsMapper)
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
            if ($this->cacheManager->settingsExists($namespace)) {
                return $this->cacheManager->get($namespace);
            }
            $settings = $this->getSettingsFromRealSource($namespace);
            $this->cacheManager->create($namespace, $settings);

            return $settings;
        }

        return $this->getSettingsFromRealSource($namespace);
    }

    /**
     * Gets settings from real source, most probably from database
     *
     * @param  string $namespace
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
}
