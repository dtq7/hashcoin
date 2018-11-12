<?php

session_start();

if(!isset($_SESSION['loggedInAsSuperUser'])){
  header('Location: ../adminPanel.php');
  exit();

}
require_once("../phpIncludes/Functions.php");

if(isset($_POST['key'])){

    require_once("../phpIncludes/openConnection.php");

    $prop = time();
    //$prop = date('Y-m-d',$timestamp);

  



  
    
    if($_POST['key'] == 'updateRow'){
        
        
        
       
        $bitcoin = $con->real_escape_string($_POST['bitcoinToSave']);
        $ethereum = $con->real_escape_string($_POST['ethereumToSave']);
        $yuan = $con->real_escape_string($_POST['yuanToSave']);
        $zin = $con->real_escape_string($_POST['zinToSave']);
        $plin = $con->real_escape_string($_POST['plinToSave']);
       
        $rowID = $con->real_escape_string($_POST['rowID']);

       

       
         $test2 = $con->query("UPDATE cryptos SET Bitcoin='$bitcoin',Ethereum='$ethereum',Yuan='$yuan',Zin='$zin',Plin='$plin' WHERE pick='only'");
        
    
            exit('success');

            




    }


  // 2.Populating the table
  if($_POST['key'] == 'getExistingData'){
    $start = $con->real_escape_string($_POST['start']);
    $limit = $con->real_escape_string($_POST['limit']);

    $sql5 = $con->query("SELECT id,Trade,Withdraw FROM news LIMIT $start, $limit");
    if($sql5->num_rows > 0){
        $response = "";
        while($data = $sql5->fetch_assoc()){
            $tradeStatus = ($data['Trade'] == 1)? "Enabled":"Not enabled";
            $withdrawStatus = ($data['Withdraw'] == 1)? "Enabled":"Not enabled";
           
            $response.='
                <tr>
                    
                    <td id="tradeSpecial">'.$tradeStatus.'</td>
                    <td id="withdrawSpecial">'.$withdrawStatus.'</td>
                    
                    <td>
                        <input type="button" onclick="viewORedit('.$data["id"].',\'edit\')" value="cyptos" class="btn btn-sm" style="background-color:#1F77D0;color:#ffffff;border:0;display:non">
                        
                        <input type="button" onclick="enableWithdraw()" value="enableWithdraw" class="btn btn-sm btn-primary">
                        <input type="button" onclick="disableWithdraw()" value="disableWithdraw" class="btn btn-sm btn-danger">
                        <input type="button" onclick="enableTrade()" value="enableTrade" class="btn btn-sm btn-primary">
                        <input type="button" onclick="disableTrade()" value="disableTrade" class="btn btn-sm btn-danger">
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
        $sql6 = $con->query("SELECT * FROM cryptos");
        $data2 = $sql6->fetch_assoc();

        $jsonArray = array(
           
            'bitcoin' => $data2['Bitcoin'],
            'ethereum' => $data2['Ethereum'],
            'yuan' => $data2['Yuan'],
            'zin' => $data2['Zin'],
            'plin' => $data2['Plin'],
           
        );

        exit(json_encode($jsonArray));

    }

  //  $rowID = $con->real_escape_string($_POST['rowID']);

    if($_POST['key'] == 'enableTrade'){
        $con->query("UPDATE news SET Trade = 1 WHERE pick='only'");
        exit('Trade enabled');
    }

    if($_POST['key'] == 'disableTrade'){
        $con->query("UPDATE news SET Trade = 0 WHERE pick='only'");
        exit('Trade disabled');
    }

    if($_POST['key'] == 'enableWithdraw'){
        $con->query("UPDATE news SET Withdraw = 1 WHERE pick='only'");
        exit('Withdraw enabled');
    }

    if($_POST['key'] == 'disableWithdraw'){
        $con->query("UPDATE news SET withdraw = 0 WHERE pick='only'");
        exit('Withdraw disabled');
    }
}

?>