<?php

session_start();

if(!isset($_SESSION['loggedInAsSuperUser'])){
  header('Location: ../adminPanel.php');
  exit();

}

require_once("../phpIncludes/Functions.php");

if(isset($_POST['key'])){

    require_once("../phpIncludes/openConnection.php");

   
  


    // 4. task

    if($_POST['key'] == 'updateRow'){
        
      
        $rateU = $con->real_escape_string($_POST['rateToSave']);
       
        $rowID = $con->real_escape_string($_POST['rowID']);

       

         $test2 = $con->query("UPDATE hashPercent SET rate='$rateU' WHERE id='$rowID'");
        
         exit('success');




    }


  // 2.Populating the table
  if($_POST['key'] == 'getExistingData'){
    $start = $con->real_escape_string($_POST['start']);
    $limit = $con->real_escape_string($_POST['limit']);

    $sql5 = $con->query("SELECT id,rate FROM hashPercent LIMIT $start, $limit");
    if($sql5->num_rows > 0){
        $response = "";
        while($data = $sql5->fetch_assoc()){
           
            $response.='
                <tr>
                    
                    <td id="rate'.$data["id"].'">'.$data["rate"].'</td>
                    <td>
                        <input type="button" onclick="viewORedit('.$data["id"].',\'edit\')" value="Edit" class="btn btn-sm" style="background-color:#1F77D0;color:#ffffff;border:0;">
                        
                    </td>
            </tr>'
            ;

        }
        exit($response );

    }else{
        exit('reachedMax');
    }

}

  //3. update form field populated

    if($_POST['key'] == 'getRowData'){

        $rowID = $con->real_escape_string($_POST['rowID']);
        $sql6 = $con->query("SELECT id,rate FROM hashPercent WHERE id='$rowID'");
        $data2 = $sql6->fetch_assoc();

        $jsonArray = array(
            'r' => $data2['rate']
        );

        exit(json_encode($jsonArray));

    }

    $rowID = $con->real_escape_string($_POST['rowID']);

}

?>