<?php
namespace HtSettingsModule\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use HtSettingsModule\Entity\ParameterInterface;
use HtSettingsModule\Exception;

class SettingsMapper extends AbstractDbMapper implements SettingsMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function findByNamespace($namespace)
    {
        $select = $this->getSelect();
        $select->where(['namespace' => $namespace]);

        return $this->select($select);
    }

    /**
     * {@inheritDoc}
     */
    public function insertParameter(ParameterInterface $parameter)
    {
        $result = parent::insert($parameter);
        $parameter->setId($result->getGeneratedValue());        
    }

    /**
     * {@inheritDoc}
     */
    public function updateParameter(ParameterInterface $parameter)
    {
         parent::update($entity, ['id' => $parameter->getId()]);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteParameter(ParameterInterface $parameter)
    {
        parent::delete(['id' => $parameter->getId()]);
    }

    /**
     * {@inheritDoc}
     */
    public function findParameter($parameter, $name = null)
    {
        if ($parameter instanceof ParameterInterface) {
            $where = ['namespace' => $parameter->getNamespace(), 'name' => $parameter->getName()];
        } elseif (is_string($parameter)) {
            $namespace = $parameter;
            $where = ['namespace' => $namespace, 'name' => $name];
        } else {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be string or an instance of HtSettingsModule\Entity\ParameterInterface, %s provided instead',
                    __METHOD__,
                    is_object($parameter) ? get_class($parameter) : gettype($parameter)
                )
            );
        }
        $select = $this->getSelect($select);
        $select->where($where);

        return $this->select($select);
    }

    /**
     * Sets table name of settings
     *
     * @param  string|\Zend\Db\Sql\TableIdentifier $tableName
     * @return self
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }
}
