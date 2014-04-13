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
        $result = $this->insert($parameter);
        $parameter->setId($result->getGeneratedValue());        
    }

    /**
     * {@inheritDoc}
     */
    public function updateParameter(ParameterInterface $parameter)
    {
        $where = $this->getWhereFromParameter($parameter);
        $this->update($entity, $where);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteParameter(ParameterInterface $parameter)
    {
        $where = $this->getWhereFromParameter($parameter);
        $this->delete($where);
    }

    /**
     * {@inheritDoc}
     */
    public function findParameter($parameter, $name = null)
    {
        if ($parameter instanceof ParameterInterface) {
            $where = $this->getWhereFromParameter($parameter);
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
     * Gets where condition of select, update or delete a parameter
     *
     * @param ParameterInterface $parameter
     * @return array
     */
    protected function getWhereFromParameter(ParameterInterface $parameter)
    {
        if ($parameter->getId()) {
            return ['id' => $parameter->getId()];
        } else {
            return ['namespace' => $parameter->getNamespace(), 'name' => $parameter->getName()];
        }        
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
