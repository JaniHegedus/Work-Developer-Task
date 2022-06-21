<HTML>
<HEAD>
    <Title>Users</Title>
    <link rel="stylesheet" href="../Styles/General.css">
    <link rel="stylesheet" href="../Styles/Sidebar.css">
    <link rel="stylesheet" href="../Styles/Header.css">
    <link rel = "icon" href ="https://cdn.iconscout.com/icon/premium/png-256-thumb/user-database-15-805248.png" type = "image/x-icon">
</HEAD>
<Body>
<?php
include ("../Php Classes/DatabaseClass.php");
include ("../Php Classes/console_log.php");
$view_variable="";
//Minimum Req
$obj=new DatabaseClass();

$view_variable = $obj->isInstalled();
$view_variable .=$obj->createUserTable();
$view_variable .=$obj->createAdvertisementsTable();
if(isset($_POST['button1']))
{
    if(!(isset($_POST["UserName"]))||$_POST["UserName"]==="")
    {
        $view_variable .="You did not fill out the required fields.";
        echo
        '<script type="text/javascript">
                           window.onload = function () { alert("You did not fill out the required fields."); } 
                        </script>';
    }
    else
    {
        if($_POST["id"]==="") $_POST["id"]=0;
        $obj0 = new User();
        $obj0->addNewUser($_POST["id"],$_POST["UserName"]);
        $view_variable .=$obj->WriteIntoUsers($obj0);
        echo
        '<script type="text/javascript">
                       window.onload = function () { alert("Record Created\n If not check console for errors!"); } 
                    </script>';
    }
}
if(isset($_POST['button2']))
{
    if(!(isset($_POST["reid"]))||$_POST["reid"]==="")
    {
        $view_variable .= "You did not fill out the required fields.";
        echo
        '<script type="text/javascript">
                       window.onload = function () { alert("Id is not given!"); } 
                    </script>';
    }
    else
    {
        $result = $obj->deleteDataFromUsersByID($_POST["reid"]);
        $view_variable .= $result;
        echo
        '<script type="text/javascript">
                       window.onload = function () { alert("Record Deleted"); } 
                    </script>';
    }
}
?>
<header class="header">
    <div class="left-section">
        <h1 class="page-name">Users: </h1>
    </div>
    <form class="middle-section" name="form" action="" method="post">
        <input class="id-bar"  name="id" type="number" min="0" placeholder="Id:">
        <input class="user-name-bar"  name="UserName" type="text" placeholder="UserName">
        <button class="plus-button" name="button1">
            <img class="plus-icon" src="../Images/icons/iconmonstr-user-23.svg">
            <div class="tooltip">Add</div>
        </button>
        <!-- Put position absolute inside position relative -->
        <input class="user-id-bar"  name="reid" type="number" placeholder="Id:">
        <button class="minus-button" name="button2">
            <img class="minus-icon" src="../Images/icons/iconmonstr-user-27.svg">
            <div class="tooltip">Remove</div>
        </button>
    </form>
    <div class="right-section">
    </div>
</header>
<nav class="sidebar">
    <a href="../Pages/Index.php">
        <div class="sidebar-link">
            <img src="../Images/icons/iconmonstr-home-6.svg" alt="">
            <div>Home</div>
        </div>
    <a href="../Pages/Adv.php">
    <a href="../Pages/Adv.php">
        <div class="sidebar-link">
            <img src="../Images/icons/explore.svg" alt="">
            <div>Explore Advertises</div>
        </div>
    </a>
    <div class="sidebar-link-this">
        <img src="../Images/icons/iconmonstr-user-circle-thin.svg" alt="">
        <div>Explore Users</div>
    </div>
    <div class="bottom-aligner">
    </div>
    <div class="creator">
        <p>Made by:</p> Hegedüs János
    </div>
</nav>
<?php
//Add
$view_variable .=$obj->getDataFromUsers();
$view_variable .=$obj->getDataFromAdvertisements();
$obj->createUsersTable();
?>
<?=console_log($view_variable);?>
</Body>
</HTML>
