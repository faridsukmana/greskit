
	<?php 
	header('Content-type: text/html; charset=ASCII');
	session_start();
	//==== Glbal Define For get page after #if ($_SESSION['model']==1)# =======
		$_SESSION['model'] = 1;
	//=========================
	date_default_timezone_set("Asia/Bangkok");
	
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	require_once('mysql_mysqli.inc.php');
	require_once('connect.php');
	require_once('page/global_define.php');
	require_once('page/login.php');
	require_once('page/get_application.php');  
	if($_SESSION['model']==1){
	?>
	<html>
	<head>
	<title>
	Greskit
	</title>
	<META HTTP-EQUIV="refresh" CONTENT="43200">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="icon" href="view/images/favicon.ico" type="image/vnd.microsoft.icon" />
	<link href="view/css/style.css" rel="stylesheet" type="text/css" />
	<link href="view/css/log.css" rel="stylesheet" type="text/css" />
	
	<link rel="stylesheet" href="plugin/jquery/themes/base/jquery.ui.all.css">
	<script language="javascript" src="view/js/cal2.js"></script>
	<script language="javascript" src="view/js/cal_conf2.js"></script>
	<script language="javascript" src="view/js/calendarDateInput.js"></script>
	<script src="view/js/jquery-1.5.1.js"></script> 
	
	<!--------------Jeasy (Position must top from UI Script)-------------->
	<link rel="stylesheet" type="text/css" href="plugin/jeasy/themes/bootstrap/easyui.css">
	<link rel="stylesheet" type="text/css" href="plugin/jeasy/themes/icon.css">
	<!--<script type="text/javascript" src="plugin/jeasy/jquery.min.js"></script>-->
	<script type="text/javascript" src="plugin/jeasy/jquery.easyui.min.js"></script>
				<!--Filter Datagrid--->
	<script type="text/javascript" src="plugin/jeasy/datagrid-filter/datagrid-filter.js"></script>
				<!--Group Row Datagrid--->
	<script type="text/javascript" src="plugin/jeasy/datagrid-groupview.js"></script>
	<style>
		.icon-filter{
			background:url('plugin/jeasy/datagrid-filter/filter.png') no-repeat center center;
		}
	</style>
	<!--------------------------------------------->
	
	<!----------(Graph menggunakan Vega)------>
	<script src="plugin/vega/vega.min.js"></script>
	
	<!----------(UI Script)------>
	<script src="view/js/jquery-ui.min.js"></script> 
	<script src="view/js/ui/jquery.ui.core.js"></script>
	<script src="view/js/ui/jquery.ui.widget.js"></script>
	<script src="view/js/ui/jquery.ui.datepicker.js"></script>
	<script src="plugin/jquery/ui/jquery.ui.tabs.js"></script>
	<script src="plugin/jquery/jquery.panelgallery-1_1.js"></script>
	<script src="view/js/effect.js"></script>
	<script type="text/javascript" language="javascript" src="view/js/jquery.dataTables.js"></script>
	<!----Digunakan untuk fix header---->
	<!--<script type="text/javascript" language="javascript" src="view/js/FixedHeader.js"></script>-->
	<!--------------------------------------------->
	
	<!--------- make form new field  ----------------------->
	<script src="view/js/ui/jquery.ui.mouse.js"></script>
	<script src="view/js/ui/jquery.ui.button.js"></script>
	<script src="view/js/ui/jquery.ui.draggable.js"></script>
	<script src="view/js/ui/jquery.ui.position.js"></script>
	<script src="view/js/ui/jquery.ui.resizable.js"></script>
	<script src="view/js/ui/jquery.ui.dialog.js"></script>
	<script src="view/js/ui/jquery.effects.core.js"></script>
	
	<!------------ Make multiselect function ---------------->
	<?php if($_SESSION['app']=='Purchasing Support System'){?> 
		<script type="text/javascript" src="plugin/multiselect/localisation/jquery.localisation-min.js"></script>
		<script type="text/javascript" src="plugin/multiselect/scrollTo/jquery.scrollTo-min.js"></script>
		<script type="text/javascript" src="plugin/multiselect/ui.multiselect.js"></script>
		<link type="text/css" href="view/css/ui.multiselect.css" rel="stylesheet" /> 
	<?php }?>
	<!------------------------------------------------------>
	
	<!-------------Jquery Chromatable------------------------>
<!--	<link rel="stylesheet" href="plugin/chrometable/css/style.css"> -->

	<script src="plugin/chrometable/jquery.chromatable.js"></script>
	<script>

	$(document).ready(function(){
	
		$("#yourTableID").chromatable({
		
				width: "100%", // specify 100%, auto, or a fixed pixel amount
				height: "400px",
				scrolling: "no" // must have the jquery-1.3.2.min.js script installed to use
				
			});
			
		$("#scroll").chromatable({
		
				width: "1000px",
				height: "400px",
				scrolling: "yes"
				
			});
	});
	</script>
	<!------------------------------------------------------->

	<!--------------login form------------------------------->
	<script src="view/js/dialog_log.js"></script>
	
	<script src="view/js/table.js"></script>
	<script>
		<!----- Digunakan untuk menampilkan fixed header hanya dengan merubah nama id--->
		<!--$(document).ready( function () {
		<!--	var oTable = $('#example').dataTable();
		<!--	new FixedHeader( oTable );
		<!--} );
		-->
		
		function myJS(myVar){
			alert(myVar);
		}

		$(function() {
			$( ".datepicker" ).datepicker();
		});
		$(function() {
			$( "#datepicker2" ).datepicker();
		});
		
		$(function()
		{
			$(".mytable tr:even").addClass("eventr");;
			$(".mytable tr:odd").addClass("oddtr");;
		});
		
		$(function() {
			 $(".editable").attr("disabled",false); 
			 $(".editable2").attr("disabled",false); 
		});
		
		$(
		 function()
		 {
		  $("td .tb").hover(
		   function()
		   {
			$(this).addClass("highlight");
		   },
		   function()
		   {
			$(this).removeClass("highlight");
		   }
		  )
		 }
		)
		
		// initialise plugins
		jQuery(function(){
			jQuery('ul.sf-menu').superfish();
		});
	</script>

</head>
<body>
	<?php if ((isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['app']) && $_REQUEST['user_sm']=='true')){?>
	<div class="center">
		<table>
		<tr>
			<td class="right">
				<?php echo get_page();?>
			</td>
		</tr>
		</table>
	</div>

	<?php }else if(isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['app'])){ ?>
	<div class="header_">
		<div class="header_left">
				<img src="view/images/ssup2.png" alt="image 1" width="715" height="125" />			
		</div>
		
		<div class="header_menu">
			<ul class="sf-menu">
				<?php echo get_menu(); ?>
			</ul>
		</div>
		
		<div class="header_right">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Welcome</a></li>
				</ul>
				<div id="tabs-1">
					<p>Welcome TPC Indo System Support
						<br/>
						<span class="title"><?php echo $_SESSION['user']; ?></span>
						<br/>
						Contact IT Section, if you have problem to use this application
					</p>
					<p>
						
					</p>
				</div>
			</div>
		</div>
	</div>
	
	<div class="center">
		<table>
		<tr>
			<td class="right">
				<?php echo get_page();?>
			</td>
		</tr>
		</table>
	</div>
	<div class="footer_">Copyright@TPCINDO CP:farid@tpcindo.co.id</div>
	
	<?php }else{?>				
				<?php 
				/*	if(isset($_REQUEST['domain']) && isset($_REQUEST['password']))
						echo '<br/><br/>Select your application that you want run and get ready.<br/><br/><br/>';
					else 
					echo '<br/>Welcome to ERPsiF. Please login first using your account.<br/><br/>';*/
				?>
				
				<div class="container-login" style="background-image: url('view/images/bg-01.jpg');">				
				<?php echo get_login();?>
				</div>

	<?php }?>

	<?php 
	}?>
	<!------------------------------------------------------------------------>
	
	<!----------------Jeasy function click------------------------------------>
	<script type="text/javascript" src="plugin/jeasy/function.js"></script>
	<!------------------------------------------------------------------------>
</body>
</html>