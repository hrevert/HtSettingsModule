<?php
namespace HtSettingsModule\Options;

use Zend\Stdlib\AbstractOptions;
use HtSettingsModule\Exception\InvalidArgumentException;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var CacheOptionsInterface
     */
    protected $cacheOptions;

    /**
     * Sets options of cache
     *
     * @param array|CacheOptionsInterface $cacheOptions
     * @return self
     */
    public function setCacheOptions($cacheOptions)
    {
        if ($cacheOptions instanceof CacheOptionsInterface) {
            $this->cacheOptions = $cacheOptions;
        } elseif (is_array($cacheOptions)) {
            $this->cacheOptions = new CacheOptions($cacheOptions);   
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be array or an instance of HtSettingsModule\Options\CacheOptionsInterface, %s provided instead',
                    __METHOD__,
                    is_object($cacheOptions) ? get_class($cacheOptions) : gettype($cacheOptions)
                )
            );
        }
        
        return $this;        
    }

    /**
     * Gets options of cache
     *
     * @param CacheOptionsInterface
     * @return self
     */
    public function getCacheOptions()
    {
        if (!$this->cacheOptions instanceof CacheOptionsInterface) {
            $this->cacheOptions = new CacheOptions;
        }

        return $this->cacheOptions;
    }
}
