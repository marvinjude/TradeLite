<!-- <?php
session_start();
require ("include/include.php");
if(!isset($_SESSION['username'])){
  header("location:sellerlogin.php");
}
?>
<html lang="en">
<head>
<style>
	.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 18px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}


</style>
    <meta charset="utf-8">
    <title>Welcome <?php echo $_SESSION['username']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenger Admin Theme">
	<meta name="author" content="juli ola" />
    <meta name="author" content="juli ola">

    <link href='../external.html?link=http://fonts.googleapis.com/css?family=RobotoDraft:300,400,400italic,500,700' rel='stylesheet' type='text/css'>
    <link href='../external.html?link=http://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600,700' rel='stylesheet' type='text/css'>

    <!--[if lt IE 10]>
        <script src="assets/js/media.match.min.js"></script>
        <script src="assets/js/placeholder.min.js"></script>
    <![endif]-->

    <link href="fonts/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet">        <!-- Font Awesome -->
    <link href="css/styles.css" type="text/css" rel="stylesheet">                                     <!-- Core CSS with all styles -->

    <link href="assets/plugins/jstree/dist/themes/avenger/style.min.css" type="text/css" rel="stylesheet">    <!-- jsTree -->
    <link href="assets/plugins/codeprettifier/prettify.css" type="text/css" rel="stylesheet">                <!-- Code Prettifier -->
    <link href="assets/plugins/iCheck/skins/minimal/blue.css" type="text/css" rel="stylesheet">              <!-- iCheck -->

    
<link href="assets/plugins/form-daterangepicker/daterangepicker-bs3.css" type="text/css" rel="stylesheet"> 	<!-- DateRangePicker -->
<link href="assets/plugins/fullcalendar/fullcalendar.css" type="text/css" rel="stylesheet"> 					<!-- FullCalendar -->
<link href="assets/plugins/charts-chartistjs/chartist.min.css" type="text/css" rel="stylesheet"> 				<!-- Chartist -->

    </head>

    <body class="infobar-offcanvas">
        <div id="headerbar">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-brown">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-pencil"></i></div>
					</div>
					<div class="tile-footer">
						//
					</div>
				</a>
			</div>
			
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-grape">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-group"></i></div>
						<div class="pull-right"><span class="badge">2</span></div>
					</div>
					<div class="tile-footer">
						
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-primary">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-envelope-o"></i></div>
						<div class="pull-right"><span class="badge">10</span></div>
					</div>
					
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-inverse">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-camera"></i></div>
						<div class="pull-right"><span class="badge">3</span></div>
					</div>
					<div class="tile-footer">
						
					</div>
				</a>
			</div>

			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-midnightblue">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-cog"></i></div>
					</div>
					<div class="tile-footer">
						
					</div>
				</a>
			</div>
			<div class="col-xs-6 col-sm-2">
				<a href="#" class="shortcut-tile tile-orange">
					<div class="tile-body">
						<div class="pull-left"><i class="fa fa-wrench"></i></div>
					</div>
					<div class="tile-footer">
						Plugins
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
        <header id="topnav" class="navbar navbar-midnightblue navbar-fixed-top clearfix" role="banner">

	<span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
		<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar"><span class="icon-bg"><i class="fa fa-fw fa-bars"></i></span></a>
	</span>


	

	<ul class="nav navbar-nav toolbar pull-right">
		<li class="dropdown toolbar-icon-bg">
			<a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">
				<span class="icon-bg">
					<i class="fa fa-fw fa-ellipsis-h"></i>
				</span>
			</a>
		</li>		
		<li class="dropdown toolbar-icon-bg">
			<!-- <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-bell"></i></span><span class="badge badge-info">5</span></a> -->
		</li>

		<li class="dropdown toolbar-icon-bg hidden-xs">
			<!-- <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-envelope"></i></span></a> -->
			<div class="dropdown-menu dropdown-alternate messages arrow">
				<div class="dd-header">
					<span>Messages</span>
					<span><a href="#">Settings</a></span>
				</div>
		<li class="dropdown toolbar-icon-bg">
			<a href="#" class="dropdown-toggle" data-toggle='dropdown'><span class="icon-bg"><i class="fa fa-fw fa-user"></i></span></a>
			<ul class="dropdown-menu userinfo arrow">
				<li><a href="#"><span class="pull-left">NAME</span> <span class="badge badge-info">100%</span></a></li>
				<li class="divider"></li>
				<li><a href="logout.php"><span class="pull-left">Sign Out</span> <i class="pull-right fa fa-sign-out"></i></a></li>
			</ul>
		</li>

	</ul>

