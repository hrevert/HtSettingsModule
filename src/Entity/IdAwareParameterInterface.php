<?php
namespace HtSettingsModule\Entity;

interface IdAwareParameterInterface
{
    /**
     * Sets Parameter id
     *
     * @param  int  $id
     * @return self
     */
    public function setId($id);

    /**
     * Gets Parameter id
     *
     * @return int
     */
    public function getId();
}
