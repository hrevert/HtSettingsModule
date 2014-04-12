<?php
namespace HtSettingsModule\View\Helper;

use Zend\View\Helper\AbstractHelper;
use HtSettingsModule\Service\SettingsProviderInterface;

class SettingsProvider extends AbstractHelper
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
