<HTML lang="en">
<HEAD>
    <Title>Home</Title><!--Title-->
    <!--Calling the StyleSheets-->
    <link rel="stylesheet" href="../Styles/General.css">
    <link rel="stylesheet" href="../Styles/Sidebar.css">
    <link rel="stylesheet" href="../Styles/Header.css">
    <!--Creating Icon-->
    <link rel = "icon" href ="https://cdn.iconscout.com/icon/premium/png-256-thumb/user-database-15-805248.png" type = "image/x-icon">
</HEAD>
<Body>
    <?php
        include ("../Php Classes/DatabaseClass.php");
        include ("../Php Classes/console_log.php");
        $obj=new DatabaseClass();

        $view_variable = $obj->isInstalled();
        $view_variable .=$obj->createUserTable();
        $view_variable .=$obj->createAdvertisementsTable();

    ?>
    <header class="header">
        <div class="left-section-only">
            <h1 class="page-name">Home:</h1>
        </div>
    </header>
    <!--Creating Navigation Bar-->
    <nav class="sidebar">
        <!--Current Page-->
        <div class="sidebar-link-this">
            <img src="../Images/icons/iconmonstr-home-6.svg" alt="">
            <div>Home</div>
        </div>
        <!--Moving Between Pages-->
        <a href="../Pages/Adv.php">
            <div class="sidebar-link">
                <img src="../Images/icons/explore.svg" alt="">
                <div>Explore Advertises</div>
            </div>
        </a>
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
        //Getting Data from Redirected URL using .htaccess file
        if(array_key_first($_GET)!="_ijt") //Making Sure PHPStorms Live Reload ERROR Not Popping up{
        {   //Printing other types of errors
            echo("<h1 align='center'>Error: ");
            foreach (array_keys($_GET) as $key)
            {
                echo $key . " ";
            }echo(" not found</h1>");
        }
    ?>
    <table class="welcome-table"><!--Creating Welcome Page to Show the current Task-->
        <tr>
            <td ><h1>Welcome</h1></td>
        </tr>
        <tr>
            <td class="welcome">
                <h3>In this page you can find the navbar and the empty header.</h3>
                <h2>My task was:</h2>
                <p>It's a really simple php application, based on an MVC pattern. I'd like to
                have a system which is implemented in core PHP (no framework or CMS can be
                used) and it is:
                <ul>
                    <li>URL mapped (.htaccess rewrite)</li>
                    <li>Based on an MVC pattern</li>
                    <li>Object oriented</li>
                    <li>Uses database (MySQL)</li>
                </ul>
                <h4>Requirements:</h4>
                <p>The application should have 2 database tables: users (id, name) and
                advertisements (id, userid, title).
                <p>As a user I'd like a page that shows the list of the users existing in
                the system.
                <p>As a user I'd like a page that shows the list of the existing
                advertisements in the system (and the related user's name of course)
                <p>They should be different pages
                <p>So the system should contain 3 pages:
                    <ul>
                    <li>index, with the links to the user list and the advertisement list</li>
                    <li>user list</li>
                    <li>advertisement list</li>
                    <li>The whole system should have a minimalist design (css)</li>
                </ul>

                <h4>In summary:</h4>

                <p>So it's a 3 paged application, with a minimal design, and database access,
                which is URL mapped, and based on an MVC pattern. No framework or CMS
                allowed to use.
                <p>I need the source of the application, which I expect to be about 6-8 files.
                Here can be a difference of course.

                <h4>Requirements regarding the implementation:</h4>
                <ul>
                    <li>Must be object oriented!</li>
                    <li>Must have at least 1 layer under the Controller layer</li>
                    <li>Model and service methods should be separated. Model here should be
                        clear, used only for representation.</li>
                    <li>Must have a nice, and well documented code</li>
                    <li>A very simple css, in minimal style</li>
                </ul>

                <p>This is important for us, it helps with the decision. If you can solve
                this, you definitely can fit to our project.
                <p>Let me know if you have any questions.
            </td>
        </tr>
    </table>
    <?=console_log($view_variable);//Printing all gathered data to the Console?>
</Body>
</HTML>
