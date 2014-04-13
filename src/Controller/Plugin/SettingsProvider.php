<?php
namespace HtSettingsModule\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use HtSettingsModule\Service\SettingsProviderInterface;

class SettingsProvider extends AbstractPlugin
{
    /**
     * @var SettingsProviderInterface
     */
    protected $settingsProvider;

    /**
     * Constructor
     *
     * @param SettingsProviderInterface $settingsProvider
     */
    public function __construct(SettingsProviderInterface $settingsProvider)
    {
        $this->settingsProvider = $settingsProvider;
    }

    /**
     * Gets settings of a namespace
     *
     * @param  string $namespace
     * @return object
     */
    public function __invoke($namespace)
    {
        return $this->settingsProvider->getSettings($namespace);
    }
}
