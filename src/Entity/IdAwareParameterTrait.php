<?php
namespace HtSettingsModule\Entity;

trait IdAwareParameterTrait
{
    /**
     * Parameter id.
     *
     * @var int
     */
    protected $id;

    /**
     * Sets Parameter id
     *
     * @param  int  $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets Parameter id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
