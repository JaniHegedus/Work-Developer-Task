<HTML lang="en">
    <HEAD>
        <Title>Users</Title><!--Title-->
        <!--Calling the StyleSheets-->
        <link rel="stylesheet" href="../Styles/General.css">
        <link rel="stylesheet" href="../Styles/Sidebar.css">
        <link rel="stylesheet" href="../Styles/Header.css">
        <!--Creating Icon-->
        <link rel = "icon" href ="https://cdn.iconscout.com/icon/premium/png-256-thumb/user-database-15-805248.png" type = "image/x-icon">
    </HEAD>
    <Body>
        <?php
        //Including PHP CLasses to use them
        include ("../Php Classes/DatabaseClass.php");
        include ("../Php Classes/console_log.php");
        //Creating Console Log Variable
        $view_variable="";
        //Creating object to reach methods
        $obj=new DatabaseClass();

        if(isset($_POST['button1'])) //If Button 1 is clicked
        {
            if(!(isset($_POST["UserName"]))||$_POST["UserName"]==="") //And Fields aren't empty or not set
            {
                $view_variable .="You did not fill out the required fields.";//Console Logging
                echo
                '<script type="text/javascript">
                                   window.onload = function () { alert("You did not fill out the required fields."); } 
                                </script>';//Error Popup
            }
            else//If not empty and set
            {
                if($_POST["id"]==="") $_POST["id"]=0; //If Adv ID not given setting it to 0 to make a new record anyway
                $obj0 = new User(); //Creating object to create new User
                $obj0->addNewUser($_POST["id"],$_POST["UserName"]); //Creating new User
                $view_variable .=$obj->WriteIntoUsers($obj0); //Adding to Console Log and Writing into the correct DataBase
                echo
                '<script type="text/javascript">
                               window.onload = function () { alert("Record Created\n If not check console for errors!"); } 
                            </script>';//Half-Success Popup
            }
        }
        if(isset($_POST['button2']))//If Button 2 is clicked
        {
            if(!(isset($_POST["remid"]))||$_POST["remid"]==="")//And Fields aren't empty
            {
                $view_variable .= "You did not fill out the required fields.";//Console Logging
                echo
                '<script type="text/javascript">
                               window.onload = function () { alert("Id is not given!"); } 
                            </script>';//Error Popup
            }
            else//If not empty and set
            {
                $view_variable = $obj->deleteDataFromUsersByID($_POST["remid"]); ////Console Logging And Removing from DataBase
                echo
                '<script type="text/javascript">
                               window.onload = function () { alert("Record Deleted"); } 
                            </script>';//Success Popup
            }
        }
        ?>
        <header class="header">
            <div class="left-section">
                <h1 class="page-name">Users: </h1>
            </div>
            <!--Creating Form area from witch we can get data-->
            <form class="middle-section" name="form" action="" method="post">
                <!--Creating Input Fields-->
                <input class="id-bar"  name="id" type="number" min="0" placeholder="Id:">
                <input class="user-name-bar"  name="UserName" type="text" placeholder="UserName">
                <!--Creating a Button-->
                <button class="plus-button" name="button1">
                    <img class="plus-icon" src="../Images/icons/iconmonstr-user-23.svg">
                    <div class="tooltip">Add</div>
                </button>
                <!--Creating Input Fields-->
                <input class="user-id-bar"  name="remid" type="number" placeholder="Id:">
                <!--Creating a Button-->
                <button class="minus-button" name="button2">
                    <img class="minus-icon" src="../Images/icons/iconmonstr-user-27.svg">
                    <div class="tooltip">Remove</div>
                </button>
            </form>
            <div class="right-section">
            </div>
        </header>
        <!--Creating Navigation Bar-->
        <nav class="sidebar">
            <!--Moving Between Pages-->
            <a href="../Pages/Index.php">
                <div class="sidebar-link">
                    <img src="../Images/icons/iconmonstr-home-6.svg" alt="">
                    <div>Home</div>
                </div>
            </a>
            <!--Moving Between Pages-->
            <a href="../Pages/Adv.php">
                <div class="sidebar-link">
                    <img src="../Images/icons/explore.svg" alt="">
                    <div>Explore Advertises</div>
                </div>
            </a>
            <!--Current Page-->
            <div class="sidebar-link-this">
                <img src="../Images/icons/iconmonstr-user-circle-thin.svg" alt="">
                <div>Explore Users</div>
            </div>
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
            $obj->createUsersTable();
        ?>
        <?=console_log($view_variable);//Printing all gathered data to the Console?>
    </Body>
</HTML>
