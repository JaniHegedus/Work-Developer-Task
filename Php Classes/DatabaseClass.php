<?php
require "Advertisements.php";
class DatabaseClass
{
    protected $host = "localhost";
    protected $port = 3306;
    protected $name = "root";
    protected $password = "";
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
                $conn->close();
                return "Table Users created successfully\n"; //in case its not already
            }
        }catch (mysqli_sql_exception)
        {
            if(mysqli_errno($conn)===150)
            {
                $conn->close();
                return "Could not create database table!";
            }
            if(mysqli_errno($conn)===1050)
            {
                $conn->close();
                return "Users Table is already created!\n";
            }
            else{
                $result=mysqli_errno($conn);
                $conn->close();
                return "Unknown Error! Number(".$result.")\n";
            }
        }
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
                userid INT(6) UNSIGNED,
                title VARCHAR(30),
                FOREIGN KEY (userid) REFERENCES Users(id)
            )";
            if ($conn->query($sql) === TRUE) {
                $conn->close();
                return "Table Advertisements created successfully\n"; //in case its not already
            }
        }catch (mysqli_sql_exception)
        {
            if(mysqli_errno($conn)===150)
            {
                $conn->close();
                return "Could not create database table!";
            }
            if(mysqli_errno($conn)===1050)
            {
                $conn->close();
                return "Advertisements Table is already created!\n";
            }
            else{
                $result=mysqli_errno($conn);
                $conn->close();
                return "Unknown Error! Number(".$result.")\n";
            }
        }
        return "";
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
        catch (mysqli_sql_exception $e)
        {
            if(mysqli_errno($conn) == 1062)
            {
                $conn->close();
                return "Existing found...\n";
            }
            else{
                $conn->close();
                return $e->getMessage();
            }
        }
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

            if ($conn->query($sql) === TRUE)
            {
                return "New record created successfully\n";
            }
            else
            {
                return "Error: " . $sql . "\n" . $conn->error;
            }
        }catch (mysqli_sql_exception $e)
        {
            //return $advertisements->getusername()." skipped!\n";
            if(mysqli_errno($conn) == 1062)
            {
                $conn->close();
                return "Existing found...\n";
            }
            if(mysqli_errno($conn)== 1452)
            {
                $conn->close();
                return "User with this Id not found...\n";
            }
            else{
                $conn->close();
                return $e->getMessage();
            }
        }
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
        $out="";

        if ($resultCheck>0)
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
            $conn->close();
            return $out;
        }
        else
        {
            $conn->close();
            return "0 results\n";
        }
    }
    public function getUsersByID($id){
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
                if($row["id"]===$id)
                    return $row["username"];
            }
            $conn->close();
        }
        else
        {
            $conn->close();
            return "Not found!\n";
        }
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
        $out="";
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
            return $out;
        }
        else
        {
            return "0 results \n";
        }
        $conn->close();
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
            return "Record deleted successfully" . "\n";
        }
        else
        {
            $conn->close();
            return "Error deleting record: " . $conn->error . "\n";
        }
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
            $conn->close();
            return "Record deleted successfully"."\n";
        } else {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close();
            return $value;
        }
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
        if ($id!=null){
            if ($conn->query($sql) === TRUE) {
                return "Record deleted successfully"."\n";
            } else {
                $conn->close();
                return "Error deleting record: " . $conn->error."\n";
            }
        }
        else
        {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close();
            return $value;
        }
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

        if ($conn->query($sql) === TRUE)
        {
            $conn->close();
            return "Record deleted successfully"."\n";
        }
        else
        {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close();
            return $value;
        }
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

        if ($conn->query($sql) === TRUE)
        {
            $conn->close();
            return "Record deleted successfully"."\n";
        }
        else
        {
            $value= "Error deleting record: " . $conn->error."\n";
            $conn->close();
            return $value;
        }
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

        if ($conn->query($sql) === TRUE)
        {
            $conn->close();
            return "Record updated successfully\n";
        }
        else
        {
            $value= "Error updating record: " . $conn->error."\n";
            $conn->close();
            return $value;
        }
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

        if ($conn->query($sql) === TRUE)
        {
            $conn->close();
            return "Record updated successfully\n";
        }
        else
        {
            $value= "Error updating record: " . $conn->error."\n";
            $conn->close();
            return $value;
        }
    }

    public function createUsersTable()
    {
        $con = mysqli_connect($this->getHost(),$this->getname(),$this->getPassword(),$this->getDb(),$this->getPort());

        if (!$con)
        {
            die('Could not connect: ' . mysqli_error());
        }

        $result = mysqli_query($con,"SELECT * FROM users");
        echo "
            <table>
                <tr>
                    <th>Id</th>
                    <th>name</th>
                </tr>
            ";
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_close($con);
    }
    public function createAdvTable()
    {
        $con = mysqli_connect($this->getHost(),$this->getname(),$this->getPassword(),$this->getDb(),$this->getPort());

        if (!$con)
        {
            die('Could not connect: ' . mysqli_error());
        }

        $result = mysqli_query($con,"SELECT * FROM advertisements");
        echo "
            <table>
                <tr>
                    <th>Id:</th>
                    <th>UserName:</th>
                    <th>Title:</th>
                </tr>
            ";
        while($row = mysqli_fetch_array($result))
        {
            $obj= new DatabaseClass();
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $obj->getUsersByID($row['userid'])." (userid:".$row['userid'].")". "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_close($con);
    }
}
