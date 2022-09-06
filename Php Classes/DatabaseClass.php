<?php
require "Advertisements.php";
class DatabaseClass
{
    protected $host = "localhost"; //Server IP
    protected $port = 3306;//Server Port
    protected $name = "root"; //Username which you will access the DataBase
    protected $password = ""; //Password which you will access the DataBase
    protected $db = "work"; //DataBase which you will access

    //Getters: Methods to return value
    public function getPort(): int
    {
        return $this->port;
    }
    public function getHost():string
    {
        return $this->host;
    }
    public function getname():string
    {
        return $this->name;
    }
    public function getPassword():string
    {
        return $this->password;
    }
    public function getDb():string
    {
        return $this->db;
    }
    //Check if mysqli connection can be built or not
    public function isInstalled():string
    {
        if (function_exists('mysqli_connect')) {
            return "mysqli is installed! \n";
        }else{
            return " Enable Mysqli support in your PHP installation \n";
        }
    }
    //Create Tables to the DataBase
    public function createUserTable():string //Creating Users Table
    {
        $conn = mysqli_connect($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        try
        {
            $sql = "CREATE TABLE users 
            (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30)
            )";//CREATE with ATTRIBUTES
            if ($conn->query($sql) === TRUE) {
                $conn->close(); //Closing Connection
                return "Table Users created successfully\n"; //in case its not already
            }
        }catch (mysqli_sql_exception) //Catching errors
        {
            if(mysqli_errno($conn)===150)
            {
                $conn->close(); //Closing Connection
                return "Could not create database table!";//Returning couldn't to the log
            }
            if(mysqli_errno($conn)===1050)
            {
                $conn->close(); //Closing Connection
                return "Users Table is already created!\n";//Returning exists to the log
            }
            else{
                $result=mysqli_errno($conn); //Catching new error code
                $conn->close(); //Closing Connection
                return "Unknown Error! Number(".$result.")\n";//Returning error code to the log
            }
        }
        return "";
    }
    public function createAdvertisementsTable():string//Creating Advertisements Table
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase

