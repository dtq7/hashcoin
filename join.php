<?php


use PHPMailer\PHPMailer\PHPMailer;

ob_start();







$errEmail = "";
$errUsername = "";
$errno = "";
$reg = "";
require_once("./phpIncludes/Functions.php");

$ref = "";

if(isset($_GET['ref'])){
  $refCode = $_GET['ref'];
  $sqlRe = $con->query("SELECT id,referer FROM users WHERE refererCode='$refCode'");
  $dataRe = $sqlRe->fetch_assoc();
  $ref = $dataRe["referer"];
}

$prop = time();
//$prop = date('Y-m-d',$timestamp);

if(isset($_POST['submit'])){

      require_once('./phpIncludes/openConnection.php');

      $fullname = $con->real_escape_string($_POST['FullName']);
      $username = $con->real_escape_string($_POST['UserName']);
      $email = $con->real_escape_string($_POST['Email']);
      $phone = $con->real_escape_string($_POST['Phone']);
      $password = $con->real_escape_string($_POST['Password']);
      $bitAddress = $con->real_escape_string($_POST['bitcoinAddress']);
      $package = $con->real_escape_string($_POST['Package']);
      $referer = $con->real_escape_string($_POST['Referer']);
      //$accountname = $con->real_escape_string($_POST['AccountNumber']);
      $tos = $con->real_escape_string($_POST['TOS']);
      $token = tokenGenerator(15);
  



      $sqlno = $con->query("SELECT id FROM users WHERE phoneNumber='$phone'");
      if($sqlno->num_rows>0){
        $errno = 'Phone Number already exists';
      }

      $sql1 = $con->query("SELECT id FROM users WHERE email='$email'");
      if($sql1->num_rows>0){
        $errEmail = 'Email already exists';
      }



      $sql2 = $con->query("SELECT id FROM users WHERE username='$username'");
      if($sql2->num_rows>0){
        $errUsername = 'Username already exists';
      }

      
       

      if($sql1->num_rows == 0 && $sql2->num_rows == 0 && $sqlno->num_rows == 0){

       


        include_once "./PHPMailer/Exception.php";
        include_once "./PHPMailer/SMTP.php";
        include_once "./PHPMailer/PHPMailer.php";
      
 /*

          $to['email'] = $email;      
          $to['name'] = $fullname;   
          $mail = new PHPMailer;
          $mail->IsSMTP();                                     
          $mail->SMTPAuth = true;
          $mail->Port = 465;
          $mail->Username = 'Victoranyino@gmail.com';
          $mail->Password = 'ugo12344';
          $mail->SMTPSecure = 'ssl';
          $mail->From = 'Victoranyino@gmail.com';
          $mail->FromName = "MINERSAFE";
          $mail->AddAddress($to['email'],$to['name']);
          $mail->Priority = 1;
          $mail->AddCustomHeader("X-MSMail-Priority: High");
          $mail->WordWrap = 50;
          
      */
        
          $mail = new PHPMailer();
          $mail->Username = $GMAIL_USER_NAME;
          $mail->Password = $GMAIL_PASSWORD;
          $mail->setFrom($GMAIL_USER_NAME,'IQ Brokers');
          $mail->addReplyTo('noreply@iqbrokers.us');
          $mail->addAddress($email);
          $mail->isHTML(true);                                  // Set email format to HTML
       
         
          $mail->Subject = 'Verify IQ Brokers Account';
          $mail->Body = "
              Congratulations on your sign up! Click the link below to verify your account. Welcome to the IQ Brokers!:<br><br>
          
              <a href='https://www.iqbrokers.us/confirmEmail.php?email=$email&token=$token'>Click here</a>
          ";
		    if($mail->send()){  
            //if(true){
			//	
				
				$test = $con->query("INSERT INTO users(fullName, userName, hashedPassword,email,token, phoneNumber, referer, unit,package, referralUnit,dateWeeklyUnitActivated,bitcoinWalletAddress) VALUES 
				('$fullname','$username','$password','$email','$token','$phone','$referer',$package * 0.1,$package,0,'$prop','$bitAddress')");
				
				if($test){
					$reg = "passed";
					
				}else{
					$reg = "failed";
                
				
          //  echo '1';
			}
		}
      //    }
        //  else {
          //  echo "<script src=\"../assets/customJSFolder/errorRedirect.js\" type=\"text/javascript\">";
           // echo "</script>";
         //   echo '2';
         // }

      }


	

}



?>

<!doctype html>
<html class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"
    style="">
<!--<![endif]-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>IQ Brokerss | Join</title>

	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="icon" type="image/png" href="./files/logo-clear.png">
	<link href="css/lib/sweetalert/sweetalert.css" rel="stylesheet">


	<link rel="stylesheet" href="./asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="./asset/css/animations.css">
	<link rel="stylesheet" href="./asset/css/fonts.css">
	<link rel="stylesheet" href="./asset/css/font-awesome.min.css">
	<link rel="stylesheet" href="./asset/css/main.css" class="color-switcher-link">
	<link rel="stylesheet" href="./asset/css/shop.css">
	<script src="./asset/js/modernizr-2.6.2.min.js"></script>

	<?php 
	//Initializer.
		echo "<script src=\"./asset/js/jquery.min.js\" type=\"text/javascript\"></script>";
		if($reg == "passed"){
			echo "<script src=\"./asset/js/jquery.min.js\" type=\"text/javascript\"></script>";
			echo "<script src=\"./asset/customJSFolder/finishRedirect.js\" type=\"text/javascript\">";
			echo "</script>";
		}else if($reg == "failed"){
			echo "<script src=\"./asset/js/jquery.min.js\" type=\"text/javascript\"></script>";
			echo "<script src=\"./asset/customJSFolder/errorRedirect.js\" type=\"text/javascript\">";
			echo "</script>";
		}
	?>
	<script src="./asset/customJSFolder/"></script>
	<!--[if lt IE 9]>
		<script src="js/vendor/html5shiv.min.js"></script>
		<script src="js/vendor/respond.min.js"></script>
		<script src="js/vendor/jquery-1.12.4.min.js"></script>
	<![endif]-->
</head>

<body>
	<!--[if lt IE 9]>
		<div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your experience.</div>
	<![endif]-->

	<!-- search modal -->
	<div class="modal" tabindex="-1" role="dialog" aria-labelledby="search_modal" id="search_modal">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">
				<i class="rt-icon2-cross2"></i>
			</span>
		</button>
		<div class="widget widget_search">
			<form method="get" class="searchform search-form form-inline" action="#/html/hashcoin/">
				<div class="form-group bottommargin_0">
					<input type="text" value="" name="search" class="form-control" placeholder="Search keyword" id="modal-search-input"> </div>
				<button type="submit" class="theme_button no_bg_button">Search</button>
			</form>
		</div>
	</div>
	<!-- Unyson messages modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="messages_modal">
		<div class="fw-messages-wrap ls with_padding">
			<!-- Uncomment this UL with LI to show messages in modal popup to your user: -->
			<!--
		<ul class="list-unstyled">
			<li>Message To User</li>
		</ul>
		-->
		</div>
	</div>
	<!-- eof .modal -->
	<!-- wrappers for visual page editor and boxed version of template -->
	<div id="canvas">
		<div id="box_wrapper">
			<!-- template sections -->
			<section class="page_toplogo ls section_padding_top_15 section_padding_bottom_15 table_section table_section_md">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-sm-12 col-md-push-4 text-center">
							<a href="" class="logo top_logo top_offset_logo">
								<img src="./files/logo-clear.png" alt="">
							</a>
							<!-- header toggler -->
							<span class="toggle_menu">
								<span></span>
							</span>
						</div>
						<div class="col-md-4 col-sm-6 col-md-pull-4 text-center text-md-left">

						</div>
						<div class="col-md-4 col-sm-6 text-center text-md-right hidden-xs">
							<div class="widget widget_search inline-block">

							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="page_header_wrapper header_white affix-wrapper" style="height: 86px;">
				<header class="page_header header_white affix">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-center">
								<!-- main nav start -->
								<nav class="mainmenu_wrapper" style="">
									<ul class="mainmenu nav sf-menu sf-js-enabled sf-arrows" style="touch-action: pan-y;">
										<li class="">
											<a href="./index.php" id="">Home</a>
										</li>

										<li class="">
											<a href="./faq.php" id="">HIW</a>
										</li>
										<li class="">
											<a href="./join.php" class="">Join</a>
										</li>
									</ul>
								</nav>
								<!-- eof main nav -->
							</div>
						</div>
					</div>
				</header>
			</div>

			

			<!--Join div-->
			<div>
				<section class="page_breadcrumbs cs gradient background_cover color_overlay section_padding_top_15 section_padding_bottom_15">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-center">
								<h2>Join</h2>

							</div>
						</div>
					</div>
				</section>
				<section class="ls section_padding_top_25 section_padding_bottom_100">
					<div class="container">
						<div class="row">
							<form class="form-signin" id="form" method="post" action="join.php">
								<div class="col-md-6">
									<div class="form-group validate-required" id="billing_first_name_field">
										<label for="billing_first_name" class="control-label">
											<span class="grey">Full Name:</span>
											<span class="required">*</span>
										</label>
										<input type="text" class="form-control " name="FullName" id="inputFullName" placeholder="" value="" required> </div>

									<div class="form-group" id="billing_company_field">
										<label for="billing_company" class="control-label">
											<span class="grey">Username:</span>
                                            <span class="required" required>*</span>
										</label>
										<input type="text" class="form-control " name="UserName" id="inputUserName" placeholder="" value=""> <p style="color:red; text-align:center; font-size:14px;" class="mt-3" id="usernameErr"> <?php echo $errUsername ?> </p> </div>
								</div>

								<div class="col-md-6">
									<div class="form-group validate-required" id="billing_last_name_field">
										<label for="billing_last_name" class="control-label">
											<span class="grey">Email:</span>
											<span class="required">*</span>
										</label>
										<input type="email" class="form-control " name="Email" id="inputEmail" placeholder="" value="" required><p style="color:red; text-align:center; font-size:14px;" class="mt-3" id="emailErr"> <?php echo $errEmail ?> </p> </div>
									<div class="form-group validate-required validate-email" id="billing_email_field">
										<label for="billing_email" class="control-label">
											<span class="grey">Contact</span>
											<span class="required">*</span>
										</label>
										<input type="text" class="form-control " name="Phone" id="inputContact" placeholder="" value="" required>  <p style="color:red; text-align:center; font-size:14px;" class="mt-3" id="phoneErr"> <?php echo $errno ?></p></div>
								</div>

								


								<div class="col-sm-12">
								<div class="form-group">
										<label for="billing_state" class="control-label">
											<span class="grey">Package:</span>
											<span class="required">*</span>
										</label>
										<select class="form-control" name="Package" id="inputPackage" required>
											<option value="" style="display:none">Select a package...</option>
											<option value="50">50 Dollars</option>
											<option value="100">100 Dollars</option>
											<option value="150">150 Dollars</option>
											<option value="200">200 Dollars</option>
											<option value="500">500 Dollars</option>
                                            <option value="100">1000 Dollars</option>
										</select>
									</div>
								</div>
								

								<div class="col-sm-12">
									<div class="form-group address-field validate-required" id="billing_address_fields">
										<label for="billing_address_1" class="control-label">
											<span class="grey">Bitcoin Address:</span>
											<span class="required">*</span>
										</label>
										<input type="text" class="form-control " name="bitcoinAddress" id="inputBitcoinAddress" placeholder="" value=""> </div>
								</div>

								<!-- Referal input type -->
								<input type="hidden" placeholder="Refered by..." name="Referer" id="referer" class="form-control mb-4" value="<?php echo $ref; ?>">
								

								<div class="col-md-12">
									<div class="form-group address-field validate-required" id="billing_city_field">
										<label for="billing_city" class="control-label">
											<span class="grey">Password:</span>
											<span class="required" >*</span>
										</label>
										<input type="password" class="form-control " name="Password" id="inputPassword" placeholder="" value="" required> </div>
									
									
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="TOS" value="accepted" required> I accept the terms and conditions.
											</label>
										</div>
										
									</div>
								</div>
								
								<button type="submit" class="theme_button wide_button color1" style="margin:auto" name="submit" id="sub">Register Now</button>
								<p style="margin-left:10px;margin-top:9px" class="">Already a member? <a href="./index.php#LogS">Sign In</a></p>
									
								</div>
								<div class="col-sm-12">
									
									
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>






			<footer class="page_footer ds texture_bg section_padding_top_5 section_padding_bottom_5 columns_padding_25 table_section">
				<div class="container">
					<div class="row">
						<div class="col-md-6 text-center">
							<div class="widget widget_text">
								<a href="#/html/hashcoin/" class="logo">
									<img src="./files/logo-clear.png" alt="">
								</a>
								<h3 class="widget-title topmargin_15">IQ Brokers</h3>
								<p class="bottommargin_10">IQBrokers is a forex and binary option inspired platform which offer you 30% in 6days. Every investor is entitled to 15% ROI during the first 3days of trade and 15%+Capital for the remaining 3days, making it 30% in 6days.</p>
								<p class="small-text grey colorlinks"> 2099 Limer St, Ellijay, GA 30540
									<br> +1 (267) 526-5440
									<br>
									<a href="mailto:iqbrokers@support.us">iqbrokers@support.us</a>
								</p>
								<p class="topmargin_25">
									<a href="">
										<i class="fa fa-facebook"></i>
									</a>
									<a href="https://t.me/joinchat/Fj2Nk00oBFkojShwiIQwrA">
										<i class="fa fa-telegram"></i>
									</a>
									<a href="">
										<i class="fa fa-twitter"></i>
									</a>

								</p>
							</div>
						</div>

						<div class="col-md-5 text-center">
							<div class="widget widget_mailchimp widget_media_margin">
								<h3 class="widget-title">Newsletter</h3>
								<form class="signup" action="" method="get">
									<p class="bottommargin_30">Subscribe to our mailing list to receive new updates and special offers:</p>
									<div class="form-group-wrap">
										<div class="form-group">
											<label for="footer-mailchimp" class="sr-only">Enter your email here</label>
											<input name="email" id="newsletterInput" type="email" id="footer-mailchimp" class="mailchimp_email form-control" placeholder="Email Address"> </div>

									</div>
									<div class="response"></div>
								</form>
								<button type="button" id="" class="theme_button wide_button color1 topmargin_5 subscribe">Subscribe</button>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<section class="ls page_copyright section_padding_15">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 text-center">
							<p class="small-text thin">© Copyright 2018. All Rights Reserved.</p>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- eof #box_wrapper -->
	</div>
	<!-- eof #canvas -->
	<script src="./asset/js/jquery.min.js"></script>
	<script src="./asset/js/jquery.validate.min.js"></script>
    <script src="./asset/js/popper.min.js"></script>
    <script src="./asset/js/bootstrap.min.js"></script>
	<script src="./files/compressed.js"></script>
	<script src="./files/main.js"></script>
	<script src="./files/switcher.js"></script>


	<script src="js/lib/sweetalert/sweetalert.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/sweetalert/sweetalert.init.js"></script>
    <!--Custom JavaScript -->
  


	<script src="./asset/js/personal.js"></script>



	<script type="text/javascript" src="./asset/js/js"></script>

	<div id="switcher">
		<div class="color_switcher_header">
			<h4>Styles Selector</h4>
			<span class="rt-icon2-brush"></span>
		</div>
		<div id="switcher_accent_color">
			<p>Accent color:</p>
			<ul id="switcher-colors" class="list-inline">
				<li>
					<a href="#/html/hashcoin/services.html#" data-color="" class="color1"></a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" data-color="2" class="color2"></a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" data-color="3" class="color3"></a>
				</li>
			</ul>
		</div>
		<div id="switcher_color_scheme">
			<p>Color scheme:</p>
			<ul id="switcher-version" class="list-inline">
				<li class="active">
					<a href="#/html/hashcoin/services.html#" class="light">Light</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="dark">Dark</a>
				</li>
			</ul>
		</div>
		<div id="switcher_layout">
			<p>Layout style:</p>
			<div class="checkbox checkbox-slider--b-flat">
				<label>
					<input type="checkbox" id="layout">
					<span>Boxed</span>
				</label>
			</div>
		</div>
		<div id="switcher_patterns">
			<p class="for-toggle hidden">Boxed Patterns</p>
			<ul id="switcher-patterns" class="list-inline for-toggle hidden">
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern0" data-pattern="pattern0">
						<img src="./files/pattern0.png" alt="" width="40" height="40" title="pattern0">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern1" data-pattern="pattern1">
						<img src="./files/pattern1.png" alt="" width="40" height="40" title="pattern1">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern2" data-pattern="pattern2">
						<img src="./files/pattern2.png" alt="" width="40" height="40" title="pattern2">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern3" data-pattern="pattern3">
						<img src="./files/pattern3.png" alt="" width="40" height="40" title="pattern3">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern4" data-pattern="pattern4">
						<img src="./files/pattern4.png" alt="" width="40" height="40" title="pattern4">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern5" data-pattern="pattern5">
						<img src="./files/pattern5.png" alt="" width="40" height="40" title="pattern5">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern6" data-pattern="pattern6">
						<img src="./files/pattern6.png" alt="" width="40" height="40" title="pattern6">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern7" data-pattern="pattern7">
						<img src="./files/pattern7.png" alt="" width="40" height="40" title="pattern7">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern8" data-pattern="pattern8">
						<img src="./files/pattern8.png" alt="" width="40" height="40" title="pattern8">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern9" data-pattern="pattern9">
						<img src="./files/pattern9.png" alt="" width="40" height="40" title="pattern9">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern10" data-pattern="pattern10">
						<img src="./files/pattern10.png" alt="" width="40" height="40" title="pattern10">
					</a>
				</li>
				<li>
					<a href="#/html/hashcoin/services.html#" class="pattern11" data-pattern="pattern11">
						<img src="./files/pattern11.png" alt="" width="40" height="40" title="pattern11">
					</a>
				</li>
			</ul>
		</div>
	</div>
	<a href="#/html/hashcoin/services.html#" id="toTop" style="display: inline;">
		<span id="toTopHover"></span>To Top</a>

        
</body>

</html>