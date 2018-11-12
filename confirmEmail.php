<?php

    if(!isset($_GET['email']) || !isset($_GET['token'])){
        header('Location: join.php');
        exit();
    }else{
        require_once('./phpIncludes/openConnection.php');

        $eml = $con->real_escape_string($_GET['email']);
        $tok= $con->real_escape_string($_GET['token']);

        $sql = $con->query("SELECT id FROM users WHERE email='$eml' AND token='$tok' AND isEmailConfirmed=0");
       // echo $sql->num_rows;
        if($sql->num_rows > 0){
            $con->query("UPDATE users SET isEmailConfirmed=1, token='' WHERE email='$eml'");
            header('Location: index.php');
            exit();
        }



    }


?>