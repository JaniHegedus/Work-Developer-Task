<?php
require "User.php";
class Advertisements extends User
{
    private int $id; //ID of the AD
    private string $title; //Title of the AD
    //Using new function instead of __construct()
    public function addNewAdvertisement($id, $userid ,$title):string
    {
        if($userid!=null)
        {
            //Giving values:
            $this->userid=$userid;
            $this->id=$id;
            $this->title = $title;
        }
        else
        {
            return "Already added!";
        }
        return "";
    }
    //Getters:
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
}