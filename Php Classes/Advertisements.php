<?php
require "User.php";
class Advertisements extends User
{
    private int $id;
    private string $title;
    public function addNewAdvertisement($id, $userid ,$title):string
    {
        try
        {
            $this->userid=$userid;
            $this->id=$id;
            $this->title = $title;
        }
        catch (TypeError)
        {
            return error_log();
        }
        return "";
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getAllData():string
    {
        return "Id: ". $this->id. "Userid: ".$this->userid." Name:".$this->username." Title: ".$this->title;
    }
}