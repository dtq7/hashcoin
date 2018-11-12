$(document).ready(function () {



    /*
                                               $('#preloader').fadeIn("swing", function(){

                                               });
                                               
                                               ------------------------------

                                                 $('#preloader').fadeOut('1000s','swing',function(){

                                                 });
                                                 */

    function isNotEmpty(caller) {
        if (caller.val() == '') {
            caller.css('border', '2px solid red');
            return false;
        } else
            caller.css('border', '');

        return true;
    }       

    //Removing error message on input box for registration
    $('#inputEmail').on('focus', function () {
        $('#emailErr').text('');
    });

    $('#inputUserName').on('focus', function () {
        $('#usernameErr').text('');
    });

    $('#inputContact').on('focus', function () {
        $('#phoneErr').text('');
    });

    //Removing error message on input box for login
    $('#inputUsername,#inputPassword').on('focus', function () {
        $('#disErr').text('');
    });

    //Subscribe sweet alert
    $('.subscribe').on('click',function(){
        if (isNotEmpty($('#newsletterInput')) ){
        $('#newsletterInput').val("");
         swal("Congratulations !!", "Your have successfully subscribed to our newsletter", "success");
        }
    });

    $('.subscribe2').on('click',function(){
        if (isNotEmpty($('#a')) && isNotEmpty($('#b')) && isNotEmpty($('#c')) && isNotEmpty($('#d')) ){
        $('#a,#b,#c,#d').val("");
         swal("Sent!", "", "success");
        }
    });





   


    //Logging the user in
    $('button#login').on('click', function () {

        var username = $('#inputUsername').val();
        var password = $('#inputPassword').val();

        if (isNotEmpty($('#inputUsername')) && isNotEmpty($('#inputPassword'))) {
            $('#preloader').fadeIn("swing", function(){

            $.ajax({
                url: "index.php",
                method: 'POST',
                data: {
                    login: 1,
                    sentUsername: username,
                    sentPassword: password
                },
                success: function (response) {
                    if (response.indexOf('success') >= 0) {
                        $('#preloader').fadeOut('1000s','swing',function(){
                            window.location = 'dashboard.php';
                        });
                       
                    } else {
                        $('#preloader').fadeOut('1000s','swing',function(){
                            $('#disErr').text("Access Denied");
                        });
                       
                    }
                },
                dataType: 'text'
            });

        });
        }



    });







    //  alert("Hello");








});