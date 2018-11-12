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

  


  

    // 1. Adding new User
    if($_POST['key'] == 'addNew'){
        
    $fullname = $con->real_escape_string($_POST['nameToSave']);
    $username = $con->real_escape_string($_POST['userToSave']);
    $password = $con->real_escape_string($_POST['passToSave']);
    $email = $con->real_escape_string($_POST['emailToSave']);
    $phonenumber = $con->real_escape_string($_POST['phoneNumberToSave']);
    $bitcoin = $con->real_escape_string($_POST['bitcoinToSave']);
    $unit = $con->real_escape_string($_POST['unitToSave']);
    $isActivated = $con->real_escape_string($_POST['isActivatedToSave']);
    $isSuspended = $con->real_escape_string($_POST['isSuspendedToSave']);
    $token = tokenGenerator(15);


    $sql1 = $con->query("SELECT id FROM users WHERE email='$email'");
    if($sql1->num_rows > 0){
        exit('email exists');
    }



    $sql2 = $con->query("SELECT id FROM users WHERE username='$username'");
    if($sql2->num_rows > 0){
      exit('username exists');
    }



   

   
     

    if($sql1->num_rows == 0 && $sql2->num_rows == 0){


        $test = $con->query("INSERT INTO users(fullName, userName, hashedPassword,email,token, phoneNumber,isEmailConfirmed,referralUnit,unit,isSuspended,bitcoinWalletAddress,dateWeeklyUnitActivated) VALUES 
                                              ('$fullname','$username','$password','$email','$token','$phonenumber',$isActivated,0,$unit,$isSuspended,'$bitcoin','$prop')");

   

        if($test){
          exit('success');
        }
        else {
          exit('failed');
        }

    }


    } //End of task 1






    if($_POST['key'] == 'payNew'){
        
        $amount = $con->real_escape_string($_POST['amountToSave']);

        $rowID = $con->real_escape_string($_POST['rowID']);
      
    
    
             $test = $con->query("UPDATE users SET unit = unit + '$amount' WHERE id='$rowID'");

             $total = $con->query("SELECT id,unit FROM users WHERE id='$rowID'");
             $totalData = $total->fetch_assoc();

             $value = $totalData['unit'];
    
       
    
            if($test){
              $res = [
                  "successMessage" => "success",
                  "balance" => round($value,2)
              ];  
              exit(json_encode($res));
            }
            else {
                $res = 'failed';  
                exit(json_encode($res));
            }
    
        
    
    
        } //End of task #






    // 4. task

    if($_POST['key'] == 'updateRow'){
        
        $fullname = $con->real_escape_string($_POST['nameToSave']);
        $username = $con->real_escape_string($_POST['userToSave']);
        $password = $con->real_escape_string($_POST['passToSave']);
        $email = $con->real_escape_string($_POST['emailToSave']);
        $phonenumber = $con->real_escape_string($_POST['phoneNumberToSave']);
        $bitcoin = $con->real_escape_string($_POST['bitcoinToSave']);
        $unit = $con->real_escape_string($_POST['unitToSave']);
        $isActivated = $con->real_escape_string($_POST['isActivatedToSave']);
        $isSuspended = $con->real_escape_string($_POST['isSuspendedToSave']);
        $rowID = $con->real_escape_string($_POST['rowID']);

        $sql9 = $con->query("SELECT userName,email FROM users WHERE id='$rowID'");
        $data3 = $sql9->fetch_assoc();
        $currentEmail = $data3['email'];
        $currentUser = $data3['userName'];
    
    
        $sql7 = $con->query("SELECT email FROM users WHERE email='$email'");
        $data4 = $sql7->fetch_assoc();

        
        if($sql7->num_rows > 0){
            if($data4['email'] != $currentEmail){
                exit('email exists');
            }
        }

        $sql8 = $con->query("SELECT userName FROM users WHERE userName='$username'");
        $data5 = $sql8->fetch_assoc();

        if($sql8->num_rows > 0){
            if($data5['userName'] != $currentUser){
                exit('user exists');
            }
        }

         $test2 = $con->query("UPDATE users SET fullName='$fullname', userName='$username', hashedPassword='$password',email='$email',phoneNumber='$phonenumber',isEmailConfirmed=$isActivated,unit=$unit,isSuspended=$isSuspended,bitcoinWalletAddress='$bitcoin' WHERE id='$rowID'");
    
            exit('success');




    }


  // 2.Populating the table
  if($_POST['key'] == 'getExistingData'){
    $start = $con->real_escape_string($_POST['start']);
    $limit = $con->real_escape_string($_POST['limit']);

    $sql5 = $con->query("SELECT id,fullName,userName,email,phoneNumber,unit,isSuspended FROM users LIMIT $start, $limit");
    if($sql5->num_rows > 0){
        $response = "";
        while($data = $sql5->fetch_assoc()){
           $niceSuspensionVal =  ($data["isSuspended"] == 0)?  'Active' : 'Suspended';
           $formatedUnit = round($data["unit"],2);
            $response.='
                <tr>
                    
                    <td id="fullname'.$data["id"].'">'.$data["fullName"].'</td>
                    <td id="username'.$data["id"].'">'.$data["userName"].'</td>
                    <td id="email'.$data["id"].'">'.$data["email"].'</td>
                    <td id="phonenumber'.$data["id"].'">'.$data["phoneNumber"].'</td>
                    <td id="unit'.$data["id"].'">'.$formatedUnit.'</td>
                    <td id="suspended'.$data["id"].'">'.$niceSuspensionVal.'</td>
                    <td>
                        <input type="button" onclick="viewORedit('.$data["id"].',\'edit\')" value="Edit" class="btn btn-sm" style="background-color:#1F77D0;color:#ffffff;border:0;">
                        <input type="button" onclick="viewORedit('.$data["id"].',\'pay\')" value="pay" class="btn btn-sm" style="background-color:#a59746;color:#ffffff;border:0;">
                        <input type="button" onclick="viewORedit('.$data["id"].',\'view\')" value="View" class="btn btn-sm" style="background-color:grey;color:#ffffff;border:0;">
                        <input type="button" onclick="deleteRow('.$data["id"].')" value="Delete" class="btn btn-sm btn-danger">
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
        $sql6 = $con->query("SELECT fullName,userName,hashedPassword,email,phoneNumber,unit,isEmailConfirmed,isSuspended,bitcoinWalletAddress,referer,referralUnit,isMiningActivated,dateCreated FROM users WHERE id='$rowID'");
        $data2 = $sql6->fetch_assoc();

        $jsonArray = array(
            'fullname' => $data2['fullName'],
            'username' => $data2['userName'],
            'password' => $data2['hashedPassword'],
            'email' => $data2['email'],
            'phonenumber' => $data2['phoneNumber'],
            'unit' => $data2['unit'],
            'bitcoin' => $data2['bitcoinWalletAddress'],
            'referer' => $data2['referer'],
            'referralunit' => $data2['referralUnit'],
            'miningactivated' => $data2['isMiningActivated'],
            'datecreated' => $data2['dateCreated'],
            'activated' => $data2['isEmailConfirmed'],
            'suspended' => $data2['isSuspended']

        );

        exit(json_encode($jsonArray));

    }

    $rowID = $con->real_escape_string($_POST['rowID']);

    if($_POST['key'] == 'deleteRow'){
        $con->query("DELETE FROM users WHERE id='$rowID'");
        exit('The row has been deleted');
    }

}

?>