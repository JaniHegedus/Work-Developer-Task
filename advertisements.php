<?php

class advertisements extends users
{
    private $id;
    private $title;

    /**
     * @param $id
     * @param $title
     */
    public function __construct($id,$userid ,$title)
    {
        $this->id = $id;
        $this->userid = $userid;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


}