<?php
namespace HtSettingsModule\Mapper\FileSystem;

use HtSettingsModule\Entity\ParameterInterface;
use HtSettingsModule\Exception;
use League\Flysystem\FilesystemInterface;
use HtSettingsModule\Mapper\SettingsMapperInterface;

class FileSystemMapper implements SettingsMapperInterface
{
    /**
     * @var ParameterInterface
     */
    protected $entityPrototype;

    /**
     * @var FilesystemInterface
     */
    protected $fileSystem;

    /**
     * @var Adapter\AdapterInterface
     */
    protected $adapter;

    /**
     * Constructor
     *
     * @param FilesystemInterface $fileSystem
     * @param ParameterInterface  $entityPrototype
     */
    public function __construct(FilesystemInterface $fileSystem, ParameterInterface $entityPrototype, Adapter\AdapterInterface $adapter)
    {
        $this->fileSystem = $fileSystem;
        $this->entityPrototype = $entityPrototype;
        $this->adapter = $adapter;
    }

    /**
     * {@inheritDoc}
     */
    public function findByNamespace($namespace)
    {
        $data = $this->read($namespace);
        $parameters = [];
        foreach ($data as $name => $value) {
            $parameter = clone $this->entityPrototype;
            $parameter->setName($name);
            $parameter->setValue($value);
            $parameter->setNamespace($namespace);
            $parameters[] = $parameter;
        }

        return $parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function insertParameter(ParameterInterface $parameter)
    {
        $this->updateParameter($parameter);
    }

    /**
     * {@inheritDoc}
     */
    public function updateParameter(ParameterInterface $parameter)
    {
        $data = $this->read($parameter->getNamespace());
        $data[$parameter->getName()] = $parameter->getValue();
        $this->write($parameter->getNamespace(), $data);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteParameter(ParameterInterface $parameter)
    {
        $data = $this->read($parameter->getNamespace());
        unset($data[$parameter->getName()]);

        $this->write($parameter->getNamespace(), $data);
    }

    /**
     * {@inheritDoc}
     */
    public function findParameter($parameter, $name = null)
    {
        if ($parameter instanceof ParameterInterface) {
            $namespace = $parameter->getNamespace();
            $name = $parameter->getName();
            $data = $this->read($namespace);
            $parameter->setValue($data[$name]);

            return $parameter;
        } elseif (!is_string($parameter)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be string or an instance of HtSettingsModule\Entity\ParameterInterface, %s provided instead',
                    __METHOD__,
                    is_object($parameter) ? get_class($parameter) : gettype($parameter)
                )
            );
        }

        $namespace = $parameter;
        $data = $this->read($namespace);
        $parameter = clone $this->entityPrototype;
        $parameter->setName($name);
        $parameter->setValue($data[$name]);
        $parameter->setNamespace($namespace);

        return $parameter;
    }

    /**
     * Reads settings content of a namespace
     *
     * @param  string $namespace
     * @return array
     */
    protected function read($namespace)
    {
        $file = $this->adapter->getFileName($namespace);
        if (!$this->fileSystem->has($file)) {
            return [];
        }

        return $this->adapter->onRead($this->fileSystem->read($file));
    }

    /**
     * Write settings content of a namespace
     *
     * @param  string $namespace
     * @param  array  $data
     * @return void
     */
    protected function write($namespace, array $data)
    {
        $file = $this->adapter->getFileName($namespace);
        $contents = $this->adapter->prepareForWriting($data);
        if (!$this->fileSystem->has($file)) {
            $this->fileSystem->write($file, $contents);
        }

        $this->fileSystem->update($file, $contents);
    }
}
