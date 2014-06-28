<?php
namespace HtSettingsModule\Mapper\FileSystem\Adapter;

interface AdapterInterface
{
    /**
     * Converting array data to certain format for storage
     *
     * @param  array  $data
     * @return string
     */
    public function prepareForWriting(array $data);

    /**
     * Converting certain format string data to array
     *
     * @param  string $contents
     * @return array  $data
     */
    public function onRead($contents);

    /**
     * Gets setttings file name for a namespace
     *
     * @return $namespace
     * @return string
     */
    public function getFileName($namespace);
}
