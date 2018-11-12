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
        <title>IQ Brokers | Users</title>


        <link href="./special/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="./special/dataTables.bootstrap.min.css">

        <style>
            .mb-2 {
                margin-bottom: 10px;
            }

            .mb-3 {
                margin-bottom: 26px;
            }
        </style>



    </head>

    <body>

        <div class="container" style="margin-top:1px">


            <!--Add new user Modal -->
            <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document" style="height:1px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">ADD USER</h3>
                        </div>
                        <div class="modal-body">
                            <div id="editContent">
                                <input type="text" class="form-control mb-2" placeholder="Full Name..." id="fullNameA">
                                <input type="text" class="form-control mb-2" placeholder="Username..." id="userNameA">
                                <input type="password" class="form-control mb-2" placeholder="Password..." id="passwordA">
                                <input type="email" class="form-control mb-2" placeholder="Email..." id="emailA">
                                <input type="phoneNumber" class="form-control mb-2" placeholder="Phone Number..." id="phoneNumberA">
                                <input type="text" class="form-control mb-2" placeholder="bitcoin address..." id="bitcoinA">
                                <input type="text" class="form-control mb-2" placeholder="Unit..." id="unitA">
                                <input type="checkbox" class=" mb-3 mr-4" id="isActivatedA" style="margin-right:12px">
                                <label for="">Activate User </label>
                                <br>
                                <input type="checkbox" class=" mb-2 mr-4" id="isSuspendedA" style="margin-right:12px">
                                <label for="">Suspend User </label>
                                <br>

                                <input type="hidden" id="editRowID" value="0">
                            </div>

                            <div id="payContent">
                                <input type="text" class="form-control mb-2" placeholder="Amount..." id="fullAmountA">


                                <input type="hidden" id="editRowID" value="0">
                            </div>

                            <div id="showContent" style="display:none">
                                <div style="font-size:17px;font-family:Helvetica,sans-serif">
                                    <label for="">FULL NAME : </label>
                                    <span id="viewfullname"> </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">USERNAME : </label>
                                    <span id="viewusername"> </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">PASSWORD : </label>
                                    <span id="viewpassword"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">EMAIL : </label>
                                    <span id="viewemail"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">PHONE NUMBER : </label>
                                    <span id="viewphonenumber"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">BITCOIN ADDRESS : </label>
                                    <span id="viewbitcoin"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">REFERER : </label>
                                    <span id="viewreferer"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">UNIT : </label>
                                    <span id="viewunit"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">REFERRAL UNIT : </label>
                                    <span id="viewreferralunit"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">EMAIL CONFIRMATION : </label>
                                    <span id="viewemailconfirm"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">STATUS : </label>
                                    <span id="viewsuspension"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">DATE CREATED : </label>
                                    <span id="viewdatecreated"> Hello </span>
                                </div>
                                <div style="font-size:17px">
                                    <label for="">TRADER : </label>
                                    <span id="viewminer"> Hello </span>
                                </div>


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
                    <h2>ADMIN PANEL
                        <small>USERS</small>
                    </h2>
                    <div class="btn-group" role="group" aria-label="Basic example">


                        <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-right:1px solid #ffffff;" href="./manageUsers.php" role="button"
                            type="button" class="btn btn-secondary">USERS</a>
                        <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;border-right:1px solid #ffffff;"
                            href="./manageBuy.php" role="button" type="button" class="btn btn-secondary">BUY REQUEST</a>
                        <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./manageSell.php" role="button"
                            type="button" class="btn btn-secondary">SELL REQUEST</a>
                        <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./manageHashPower.php" role="button"
                            type="button" class="btn btn-secondary">RATE</a>
                        <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./mineView.php" role="button"
                            type="button" class="btn btn-secondary">MINE</a>
                        <a style="background-color:#3b9458;color:#FFFFFF;border:0;border-left:1px solid #ffffff;" href="./news.php" role="button"
                            type="button" class="btn btn-secondary">UTILITY</a>

                    </div>

                    <a href="../logSuperUserOut.php" style="float:right;background-color:#3b9458;color:#FFFFFF;border:0;margin-left:10px;" type="button"
                        name="" id="" class="btn btn-md btn-success ">Log Out</a>

                    <input style="float:right;background-color:#3b9458;color:#FFFFFF;border:0;" type="button" name="" id="addNew" class="btn btn-md btn-success"
                        value="Add new">




                    <table class="table table-hover table-bordered">
                        <br>
                        <br>
                        <thead>
                            <tr>

                                <td>Full Name</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Phone Number</td>
                                <td>Unit</td>

                                <td>Status</td>
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
            $(document).ready(function () {
                var activationCode;
                var suspensionCode;
                $('#addNew').on('click', function () {
                    $('#exampleModalLongTitle').html('ADD USER');
                    $('#fullNameA').val('');
                    $('#userNameA').val('');
                    $('#passwordA').val('');
                    $('#emailA').val('');
                    $('#phoneNumberA').val('');
                    $('#bitcoinA').val('');
                    $('#unitA').val('');
                    $("#isActivatedA").prop("checked", false);
                    $("#isSuspendedA").prop("checked", false);
                    $('#addNewUser').modal('show');
                });

                $('#addNewUser').on('hidden.bs.modal', function () {
                    $('#showContent').fadeOut();
                    $('#payContent').fadeOut();
                    $('#editContent').fadeIn();
                    $('editRowID').val(0);
                    $('#fullNameA').val('');
                    $('#userNameA').val('');
                    $('#passwordA').val('');
                    $('#emailA').val('');
                    $('#phoneNumberA').val('');
                    $('#bitcoinA').val('');
                    $('#unitA').val('');
                    $("#isActivatedA").prop("checked", false);
                    $("#isSuspendedA").prop("checked", false);
                    $('#manageBtn').attr('value', 'Save').attr('onclick', 'saveData("addNew")').fadeIn();

                });

                getExistingData(0, 10);

            });

            function deleteRow(rowID) {
                if (confirm('Are you sure')) {
                    $.ajax({
                        url: 'userAdminHandler.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            key: 'deleteRow',
                            rowID: rowID
                        },
                        success: function (response) {
                            $("#fullname" + rowID).parent().remove();
                            alert(response);
                        }


                    });
                }
            }

            function viewORedit(rowID, type) {
                $.ajax({
                    url: 'userAdminHandler.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        key: 'getRowData',
                        rowID: rowID
                    },
                    success: function (response) {

                        var niceSUS = (response.suspended == 1) ? 'Suspended' : 'Active';
                        var niceACTIVE = (response.activated == 1) ? 'Email Verified' :
                            'Email not Verified';
                        var niceMIN = (response.miningactivated == 1) ? 'Active Miner' : 'Not a Miner';


                        if (type == "view") {
                            $('#exampleModalLongTitle').html('');
                            $('#manageBtn').fadeOut();
                            $('span#viewfullname').text(response.fullname);
                            $('span#viewusername').text(response.username);
                            $('span#viewpassword').text(response.password);
                            $('span#viewemail').text(response.email);
                            $('span#viewphonenumber').text(response.phonenumber);

                            $('span#viewbitcoin').text(response.bitcoin);
                            $('span#viewreferer').text(response.referer);
                            $('span#viewwalletid').text(response.walletid);
                            $('span#viewunit').text(response.unit);
                            $('span#viewreferralunit').text(response.referralunit);
                            $('span#viewemailconfirm').text(niceACTIVE);
                            $('span#viewsuspension').text(niceSUS);
                            $('span#viewdatecreated').text(response.datecreated);

                            $('span#viewminer').text(niceMIN);
                            $('#showContent').fadeIn();
                            $('#editContent').fadeOut();
                            $('#payContent').fadeOut();

                        } else if(type == "edit") {
                            $('#showContent').fadeOut();
                            $('#payContent').fadeOut();
                            $('#editContent').fadeIn();
                            $('#editRowID').val(rowID);
                            $('#fullNameA').val(response.fullname);
                            $('#userNameA').val(response.username);
                            $('#passwordA').val(response.password);
                            $('#emailA').val(response.email);
                            $('#phoneNumberA').val(response.phonenumber);

                            $('#bitcoinA').val(response.bitcoin);
                            $('#unitA').val(response.unit);
                            (response.activated == 1) ? $('#isActivatedA').prop('checked', true): $(
                                '#isActivatedA').prop('checked', false);

                            (response.suspended == 1) ? $('#isSuspendedA').prop('checked', true): $(
                                '#isSuspendedA').prop('checked', false);
                            $('#manageBtn').attr('value', 'update changes').attr('onclick',
                                'saveData("updateRow")');
                            $('#exampleModalLongTitle').html(response.username);
                        }

                        else if(type == "pay") {
                            $('#showContent').fadeOut();
                            $('#payContent').fadeIn();
                            $('#editContent').fadeOut();
                            $('#editRowID').val(rowID);
                           
                            $('#manageBtn').attr('value', 'Pay').attr('onclick',
                                'payUp()');
                            $('#exampleModalLongTitle').html("PAY USER");
                        }else{
                            //
                        }


                        $('#addNewUser').modal('show');


                    }
                });

            }

            function getExistingData(start, limit) {

                $.ajax({
                    url: 'userAdminHandler.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        key: 'getExistingData',
                        start: start,
                        limit: limit
                    },
                    success: function (response) {
                        if (response != 'reachedMax') {
                            $('tbody').append(response);
                            start += limit;
                            getExistingData(start, limit);
                        } else {
                            $(".table").DataTable();
                        }
                    }
                });
            }



            function saveData(Thekey) {
                if ($("#isActivatedA").prop("checked")) {
                    activationCode = 1;
                } else {
                    activationCode = 0;
                }


                if ($("#isSuspendedA").prop("checked")) {
                    suspensionCode = 1;
                } else {
                    suspensionCode = 0;
                }

                var nameS = $('#fullNameA');
                var userS = $('#userNameA');
                var passS = $('#passwordA');
                var emailS = $('#emailA')
                var phoneNumberS = $('#phoneNumberA')

                var bitcoinS = $('#bitcoinA');
                var unitS = $('#unitA');
                isActivatedS = activationCode;

                var isSuspendedS = suspensionCode;
                var editRowID = $('#editRowID')

                if (isNotEmpty(nameS) && isNotEmpty(userS) && isNotEmpty(passS) && isNotEmpty(emailS) && isNotEmpty(
                        phoneNumberS)) {
                    $.ajax({
                        url: 'userAdminHandler.php',
                        method: 'POST',
                        dataType: 'text',
                        data: {
                            key: Thekey,
                            nameToSave: nameS.val(),
                            userToSave: userS.val(),
                            passToSave: passS.val(),
                            emailToSave: emailS.val(),
                            phoneNumberToSave: phoneNumberS.val(),
                            bitcoinToSave: bitcoinS.val(),
                            unitToSave: unitS.val(),
                            isActivatedToSave: isActivatedS,
                            isSuspendedToSave: isSuspendedS,
                            rowID: editRowID.val()
                        },
                        success: function (response) {
                            // alert (response);
                            if (response != "success") {
                                alert('failed');
                                // $('#addNewUser').modal('hide');
                            }

                            if (response == "success") {
                                // alert ('yep');

                                var niceSuspensionValue = (isSuspendedS == 0) ? 'Active' : 'Suspended';

                                $("#fullname" + editRowID.val()).html(nameS.val());
                                $("#username" + editRowID.val()).html(userS.val());
                                $("#email" + editRowID.val()).html(emailS.val());
                                $("#phonenumber" + editRowID.val()).html(phoneNumberS.val());
                                $("#unit" + editRowID.val()).html(unitS.val());

                                $("#suspended" + editRowID.val()).html(niceSuspensionValue);




                                nameS.val('');
                                userS.val('');
                                passS.val('');
                                emailS.val('');

                                phoneNumberS.val('');

                                bitcoinS.val('');

                                unitS.val('');
                                $("#isActivatedA").prop("checked", false);

                                $("#isSuspendedA").prop("checked", false);

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

             function payUp() {
              

                var amountS = $('#fullAmountA');
               
               
                var editRowID = $('#editRowID')

                if (isNotEmpty(amountS)) {
                    $.ajax({
                        url: 'userAdminHandler.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            key: "payNew",
                            amountToSave: amountS.val(),
                           
                            rowID: editRowID.val()
                        },
                        success: function (response) {
                            // alert (response);
                            if (response.successMessage != "success") {
                            
                                // $('#addNewUser').modal('hide');
                            }

                            if (response.successMessage == "success") {
                                

                                 $("#unit" + editRowID.val()).html(response.balance);
                                amountS.val('');
                               

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


            function isNotEmpty(caller) {
                if (caller.val() == '') {
                    caller.css('border', '1px solid red');
                    return false;
                } else
                    caller.css('border', '');

                return true;
            }
        </script>
    </body>

    </html>