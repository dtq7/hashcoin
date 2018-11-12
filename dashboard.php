<?php

session_start();

if(!isset($_SESSION['loggedIn'])){
  header('Location: index.php');
  exit();

}
$loggedInUser = $_SESSION['user'];

$res = '';
$picture="";
$packageActive = "";
$activator = "";
$totalBalance = "";
$referralBalance = "";
$fullName ="";
$email = "";
$contact = "";
$bitcoinAddress =""; 
$unit = "";
$referralUnit = "";
$rate = "";
$tradeStatus = "";
$withdrawStatus = "";

$bi = '';
$et = '';
$yu = '';
$zi = '';
$pl = '';


$timestamp = time();
$prop = date('Y-m-d',$timestamp);

require_once('./phpIncludes/openConnection.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Get crypto results
$sqlCrpts = $con->query("SELECT id,Bitcoin,Ethereum,Yuan,Zin,Plin FROM cryptos WHERE pick='only'");
$dataCrpts = $sqlCrpts->fetch_assoc();
$bi = $dataCrpts["Bitcoin"];
$et = $dataCrpts["Ethereum"];
$yu = $dataCrpts["Yuan"];
$zi = $dataCrpts["Zin"];
$pl = $dataCrpts["Plin"];



                    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// First thing to do is to pay mining debt for the first 3days
$sqlFirst = $con->query("SELECT * FROM mineTable WHERE username='$loggedInUser' AND mineComplete =0");

while($row = $sqlFirst->fetch_assoc()){

  $twoTimesCount = $row['kount'];
   
  $prev =  $row['computerDate'];


  $curr = time();

 $diff = floor(($curr - $prev)/(60*60*24));

 if($diff >= 3 && $twoTimesCount == 1){


        $profit = ($row['mineUnit'] * (floatval($row['percent'])/100));
        $id = $row['id'];
        $con->query("UPDATE mineTable SET mineComplete=0, computerDate=computerDate+(60*60*24*3),kount = kount + 1 WHERE id='$id'"); 
        $con->query("UPDATE users SET unit = unit - '$profit' WHERE userName='HASHCOIN'");
        $con->query("UPDATE users SET unit = unit + '$profit' WHERE userName='$loggedInUser'");
        $messageRef = "Your trading for the first three days is complete. Your account has been credited with " . $profit . " Dollars" ;
        $con->query("INSERT into notificationTable(username,notifications) VALUES('$loggedInUser','$messageRef')");

   


        $idF = $row['id'];

        $sqlFormatDate = $con->query("SELECT * FROM mineTable WHERE id='$idF'");
        $dataDateFormat = $sqlFormatDate->fetch_assoc();
        $unformatedDate = $dataDateFormat['computerDate'];
        $newFormatedDate =  date('Y-m-d',$unformatedDate);

        $con->query("UPDATE mineTable SET dates = '$newFormatedDate' WHERE id='$idF'");



 }
}


// Second thing to do is to pay mining debt for the second 3days
$sqlSecond = $con->query("SELECT * FROM mineTable WHERE username='$loggedInUser' AND mineComplete =0");

while($row2 = $sqlSecond->fetch_assoc()){

  $twoTimesCount2 = $row2['kount'];
   
  $prev2 =  $row2['computerDate'];


  $curr2 = time();

 $diff2 = floor(($curr2 - $prev2)/(60*60*24));

 if($diff2 >= 3 && $twoTimesCount2 == 2){


        $profit = ($row2['mineUnit'] * (floatval($row2['percent'])/100));
        $profitCapital = $row2['mineUnit'] + $profit;
        $id = $row2['id'];
        $con->query("UPDATE mineTable SET mineComplete=1, computerDate=computerDate+(60*60*24*3),kount = kount + 1 WHERE id='$id'"); 
        $con->query("UPDATE users SET unit = unit - '$profitCapital' WHERE userName='HASHCOIN'");
        $con->query("UPDATE users SET unit = unit + '$profitCapital' WHERE userName='$loggedInUser'");
        $messageRef = "Your trading for the second three days is complete. Your account has been credited with " . $profitCapital . " Dollars" ;
        $con->query("INSERT into notificationTable(username,notifications) VALUES('$loggedInUser','$messageRef')");

   


        $idF = $row2['id'];

        $sqlFormatDate = $con->query("SELECT * FROM mineTable WHERE id='$idF'");
        $dataDateFormat = $sqlFormatDate->fetch_assoc();
        $unformatedDate = $dataDateFormat['computerDate'];
        $newFormatedDate =  date('Y-m-d',$unformatedDate);

        $con->query("UPDATE mineTable SET dates = '$newFormatedDate' WHERE id='$idF'");



 }
}

//Get trade status and withdraw status
$sqlStatus = $con->query("SELECT * FROM news WHERE pick='only'");
$dataStatus = $sqlStatus->fetch_assoc();
$tradeStatus = $dataStatus['Trade'];
$withdrawStatus= $dataStatus['Withdraw'];


 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 //Image setting
$src="";

$sqlPic = $con->query("SELECT profilePicture FROM users WHERE userName='$loggedInUser'");
$dataPic = $sqlPic->fetch_assoc();
$resl = $dataPic['profilePicture'];
if(($resl) != ''){
    $src = "data:image/jpeg;base64,";
    $src.=base64_encode($resl);
   
}else{
    $src="./images/default-avatar.png";
}
$sqlPic->free_result();

 //Get general details
$sqlGeneral = $con->query("SELECT id,fullName,userName,email,phoneNumber,bitcoinWalletAddress,unit,referralUnit FROM users WHERE userName='$loggedInUser'");
$dataGeneral = $sqlGeneral->fetch_assoc();
$fullName = $dataGeneral['fullName'];
$email = $dataGeneral['email'];
$contact = $dataGeneral['phoneNumber'];
$bitcoinAddress = $dataGeneral['bitcoinWalletAddress'];
$unit = $dataGeneral['unit'];
$referralUnit = $dataGeneral['referralUnit'];

//Get rate
$sqlRate = $con->query("SELECT id,rate FROM hashPercent where id=1");
$dataRate = $sqlRate->fetch_assoc();
$rate = $dataRate['rate'];


//Enable accounts that have paid up
$sqlEnable = $con->query("SELECT id,unit,package FROM users WHERE userName='$loggedInUser' AND packageActivated=0");
$dataEnable = $sqlEnable->fetch_assoc();
$unitEnable = $dataEnable['unit'];
$packageEnable = $dataEnable['package'];
$doubleEnable = $unitEnable * 2;

if($unitEnable >= $packageEnable){
    $con->query("UPDATE users SET packageActivated=1 WHERE userName='$loggedInUser'");
}else{
    //
}

//Pay up referer
$sqlReferral = $con->query("SELECT id,package,referer FROM users WHERE userName='$loggedInUser' AND paidReferral=0 AND packageActivated=1");
$dataReferral = $sqlReferral->fetch_assoc();
$packageReferral = $dataReferral['package'];
$nameReferrral =$dataReferral['referer'];
$percentReferral = 0.05 * $packageReferral;
if($sqlReferral->num_rows>0){
    $testRef = $con->query("UPDATE users SET referralUnit=referralUnit + $percentReferral WHERE userName='$nameReferrral'");
    $messageReferral = "Your account has been credited with " .$percentReferral."dollars for refering user ". $loggedInUser."." ;
    $con->query("INSERT into notificationTable(username,notifications) VALUES('$nameReferrral','$messageReferral')");
    if($testRef){
        $con->query("UPDATE users SET paidReferral=1 WHERE userName='$loggedInUser'");
    }
   
}


 //Disable accounts that are not actve.
 $sqlDisable = $con->query("SELECT id,packageActivated,package FROM users WHERE userName='$loggedInUser'");
 $dataDisable = $sqlDisable->fetch_assoc();
 $valueDisable = $dataDisable['packageActivated'];
 if($valueDisable == 0){
    $packageActive = "no";
    $activator = "ACTIVATE ACCOUNT";
 }else{
     $packageActive = "yes";
 }

//Change profile picture
 if(isset($_POST['insert'])){ 
    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"])); 
    $sql = $con->query("UPDATE users SET profilePicture = '$file' WHERE userName='$loggedInUser'");
    if($sql){
        $picture = "good";
    }else{
        $picture = "bad";
    }
    
}





        if(isset($_POST['key'])){

            if($_POST['key'] == 'getDetailsInProgress'){
                $sqlmineDetails = $con->query("SELECT id,mineUnit,mineComplete FROM mineTable WHERE username='$loggedInUser' AND mineComplete=0");
               if($sqlmineDetails->num_rows > 0){
                   $respons = "";
                   while($data = $sqlmineDetails->fetch_assoc()){
                     //  $getTheTime =  strtotime($data["dates"]);
                       $getTheUnit = $data["mineUnit"]. " Dollars";
                       
           
                      
                       $respons.='
                           <tr>
                               
                               
                               <td>'.$getTheUnit.'</td>
                               <td>'.'<span class="badge badge-warning">In Progress</span>'.'</td>
                               
                               
                       </tr>'
                       ; 
                       /*
                       $response.='
                       <tr>'.'<td>'.$getTheUnit.'</td>'.'<td>'.'<span class="badge badge-warning"">'.'In Progress'.'</span>'.'</td>'.'</tr>'
                       ';

                       $respons.='
                           <tr class="mineProgressModalInfo"><span style="color:#6ebce2;fontweight:500;text-transform:uppercase;list-style-type:none;margin-left:0">'.$data["hashpower"].'</span> : '.$data["mineUnit"].'TMC In progress till  '.$formatTheTime.'</li>
                       ';
           
                       
                       */

                       
                       
                      
           
                   }
                   exit($respons);
           
               }else{
                   exit();
               }
           
           }
           
           
           if($_POST['key'] == 'getDetailsCompleted'){
               $sqlmineDetails = $con->query("SELECT id,mineUnit,mineComplete FROM mineTable WHERE username='$loggedInUser' AND mineComplete=1");
              if($sqlmineDetails->num_rows > 0){
                  $respons = "";
                  while($data = $sqlmineDetails->fetch_assoc()){
                    $getTheUnit = $data["mineUnit"]. " Dollars";
                      
                     /*
                      $respons.='
                          <tr>
                              
                              
                              <td id="two'.$data["id"].'">'.$data["hashpower"].'</td>
                              <td id="four'.$data["id"].'">'.$data["mineUnit"].'</td>
                              <td id="five'.$data["id"].'">'.$data["recomitUnit"].'</td>
                              <td id="six'.$data["id"].'">'.$nice .'</td>
                              <td id="two'.$data["id"].'">'.$data["dates"].'</td>
                              
                      </tr>'
                      ; */
                      $respons.='
                      <tr>
                          
                          
                          <td>'.$getTheUnit.'</td>
                          <td>'.'<span class="badge badge-success">Complete</span>'.'</td>
                          
                          
                  </tr>'
                  ; 
           
                     
           
                  }
                  exit($respons);
           
              }else{
                  exit();
              }
           
           }

           
           if($_POST['key'] == 'getNotifications'){
            $sqlNotificationDetails = $con->query("SELECT id,notifications FROM notificationTable WHERE username='$loggedInUser' AND seen=0");
           if($sqlNotificationDetails->num_rows > 0){
               $response = "";
               while($dataNotification = $sqlNotificationDetails->fetch_assoc()){
                   /*
                   $response.='
                        <a href="#"><div class="mail-contnet"><span class="mail-desc" style="text-overflow: inherit;">'.substr($dataNotification["notifications"], 0, 27).'</span><span class="mail-desc" style="text-overflow: inherit;">'.substr($dataNotification["notifications"], 27, strlen($dataNotification)).'</span></div></a>
             ';
               */   
              $response.='
              <a href="#"><div class="mail-contnet"><span class="mail-desc" style="text-overflow: initial;">'.$dataNotification["notifications"].'</span></div></a>
   ';
               }
              
               $jsonArrayNotification = [
                   "No" => $sqlNotificationDetails->num_rows,
                   "Message" => $response
                 ];
       
               exit(json_encode($jsonArrayNotification));
       
           }else{
               $emptyNotification = '<a href="#"><div class="mail-contnet"><span class="mail-desc" style="text-overflow: initial;">'.'No new notification'.'</span></div></a>';
               exit(json_encode($emptyNotification));
           }
       
       }

       //Settle notifications //////////////////////////////////////////////////////
       if($_POST['key'] == 'settleNotifications'){
    
        $con->query("UPDATE notificationTable SET seen='1' WHERE username='$loggedInUser'");
        

    }
       
        

            //Update profile starts//////////////////////////////////////////////////////////
            if($_POST['key'] == 'upInfo'){

                $nameUp = $con->real_escape_string($_POST['nameToUpdate']);
                $bitcoinUp = $con->real_escape_string($_POST['bitcoinToUpdate']);
            
    
                $sqlUp = $con->query("UPDATE users SET fullName='$nameUp',bitcoinWalletAddress='$bitcoinUp' WHERE userName='$loggedInUser'");
    
                if($sqlUp){
                    exit('success');
                }else{
                    exit('failed');
                }
              
            }
            //Update profile ends ////////////////////////////////////////////////////////////

            //Buy request starts ////////////////////////////////////////////
            if($_POST['key'] == 'tokBuy'){

                $transactionId = $con->real_escape_string($_POST['tranToSend']);
                $unit = $con->real_escape_string($_POST['unitToSend']);

                if($unit <= 0 ){
                    $res = "Invalid amount";
                    exit(json_encode($res));
                }
              
                $test = $con->query("INSERT INTO buyRequest(username,TransactionId,unit) VALUES('$loggedInUser','$transactionId',$unit)");
                if($test){
                    $res = "success";
                    exit(json_encode($res));
                }else{
                    $res = "error";
                    exit(json_encode($res));
                }
            }
            //Buy request starts ////////////////////////////////////////////

            //Sell request starts ////////////////////////////////////////////

            if($_POST['key'] == 'selTok'){
                $unit = $con->real_escape_string($_POST['unitToSell']);
                
        
                if($unit <= 0 || is_nan($unit)){
                    $res = "Invalid Amount";
                    exit(json_encode($res));
                  
                }

                $charge = 0.05 * $unit;
                $sumDeduct = $unit - $charge;
                $sumProfit = $unit + $charge;
        
        
                
                $sql1 = $con->query("SELECT unit FROM users WHERE userName='$loggedInUser'");
                $data1 = $sql1->fetch_assoc();
                $currentBalance = $data1["unit"];
                
        
               
                
                if($currentBalance < $unit ){
                    $res = "Insufficient Balance";
                    exit(json_encode($res));
                   
                }
        
               
                
        
                //Pay the system
                $test1 = $con->query("UPDATE users SET unit = unit + '$unit' WHERE userName='HASHCOIN'");

                if($test1){
                    //Deduct from user
                    $test2 =  $con->query("UPDATE users SET unit = unit - '$unit' WHERE userName='$loggedInUser'");

                    if($test2){
                        //log in sellReques history
                       $test3 =   $con->query("INSERT INTO sellRequest(username,unit)  VALUES('$loggedInUser','$sumDeduct') ");

                       if($test3){
                        $res = "Sucess";
                        exit(json_encode($res));
                          

                       }else{
                        $res = "error";
                        exit(json_encode($res));
                       
                       }
                    }
                }
        
                
        
                
        
        
        }

        //Sell request ends ////////////////////////////////////////////

         //Withdraw request starts ////////////////////////////////////////////

         if($_POST['key'] == 'withdrawTok'){
            $unit = $con->real_escape_string($_POST['unitToWithdraw']);
            
    
            if($unit <= 0 || is_nan($unit)){
                $res = "Invalid Amount";
                exit(json_encode($res));
            }

            $charge = 0.05 * $unit;
            $sumDeduct = $unit - $charge;
            $sumProfit = $unit + $charge;
    
    
            
            $sql1 = $con->query("SELECT unit FROM users WHERE userName='$loggedInUser'");
            $data1 = $sql1->fetch_assoc();
            $currentBalance = $data1["unit"];
            $newBalance = $currentBalance - $unit;
            
    
           
            
            if($currentBalance < $unit ){
                $res = "Insufficient Balance";
                exit(json_encode($res));
            }
    
           
            
    
            //Pay the system
            $test1 = $con->query("UPDATE users SET unit = unit + '$unit' WHERE userName='HASHCOIN'");

            if($test1){
                //Deduct from user
                $test2 =  $con->query("UPDATE users SET unit = unit - '$unit' WHERE userName='$loggedInUser'");

                if($test2){
                    //log in sellRequest history
                   $test3 =   $con->query("INSERT INTO sellRequest(username,unit)  VALUES('$loggedInUser','$sumDeduct') ");

                   if($test3){
                    $jsonArray = [
                        "successMessage" => "success",
                        "currentBalance" => round($newBalance,2)
                      ];
                      exit(json_encode($jsonArray));

                   }else{
                        $res = "error";
                        exit(json_encode($res));
                   }
                }
            }
    
            
    
            
    
    
    }

    //Withdraw request ends ////////////////////////////////////////////


     //Withdraw refferal request starts ////////////////////////////////////////////

     if($_POST['key'] == 'withdrawRef'){
        $unit = $con->real_escape_string($_POST['unitToWithdraw']);
        

        if($unit <= 0 || is_nan($unit)){
            $res = "Invalid Amount";
            exit(json_encode($res));
        }

        $charge = 0.05 * $unit;
        $sumDeduct = $unit - $charge;
        $sumProfit = $unit + $charge;


        
        $sql1 = $con->query("SELECT referralUnit FROM users WHERE userName='$loggedInUser'");
        $data1 = $sql1->fetch_assoc();
        $currentBalance = $data1["referralUnit"];
        $newBalance = $currentBalance - $unit;
        

       
        
        if($currentBalance < $unit ){
            $res = "Insufficient Balance";
            exit(json_encode($res));
        }

       
        

        //Pay the system
        $test1 = $con->query("UPDATE users SET unit = unit + '$unit' WHERE userName='HASHCOIN'");

        if($test1){
            //Deduct from user
            $test2 =  $con->query("UPDATE users SET referralUnit = referralUnit - '$unit' WHERE userName='$loggedInUser'");

            if($test2){
                //log in sellRequest history
               $test3 =   $con->query("INSERT INTO sellRequest(username,unit)  VALUES('$loggedInUser','$sumDeduct') ");

               if($test3){
                $jsonArray = [
                    "successMessage" => "success",
                    "currentBalance" => round($newBalance,2)
                  ];
                  exit(json_encode($jsonArray));

               }else{
                    $res = "error";
                    exit(json_encode($res));
               }
            }
        }

        

        


}

    //Withdraw referral request ends ////////////////////////////////////////////

 //Trade request starts ////////////////////////////////////////////

 if($_POST['key'] == 'tradeTok'){
    $unit = $con->real_escape_string($_POST['unitToTrade']);
    $percent = $con->real_escape_string($_POST['percentToTrade']);
    $newPercent = $percent / 2;
    

    if($unit <= 0 || is_nan($unit)){
        $res = "Invalid Amount";
        exit(json_encode($res));
      
    }


    
    $sql1 = $con->query("SELECT unit FROM users WHERE userName='$loggedInUser'");
    $data1 = $sql1->fetch_assoc();
    $currentBalance = $data1["unit"];
    $newBalance = $currentBalance - $unit;
    

   
    
    if($currentBalance < $unit || $unit < 0){
        $res = "Insufficient Balance";
        exit(json_encode($res));
       
    }

    $startMineQuery = $con->query("INSERT INTO mineTable(username,mineUnit,mineComplete,percent,dates,computerDate,computerDateStarted) VALUES('$loggedInUser','$unit',0,'$newPercent','$prop','$timestamp','$timestamp')");
            $con->query("UPDATE users SET unit = unit + '$unit' WHERE userName='HASHCOIN'");
            $con->query("UPDATE users SET unit = unit - '$unit', isMiningActivated=1 WHERE userName='$loggedInUser'");
            if($startMineQuery){
                $jsonArray = [
                    "successMessage" => "Trade begins",
                    "currentBalance" => round($newBalance,2)
                  ];
               
                exit(json_encode($jsonArray));
            }else{
                $res = "Something went wrong";
                exit(json_encode($res));
            }
}

        }
//Trade request ends ////////////////////////////////////////////


          

 ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" href="./files/logo-clear.png">
       
        <title>IQ Brokers | Dashboard</title>
        <!-- Bootstrap Core CSS -->
        <link href="css/lib/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Custom CSS -->

        <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
        <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
        <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
        <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
        <link href="css/helper.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">


        <?php 
	    //Initializer.
		echo "<script src=\"./js/lib/jquery/jquery.min.js\" type=\"text/javascript\"></script>";
		if($packageActive == "no"){
			
			echo "<script src=\"./js/jsInit/disableButton.js\" type=\"text/javascript\">";
			echo "</script>";
		}else if($packageActive == "yes"){
			//
        }
        
       
	?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
        <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <!-- Main wrapper  -->
        <div id="main-wrapper" style="overflow-x: hidden">
            <!-- header header  -->
            <div class="header">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <!-- Logo -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.html">
                            <!-- Logo icon -->
                            <b>

                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span>

                            </span>
                        </a>
                    </div>
                    <!-- End Logo -->
                    <div class="navbar-collapse">
                        <!-- toggle and nav items -->
                        <ul class="navbar-nav mr-auto mt-md-0">
                            <!-- This is  -->
                            <li class="nav-item">
                                <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)">
                                    <i class="mdi mdi-menu"></i>
                                </a>
                            </li>
                            <li class="nav-item m-l-10">
                                <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)">
                                    <i class="ti-menu"></i>
                                </a>
                            </li>
                            <!-- Messages -->
                            <li class="nav-item dropdown mega-dropdown">
                            </li>
                            <!-- End Messages -->
                        </ul>
                        <!-- User profile and search -->
                        <ul class="navbar-nav my-lg-0">


                            <!-- Messages -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-envelope settleNotification"></i>
                                    <div id="divNotify" class="notify">
                                        <span class="heartbit"></span>
                                        <span class="point"></span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right mailbox animated notificationBox zoomIn" aria-labelledby="2">
                                    <ul>
                                    <li>
                                        <div class="drop-title">You have <span id="notificationNumber"></span> new notification</div>
                                    </li>

                                        <li>
                                            <div class="message-center" >
                                                <!-- Message -->
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!Just see the my admin!</span>
                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>
                                                <a href="#">

                                                    <div class="mail-contnet">

                                                        <span class="mail-desc">Just see the my admin!</span>

                                                    </div>
                                                </a>




                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <!-- End Messages -->
                            <!-- Profile -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="<?php echo $src; ?>" alt="user" class="profile-pic" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                    <ul class="dropdown-user">
                                        <li>
                                            <a href="#"  id="expandProfile2">
                                                <i class="ti-user"></i> Profile</a>
                                        </li>

                                        <li>
                                            <a href="./logout.php">
                                                <i class="fa fa-power-off"></i> Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- End header header -->
            <!-- Left Sidebar  -->
            <div class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li>
                                <a class="" href="#" id="expandDashboard" aria-expanded="false">
                                    <i class="fa fa-tachometer"></i>
                                    <span class="hide-menu">Dashboard </span>
                                </a>
                            </li>
                            <li class="nav-label">Activities</li>
                            <li>
                                <a class="" href="#" id="expandTrade" aria-expanded="false">
                                    <i class="fa fa-book"></i>
                                    <span class="hide-menu">Trade </span>
                                </a>
                            </li>
                            <li>
                                <a class="" href="#" id="expandTransact" aria-expanded="false">
                                    <i class="fa fa-suitcase"></i>
                                    <span class="hide-menu">Fund Account </span>
                                </a>
                            </li>
                            <li>
                                <a class="" href="#" id="expandProfile" aria-expanded="false">
                                    <i class="fa fa-user"></i>
                                    <span class="hide-menu">Profile </span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </div>
            <!-- End Left Sidebar  -->
            <!-- Page wrapper  -->


            <!-- Dashboard  -->
            <div class="page-wrapper present" id="dashboardId">
                <!-- Bread crumb -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-primary">Dashboard</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- End Bread crumb -->
                <!-- Container fluid  -->
                <div class="container-fluid">
                    <!-- Start Page Content -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span>
                                            <i class="fa fa-usd f-s-40 color-primary"></i>
                                        </span>
                                    </div>
                                    <button type="button" id="withdrawFunds" class="btn btn-info btn-outline btn-rounded m-b-10 m-l-5" style="color:#ffffff">Withdraw</button>
                                    <div class="media-body media-text-right">
                                        <h2 id="actualBal">
                                            <span>
                                                <?php echo $activator;?>
                                            </span>
                                            <?php echo $unit; ?>
                                        </h2>
                                        <p class="m-b-0">Total Balance</p>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card p-30">
                                <div class="media">
                                    <div class="media-left meida media-middle">
                                        <span>
                                            <i class="fa fa-usd f-s-40 color-success"></i>
                                        </span>
                                    </div>
                                    <button type="button" id="withdrawRef" class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5" style="color:#ffffff">Withdraw</button>
                                    <div class="media-body media-text-right">
                                        <h2 id="actualRef">
                                            
                                            <?php echo $referralUnit; ?>
                                        </h2>
                                        <p class="m-b-0">Referral Balance</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row bg-white m-l-0 m-r-0 box-shadow ">

                    <!-- column -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cryptocurrency Chart</h4>
                                <div id="extra-area-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->

                    <!-- column -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body browser">
                                <p class="f-w-600">Bitcoin
                                    <span class="pull-right"><?php echo $bi;?>%</span>
                                </p>
                                <div class="progress ">
                                    <div role="progressbar" style="width: <?php echo $bi;?>%; height:8px;" class="progress-bar bg-danger wow animated progress-animated">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>

                                <p class="m-t-30 f-w-600">Etheruem
                                    <span class="pull-right"><?php echo $et;?>%</span>
                                </p>
                                <div class="progress">
                                    <div role="progressbar" style="width: <?php echo $et;?>%; height:8px;" class="progress-bar bg-info wow animated progress-animated">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>

                                <p class="m-t-30 f-w-600">Yuan
                                    <span class="pull-right"><?php echo $yu;?>%</span>
                                </p>
                                <div class="progress">
                                    <div role="progressbar" style="width: <?php echo $yu;?>%; height:8px;" class="progress-bar bg-success wow animated progress-animated">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>

                                <p class="m-t-30 f-w-600">Zin
                                    <span class="pull-right"><?php echo $zi;?>%</span>
                                </p>
                                <div class="progress">
                                    <div role="progressbar" style="width: <?php echo $zi;?>%; height:8px;" class="progress-bar bg-warning wow animated progress-animated">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>

                                <p class="m-t-30 f-w-600">Plin
                                    <span class="pull-right"><?php echo $pl;?>%</span>
                                </p>
                                <div class="progress m-b-30">
                                    <div role="progressbar" style="width: <?php echo $pl;?>%; height:8px;" class="progress-bar bg-success wow animated progress-animated">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                </div>






                <!-- End PAge Content -->
            </div>

            <!-- Trade  -->
            <div class="page-wrapper absent" id="tradeId">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-primary">Trade</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Trade</li>
                        </ol>
                    </div>
                </div>
                <!-- End Bread crumb -->
                <!-- Container fluid  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body p-b-0">
                                    <h4 class="card-title">Trade</h4>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs customtab2" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home7" role="tab">
                                                <span class="hidden-sm-up">
                                                    TRADE
                                                </span>
                                                <span class="hidden-xs-down">Trade</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#profile7" role="tab">
                                                <span class="hidden-sm-up">
                                                    TRADE HISTORY
                                                </span>
                                                <span class="hidden-xs-down">Trade History</span>
                                            </a>
                                        </li>

                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <!--Buy Div-->
                                        <div class="tab-pane active" id="home7" role="tabpanel">
                                            <div class="p-20">
                                                <div class="row">
                                                <div class="col-md-3"></div>
                                                    <div class="col-md-6" style="text-align:center">
                                                        <div class="card p-30">
                                                            <div class="media">
                                                                <div class="media-left meida media-middle">
                                                                    <span>
                                                                        <i class="fa fa-usd f-s-40 color-primary"></i>
                                                                    </span>
                                                                </div>
                                                                <button type="button" id="tradeFunds" class="btn btn-info btn-outline btn-rounded m-b-10 m-l-5 " style="color:#ffffff">Start Trade
                                                                    <small>@</small>
                                                                    <small id="hashP">
                                                                        <?php echo $rate; ?>
                                                                    </small>
                                                                </button>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-7" style="display:none">
                                                        <div class="card bg-dark">
                                                            <div class="testimonial-widget-one p-17">
                                                                <div class="testimonial-widget-one owl-carousel owl-theme newsBox">
                                                                    
                                                                   
                                                                  
                                                                    <div class="item">
                                                                        <div class="testimonial-content">

                                                                            
                                                                            <div class="testimonial-text">
                                                                                 Lorem ipsum dolor sit amet, consectetur
                                                                                adipisicing elit, sed do eiusmod tempor incididunt
                                                                                ut labore et dolore magna aliqua. Ut enim
                                                                                ad minim veniam, quis nostrud exercitation
                                                                                .
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="item">
                                                                        <div class="testimonial-content">

                                                                          

                                                                            <div class="testimonial-text">
                                                                                Lorem ipsum dolor sit amet, consectetur
                                                                                adipisicing elit, sed do eiusmod tempor incididunt
                                                                                ut labore et dolore magna aliqua. Ut enim
                                                                                ad minim veniam, quis nostrud exercitation
                                                                                .
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!--Sell Div-->
                                        <div class="tab-pane  p-20" id="profile7" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-title">
                                                            <h4>Recent trade </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>Amount</th>
                                                                            <th>Status</th>
                                                                            

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="tabList">
                                                                            <tr>
                                                                                <td>2</td>
                                                                                <td>1</td>
                                                                            </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Transact  -->
            <div class="page-wrapper absent" id="transactId">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-primary">Fund Account</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Fund Account</li>
                        </ol>
                    </div>
                </div>
                <!-- End Bread crumb -->
                <!-- Container fluid  -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="card p-30">
                                    <div class="media">
                                        <div class="media-left meida media-middle">
                                            <span>
                                                <i class="fa fa-usd f-s-40 color-primary"></i>
                                            </span>
                                        </div>
                                        <button type="button" id="buyFunds" class="btn btn-info btn-outline btn-rounded m-b-10 m-l-5" style="color:#ffffff;width:90%;">Fund Account </button>
                                        <div class="media-body media-text-right">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="display:none">
                                <div class="card p-30">
                                    <div class="media">
                                        <div class="media-middle meida media-middle">
                                            <span>
                                                <i class="fa fa-usd f-s-40 color-success"></i>
                                            </span>
                                        </div>
                                        <button type="button" id="sellFunds" class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5" style="color:#ffffff;width:90%;">SELL</button>
                                        <div class="media-body media-text-right">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Profile  -->
            <div class="page-wrapper absent" id="profileId">
                <!-- Bread crumb -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-primary">Profile</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0)">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
                <!-- End Bread crumb -->


                <!-- Container fluid  -->
                <div class="container-fluid">
                    <!-- Start Page Content -->
                    <div class="row">
                        <!-- Column -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-two">
                                        <header>
                                            <div class="avatar">
                                                <img src="<?php echo $src; ?>" alt="Allison Walker" />
                                            </div>
                                        </header>
                                        

                                        <h3>
                                            <?php echo $fullName?>
                                        </h3>
                                        

                                        <div class="contacts">

                                            <a href="" style="visibility:hidden">
                                                <i class="fa fa-whatsapp"></i>
                                            </a>
                                            <a id="uploadDpButton" href="">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <a href="" style="display:none">
                                                <i class="fa fa-envelope"></i>
                                            </a>
                                            <div class="clear"></div>
                                        </div>
                                        <div style="text-align:center;display:none" id="uploadDiv">
                                            <form enctype="multipart/form-data" method="post">
                                                <input type="file" class="form-control mb-2" name="image" id="image">
                                                <button type="submit" name="insert" id="insert" class="btn btn-primary btn-xs btn-fill pull-center mr-3" style="border:0;background: linear-gradient(to right, #3a7fd5, #6ebce2);color:#fff">Upload</button>
                                                <button type="button" onclick="cancel()" class="btn btn-danger btn-xs btn-fill pull-center"
                                                    id="cancelUploadDp">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r">
                                            <strong>Full Name</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $fullName ?>
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-xs-6 b-r">
                                            <strong>Mobile</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $contact ?>
                                            </p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r">
                                            <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">
                                                <?php echo $email ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-xs-6">
                                            <strong class="text-info">Referral link</strong>
                                            <br>
                                            <p class="text-muted text-info">
                                             https://www.iqbrokers.us/join.php?ref=<?php echo $loggedInUser;?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-horizontal form-material">
                                        <div class="form-group">
                                            <label class="col-md-12">Full Name</label>
                                            <div class="col-md-12">
                                                <input type="text" placeholder="" value="<?php echo $fullName ?>" class="form-control form-control-line" id="fullNameUpdate">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-email" class="col-md-12">Email</label>
                                            <div class="col-md-12">
                                                <input type="email" value="<?php echo $email ?>" placeholder="" class="form-control form-control-line" name="example-email"
                                                    id="example-email" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Username</label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?php echo $loggedInUser ?>" class="form-control form-control-line" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Phone No</label>
                                            <div class="col-md-12">
                                                <input type="text" placeholder="" class="form-control form-control-line" value="<?php echo $contact ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Bitcoin Address</label>
                                            <div class="col-md-12">
                                                <input type="text" placeholder="" class="form-control form-control-line" value="<?php echo $bitcoinAddress ?>" id="bitcoinUpdate">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="updateProfileInfo" class="btn btn-success btn-outline m-b-10 m-l-5" style="color:#ffffff">Update Profile</button>
                                                <img src="./asset/images/spinner-loop.gif" style="height:70px;width:100px;display:none" id="preloader" alt="">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Column -->
                    </div>

                    <!-- End PAge Content -->
                </div>
                <!-- End Container fluid  -->






                <!-- End PAge Content -->
            </div>


            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved.
                <a href="">IQ Brokers</a>
            </footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->
        <!-- All Jquery -->
        <script src="js/lib/jquery/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="js/lib/bootstrap/js/popper.min.js"></script>
        <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="js/jquery.slimscroll.js"></script>
        <!--Menu sidebar -->
        <script src="js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <!--Custom JavaScript -->


        <!-- Amchart -->
        <script src="js/lib/morris-chart/raphael-min.js"></script>
        <script src="js/lib/morris-chart/morris.js"></script>
        <script src="js/lib/morris-chart/dashboard1-init.js"></script>


        <script src="js/lib/calendar-2/moment.latest.min.js"></script>
        <!-- scripit init-->
        <script src="js/lib/calendar-2/semantic.ui.min.js"></script>
        <!-- scripit init-->
        <script src="js/lib/calendar-2/prism.min.js"></script>
        <!-- scripit init-->
        <script src="js/lib/calendar-2/pignose.calendar.min.js"></script>
        <!-- scripit init-->
        <script src="js/lib/calendar-2/pignose.init.js"></script>

        <script src="js/lib/owl-carousel/owl.carousel.min.js"></script>
        <script src="js/lib/owl-carousel/owl.carousel-init.js"></script>


        <script src="js/lib/sweetalert/sweetalert.min.js"></script>
        <!-- scripit init-->
        <script src="js/lib/sweetalert/sweetalert.init.js"></script>
        <!--Custom JavaScript -->

        <!-- scripit init-->

        <script src="js/scripts.js"></script>

        <script src="./js/dash.js"></script>

        <?php
          if($picture == "good"){
			
			echo "<script src=\"./js/jsInit/goodPicture.js\" type=\"text/javascript\">";
			echo "</script>";
		}else if($picture == "bad"){
			echo "<script src=\"./js/jsInit/badPicture.js\" type=\"text/javascript\">";
			echo "</script>";
        }

        if($tradeStatus == 0){
			
			echo "<script src=\"./js/jsInit/hangTrade.js\" type=\"text/javascript\">";
			echo "</script>";
        }
        
        if($withdrawStatus == 0){
			
			echo "<script src=\"./js/jsInit/hangWithdraw.js\" type=\"text/javascript\">";
			echo "</script>";
		}
        ?>

            <script>
                $(document).ready(function () {
                  //  alert("Hey");
                });
            </script>

    </body>

    </html>