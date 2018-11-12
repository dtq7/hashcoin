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
    <title>IQ Brokers | Utility</title>


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
        <h3 class="modal-title" id="exampleModalLongTitle">EDIT CRYPTOS</h3>
      </div>
      <div class="modal-body">
      <div id="editContent">
            <label for="">Bitcoin</label><br>
            <input type="text" class="form-control mb-2" placeholder="Bitcoin..." id="Bitcoin">
            <label for="">Ethereum</label><br>
            <input type="text" class="form-control mb-2" placeholder="Ethereum..." id="Ethereum">
            <label for="">Yuan</label><br>
            <input type="text" class="form-control mb-2" placeholder="Yuan..." id="Yuan">
            <label for="">Zin</label><br>
            <input type="text" class="form-control mb-2" placeholder="Zin..." id="Zin">
            <label for="">Plin</label><br>
            <input type="text" class="form-control mb-2" placeholder="Plin..." id="Plin">
             
             <input type="hidden" id="editRowID" value="0">
      </div>
      <div id="showContent" style="display:none">
        <div style="font-size:17px;font-family:Helvetica,sans-serif"><label for=""> </label><span id="viewNews"> </span></div>      
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
        <h2>ADMIN PANEL <small>NEWS</small> </h2>
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
                    
                    <td>Trade</td>
                    <td>Withdraw</td>
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
      
        $('#addNew').on('click',function(){
            $('#exampleModalLongTitle').html('ADD NEWS');
            $('#newsA').val('');
            $('#addNewUser').modal('show');
        });

        $('#addNewUser').on('hidden.bs.modal', function(){
            $('#showContent').fadeOut();
            $('#editContent').fadeIn();
            $('editRowID').val(0);
            $('#newsA').val('');
            $('#manageBtn').attr('value', 'Save').attr('onclick', 'saveData("addNew")').fadeIn();

        });

        getExistingData(0,10);

    });

    function deleteRow(rowID){
        if(confirm('Are you sure')){
            $.ajax({
            url:'newshandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'deleteRow',
                    rowID:rowID
                },success: function (response){
                    $("#fullname" + rowID).parent().remove();
                    alert(response);
                }
        
       
       });
    }
}

 function enableWithdraw(){
        if(confirm('Are you sure you want to enable withdraw button')){
            $.ajax({
            url:'newshandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'enableWithdraw'
                },success: function (response){
                    if(response == "Withdraw enabled"){
                        $('#withdrawSpecial').html('Enabled');
                        alert(response);
                    }
                }
        
       
       });
    }
}

function disableWithdraw(){
        if(confirm('Are you sure you want to disable withdraw button')){
            $.ajax({
            url:'newshandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'disableWithdraw'
                },success: function (response){
                    if(response == "Withdraw disabled"){
                        $('#withdrawSpecial').html('Not enabled');
                        alert(response);
                    }
                }
        
       
       });
    }
}

 function enableTrade(){
        if(confirm('Are you sure you want to enable trade button')){
            $.ajax({
            url:'newshandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'enableTrade'
                },success: function (response){

                    if(response == "Trade enabled"){
                        $('#tradeSpecial').html('Enabled');
                        alert(response);
                    }
                    //$("#fullname" + rowID).parent().remove();
                    
                }
        
       
       });
    }
}

function disableTrade(){
        if(confirm('Are you sure you want to disable trade button')){
            $.ajax({
            url:'newshandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:'disableTrade'
                },success: function (response){
                    if(response == "Trade disabled"){
                        $('#tradeSpecial').html('Not enabled');
                        alert(response);
                    }
                }
        
       
       });
    }
}



    function viewORedit(rowID, type){
        $.ajax({
            url:'newshandler.php',
                method:'POST',
                dataType:'json',
                data:{
                    key:'getRowData',
                    rowID:rowID
                },success: function (response){
                  
                   

                    if(type == "view"){
                        $('#exampleModalLongTitle').html('');
                        $('#manageBtn').fadeOut();
                        
                
                        $('#showContent').fadeIn();
                        $('#editContent').fadeOut();

                    }else{
                        $('#showContent').fadeOut();
                        $('#editContent').fadeIn();
                        $('#editRowID').val(rowID);
                        
                        $('#Bitcoin').val(response.bitcoin);
                        $('#Ethereum').val(response.ethereum);
                        $('#Yuan').val(response.yuan);
                        $('#Zin').val(response.zin);
                        $('#Plin').val(response.plin);
                        $('#manageBtn').attr('value', 'update changes').attr('onclick', 'saveData("updateRow")');
                        $('#exampleModalLongTitle').html('Cryptocurrency');
                        }

                    
                    $('#addNewUser').modal('show');
                    
                    
                }
        });

    }

    function getExistingData(start, limit){
        
        $.ajax({
            url:'newshandler.php',
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
       
       
        var bitcoin = $('#Bitcoin');
        var ethereum = $('#Ethereum');
        var yuan = $('#Yuan');
        var zin = $('#Zin');
        var plin = $('#Plin');
        var editRowID = $('#editRowID');

        if(true){
            $.ajax({
                url:'newshandler.php',
                method:'POST',
                dataType:'text',
                data:{
                    key:Thekey,
                    bitcoinToSave: bitcoin.val(),
                    ethereumToSave: ethereum.val(),
                    yuanToSave: yuan.val(),
                    zinToSave: zin.val(),
                    plinToSave: plin.val(),
                   
                    rowID: editRowID.val()
                },success: function (response){
                   // alert (response);
                    if(response != "success"){
                        alert('failed');
                       // $('#addNewUser').modal('hide');
                    }

                    if(response == "success"){
                       
                        alert("Changed successfully");
                        $('#addNewUser').modal('hide');
                        $('#manageBtn').attr('value', 'Save').attr('onclick', 'saveData("addNew")');
                        $('#exampleModalLongTitle').html('ADD NEWS');

                       
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