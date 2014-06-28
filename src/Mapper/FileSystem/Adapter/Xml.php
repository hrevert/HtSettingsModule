<?php
namespace HtSettingsModule\Mapper\FileSystem\Adapter;

use Zend\Config\Reader\ReaderInterface;
use Zend\Config\Writer\WriterInterface;
use Zend\Config\Reader\Xml as XmlReader;
use Zend\Config\Writer\Xml as XmlWriter;
use Zend\Config\Config;

class Xml implements AdapterInterface
{
    /**
     * @var XmlReader
     */
    protected $reader;

    /**
     * @var XmlWriter
     */
    protected $writer;

    /**
     * {@inheritDoc}
     */
    public function prepareForWriting(array $data)
    {
        return $this->getWriter()->toString(new Config($data));
    }

    /**
     * {@inheritDoc}
     */
    public function onRead($contents)
    {
        return $this->getReader()->fromString($contents);
    }

    /**
     * {@inheritDoc}
     */
    public function getFileName($namespace)
    {
        return 'ht-settings-' . $namespace . '.xml';
    }

    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    public function getReader()
    {
        if (!$this->reader instanceof XmlReader) {
            $this->setReader(new XmlReader);
        }

        return $this->reader;
    }

    public function setWriter(WriterInterface $writer)
    {
        $this->writer = $writer;

        return $this;
    }

    public function getWriter()
    {
        if (!$this->writer instanceof XmlWriter) {
            $this->setWriter(new XmlWriter);
        }

        return $this->writer;
    }
}
