<?php
namespace HtSettingsModule\Service;

use HtSettingsModule\Options\ModuleOptionsInterface;
use HtSettingsModule\Mapper\SettingsMapperInterface;
use HtSettingsModule\Exception;

class SettingsService implements SettingsServiceInterface
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
     * Constructor
     *
     * @param ModuleOptionsInterface $options
     * @param SettingsMapperInterface $settingsMapper
     */
    public function __construct(ModuleOptionsInterface $options, SettingsMapperInterface $settingsMapper)
    {
        $this->options = $options;
        $this->settingsMapper = $settingsMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function save($settings, $namespace = null)
    {
        if ($namespace !== null) {
            $namespaceOptions = $this->options->getNamespaceOptions($namespace);
        } else {
            $namespaceOptions = $this->detectNamespace($settings);
        }

        $arrayData = $namespaceOptions->getHydrator()->extract($settings);
        foreach ($arrayData as $name => $value) {
            $parameter = $this->settingsMapper->findParameter($namespaceOptions->getName(), $name);
            if ($parameter) {
                if ($parameter->getValue() != $value) {
                    $parameter->setValue($value);
                    $this->settingsMapper->updateParameter($parameter);                    
                }
            } else {
                $parameterEntityClass = $this->options->getParameterEntityClass();
                $parameter = new $parameterEntityClass($namespaceOptions->getName(), $name, $value);
                $this->settingsMapper->insertParameter($parameter);
            }
            
        }
    }

    /**
     * Tries to detect namespace from modal class
     *
     * @param object $settings
     * @return \HtSettingsModule\Options\NamespaceOptionsInterface
     */
    protected function detectNamespace($settings)
    {
        foreach ($this->options->getNamespaces() as $namespaceOptions) {
            $namespaceEntityClass = $namespace->getEntityClass();
            if ($settings instanceof $namespaceEntityClass) {
                return $namespaceOptions;
            }
        }

        throw new Exception\InvalidArgumentException('Unknows Settings namespace');
    }
}
