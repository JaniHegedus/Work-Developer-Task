<?php
class DatabaseClass
{
    protected $host = "localhost:3310";
    protected $name = "root";
    protected $password = "password";
    protected $db = "work";

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getname()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setname($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param string $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    public function isInstalled()
    {
        if (function_exists('mysqli_connect')) {
            echo "mysqli is installed! <br>";
        }else{
            echo " Enable Mysqli support in your PHP installation <br>";
        }
    }


    public function WriteIntoUsers($id,$name){

        // Create connection
        $conn = mysqli_connect($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb());

        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn -> connect_error."<br>");
        }
        try
        {
            $sql = "CREATE TABLE Users 
            (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL
            )";
            if ($conn->query($sql) === TRUE) {
                echo "Table Users created successfully<br>"; //in case its not already
            }
        }catch (mysqli_sql_exception)
        {
            echo "Already Created!<br>";
        }
        try{
            $sql = "INSERT INTO Users (id, name) VALUES ($id,$name)";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error."<br>";
            }
        }catch (mysqli_sql_exception)
        {
            echo $name." is already added!<br>";
        }


        $conn->close();
    }
    public function WriteIntoAdvertisements($id,$userid,$title)
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb());
        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn -> connect_error."<br>");
        }
        try
        {
            $sql = "CREATE TABLE Advertisements 
            (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                userid INT(6) NOT NULL, 
                title VARCHAR(30) NOT NULL
            )";
            if ($conn->query($sql) === TRUE) {
                echo "Table Advertisements created successfully<br>"; //in case its not already
            }
        }catch (mysqli_sql_exception)
        {
            echo "Already Created<br>";
        }
        try{
            $sql = "INSERT INTO Advertisements (id,userid, title) VALUES ($id,$userid,$title)";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully<br>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }catch (mysqli_sql_exception)
        {
            echo $title." is already added!<br>";
        }

        $conn->close();
    }

    public function getDataFromUsers()
    {
        $link = mysqli_connect($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb());

        // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error()."<br>");
        }

        // Attempt select query execution
        $sql = "SELECT * FROM users";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table>";
                echo "<tr>";
                echo "<th>id</th>";
                echo "<th>name</th>";
                echo "</tr>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            } else{
                echo "No records matching your query were found.";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

        // Close connection
        mysqli_close($link);
    }
    public function getDataFromAdvertisements()
    {
        // Create connection
        $conn = new mysqli($this->getHost(), $this->getname(), $this->getPassword(), $this->getDb());
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error."<br>");
        }

        $sql = "SELECT id, userid, title FROM advertisements";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - userid: " . $row["userid"]. " - title: " . $row["title"]. "<br>";
            }
        }
        else
        {
            echo "0 results";
        }
        $conn->close();
    }

}
