<?php
namespace HtSettingsModule\Mapper\FileSystem\Adapter;

class Json implements AdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public function prepareForWriting(array $data)
    {
        return \Zend\Json\Json::encode($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function onRead($contents)
    {
        return \Zend\Json\Json::decode($contents, \Zend\Json\Json::TYPE_ARRAY);
    }

    /**
     * {@inheritDoc}
     */
    protected function getFileName($namespace)
    {
        return 'ht-settings-' . $namespace . '.json';
    }
}