        try //Trying to Create Table in DataBase
        {
            //CREATE with ATTRIBUTES
            $sql = "CREATE TABLE advertisements 
            (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                userid INT(6) UNSIGNED,
                title VARCHAR(30),
                FOREIGN KEY (userid) REFERENCES Users(id)
            )";
            //If Created close Connection
            if ($conn->query($sql) === TRUE) {
                $conn->close(); //Closing Connection
                return "Table Advertisements created successfully\n"; //in case its not already
            }
        }catch (mysqli_sql_exception) //Catching errors
        {
            if(mysqli_errno($conn)===150)
            {
                $conn->close(); //Closing Connection
                return "Could not create database table!";//Returning couldn't to the log
            }
            if(mysqli_errno($conn)===1050)//Catching if it already exist's
            {
                $conn->close(); //Closing Connection 
                return "Advertisements Table is already created!\n";//Returning exists to the log
            }
            else{
                $result=mysqli_errno($conn); //Catching new error code
                $conn->close(); //Closing Connection
                return "Unknown Error! Number(".$result.")\n";//Returning error code to the log
            }
        }
        return "";
    }
    //Write Data to tables
    public function WriteIntoUsers(User $user):string//Wrinting into Users Table
    {

        // Create connection
        $conn = mysqli_connect($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase

        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn -> connect_error."\n"); //Connection failure
        }

        $id=$user->getUserId();
        $name=$user->getusername();
        try //Trying to Create Table in DataBase
        {
            $sql = "INSERT INTO users (id, username) VALUES ($id,'$name')";//Select Data

            if ($conn->query($sql) === TRUE) {
                return "New record created successfully\n"; //Returning Success
            } else {
                return "Error: " . $sql . "\n" . $conn->error . "\n";//Returning error to the log
            }
        }
        catch (mysqli_sql_exception) //Catching errors
        {
            if(mysqli_errno($conn) == 1062)
            {
                $conn->close(); //Closing Connection
                return "Existing found...\n";
            }
            else{
                $result=mysqli_errno($conn); //Catching new error code
                $conn->close(); //Closing Connection
                return "Unknown Error! Number(".$result.")\n";//Returning error code to the log
            }
        }
    }
    public function WriteIntoAdvertisements(Advertisements $advertisements):string//Wrinting into Advertisements Table
    {

        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn -> connect_error."\n"); //Connection failure
        }
        $id=$advertisements->getId();
        $userId=$advertisements->getUserId();
        $title=$advertisements->getTitle();
        try {
            $sql = "INSERT INTO advertisements (id,userid, title) VALUES ($id,'$userId','$title')";//Select Data

            if ($conn->query($sql) === TRUE)
            {
                return "New record created successfully\n"; //Returning Success
            }
            else
            {
                return "Error: " . $sql . "\n" . $conn->error . "\n";//Returning error to the log
            }
        }catch (mysqli_sql_exception) //Catching errors
        {
            //return $advertisements->getusername()." skipped!\n";
            if(mysqli_errno($conn) == 1062)
            {
                $conn->close(); //Closing Connection
                return "Existing found...\n";//Returning Existing Error
            }
            if(mysqli_errno($conn)== 1452)
            {
                $conn->close(); //Closing Connection
                return "User with this Id not found...\n";//Returning ID Error
            }
            else{
                $result=mysqli_errno($conn); //Catching new error code
                $conn->close(); //Closing Connection
                return "Unknown Error! Number(".$result.")\n";//Returning error code to the log
            }
        }
    }
    //Get data from Tables
    public function getDataFromUsers():string//Getting data from Users Table
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase

        // GET CONNECTION ERRORS
        if ($conn->connect_error) {
            die("Connection failed: " . $conn -> connect_error."\n"); //Connection failure
        }

        // SQL QUERY
        $query = "SELECT * FROM users;";//Select Data

        // FETCHING DATA FROM DATABASE
        $result = mysqli_query($conn,$query);//Creating query
        $resultCheck = mysqli_num_rows($result);//Creating Result Checker
        $out="";//Creating return value

        if ($resultCheck>0)//Checking if result exists
        {
            // OUTPUT DATA OF EACH ROW
            while($row = mysqli_fetch_assoc($result))
            {
                $out .= "Id: " ;
                $out .= $row["id"];
                $out .= " - UserName: " ;
                $out .= $row["username"];
                $out .= "\n";
            }
            $conn->close(); //Closing Connection
            return $out;//Sending to console
        }
        else
        {
            $conn->close(); //Closing Connection
            return "0 results\n";//Sending empty database to console
        }
    }
    public function getUsersByID($id)//Get users by id
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase

        // GET CONNECTION ERRORS
        if ($conn->connect_error) {
            die("Connection failed: " . $conn -> connect_error."\n"); //Connection failure
        }

        // SQL QUERY
        $query = "SELECT * FROM users;";//Select Data

        // FETCHING DATA FROM DATABASE
        $result = mysqli_query($conn,$query);//Creating query
        $resultCheck = mysqli_num_rows($result);//Creating Result Checker

        if ($resultCheck>0)//Checking if result exists
        {
            // OUTPUT DATA OF EACH ROW
            while($row = mysqli_fetch_assoc($result))
            {
                if($row["id"]===$id) return $row["username"]; //Returning username to console
            }
            $conn->close(); //Closing Connection
        }
        else
        {
            $conn->close(); //Closing Connection
            return "Not found!\n";//Sending not found to console
        }
    }
    public function getDataFromAdvertisements():string//Getting data from Advertisements Table
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");//Connection Error
        }

        $sql = "SELECT id, userid, title FROM advertisements";//Select Data
        $result = $conn->query($sql); //Creating query
        $out="";//Creating return value
        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $out .= "Id: " ;
                $out .= $row["id"];
                $out .= " - UserId: " ;
                $out .= $row["userid"];
                $out .= " - Title: " ;
                $out .= $row["title"];
                $out .= "\n";
            }
            return $out;//Sending to console
        }
        else
        {
            return "0 results \n";//Sending empty database to console
        }
        $conn->close(); //Closing Connection
    }
    //Delete Data Methods
    //Users
    public function deleteDataFromUsersByID($id):string//Delete data from Users Table by id
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");//Connection failure
        }

        // sql to delete a record
        $sql = "DELETE FROM users WHERE id=$id";//Select Data
        if ($conn->query($sql) === TRUE) {
            return "Record deleted successfully" . "\n";//Sending success to console
        }
        else
        {
            $conn->close(); //Closing Connection
            return "Error deleting record: " . $conn->error . "\n";//Sending error to console
        }
    }
    public function deleteDataFromUsersByUserName($username):string//Delete data from Users Table by username
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        // sql to delete a record
        $sql = "DELETE FROM users WHERE username=$username";//Select Data

        if ($conn->query($sql) === TRUE) {
            $conn->close(); //Closing Connection
            return "Record deleted successfully"."\n";//Sending success to console
        } else {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close(); //Closing Connection
            return $value;//Sending error to console
        }
    }
    //Advertisements
    public function deleteDataFromAdvertisementsByID($id):string//Delete data from Advertisements Table by id
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");//Connection failure
        }

        // sql to delete a record
        $sql = "DELETE FROM advertisements WHERE id=$id";//Select Data
        if ($id!=null){
            if ($conn->query($sql) === TRUE) {
                return "Record deleted successfully"."\n";//Sending success to console
            } else {
                $conn->close(); //Closing Connection
                return "Error deleting record: " . $conn->error."\n";//Sending error to console
            }
        }
        else
        {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close(); //Closing Connection
            return $value;//Sending error to console
        }
    }
    public function deleteDataFromAdvertisementsBytitle($title):string//Delete data from Advertisements Table by title
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");//Connection failure
        }

        // sql to delete a record
        $sql = "DELETE FROM advertisements WHERE title=$title";//Select Data

        if ($conn->query($sql) === TRUE)
        {
            $conn->close(); //Closing Connection
            return "Record deleted successfully"."\n";//Sending success to console
        }
        else
        {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close(); //Closing Connection
            return $value;//Sending error to console
        }
    }
    public function deleteDataFromAdvertisementsByuserid($userid):string//Delete data from Advertisements Table by userid
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");//Connection failure
        }

        // sql to delete a record
        $sql = "DELETE FROM advertisements WHERE userid=$userid";//Select Data

        if ($conn->query($sql) === TRUE)
        {
            $conn->close(); //Closing Connection
            return "Record deleted successfully"."\n";//Sending success to console
        }
        else
        {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close(); //Closing Connection
            return $value;//Sending error to console
        }
    }
    //Modify Data Methods
    //Users
    public function modifyDataFromUsersByuserid($userid,$username):string//Modify data from Users Table by id
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn -> connect_error."\n"); //Connection failure
        }

        $sql = "UPDATE users SET username='$username' WHERE id=$userid";//Select Data

        if ($conn->query($sql) === TRUE)
        {
            $conn->close(); //Closing Connection
            return "Record updated successfully\n";//Sending success to console
        }
        else
        {
            $value= "Error updating record: " . $conn->error."\n";
            $conn->close(); //Closing Connection
            return $value;//Sending error to console
        }
    }
    //Advertisements
    public function modifyDataFromAdvertisementsByUserId($userId,$title):string//Modify data from Advertisements Table by userid
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort()); //Connecting to DataBase
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn -> connect_error."\n"); //Connection failure
        }

        $sql = "UPDATE advertisements SET title='$title' WHERE userid=$userId";//Select Data

        if ($conn->query($sql) === TRUE)
        {
            $conn->close(); //Closing Connection
            return "Record updated successfully\n";//Sending success to console
        }
        else
        {
            $value= "Error updating record: " . $conn->error."\n";
            $conn->close(); //Closing Connection
            return $value;//Sending error to console
        }
    }
    //Create Table to the php file to display Data
    public function createUsersTable()//Create Table from Users Table
    {
        $con = mysqli_connect($this->getHost(),$this->getname(),$this->getPassword(),$this->getDb(),$this->getPort()); //Connecting to DataBase

        if (!$con)
        {
            die('Could not connect: ' . mysqli_error()); //clound not connect
        }

        $result = mysqli_query($con,"SELECT * FROM users");//Select Data
        //Sending Table to PHP
        echo "
            <table>
                <tr>
                    <th>Id</th>
                    <th>name</th>
                </tr>
            ";//sending Top Row
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "</tr>";
        }//Sending Data
        mysqli_close($con);
        echo "</table>";//Closing Table
    }
    public function createAdvTable()//Create Table from Advertisements Table
    {
        $con = mysqli_connect($this->getHost(),$this->getname(),$this->getPassword(),$this->getDb(),$this->getPort()); //Connecting to DataBase

        if (!$con)
        {
            die('Could not connect: ' . mysqli_error()); //clound not connect
        }

        $result = mysqli_query($con,"SELECT * FROM advertisements");//Select Data
        //Sending Table to PHP
        echo "
            <table>
                <tr>
                    <th>Id:</th>
                    <th>UserName:</th>
                    <th>Title:</th>
                </tr>
            ";//sending Top Row
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $this->getUsersByID($row['userid'])." (userid:".$row['userid'].")". "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "</tr>";//Sending Data
        }
        echo "</table>";//Closing Table
        mysqli_close($con);//Closing Connection
    }
}
