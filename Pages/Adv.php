<HTML>
<HEAD>
    <Title>Advertisements</Title>
    <link rel="stylesheet" href="../Styles/General.css">
    <link rel="stylesheet" href="../Styles/Sidebar.css">
    <link rel="stylesheet" href="../Styles/Header.css">
    <link rel = "icon" href ="https://cdn.iconscout.com/icon/premium/png-256-thumb/user-database-15-805248.png" type = "image/x-icon">
</HEAD>
<Body>
    <header class="header">
        <div class="left-section">
            <h1 class="page-name">Advertisements:</h1>
        <?php
            //Add
            include ("../Php Classes/DatabaseClass.php");
            include ("../Php Classes/console_log.php");
            $obj=new DatabaseClass();
            $view_variable = "";

            if(isset($_POST['button3']))
            {
                if(!(isset($_POST["userid"])) || !(isset($_POST["title"]))||!(isset($_POST["id"])))
                {
                    $view_variable .="You did not fill out the required fields.";
                }
                else
                {
                    if($_POST["title"]==""||$_POST["userid"]=="")
                    {
                        //$view_variable.= $_POST["id"]."\n";
                        //$view_variable.= $_POST["userid"]."\n";
                        //$view_variable.= $_POST["title"]."\n";
                        echo
                        '<script type="text/javascript">
                           window.onload = function () { alert("You did not fill out the required fields."); } 
                        </script>';
                    }
                    else
                    {
                        if($_POST["id"]==="") $_POST["id"]=0;
                        $obj = new Advertisements();
                        $obj0 = new DatabaseClass();
                        $view_variable .= $obj -> addNewAdvertisement($_POST["id"],$_POST["userid"],$_POST["title"]);
                        $view_variable .=$obj0-> WriteIntoAdvertisements($obj);
                        echo
                        '<script type="text/javascript">
                        window.onload = function () { alert("Record Created\n If not check console for errors!"); } 
                        </script>';
                    }
                }
            }
            if(isset($_POST['button4']))
            {
                if(!(isset($_POST["reid"])||$_POST["reid"]===""))
                {
                    $view_variable .= "You did not fill out the required fields.";
                    echo
                        '<script type="text/javascript">
                        window.onload = function () { alert("User with this Id is not found!"); } 
                        </script>';
                }
                else
                {
                    if($_POST["reid"]==="")
                    {
                        echo
                            '<script type="text/javascript">
                            window.onload = function () { alert("Id is not given"); } 
                            </script>';
                    }
                    else
                    {
                        $view_variable .= $obj->deleteDataFromAdvertisementsByID($_POST["reid"]);
                        echo
                            '<script type="text/javascript">
                             window.onload = function () { alert("Record Deleted"); } 
                             </script>';
                    }
                }
            }

        ?>
        </div>
        <form class="middle-double-section" name="form" action="" method="post">
            <input class="id-bar"  name="id" type="number" min="0" placeholder="Id:">
            <input class="user-id-bar"  name="userid" type="number" min="0" placeholder="UserId:">
            <input class="user-title-bar" name="title" type="text" placeholder="Title:">
            <button class="plus-button" name="button3" value="button3">
                <img class="plus-icon" src="../Images/icons/iconmonstr-plus-2.svg">
                <div class="tooltip">Add</div>
            </button>
            <!-- Put position absolute inside position relative -->
            <input class="user-id-bar"  name="reid" type="number" placeholder="Id:">
            <button class="minus-button"  name="button4" value="button4" ">
                <img class="minus-icon" src="../Images/icons/iconmonstr-minus-6.svg">
                <div class="tooltip">Remove</div>
            </button>
        </form>
        <div class="right-section">
        </div>
    </header>
    <nav class="sidebar">
        <a href="Index.php">
            <div class="sidebar-link">
                <img src="../Images/icons/iconmonstr-home-6.svg" alt="">
                <div>Home</div>
            </div>
        </a>
        <div class="sidebar-link-this">
            <img src="../Images/icons/explore.svg" alt="">
            <div>Explore Advertises</div>
        </div>
        <a href="../Pages/Users.php">
            <div class="sidebar-link">
                <img src="../Images/icons/iconmonstr-user-circle-thin.svg" alt="">
                <div>Explore Users</div>
            </div>
        </a>
        <div class="bottom-aligner">
        </div>
        <div class="creator">
            <p>Made by:</p> Hegedüs János
        </div>
    </nav>
        <?php

            $obj = new DatabaseClass();
                //Add
            $view_variable .=$obj->getDataFromUsers();
            $view_variable .=$obj->getDataFromAdvertisements();
            $obj->createAdvTable();
        ?>
    <?=console_log($view_variable);?>
</Body>
</HTML>
