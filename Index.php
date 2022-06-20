<HTML>
<HEAD>
    <Title>Home Page</Title>
</HEAD>
    <Body>
        <?php
            include ("DatabaseClass.php");
            $obj = new DatabaseClass();
            $obj->isInstalled();
            $obj-> WriteIntoUsers(1,"John Doe");
            $obj-> WriteIntoAdvertisements(1, 1, "Advertisement Title" );
            $a = $obj->getDataFromUsers();
            $b = $obj->getDataFromAdvertisements();
            echo "<pre>";
            echo "</pre>";
        ?>
    </Body>
</HTML>
