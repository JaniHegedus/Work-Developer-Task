<?php

class User
{
    public ?int $userid = null;
    public string $username ="";

    public function addNewUser($id,$username)
    {
        $this->userid=$id;
        $this->username = $username;
    }
    public function getUserId():int
    {
        return $this->userid;
    }

    public function setUserId($id)
    {
        $this->userid = $id;
    }
    public function getusername():string
    {
        return $this->username;
    }

    public function setusername($username)
    {
        $this->username = $username;
    }

}