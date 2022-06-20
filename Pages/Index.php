<HTML>
<HEAD>
    <Title>Home Page</Title>
</HEAD>
    <Body>
        <?php
            include ("../Php Classes/DatabaseClass.php");
            include "../Php Classes/console_log.php";
            $i=0;
            function firstSteps():string
            {
                $obj = new DatabaseClass();

                $result="";
                $result .=$obj->isInstalled();
                $result .=$obj ->createUserTable();
                $result .=$obj->createAdvertisementsTable();
                return $result;
            }
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
                $result .=$obj -> addNewAddvertisement($id, $userid,$adv );
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
            //Minimum Req
            $view_variable = firstSteps();
            //Add
            $view_variable .=AddnewUsers(1,"John");
            //$view_variable .=AddnewAdv(1,1,"Title");
            //$view_variable .=AddnewAdv(2,1,"Title0");
            //$view_variable .=AddnewAdv(3,1,"Title1");
            $view_variable .=readDataFromDataBase();

            //delete
            $obj = new DatabaseClass();
            $view_variable.=$obj ->deleteDataFromAdvertisementsByuserid(1);
            $view_variable.=$obj ->deleteDataFromAdvertisementsByID(1);

            //Add
            $view_variable .=AddnewUsers(1,"John");
            //$view_variable .=AddnewAdv(4,1,"Title");
            //$view_variable .=AddnewAdv(5,1,"Title0");
            //$view_variable .=AddnewAdv(6,1,"Title1");

            //check
            $view_variable .=readDataFromDataBase();

            $view_variable .=AddnewUsers(2,"John");
            //$view_variable .=AddnewAdv(7,2,"Title");
            //$view_variable .=AddnewAdv(8,2,"Title0");
            //$view_variable .=AddnewAdv(9,2,"Title1");
            //$view_variable .=readDataFromDataBase();

        ?>

        <?= console_log($view_variable); ?>
    </Body>
</HTML>
