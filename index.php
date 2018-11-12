<?php


  session_start();

  $msg = "";

  function redirect(){
    Header('Location: dashboard.php');
    exit();
  };

if(isset($_SESSION['loggedIn'])){
  redirect();
}





  if(isset($_POST['login'])){

    //$con = new mysqli('localhost', 'dtq7', '1234', 'MinerSafe');

    require_once('./phpIncludes/openConnection.php');

    $username = $con->real_escape_string($_POST['sentUsername']);
    $password = $con->real_escape_string($_POST['sentPassword']);

    $sql = $con->query("SELECT userName FROM users WHERE userName='$username' AND hashedPassword='$password' AND isEmailConfirmed=1 AND isSuspended=0");
    $data = $sql->fetch_assoc();
    if($sql->num_rows > 0){
      $_SESSION['loggedIn'] = '1';
      $_SESSION['user'] = $data['userName'];
      $msg = "Everthing okay";
      exit("success");
    }else {
      $msg = "Access denied";
      exit("failed");
    }

  }

 ?>
<!DOCTYPE html>

<html class=" js flexbox canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths"
    style="">
<!--<![endif]-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>IQ Brokers</title>

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
								<span style="margin-right:10px;margin-top:20px:color:black;display:none">IQ</span><img src="./files/logo-clear.png" alt=""><span style="display:none">Brokers</span>
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

			<!--Index div-->
			<div>
				<section class="intro_section page_mainslider ds">
					<div class="flexslider vertical-nav" data-dots="true" data-nav="false">
						<ul class="slides">

							<li data-thumb-alt="" class="" style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;">
								<img src="./files/slide02.jpg" alt="" draggable="false">
								<div class="container">
									<div class="row">
										<div class="col-sm-12 text-center">
											<div class="slide_description_wrapper">
												<div class="slide_description">
													<div class="intro-layer" data-animation="fadeInUp" style="visibility: hidden;">
													
														<h2 class="semi-bold" style="margin-bottom:40px"> IQ BROKERS
															<br>
															<span class="thin">Easy way to Trade</span>
															<br>
															<span class="thin">Bitcoin</span>
														</h2>
													</div>
													<div class="intro-layer" data-animation="fadeInUp" style="visibility: hidden;">
														<a href="./join.php" class="theme_button color1 min_width_button">
															Join us
														</a>
													</div>
												</div>
												<!-- eof .slide_description -->
											</div>
											<!-- eof .slide_description_wrapper -->
										</div>
										<!-- eof .col-* -->
									</div>
									<!-- eof .row -->
								</div>
								<!-- eof .container -->
							</li>

						</ul>

					</div>
					<!-- eof flexslider -->
				</section>
				<section id="about" class="ls ms background_cover section_about section_padding_top_150 section_padding_bottom_150 columns_padding_25">
					<div class="container">
						<div class="row">
							<div class="col-sm-8 col-md-6 col-lg-5 col-sm-offset-4 col-md-offset-6 col-lg-offset-7">
								<p class="small-text highlight">What is bitcoin</p>
								<h2 class="section_header">A New Kind of Money</h2>
								<p>Bitcoin is a cryptocurrency, a form of electronic cash. It is the world's first decentralized digital currency, and it was designed to work without a central bank or single administrator.</p>
								<p class="topmargin_30">
									<a href="./join.php" class="theme_button color1 min_width_button">Join us</a>
								</p>
							</div>
						</div>
					</div>
				</section>


				<section class="ls section_padding_top_25 section_padding_bottom_25 " id="LogS">
					<div class="container">
						<div class="row">
							<form class="" role="form">
								<div class="col-md-8 col-md-offset-2 text-center">
									<h2 class="hover-color3">
										SIGN IN
									</h2>
									<div class="form-group form-signin" id="billing_first_name_field">
										<label for="billing_first_name" class="control-label">

											<span class="required"></span>
										</label>
										<input type="text" class="form-control"  placeholder="USERNAME" id="inputUsername" id="billing_first_name" 
										    value=""> </div>
									<div class="form-group" id="billing_company_field">
										<label for="billing_company" class="control-label">

										</label>
										<input type="password" id="inputPassword" class="form-control " placeholder="PASSWORD" name="billing_company" id="billing_company" 
										    value=""> </div>
									<div class="radio text-left">
										<label>
											<input type="checkbox" name="optionsRadios"> Remember me
										</label>
									</div>
									<div class="col-sm-4 col-md-4 col-md-offset-4">

									<img src="./asset/images/spinner-loop.gif" style="height:70px;width:100px;display:none" id="preloader" alt="">
									  

									<p style="color:red; text-align:center" class="mt-3" id="disErr"> <?php echo $msg ?> </p>
										<button type="button" id="login" class="theme_button wide_button color1 topmargin_10">Login</button>
										

									</div>
								</div>




							</form>
						</div>
					</div>
				</section>
				<section id="advantages" class="ls ms section_advantages background_cover section_padding_top_100 section_padding_bottom_100 columns_margin_bottom_30">
					<div class="container">
						<div class="row">
							<div class="col-md-4 col-sm-6">
								<div class="teaser max_width_260 text-center">
									<div class="teaser_icon size_small highlight">
										<i class="fa fa-lock"></i>
									</div>
									<h4>
										<a href="">Safe &amp; Secure</a>
									</h4>
									<p>Be sure in your account security and your funds safe.</p>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-md-offset-4">
								<div class="teaser max_width_260 text-center">
									<div class="teaser_icon size_small highlight">
										<i class="fa fa-user"></i>
									</div>
									<h4>
										<a href="">Experts Support</a>
									</h4>
									<p>Support will answer your questions regarding bitcoins.</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3 col-sm-6">
								<div class="teaser max_width_260 text-center">
									<div class="teaser_icon size_small highlight3">
										<i class="fa fa-mobile"></i>
									</div>
									<h4 class="hover-color3">
										<a href="">Mobile Apps</a>
									</h4>
									<p>Perfectly developed mobile apps will open new opportunities.</p>
								</div>
							</div>
							<div class="col-md-3 col-sm-6 col-md-offset-6">
								<div class="teaser max_width_260 text-center">
									<div class="teaser_icon size_small highlight3">
										<i class="fa fa-dashboard"></i>
									</div>
									<h4 class="hover-color3">
										<a href="">Instant Exchange</a>
									</h4>
									<p>Instant Exchange allows you to send bitcoin and pay for it</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-sm-6">
								<div class="teaser max_width_260 text-center">
									<div class="teaser_icon size_small highlight2">
										<i class="fa fa-key"></i>
									</div>
									<h4 class="hover-color2">
										<a href="">Secure Wallet</a>
									</h4>
									<p>Perfectly developed mobile apps will open new opportunities.</p>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-md-offset-4">
								<div class="teaser max_width_260 text-center">
									<div class="teaser_icon size_small highlight2">
										<i class="fa fa-shopping-cart"></i>
									</div>
									<h4 class="hover-color2">
										<a href="">Recuring Buys</a>
									</h4>
									<p>Recurring transaction feature allows you to schedule future</p>
								</div>
							</div>
						</div>
					</div>
				</section>
				

			

				<section id="quote" class="ls ms background_cover section_contact section_padding_100">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-center">
							<h2 class="section_header">About Us</h2>
								<p class="small-text">IQBROKERS IS A FOREX AND BINARY OPTION INSPIRED PLATFORM WHICH OFFERS YOU 30% IN 6days

