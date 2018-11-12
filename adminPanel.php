<?php

session_start();

$msg = "";

function redirect(){
  Header('Location: ./CRUD/manageUsers.php');
  exit();
};

if(isset($_SESSION['loggedInAsSuperUser'])){
redirect();
}





if(isset($_POST['login'])){

  //$con = new mysqli('localhost', 'dtq7', '1234', 'MinerSafe');

  require_once('./phpIncludes/openConnection.php');


  $password = $con->real_escape_string($_POST['thepass']);

  $sql = $con->query("SELECT hashedPassword FROM users WHERE userName='HASHCOIN' AND isEmailConfirmed=1");
  $data = $sql->fetch_assoc();
  if($sql->num_rows > 0){
      if($password == $data['hashedPassword'].'1'){
        $_SESSION['loggedInAsSuperUser'] = '1';
        $_SESSION['pass'] = $data['hashedPassword'];
        $msg = "Everthing okay";
        exit("success");
      }else {
        $msg = "Access denied";
        exit("failed");
      }
}

}
?>

 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./files/logo-clear.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>IQ Brokers | SUPERADMIN</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link rel="stylesheet" href="./asset/css/bootstrap.min.css">
</head>

<body>
    

           <div class="content">

           <div class="container">
                <div class="row" style="margin-top:25%;margin-bottom:25%">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                   
                        <input type="email" id="email" class="form-control mb-3" placeholder="Enter your admin password..." style="border:1px solid grey">
                        <input type="button" id="retrieve" class="btn btn-md justify-content-center mb-2" style="background: #3a7fd5;color:#ffffff;opacity:1;border-radius:3px;border:0;width:33%;margin-left:33%;margin-top:30px;" value="Login" ><br>
                        <p id="res" style="color:red; text-align:center; margin-top:10px;"></p>
                        <img src="./asset/images/spinner-loop.gif" style="height:100px;width:30%;margin-left:35%;display:none" id="preloader" alt="">
                    
                   
                    </div>
                    <div class="col-md-3"></div>
                </div>
           </div>


      
      <footer class="footer pull-right text-right" style="position:absolute;bottom:5%">
     
          <div class="container">
              <nav>
                  <p class="copyright text-right">
                      ©
                      <script>
                          document.write(new Date().getFullYear())
                      </script>
                      <a href="#">HASHCOIN</a>
                  </p>
              </nav>
          </div>
      </footer>
    </div>

</body>
<!--   Core JS Files   -->
<script src="./asset/js/jquery.min.js"></script>

<script>
var password = $('#email');

$(document).ready(function(){
    $('#res').text('');
    $('#retrieve').on('click', function(){
        $('#res').text('');
       
        
        if(isNotEmpty(password)){  
            $('#preloader').fadeIn("swing", function(){

                         $.ajax({
                            url:'adminPanel.php',
                            method:'POST',
                            dataType:'text',
                            data:{
                                login:1,
                                thepass:password.val(),
                                
                            },success: function (response){

                                if(response == 'failed'){
                                    $('#preloader').fadeOut('1000s','swing',function(){
                                    $('#res').text('Access Denied');
                                });
                                
                                  
                                }
                                if(response == 'success'){
                                    $('#preloader').fadeOut('1000s','swing',function(){
                                    window.location = './CRUD/manageUsers.php';
                                });
                                  
                                }

                                

               
           }
    
                
            });
        });

        }
                
            });

       



   
        });






function isNotEmpty(caller){
                if(caller.val() == ''){
                    caller.css('border', '1px solid red');
                    return false;
                }else
                    caller.css('border','');
                
                return true;
            }




</script>

</html>