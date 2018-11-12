<?php

session_start();

if(!isset($_SESSION['loggedInAsSuperUser'])){
  header('Location: ../adminPanel.php');
  exit();

}

require_once("../phpIncludes/Functions.php");
 require_once("../phpIncludes/openConnection.php");
if(isset($_POST['key'])){

   
    
  // 2.Populating the table
  if($_POST['key'] == 'getExistingData'){
    $start = $con->real_escape_string($_POST['start']);
    $limit = $con->real_escape_string($_POST['limit']);

    $sql = $con->query("SELECT id,username,unit,dates,addressed FROM sellRequest WHERE addressed=0 LIMIT $start, $limit ");
    if($sql->num_rows > 0){
        $response = "";
        while($data = $sql->fetch_assoc()){
           $niceAddressedVal =  ($data["addressed"] == 0)?  'Not Addressed' : 'Addressed';
            $response.='
                <tr>
                    
                    <td id="username'.$data["id"].'">'.$data["username"].'</td>
                    <td>'.$data["unit"].'</td>
                    
                    <td>'.$data["dates"].'</td>
                    <td>'. $niceAddressedVal.'</td>
                    <td>
                        <input type="button" onclick="deleteRow('.$data["id"].')" value="Address Request" class="btn btn-sm btn-success">
                    </td>
            </tr>'
            ;

        }
        exit($response );

    }else{
        exit('reachedMax');
    }

}

    $rowID = $con->real_escape_string($_POST['rowID']);

    if($_POST['key'] == 'deleteRow'){
        $con->query("UPDATE sellRequest SET addressed=1 WHERE id='$rowID'");
        exit('The Request has been addressed');
    }

}

?>