<?php

class User
{
    public ?int $userid = null;//ID of the User
    public string $username ="";//Name of the User
    //Using new function instead of __construct()
    public function addNewUser($id,$username)
    {
        //Giving values:
        $this->userid=$id;
        $this->username = $username;
    }
    //Getters:
    public function getUserId():int
    {
        return $this->userid;
    }
    public function getusername():string
    {
        return $this->username;
    }
}