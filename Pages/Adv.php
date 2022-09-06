<HTML lang="en">
<HEAD>
    <Title>Advertisements</Title><!--Title-->
    <!--Calling the StyleSheets-->
    <link rel="stylesheet" href="../Styles/General.css">
    <link rel="stylesheet" href="../Styles/Sidebar.css">
    <link rel="stylesheet" href="../Styles/Header.css">
    <!--Creating Icon-->
    <link rel = "icon" href ="https://cdn.iconscout.com/icon/premium/png-256-thumb/user-database-15-805248.png" type = "image/x-icon">
</HEAD>
<Body>
    <header class="header">
        <div class="left-section">
            <h1 class="page-name">Advertisements:</h1>
        <?php
            //Including PHP CLasses to use them
            include ("../Php Classes/DatabaseClass.php");
            include ("../Php Classes/console_log.php");
            //Creating Console Log Variable
            $view_variable = "";
            //Creating object to reach methods
            $obj=new DatabaseClass();

            if(isset($_POST['button3']))//If Button 3 is clicked
            {
                if(!(isset($_POST["userid"])) || !(isset($_POST["title"]))||!(isset($_POST["id"])))//And Fields aren't set
                {
                    $view_variable .="You did not fill out the required fields.";
                }
                else//If set
                {
                    if($_POST["title"]==""||$_POST["userid"]=="")//Checking if they are empty
                    {
                        /*//DEBUG:
                        $view_variable.= $_POST["id"]."\n";
                        $view_variable.= $_POST["userid"]."\n";
                        $view_variable.= $_POST["title"]."\n";
                        */
                        $view_variable .="You did not fill out the required fields.";//Console Logging
                        echo
                        '<script type="text/javascript">
                           window.onload = function () { alert("You did not fill out the required fields."); } 
                        </script>';//Error Popup
                    }
                    else
                    {
                        if($_POST["id"]==="") $_POST["id"]=0;//If Adv ID not given setting it to 0 to make a new record anyway
                        $obj0 = new Advertisements();//Creating new object to create new AD
                        $view_variable .= $obj0 -> addNewAdvertisement($_POST["id"],$_POST["userid"],$_POST["title"]);//Creating new AD
                        $view_variable .=$obj-> WriteIntoAdvertisements($obj0);//Adding to Console Log and Writing into the correct DataBase
                        echo
                        '<script type="text/javascript">
                        window.onload = function () { alert("Record Created\n If not check console for errors!"); } 
                        </script>';//Half-Success Popup
                    }
                }
            }
            if(isset($_POST['button4']))//If Button 4 is clicked
            {
                if(!(isset($_POST["reid"])))//And Fields aren't empty
                {
                    $view_variable .= "You did not fill out the required fields.";//Console Logging
                    echo
                        '<script type="text/javascript">
                        window.onload = function () { alert("User with this Id is not found!"); } 
                        </script>';//Error Popup
                }
                else//If set
                {
                    if($_POST["reid"]==="")//If empty
                    {
                        $view_variable.="No ID given!";//Console Logging
                        echo
                            '<script type="text/javascript">
                            window.onload = function () { alert("Id is not given"); } 
                            </script>';//Error Popup
                    }
                    else//If not
                    {
                        $view_variable .= $obj->deleteDataFromAdvertisementsByID($_POST["reid"]);//Console Logging And Removing from DataBase
                        echo
                            '<script type="text/javascript">
                             window.onload = function () { alert("Record Deleted"); } 
                             </script>';//Success Popup
                    }
                }
            }

        ?>
        </div>
        <!--Creating Form area from witch we can get data-->
        <form class="middle-double-section" name="form" action="" method="post">
            <!--Creating Input Fields-->
            <input class="id-bar"  name="id" type="number" min="0" placeholder="Id:">
            <input class="user-id-bar"  name="userid" type="number" min="0" placeholder="UserId:">
            <input class="user-title-bar" name="title" type="text" placeholder="Title:">
            <!--Creating a Button-->
            <button class="plus-button" name="button3" value="button3">
                <img class="plus-icon" src="../Images/icons/iconmonstr-plus-2.svg">
                <div class="tooltip">Add</div>
            </button>
            <!--Creating Input Fields-->
            <input class="user-id-bar"  name="reid" type="number" placeholder="Id:">
            <!--Creating a Button-->
            <button class="minus-button"  name="button4" value="button4" ">
                <img class="minus-icon" src="../Images/icons/iconmonstr-minus-6.svg">
                <div class="tooltip">Remove</div>
            </button>
        </form>
        <div class="right-section">
        </div>
    </header>
    <!--Creating Navigation Bar-->
    <nav class="sidebar">
        <!--Moving Between Pages-->
        <a href="Index.php">
            <div class="sidebar-link">
                <img src="../Images/icons/iconmonstr-home-6.svg" alt="">
                <div>Home</div>
            </div>
        </a>
        <!--Current Page-->
        <div class="sidebar-link-this">
            <img src="../Images/icons/explore.svg" alt="">
            <div>Explore Advertises</div>
        </div>
        <!--Moving Between Pages-->
        <a href="../Pages/Users.php">
            <div class="sidebar-link">
                <img src="../Images/icons/iconmonstr-user-circle-thin.svg" alt="">
                <div>Explore Users</div>
            </div>
        </a>
        <div class="bottom-aligner">
        </div>
        <!--Showing creator-->
        <div class="creator">
            <p>Made by:</p> Hegedüs János
        </div>
    </nav>
        <?php
            //Printing existing Database Members to the console
            $view_variable .=$obj->getDataFromUsers();
            $view_variable .=$obj->getDataFromAdvertisements();
            //Calling all the Database Data to the Screen
            $obj->createAdvTable();
        ?>
    <?=console_log($view_variable);//Printing all gathered data to the Console?>
</Body>
</HTML>
