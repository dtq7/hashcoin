$(document).ready(function () {

   

    $('a#expandProfile').on('click', function () {


        $('div#dashboardId').css('display', 'none');
        $('div#tradeId').css('display', 'none');
        $('div#transactId').css('display', 'none');
        $('div#profileId').css('display', 'block');

        //  $(".sidebartoggler").click();
        $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
            $(".nav-toggler i").addClass("mdi mdi-close");
    })

    $('a#expandProfile2').on('click', function () {


        $('div#dashboardId').css('display', 'none');
        $('div#tradeId').css('display', 'none');
        $('div#transactId').css('display', 'none');
        $('div#profileId').css('display', 'block');

      
    })

    $('a#expandDashboard').on('click', function (e) {

        $('div#dashboardId').css('display', 'block');
        $('div#tradeId').css('display', 'none');
        $('div#transactId').css('display', 'none');
        $('div#profileId').css('display', 'none');
        $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
            $(".nav-toggler i").addClass("mdi mdi-close");
    })

    $('a#expandTransact').on('click', function (e) {

        $('div#dashboardId').css('display', 'none');
        $('div#tradeId').css('display', 'none');
        $('div#transactId').css('display', 'block');
        $('div#profileId').css('display', 'none');
        $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
            $(".nav-toggler i").addClass("mdi mdi-close");
    })

    $('a#expandTrade').on('click', function (e) {

        $('div#dashboardId').css('display', 'none');
        $('div#tradeId').css('display', 'block');
        $('div#transactId').css('display', 'none');
        $('div#profileId').css('display', 'none');
        $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
            $(".nav-toggler i").addClass("mdi mdi-close");
    })


    //Withdraw funds
    document.querySelector('#withdrawFunds').onclick = function () {
        swal({
                title: "Are you sure?",
                text: "A transaction fee of 5% will be deducted !!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Continue !!",
                cancelButtonText: "No, cancel it !!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    var unit = "";
                    swal({
                            title: "WITHDRAW",
                            text: "Enter amount to withdraw",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Amount..."
                        },
                        function (inputValue) {
                            if (inputValue === false) return false;
                            if (inputValue === "" || inputValue < 0) {
                                swal.showInputError("You need to enter a valid amount!");
                                return false
                            } else {
                                unit = inputValue;


                                $.ajax({
                                    url: 'dashboard.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {
                                        key: "withdrawTok",
                                        unitToWithdraw: unit

                                    },
                                    success: function (response) {
                                        //alert(response);

                                        if (response.successMessage == 'success') {
                                            swal("Hello", "Your transaction is being processed", "success");
                                            $('#actualBal').text(response.currentBalance);
                                        }

                                        if (response == 'error') {
                                            swal("oops!", "Something went wrong", "error");
                                        }

                                        if (response == 'Invalid Amount') {
                                            swal.showInputError("You need to enter a valid amount!");
                                            return false;


                                        }



                                        if (response == 'Insufficient Balance') {
                                            swal.showInputError("Insufficient balance!");
                                            return false;


                                        }



                                    }



                                });
                            }

                        });
                } else {
                    swal("Cancelled !!", "Your transaction has been cancelled !!", "error");
                }
            });
    };

    //Withdraw funds
    document.querySelector('#withdrawRef').onclick = function () {
        swal({
                title: "Are you sure?",
                text: "A transaction fee of 5% will be deducted !!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Continue !!",
                cancelButtonText: "No, cancel it !!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    var unit = "";
                    swal({
                            title: "WITHDRAW",
                            text: "Enter amount to withdraw",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Amount..."
                        },
                        function (inputValue) {
                            if (inputValue === false) return false;
                            if (inputValue === "" || inputValue < 0) {
                                swal.showInputError("You need to enter a valid amount!");
                                return false
                            } else {
                                unit = inputValue;


                                $.ajax({
                                    url: 'dashboard.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {
                                        key: "withdrawRef",
                                        unitToWithdraw: unit

                                    },
                                    success: function (response) {
                                        //alert(response);

                                        if (response.successMessage == 'success') {
                                            swal("Hello", "Your transaction is being processed", "success");
                                            $('#actualRef').text(response.currentBalance);
                                        }

                                        if (response == 'error') {
                                            swal("oops!", "Something went wrong", "error");
                                        }

                                        if (response == 'Invalid Amount') {
                                            swal.showInputError("You need to enter a valid amount!");
                                            return false;


                                        }



                                        if (response == 'Insufficient Balance') {
                                            swal.showInputError("Insufficient balance!");
                                            return false;


                                        }



                                    }



                                });
                            }

                        });
                } else {
                    swal("Cancelled !!", "Your transaction has been cancelled !!", "error");
                }
            });
    };

    //Buy funds
    document.querySelector('#buyFunds').onclick = function () {
        var tran = "";
        var unit = "";
        swal({
                title: "BUY",
                text: "Enter amount in dollars",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Amount..."
            },
            function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "" || inputValue <= 0 || isNaN(inputValue)) {
                    swal.showInputError("You need to enter a valid amount!");
                    return false

                } else {
                    unit = inputValue;
                    swal({
                            title: "BUY",
                            text: "Please pay "+ unit +"dollars to Bitcoin Address: 1GrvaX9qrMTzX5mUwPEiyqJs6ybnzaQ8a6   and paste the transaction ID here",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Transaction Id..."
                        },
                        function (inputValue) {
                            if (inputValue === false) return false;
                            if (inputValue === "") {
                                swal.showInputError("You need to enter a valid transaction ID!");
                                return false
                            } else {
                                tran = inputValue;


                                $.ajax({
                                    url: 'dashboard.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {
                                        key: "tokBuy",
                                        tranToSend: tran,
                                        unitToSend: unit,
                                    },
                                    success: function (response) {
                                        //alert(response);

                                        if (response == 'success') {
                                            swal("Hello", "Your purchase is being processed", "success");


                                        }

                                        if (response == 'error') {
                                            swal("oops!", "Something went wrong. Pls try again.", "error");

                                        }


                                        if (response == 'Invalid amount') {
                                            swal.showInputError("You need to enter a valid amount!");
                                        }

                                    }



                                });
                            }

                        });
                }

            });
    };

    //Sell funds
    document.querySelector('#sellFunds').onclick = function () {


        swal({
                title: "Are you sure?",
                text: "A transaction fee of 5% will be deducted !!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Continue !!",
                cancelButtonText: "No, cancel it !!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    var unit = "";
                    swal({
                            title: "SELL",
                            text: "Enter amount to sell",
                            type: "input",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            animation: "slide-from-top",
                            inputPlaceholder: "Amount..."
                        },
                        function (inputValue) {
                            if (inputValue === false) return false;
                            if (inputValue === "" || inputValue < 0) {
                                swal.showInputError("You need to enter a valid amount!");
                                return false
                            } else {
                                unit = inputValue;


                                $.ajax({
                                    url: 'dashboard.php',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: {
                                        key: "selTok",
                                        unitToSell: unit

                                    },
                                    success: function (response) {
                                        //alert(response);

                                        if (response == 'success') {
                                            swal("Hello", "Your transaction is being processed", "success");
                                            $('#actualBal').text();
                                        }

                                        if (response == 'error') {
                                            swal("oops!", "Something went wrong", "error");
                                        }

                                        if (response == 'Invalid Amount') {
                                            swal.showInputError("You need to enter a valid amount!");
                                            return false;


                                        }



                                        if (response == 'Insufficient Balance') {
                                            swal.showInputError("Insufficient balance!");
                                            return false;


                                        }



                                    }



                                });
                            }

                        });
                } else {
                    swal("Cancelled !!", "Your transaction has been cancelled !!", "error");
                }
            });




    };

    //Start trading
    document.querySelector('#tradeFunds').onclick = function () {


        var unit = "";
        swal({
                title: "TRADE",
                text: "Enter amount to trade",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Amount..."
            },
            function (inputValue) {
                if (inputValue === false) return false;
                if (inputValue === "" || inputValue < 0) {
                    swal.showInputError("You need to enter a valid amount!");
                    return false
                } else {
                    unit = inputValue;


                    $.ajax({
                        url: 'dashboard.php',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            key: "tradeTok",
                            unitToTrade: unit,
                            percentToTrade: $('#hashP').text()

                        },
                        success: function (response) {
                            //alert(response);
                            $.ajax({
                                url: 'dashboard.php',
                                method: 'POST',
                                dataType: 'text',
                                data: {
                                    key: 'getDetailsInProgress'
                                },
                                success: function (response) {
                                   
                                    if (response != 'reachedMax') {
                                        $('.tabList').html(response);
                                    }
                                }
                            });
                        
                        
                            $.ajax({
                                url: 'dashboard.php',
                                method: 'POST',
                                dataType: 'text',
                                data: {
                                    key: 'getDetailsCompleted'
                                },
                                success: function (response) {
                                  //  alert(response);
                                    if (response != 'reachedMax') {
                                        $('.tabList').append(response);
                                    }
                                }
                            });
                            if (response.successMessage == 'Trade begins') {

                                
                                
                                swal("Hello", "Trade begins", "success");
                                $('#actualBal').text(response.currentBalance);
                                
                              
                            
                            }

                            if (response == 'Something went wrong') {
                                swal("oops!", "Something went wrong", "error");
                            }

                            if (response == 'Invalid Amount') {
                                swal.showInputError("You need to enter a valid amount!");
                                return false;


                            }



                            if (response == 'Insufficient Balance') {
                                swal.showInputError("Insufficient balance!");
                                return false;


                            }



                        }



                    });
                }

            });




    };

 //   alert("Hepy");

    $.ajax({
        url: 'dashboard.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'getDetailsInProgress'
        },
        success: function (response) {
           
            if (response != 'reachedMax') {
                $('.tabList').html(response);
            }
        }
    });


    $.ajax({
        url: 'dashboard.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'getDetailsCompleted'
        },
        success: function (response) {
          //  alert(response);
            if (response != 'reachedMax') {
                $('.tabList').append(response);
            }
        }
    });

    $.ajax({
        url: 'dashboard.php',
        method: 'POST',
        dataType: 'json',
        data: {
            key: 'getNotifications'
        },
        success: function (response) {
     
            if (response.No == 1) {
             
                $('.message-center').html(response.Message);
                $('#notificationNumber').text(response.No);
                $('.notificationBox').css('height', '170px');
              

            }
           else if (response.No == 2) {
               
                 $('.message-center').html(response.Message);
                 $('#notificationNumber').text(response.No);
                 $('.notificationBox').css('height', '250px');
                
 
             }
            else if (response.No > 2) {
                
                 $('.message-center').html(response.Message);
                 $('#notificationNumber').text(response.No);
               
 
             } else {
             
                $('#notificationNumber').text("no");
                $('.message-center').html("");
                $('.notificationBox').css('height', '70px');
                $('#divNotify').removeClass('notify');

            }





        }
    });

      //Handling Notification
      $('.settleNotification').click(function () {
       
        $.ajax({
            url: 'dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'settleNotifications'
            },
            success: function (response) {

            }
        });
    });
    /////////////////////////




    $('#updateProfileInfo').on('click', function () {
        var fullName = $('#fullNameUpdate');
        var bitcoin = $('#bitcoinUpdate');



        if (true) {
            $('#preloader').fadeIn("swing", function () {
                $.ajax({
                    url: 'dashboard.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        key: "upInfo",
                        nameToUpdate: fullName.val(),
                        bitcoinToUpdate: bitcoin.val()
                    },
                    success: function (response) {
                        // alert(response);

                        if (response == 'success') {
                            $('#preloader').fadeOut('1000s', 'swing', function () {
                                sweetAlert("Okay", "Successfully updated!", "success");
                                $('#fullNameUpdate').val(fullName.val());
                                $('#bitconUpdate').val(bitcoin.val());
                                $('a#expandProfile').click();
                                $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
                                    $(".nav-toggler i").addClass("mdi mdi-close");
                            });

                        } else {
                            $('#preloader').fadeOut('1000s', 'swing', function () {
                                sweetAlert("Oops...", "Could not update. Try again !!", "error");
                                $('a#expandProfile').click();
                                $("body").toggleClass("show-sidebar"), $(".nav-toggler i").toggleClass("mdi mdi-menu"),
                                    $(".nav-toggler i").addClass("mdi mdi-close");
                            });
                        }



                    }
                });
            });

        }

    });

    $('div#uploadDiv').css('display', 'none');
    $('#insert').click(function () {
        var image_name = $('#image').val();
        if (image_name == '') {
            sweetAlert("Error", "please select a valid image file!", "error");
            return false;
        } else {
            var extension = $('#image').val().split('.').pop().toLowerCase();
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                sweetAlert("Error", "Invalid image type!", "error");
                $('#image').val('');
                return false;
            }
        }
    });

    $('#uploadDpButton').on('click', function (e) {
        e.preventDefault();
        $('div#uploadDiv').css('display', 'block');
    });

    $('#cancelUploadDp').on('click', function () {
        $('div#uploadDiv').css('display', 'none');
    });







    ///////////////////////////////////////////////////////////////////////
});