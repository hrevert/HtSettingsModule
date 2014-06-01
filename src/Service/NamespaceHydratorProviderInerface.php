<?php
namespace HtSettingsModule\Service;

interface NamespaceHydratorProviderInerface
{
    /**
     * Gets hydrator of a settings namespace
     *
     * @param  string $namespace
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getHydrator($namespace);
}
