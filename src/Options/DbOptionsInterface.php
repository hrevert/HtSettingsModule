<?php
namespace HtSettingsModule\Options;

interface DbOptionsInterface
{
    /**
     * Gets table name of settings
     *
     * @return string|\Zend\Db\Sql\TableIdentifier
     */
    public function getSettingsTable();

    /**
     * Gets parameter entity class
     *
     * @return string
     */
    public function getParameterEntityClass();
}
