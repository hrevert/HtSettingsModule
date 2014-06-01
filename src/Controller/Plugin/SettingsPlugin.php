<?php
namespace HtSettingsModule\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use HtSettingsModule\Manager\SettingsManagerInterface;

class SettingsPlugin extends AbstractPlugin
{
    /**
     * @var SettingsManagerInterface
     */
    protected $settingsManager;

    /**
     * Constructor
     *
     * @param SettingsManagerInterface $settingsProvider
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * Gets settings of a namespace if namespace is provided
     *
     * @param  string|null $namespace
     * @return object|self
     */
    public function __invoke($namespace = null)
    {
        if ($namespace === null) {
            return $this;
        }

        return $this->getSettings($namespace);
    }

    /**
     * Gets settings of a namespace
     *
     * @param  string $namespace
     * @return object
     */
    public function getSettings($namespace)
    {
        return $this->settingsManager->getSettings($namespace);
    }

    /**
     * Saves settings
     *
     * @param  object      $settings
     * @param  string|null $namespace
     * @return void
     */
    public function save($settings, $namespace = null)
    {
        $this->settingsManager->save($settings, $namespace);
    }
}
