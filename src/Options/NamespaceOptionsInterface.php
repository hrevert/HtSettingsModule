<?php
namespace HtSettingsModule\Options;

interface NamespaceOptionsInterface
{
    /**
     * Gets name of namespace
     *
     * @return string
     */
    public function getName();

    /**
     * Gets entity prototype of namespace entity
     *
     * @return object
     */
    public function getEntityPrototype();

    /**
     * Gets hydrator of namespace entity for converting array to namespace entity
     *
     * @return \Zend\Stdlib\Hydrator\HydratorInterface|string
     */
    public function getHydrator();
}