</header>

        <div id="wrapper">
            <div id="layout-static">
                <div class="static-sidebar-wrapper sidebar-midnightblue">
                    <div class="static-sidebar">
                        <div class="sidebar">
    <div class="widget stay-on-collapse" id="widget-welcomebox">
        <div class="widget-body welcome-box tabular">
            <div class="tabular-row">
                <?php
                        $query = "SELECT * FROM users where username = '$_SESSION[username]'";
                        $run_query = mysqli_query($mysqli,$query);
                        $row = mysqli_fetch_assoc($run_query); 
                        $username = $row['username'];
                       
                ?>

                <div class="tabular-cell welcome-avatar">
                    <a href="#"><img src="user_pics/<?php echo $row['user_pics'];?>" class="avatar"></a>
                </div>
                
                <div class="tabular-cell welcome-options">
                    <span class="welcome-text">Welcome,</span>
                    <a href="dashboard.php" class="welcome-text"><?php echo $username; ?></a>
                </div>
            </div>
        </div>
    </div>
	<div class="widget stay-on-collapse" id="widget-sidebar">
        	        <nav role="navigation" class="widget-body">
		        <ul class="acc-menu">
				<li class="nav-separator">MENU</li>
				<li><a href="dashboard.php"><i class="fa fa-home"></i><span>MENU</span></a></li>
				
				<li class="dropdown">
				<span><i class="fa fa-paper-plane dropbt ">STOCK</i></span>
		<div class="dropdown-content">
		<a href="<?php echo __DIR_ .'newstock.php' ?>" > CREATE NEW STOCK</a>
		<a href="" title="">RECEIVE MORE STOCK</a>
		<a href="" title="">CHANGE PRICE PERTORN</a>
	</div>
				</li>
<br>
<br>
				<li class="dropdown">
				<span><i class="fa fa-paper-plane dropbt ">SALES</i></span>
				<div class="dropdown-content">
				<a href="#"></a>
				<a href="" title="">POST SALES TO CUSTOMER</a>
				<a href="" title="">POST DAILY EXPENSE</a>
				<a href="" title="">POST BANK DEPOSIT</a>
				<a href="" title="">POST BALANCE BROUGHT FORWARD</a>
				<a href="" title="">POST CUSTOMERS DEPOSIT</a>
				</div>
				<!--
				<i class="fa fa-paper-plane"></i>
				<span>SALES</span>
				</a>
				<br>-->
				</li>
<br>
<br>
	<li class="dropdown">
				<span><i class="fa fa-paper-plane dropbt ">ENQUIRY</i></span>
				<div class="dropdown-content">
				<a href="#"></a>
				<a href="" title="">DAILY DEBTORS</a>
				<a href="" title="">DAILY SALES</a>
				</div>
				
				</li>
			
				

				<li><a href="logout.php"><i class="fa fa-power-off"></i><span>Logout</span></a></li>
			</ul>
			</nav>
    </div>
</div>
                    </div>
                </div>
                <div class="static-content-wrapper">
                    <div class="static-content">
                        <div class="page-content">
                            <ol class="breadcrumb">
                            </ol>
                            <div class="page-heading">            
                            	<center>
                            		<h1>JULIOLANREWAJU</h1>	
                            	</center>
                            			<br>
                            				<h6>AGBOOLA AIYEOBASAN</h6>
                                <div class="options">
  <!--  <div class="btn-toolbar">
        <a href="#" class="btn btn-default"><i class="fa fa-fw fa-wrench"></i></a>
    </div> -->
