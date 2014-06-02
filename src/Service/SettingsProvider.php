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

    /**
     * @var NamespaceHydratorProviderInerface
     */
    protected $namespaceHydratorProvider;

    use CacheManagerAwareTrait;

    /**
     * Constructor
     *
     * @param ModuleOptionsInterface            $options
     * @param SettingsMapperInterface           $settingsMapper
     * @param NamespaceHydratorProviderInerface $namespaceHydratorProvider
     */
    public function __construct(
        ModuleOptionsInterface $options,
        SettingsMapperInterface $settingsMapper,
        NamespaceHydratorProviderInerface $namespaceHydratorProvider
    )
    {
        $this->options = $options;
        $this->settingsMapper = $settingsMapper;
        $this->namespaceHydratorProvider = $namespaceHydratorProvider;
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
     * {@inheritDoc}
     */
    public function getSettingsArray($namespace)
    {
        $resultSet = $this->settingsMapper->findByNamespace($namespace);
        $arraySettings = [];
        foreach ($resultSet as $parameter) {
            $arraySettings[$parameter->getName()] = $parameter->getValue();
        }

        return $arraySettings;
    }

    /**
     * Gets settings from real source, most probably from database
     *
     * @param  string $namespace
     * @return object
     */
    protected function getSettingsFromRealSource($namespace)
    {
        $arraySettings = $this->getSettingsArray($namespace);
        $namespaceOptions = $this->options->getNamespaceOptions($namespace);
        $entity = clone($namespaceOptions->getEntityPrototype());
        if (!empty($arraySettings)) {
            $hydrator = $this->namespaceHydratorProvider->getHydrator($namespace);
            $entity = $hydrator->hydrate($arraySettings, $entity);
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
