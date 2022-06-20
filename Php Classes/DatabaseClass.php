<?php
require "Advertisements.php";
class DatabaseClass
{
    protected $host = "127.0.0.1";
    protected $port = 3306;
    protected $name = "root";
    protected $password = "password";
    protected $db = "work";

    public function getPort(): int
    {
        return $this->port;
    }
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    public function getHost():string
    {
        return $this->host;
    }
    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getname():string
    {
        return $this->name;
    }
    public function setname($name)
    {
        $this->name = $name;
    }

    public function getPassword():string
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getDb():string
    {
        return $this->db;
    }
    public function setDb($db)
    {
        $this->db = $db;
    }


    public function isInstalled():string
    {
        if (function_exists('mysqli_connect')) {
            return "mysqli is installed! \n";
        }else{
            return " Enable Mysqli support in your PHP installation \n";
        }
    }

    public function createUserTable():string
    {
        $conn = mysqli_connect($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        try
        {
            $sql = "CREATE TABLE users 
            (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30)
            )";
            if ($conn->query($sql) === TRUE) {
                return "Table Users created successfully\n"; //in case its not already
            }
        }catch (mysqli_sql_exception)
        {
            return "User Table is already created!\n";
        }
        $conn->close();
        return "";
    }
    public function createAdvertisementsTable():string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());

        try
        {
            $sql = "CREATE TABLE advertisements 
            (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                userid INT(6) NOT NULL,
                title VARCHAR(30)
                FOREIGN KEY (userid) REFERENCES Users(id)
            )";
            if ($conn->query($sql) === TRUE) {
                return "Table Advertisements created successfully\n"; //in case its not already
            }
        }catch (mysqli_sql_exception)
        {
            return "Advertisements Table is already created!\n";
        }
        return error_log();
    }

    public function WriteIntoUsers(User $user):string
    {

        // Create connection
        $conn = mysqli_connect($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());

        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn -> connect_error."\n");
        }

        $id=$user->getUserId();
        $name=$user->getusername();
        try {
            $sql = "INSERT INTO users (id, username) VALUES ($id,'$name')";

            if ($conn->query($sql) === TRUE) {
                return "New record created successfully\n";
            } else {
                return "Error: " . $sql . "\n" . $conn->error . "\n";
            }
        }
        catch (mysqli_sql_exception)
        {
            return $user->getusername()." skipped! \n";
        }

        $conn->close();
    }
    public function WriteIntoAdvertisements(Advertisements $advertisements):string
    {

        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn -> connect_error."\n");
        }
        $id=$advertisements->getId();
        $userId=$advertisements->getUserId();
        $title=$advertisements->getTitle();
        try {
            $sql = "INSERT INTO advertisements (id,userid, title) VALUES ($id,'$userId','$title')";

            if ($conn->query($sql) === TRUE) {
                return "New record created successfully\n";
            } else {
                return "Error: " . $sql . "\n" . $conn->error;
            }
        }catch (mysqli_sql_exception)
        {
            return $advertisements->getusername()." skipped!\n";
        }
        catch (TypeError)
        {

        }
        $conn->close();
        return "";
    }

    public function getDataFromUsers():string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());

        // GET CONNECTION ERRORS
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL QUERY
        $query = "SELECT * FROM users;";

        // FETCHING DATA FROM DATABASE
        $result = mysqli_query($conn,$query);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck>0)
        {
            // OUTPUT DATA OF EACH ROW
            while($row = mysqli_fetch_assoc($result))
            {
                return "Id: " .$row["id"]. " - Name: " .$row["username"] . "\n";
            }
        }
        else {
            return "0 results\n";
        }
        $conn->close();
        return "";
    }
    public function getDataFromAdvertisements():string
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        $sql = "SELECT id, userid, title FROM advertisements";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return "Id: " . $row["id"]. " - UserId: " . $row["userid"]. " - Title: " . $row["title"]. "\n";
            }
        }
        else
        {
            return "0 results \n";
        }
        $conn->close();
        return "";
    }

    public function deleteDataFromUsersByID($id):string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        // sql to delete a record
        $sql = "DELETE FROM users WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            return "Record deleted successfully"."\n";
        } else {
            return "Error deleting record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }
    public function deleteDataFromUsersByUserName($username):string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        // sql to delete a record
        $sql = "DELETE FROM users WHERE username=$username";

        if ($conn->query($sql) === TRUE) {
            return "Record deleted successfully"."\n";
        } else {
            return "Error deleting record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }

    public function deleteDataFromAdvertisementsByID($id):string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        // sql to delete a record
        $sql = "DELETE FROM advertisements WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            return "Record deleted successfully"."\n";
        } else {
            return "Error deleting record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }
    public function deleteDataFromAdvertisementsBytitle($title):string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        // sql to delete a record
        $sql = "DELETE FROM advertisements WHERE title=$title";

        if ($conn->query($sql) === TRUE) {
            return "Record deleted successfully"."\n";
        } else {
            return "Error deleting record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }
    public function deleteDataFromAdvertisementsByuserid($userid):string
    {
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."\n");
        }

        // sql to delete a record
        $sql = "DELETE FROM advertisements WHERE userid=$userid";

        if ($conn->query($sql) === TRUE) {
            return "Record deleted successfully"."\n";
        } else {
            return "Error deleting record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }

    public function modifyDataFromUsersByuserid($userid,$username):string
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE users SET username='$username' WHERE id=$userid";

        if ($conn->query($sql) === TRUE) {
            return "Record updated successfully\n";
        } else {
            return "Error updating record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }
    public function modifyDataFromAdvertisementsByUserId($userId,$title):string
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb(),$this->getPort());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "UPDATE advertisements SET title='$title' WHERE userid=$userId";

        if ($conn->query($sql) === TRUE) {
            return "Record updated successfully\n";
        } else {
            return "Error updating record: " . $conn->error."\n";
        }

        $conn->close();
        return "";
    }
}
