<?php
namespace HtSettingsModule\Manager;

use HtSettingsModule\Service\SettingsProviderInterface;
use HtSettingsModule\Service\SettingsServiceInterface;

/**
 * Unified interface to retrieving and saving settings
 */
class SettingsManager implements SettingsManagerInterface
{
    /**
     * @var SettingsProviderInterface
     */
    protected $settingsProvider;

    /**
     * @var SettingsServiceInterface
     */
    protected $settingsService;

    /**
     * Constructor
     *
     * @param SettingsProviderInterface $settingsProvider
     * @param SettingsServiceInterface  $settingsService
     */
    public function __construct(SettingsProviderInterface $settingsProvider, SettingsServiceInterface $settingsService)
    {
        $this->settingsProvider = $settingsProvider;
        $this->settingsService  = $settingsService;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettings($namespace)
    {
        return $this->settingsProvider->getSettings($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsArray($namespace)
    {
        return $this->settingsProvider->getSettingsArray($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function save($settings, $namespace = null)
    {
        $this->settingsService->save($settings, $namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function saveParameter($namespace, $name, $value)
    {
        $this->settingsService->saveParameter($namespace, $name, $value);
    }
}
