<?php
    session_start();

    if(!isset($_SESSION['loggedInAsSuperUser'])){
      header('Location: ../adminPanel.php');
      exit();
    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="../files/logo-clear.png">
    <title>IQ Brokers | Sell request</title>


   <link href="./special/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./special/dataTables.bootstrap.min.css">

    <style>
        .mb-2{
            margin-bottom:10px;
        }
        .mb-3{
            margin-bottom:26px;
        }
        
    </style>


   
</head>
<body>

<div class="container" style="margin-top:1px">

    <div class="row">
       
        <div class="col-md-12" style="overflow-x:auto;">
        <div></div>
        <h2>ADMIN PANEL <small>SELL REQUEST</small></h2>
        <div class="btn-group" role="group" aria-label="Basic example">

            
            <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-right:1px solid #ffffff;" href="./manageUsers.php" role="button" type="button" class="btn btn-secondary">USERS</a>
            <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;border-right:1px solid #ffffff;" href="./manageBuy.php" role="button" type="button" class="btn btn-secondary">BUY REQUEST</a>
            <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./manageSell.php" role="button" type="button" class="btn btn-secondary">SELL REQUEST</a>
            <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./manageHashPower.php" role="button" type="button" class="btn btn-secondary">RATE</a>
            <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./mineView.php" role="button" type="button" class="btn btn-secondary">MINE</a>
            <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./news.php" role="button" type="button" class="btn btn-secondary">UTILITY</a>
        </div>

        <a href="../logSuperUserOut.php" style="float:right;background-color:#3b9458;color:#FFFFFF;border:0;margin-left:10px;" type="button" name="" id="" class="btn btn-md btn-success ">Log Out</a>

        <table class="table table-hover table-bordered">
        <br><br>
            <thead>
                <tr>
                    
                    <td>Username</td>
                    <td>Unit</td>
                    
                    <td>Date</td>
                    <td>Addressed</td>
                    <td>Options</td>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
        </table>
        </div>
      
    </div>
</div>
    


<script src="./special/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="./special/bootstrap.min.js" type="text/javascript"></script>
<script src="./special/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="./special/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        
        getExistingData(0,10);

    });

    function deleteRow(rowID){
        if(confirm('Are you sure')){
            $.ajax({
            url:'sellRequestHandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'deleteRow',
                    rowID:rowID
                },success: function (response){
                    $("#username" + rowID).parent().remove();
                    alert(response);
                }
        
       
       });
    }
}

    

    function getExistingData(start, limit){
        
        $.ajax({
            url:'sellRequestHandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'getExistingData',
                    start:start,
                    limit:limit
                },success: function (response){
                    if(response != 'reachedMax'){
                        $('tbody').append(response);
                        start += limit;
                        getExistingData(start, limit);
                    }else{
                        $(".table").DataTable();
                    }
                }
        });
    }

    

   

    

</script>
</body>
</html>