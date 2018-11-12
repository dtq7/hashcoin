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
    <title>IQ Brokers | Percentage</title>


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


   <!--Add new user Modal -->
   <div  class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="height:1px">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Token Rate</h3>
      </div>
      <div class="modal-body">
      <div id="editContent">
            
            <label for="">Token Rate</label>
            <input type="text" class="form-control mb-2" placeholder="rate..." id="rate">
           

            <input type="hidden" id="editRowID" value="0">
      </div>
      
                   
                    
                    
        </div>
      <div class="modal-footer">
        <input type="button" data-dismiss="modal" aria-label="Close" class="btn btn-sm" value="Close" style="background-color:#c42f2f;color:#ffffff;border:0;">
        <input type="button" id="manageBtn" onclick="saveData('addNew')" class="btn btn-sm" value="Save" style="background-color:#3a7fd5;color:white;border:0;">
        
      </div>
    </div>
  </div>
</div>






    <div class="row">
       
        <div class="col-md-12" style="overflow-x:auto;">
        <div></div>
        <h2>ADMIN PANEL <small>RATE</small> </h2>
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
                    
                    
                    <td>RATE</td>
                    <td>OPTIONS</td>
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


    function viewORedit(rowID, type){
        $.ajax({
            url:'hashPowerHandler.php',
                method:'POST',
                dataType:'json',
                data:{
                    key:'getRowData',
                    rowID:rowID
                },success: function (response){
                   
                    if(type == "view"){
                        
                        $('#showContent').fadeIn();
                        $('#editContent').fadeOut();

                    }else{
                        $('#showContent').fadeOut();
                        $('#editContent').fadeIn();
                        $('#editRowID').val(rowID);
                        
                        $('#rate').val(response.r);
                        $('#manageBtn').attr('value', 'update changes').attr('onclick', 'saveData("updateRow")');
                        }

                    
                    $('#addNewUser').modal('show');
                    
                    
                }
        });

    }

    function getExistingData(start, limit){
        
        $.ajax({
            url:'hashPowerHandler.php',
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

    

    function saveData(Thekey){
       

        var h1S = $('#one');
        var h2S = $('#two');
        var h3S = $('#three');
        var h4S = $('#four');
        var rS = $('#rate');
        
        var editRowID = $('#editRowID')

        if(isNotEmpty(h1S) && isNotEmpty(h2S) && isNotEmpty(h3S) && isNotEmpty(h4S)){
            $.ajax({
                url:'hashPowerHandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:Thekey,
                    oneToSave: h1S.val(),
                    
                    rateToSave: rS.val(),
                    
                    rowID: editRowID.val()
                },success: function (response){
                   // alert (response);
                    if(response != "success"){
                        alert('failed');
                       // $('#addNewUser').modal('hide');
                    }

                    if(response == "success"){
                       // alert ('yep');
                       
                      
                      
                       $("#rate" + editRowID.val()).html(rS.val());
                      
                      
                        $('#addNewUser').modal('hide');
                        $('#manageBtn').attr('value', 'Save').attr('onclick', 'saveData("addNew")');
                        $('#exampleModalLongTitle').html('ADD USER');

                       
                      //  header('Location: login.php');
                       // exit();


                    }

                        

                    
                    
                }
            });
        }
    }


    function isNotEmpty(caller){
        if(caller.val() == ''){
            caller.css('border', '1px solid red');
            return false;
        }else
            caller.css('border','');
        
        return true;
    }

    

</script>
</body>
</html>