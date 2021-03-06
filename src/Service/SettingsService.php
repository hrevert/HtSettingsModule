<?php
namespace HtSettingsModule\Service;

use HtSettingsModule\Options\ModuleOptionsInterface;
use HtSettingsModule\Mapper\SettingsMapperInterface;
use HtSettingsModule\Exception;
use ZfcBase\EventManager\EventProvider;

class SettingsService extends EventProvider implements SettingsServiceInterface, CacheManagerAwareInterface
{
    /**
     * @var ModuleOptionsInterface
     */
    protected $options;

    /**
     * @var SettingsMapperInterface
     */
    protected $settingsMapper;

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
    public function save($settings, $namespace = null)
    {
        if ($namespace === null) {
            $namespace = $this->detectNamespace($settings);
        }

        $namespaceParameters = $this->settingsMapper->findByNamespace($namespace);
        $hydrator = $this->namespaceHydratorProvider->getHydrator($namespace);
        $arrayData = $hydrator->extract($settings);
        $eventParams = ['settings' => $settings, 'array_data' => $arrayData, 'namespace' => $namespace];
        $this->getEventManager()->trigger(__FUNCTION__, $this, $eventParams);
        foreach ($arrayData as $name => $value) {
            $parameter = $this->findParameter($namespace, $name, $namespaceParameters);
            if ($parameter !== null) {
                if ($parameter->getValue() != $value) {
                    $parameter->setValue($value);
                    $this->getEventManager()->trigger('updateParameter', $this, ['parameter' => $parameter]);
                    $this->settingsMapper->updateParameter($parameter);
                }
            } else {
                $parameterEntityClass = $this->options->getParameterEntityClass();
                $parameter = $parameterEntityClass::create($namespace, $name, $value);
                $this->getEventManager()->trigger('insertParameter', $this, ['parameter' => $parameter]);
                $this->settingsMapper->insertParameter($parameter);
            }

        }

        if ($this->options->getCacheOptions()->isEnabled()) {
            $this->getCacheManager()->delete($namespace);
            $this->getCacheManager()->create($namespace, $settings);
        }

        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $eventParams);
    }

    /**
     * {@inheritDoc}
     */
    public function saveParameter($namespace, $name, $value)
    {
        $eventParams = ['namespace' => $namespace, 'name' => $name, 'value' => $value];
        $this->getEventManager()->trigger(__FUNCTION__, $this, $eventParams);
        if ($this->options->getCacheOptions()->isEnabled()) {
            $this->getCacheManager()->delete($namespace);
        }
        $parameter = $this->settingsMapper->findParameter($namespace, $name);
        if ($parameter) {
            if ($parameter->getValue() != $value) {
                $parameter->setValue($value);
                $this->getEventManager()->trigger('updateParameter', $this, ['parameter' => $parameter]);
                $this->settingsMapper->updateParameter($parameter);
            }
        } else {
            $parameterEntityClass = $this->options->getParameterEntityClass();
            $parameter = new $parameterEntityClass;
            $parameter->setNamespace($namespace);
            $parameter->setName($name);
            $parameter->setValue($value);
            $this->getEventManager()->trigger('insertParameter', $this, ['parameter' => $parameter]);
            $this->settingsMapper->insertParameter($parameter);
        }
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, $eventParams);
    }

    /**
     * Finds a namespace parameter from all the stored namespaces parameters
     *
     * @param  string                                           $namespace
     * @param  string                                           $name
     * @param  array                                            $namespaceParameters
     * @return \HtSettingsModule\Entity\ParameterInterface|null
     */
    protected function findParameter($namespace, $name, $namespaceParameters)
    {
        foreach ($namespaceParameters as $namespaceParameter) {
            if ($namespaceParameter->getNamespace() === $namespace && $namespaceParameter->getName() === $name) {
                return $namespaceParameter;
            }
        }

        return null;
    }

    /**
     * Tries to detect namespace from modal class
     *
     * @param  object                             $settings
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    protected function detectNamespace($settings)
    {
        foreach ($this->options->getNamespaces() as $namespaceOptions) {
            $namespaceEntityClass = $namespaceOptions->getEntityClass();
            if ($settings instanceof $namespaceEntityClass) {
                return $namespaceOptions->getName();
            }
        }

        throw new Exception\InvalidArgumentException('Unknown Settings namespace');
    }
}