</div>
                            </div>
                            <div class="container-fluid">
                                

	<div data-widget-group="group1">

		<div class="row">
			<div class="col-md-3">
				<div class="amazo-tile tile-success">
					<div class="tile-heading">
						<div class="title">MUKAZ NIGERIA LIMITED</div>
						<!-- <div class="secondary">past 28 days</div> -->
					</div>
					<!--
					<div class="tile-body">
						<div class="content">something here</div>
					</div>
					<div class="tile-footer">
						<!-- <span class="info-text text-right"><i class="fa fa-level-up"></i></span> -->

						<div id="sparkline-revenue" class="sparkline-line"></div>
					</div>
				</div>
			</div>
			<!--
			<div class="col-md-3">
				<div class="amazo-tile tile-info" href="#"> 
					<div class="tile-heading">
				
					
				        <div class="title">Total iron</div>
				        <!-- <div class="secondary">orders this month</div> -->
				    </div>

				    <!--
				    <div class="tile-body">
				        <div class="content">somethiung here</div>
				    </div>
				    <div class="tile-footer">
				    	<!-- <span class="info-text text-right">82% of 4,500</span> -->

				    	<div class="progress">
					    	<!-- <div class="progress-bar" style="width: 50%"></div> -->
					    </div>
				    </div>
				</div>
			</div>
			<!--
			<div class="col-md-3">
				<div class="amazo-tile tile-white">
					<div class="tile-heading">
						<div class="title">FINE AMOUNT</div>
						<div class="secondary"></div>
					</div>
					-->
					<div class="tile-body">
						<span class="content">
						
							

						</span>
					</div>
					<div class="tile-footer">
						<span class="info-text text-right" style="color: #94c355"> <i class="fa fa-level-up"></i></span>
						<div id="sparkline-commission" class="sparkline"></div>
					</div>
				</div>
			</div>
		</div>

		

	</div>


                            </div> <!-- .container-fluid -->
                        </div> <!-- #page-content -->
                    </div>
                    <footer role="contentinfo">
                    <center>
    <div class="clearfix">
        <ul class="list-unstyled list-inline pull-left">
            <li><h6 style="margin: 0;"> &copy; <?php echo date("Y"); ?></h6></li>

        </ul>
        </center>
        <button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
    </div>
</footer>
                </div>
            </div>
        </div>


    

        
        </div>


    
    
<script src="assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script src="assets/js/jqueryui-1.9.2.min.js"></script> 							<!-- Load jQueryUI -->

<script src="assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->


<script src="assets/plugins/easypiechart/jquery.easypiechart.js"></script> 		<!-- EasyPieChart-->
<script src="assets/plugins/sparklines/jquery.sparklines.min.js"></script>  		<!-- Sparkline -->
<script src="assets/plugins/jstree/dist/jstree.min.js"></script>  				<!-- jsTree -->

<script src="assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
<script src="assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->

<script src="assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

<script src="assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->

<script src="assets/js/enquire.min.js"></script> 									<!-- Enquire for Responsiveness -->

<script src="assets/plugins/bootbox/bootbox.js"></script>							<!-- Bootbox -->

<script src="assets/plugins/simpleWeather/jquery.simpleWeather.min.js"></script> <!-- Weather plugin-->

<script src="assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

<script src="assets/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script> 	<!-- Mousewheel support needed for jScrollPane -->

<script src="assets/js/application.js"></script>
<script src="assets/demo/demo.js"></script>
<script src="assets/demo/demo-switcher.js"></script>

<!-- End loading site level scripts -->
    
    <!-- Load page level scripts-->
    
<script src="assets/plugins/fullcalendar/fullcalendar.min.js"></script>   				<!-- FullCalendar -->

<script src="assets/plugins/wijets/wijets.js"></script>     								<!-- Wijet -->

<script src="assets/plugins/charts-chartistjs/chartist.min.js"></script>               	<!-- Chartist -->
<script src="assets/plugins/charts-chartistjs/chartist-plugin-tooltip.js"></script>    	<!-- Chartist -->

<script src="assets/plugins/form-daterangepicker/moment.min.js"></script>              	<!-- Moment.js for Date Range Picker -->
<script src="assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->

<script src="assets/demo/demo-index.js"></script> 										<!-- Initialize scripts for this page-->

    <!-- End loading page level scripts-->

    </body>

<!-- Mirrored from avenger.kaijuthemes.com/ by HTTrack Website Copier/3.x [XR&CO'2013], Wed, 02 Dec 2015 04:41:47 GMT -->
</html> -->