<?php

session_start();

if(!isset($_SESSION['loggedInAsSuperUser'])){
  header('Location: ../adminPanel.php');
  exit();

}

require_once("../phpIncludes/Functions.php");

if(isset($_POST['key'])){

    require_once("../phpIncludes/openConnection.php");


  // 1.Populating the table
  if($_POST['key'] == 'getExistingData'){
    $start = $con->real_escape_string($_POST['start']);
    $limit = $con->real_escape_string($_POST['limit']);

    $sql5 = $con->query("SELECT id,username,percent,mineUnit,mineComplete,dates FROM mineTable LIMIT $start, $limit");
    if($sql5->num_rows > 0){
        $response = "";
        while($data = $sql5->fetch_assoc()){
            $nice =  ($data["mineComplete"] == 1)?  'Complete' : 'In-progress';
           
            $response.='
                <tr>
                    
                    <td id="one'.$data["id"].'">'.$data["username"].'</td>
                    <td id="three'.$data["id"].'">'.$data["percent"].'</td>
                    <td id="four'.$data["id"].'">'.$data["mineUnit"].'</td>
                    <td id="six'.$data["id"].'">'.$nice .'</td>
                    <td id="two'.$data["id"].'">'.$data["dates"].'</td>
                    
            </tr>'
            ;

        }
        exit($response );

    }else{
        exit('reachedMax');
    }

}

  //3. update form field populated



    $rowID = $con->real_escape_string($_POST['rowID']);

}

?>