EVERY INVESTOR IS ENTITLED TO 15% ROI DURING THE FIRST THREE DAYS OF TRADE AND 15%+CAPITAL FOR THE REMAINING 3DAYS, MAKING IT 30% in 6 days</p>
								
<a href="./join.php" class="theme_button color1 min_width_button">
															Get 10% off Now
														</a>
							</div>
						</div>
					</div>
				</section>

				<section class="ls section_padding_top_25 section_padding_bottom_130 columns_margin_bottom_20">
					<div class="container">
						<div class="isotope_container isotope row masonry-layout columns_margin_bottom_20" style="position: relative; height: 954.376px;">
							<div class="isotope-item col-md-4 col-sm-6" style="position: absolute; left: 0%; top: 0px;">
								<article class="vertical-item content-padding with_border text-center">
									<div class="item-media">
										<img src="./files/box1.jpg" alt=""> </div>
									<div class="item-content">
										<h4 class="entry-title">
											<a href="">Bitcoin Transaction</a>
										</h4>
										<p class="content-3lines-ellipsis">A transaction is a transfer of Bitcoin value that is broadcast to the network and collected into.</p>
									</div>
								</article>
							</div>
							<div class="isotope-item col-md-4 col-sm-6" style="position: absolute; left: 33.3333%; top: 0px;">
								<article class="vertical-item content-padding with_border text-center">
									<div class="item-media">
										<img src="./files/box2.jpg" alt=""> </div>
									<div class="item-content">
										<h4 class="entry-title">
											<a href="">Bitcoin Exchange</a>
										</h4>
										<p class="content-3lines-ellipsis">There’s no best Bitcoin exchange on the internet today. There are several major Bitcoin exchanges.</p>
									</div>
								</article>
							</div>
							<div class="isotope-item col-md-4 col-sm-6" style="position: absolute; left: 66.6667%; top: 0px;">
								<article class="vertical-item content-padding with_border text-center">
									<div class="item-media">
										<img src="./files/box3.jpg" alt=""> </div>
									<div class="item-content">
										<h4 class="entry-title">
											<a href="">Bitcoin Investment</a>
										</h4>
										<p class="content-3lines-ellipsis">Bitcoin Blockchain is the technology backbone of the network and provides a tamper-proof data.</p>
									</div>
								</article>
							</div>
							<div class="isotope-item col-md-4 col-sm-6" style="position: absolute; left: 0%; top: 477px;">
								<article class="vertical-item content-padding with_border text-center">
									<div class="item-media">
										<img src="./files/box4.jpg" alt=""> </div>
									<div class="item-content">
										<h4 class="entry-title">
											<a href="">Bitcoin Escrow Service</a>
										</h4>
										<p class="content-3lines-ellipsis">The bitcoin escrow service acts as a neutral third party between buyer and seller when doing business.</p>
									</div>
								</article>
							</div>
							<div class="isotope-item col-md-4 col-sm-6" style="position: absolute; left: 33.3333%; top: 477px;">
								<article class="vertical-item content-padding with_border text-center">
									<div class="item-media">
										<img src="./files/box5.jpg" alt=""> </div>
									<div class="item-content">
										<h4 class="entry-title">
											<a href="">Bitcoin Mining</a>
										</h4>
										<p class="content-3lines-ellipsis">Bitcoin mining is legal and is accomplished by running double round hash verification processes.</p>
									</div>
								</article>
							</div>
							<div class="isotope-item col-md-4 col-sm-6" style="position: absolute; left: 66.6667%; top: 477px;">
								<article class="vertical-item content-padding with_border text-center">
									<div class="item-media">
										<img src="./files/box6.jpg" alt=""> </div>
									<div class="item-content">
										<h4 class="entry-title">
											<a href="">Software Development</a>
										</h4>
										<p class="content-3lines-ellipsis">Bitcoin Blockchain is the technology backbone of the network and provides a tamper-proof data.</p>
									</div>
								</article>
							</div>
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