<?php

class users
{
    protected $userid;
    private $name;

    /**
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->userid = $id;
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->userid;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->userid = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}