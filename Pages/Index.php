<HTML>
<HEAD>
    <Title>Home Page</Title>
    <link rel="stylesheet" href="../Styles/General.css">
    <link rel="stylesheet" href="../Styles/Sidebar.css">
    <link rel="stylesheet" href="../Styles/Header.css">
</HEAD>
<Body>
    <?php
            include ("../Php Classes/DatabaseClass.php");
            include ("../Php Classes/console_log.php");
            $view_variable="";
            //Minimum Req
            $obj = new DatabaseClass();

            $view_variable = $obj->isInstalled();
            $view_variable .=$obj->createUserTable();
            $view_variable .=$obj->createAdvertisementsTable();


            function AddnewUsers($userid,$username):string
            {
                $result="";
                $obj = new Advertisements();
                $obj0 = new DatabaseClass();
                $result .=$obj -> addNewUser($userid,$username);
                $result .=$obj0-> WriteIntoUsers($obj);
                return $result;
            }
            function AddnewAdv($id,$userid,$adv ):string
            {
                $result="";
                $obj = new Advertisements();
                $obj0 = new DatabaseClass();
                try
                {
                    $result .= $obj -> addNewAdvertisement($id, $userid,$adv );
                }
                catch (TypeError){

                };
                $result .=$obj0-> WriteIntoAdvertisements($obj);
                return $result;
            }
            function readDataFromDataBase():string
            {
                $result="";
                $obj = new DatabaseClass();
                $result .=$obj->getDataFromUsers();
                $result .=$obj->getDataFromAdvertisements();
                return $result;
            }
            function deletedata($id):string
            {
                $result="";
                $obj = new DatabaseClass();
                $result .=$obj ->deleteDataFromAdvertisementsByuserid($id);
                $result .=$obj ->deleteDataFromUsersByID($id);
                return $result;
            }
            function modifyName($id,$name):string
            {
                $result="";
                $obj = new DatabaseClass();
                $result .=$obj ->modifyDataFromUsersByuserid($id,$name);
                return $result;
            }
            function modifyAdv($id,$adv):string
            {
                $result="";
                $obj = new DatabaseClass();
                $result .=$obj ->modifyDataFromAdvertisementsByUserId($id,$adv);
                return $result;
            }

            //Add
            $view_variable .= AddnewUsers(1, "John");
            $view_variable .=AddnewAdv(1,1,"Title");
            $view_variable .=AddnewAdv(2,1,"Title0");
            //$view_variable .=AddnewAdv(3,1,"Title1");
            //$view_variable .=readDataFromDataBase();


            //Add
            $view_variable .=AddnewUsers(1,"John");
            $view_variable .=AddnewAdv(4,1,"Title");
            //$view_variable .=AddnewAdv(5,1,"Title0");
            //$view_variable .=AddnewAdv(6,1,"Title1");

            //check
            //$view_variable .=readDataFromDataBase();

            //$view_variable .=AddnewUsers(2,"John");


            //delete
            //$view_variable.=$obj ->deleteDataFromAdvertisementsByuserid(1);
            //$view_variable.=$obj ->deleteDataFromAdvertisementsByID(1);

            $view_variable .=readDataFromDataBase();
            $view_variable .=AddnewAdv(7,2,"Title");
            //$view_variable .=AddnewAdv(8,2,"Title0");
            //$view_variable .=AddnewAdv(9,2,"Title1");
            //$view_variable .=readDataFromDataBase();
        ?>
    <header class="header">
        <div class="left-section">
            <img class="hamburger-menu" src="../Images/icons/hamburger-menu.svg">
        </div>
        <div class="middle-section">
            <input class="search-bar" type="text" placeholder="Name">
            <button class="search-button">
                <img class="search-icon" src="../Images/icons/iconmonstr-plus-2.svg">
                <div class="tooltip">Add</div>
            </button>
            <!-- Put position absolute inside position relative -->
            <button class="voice-search-button">
                <img class="voice-search-icon" src="../Images/icons/iconmonstr-minus-6.svg">
                <div class="tooltip">Remove</div>
            </button>
        </div>
        <div class="right-section">
        </div>
    </header>
    <nav class="sidebar">
        <div class="sidebar-link">
            <img src="../Images/icons/home.svg" alt="">
            <div>Home</div>
        </div>
        <div class="sidebar-link">
            <img src="../Images/icons/explore.svg" alt="">
            <div>Explore Advertises</div>
        </div>
    </nav>
    <?= console_log($view_variable); ?>
</Body>
</HTML>
