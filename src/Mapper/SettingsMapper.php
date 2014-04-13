<?php
namespace HtSettingsModule\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use HtSettingsModule\Entity\ParameterInterface;

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
