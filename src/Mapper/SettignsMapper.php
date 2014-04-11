<?php
namespace HtSettingsModule\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class SettignsMapper extends AbstractDbMapper
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
     * Sets table name of settings
     *
     * @param string|\Zend\Db\Sql\TableIdentifier $tableName
     * @return self
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }
}
