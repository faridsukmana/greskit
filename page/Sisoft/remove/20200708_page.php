<?php
	require_once('permitted.php');
	//----Mengambil variabel yang dijadikan dalama alias menggunakan DEFINE di halaman define.php----------->
	require_once('page/Sisoft/define.php');
	//----Mengambil code halaman php yang dibutuhkan dalam pengembangan program berada di dalam folder function/include.php-------------->
	require_once(_ROOT_.'function/include.php');
	//----Library untuk mengenarate data ke excel----
	require_once(_ROOT_LIB_.'library/phpexcel/PHPExcel.php');
	//----Library untuk mengenerate dari excel ke DBMS
	require_once(_ROOT_LIB_.'library/exceltodb/exceltodbms.php');
	//----Support template
	require_once('page/Sisoft/support_template.php');
	//----Suppot for generate qrcode
	require_once(_ROOT_LIB_.'library/phpqrcode/qrlib.php');
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<link rel="icon" href="view/images/favicon.ico" type="image/vnd.microsoft.icon"/>
		<!--------------Global CSS--------------->
		<link rel="stylesheet" href="<?php echo _ROOT_;?>css/styles.css">
		
		<!--###FOLDER function/get_library.php####--->
		<!-----Fungsi mendefinisikan library yang digunakan dalam halaman ini-->
			<?php echo get_library();?>
		<!--#######################################-->
		
		<!--***********************TEMPLATE EDITING HEADER***************************************************---------------->
		<!--*************************************************************************************************---------------->
		<!-- Bootstrap Core CSS -->
		<link href="<?php echo _ROOT_;?>template/startbootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- MetisMenu CSS -->
		<link href="<?php echo _ROOT_;?>template/startbootstrap/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="<?php echo _ROOT_;?>template/startbootstrap/dist/css/sb-admin-2.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="<?php echo _ROOT_;?>template/startbootstrap/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<!--**************************************************************************************************************------>
		<!--*************************************************************************************************---------------->
		
		<title><?php echo _TITLE_;?></title>
	</head>
	
	<body>
	<!--*********************************MODEL TEMPLATE LAMA *****************************************************----->
	<?php 
	//mendaftarkan link menu dan nama menu yang akan ditampilkan dalam halaman/
	//	$link_menu = array(PATH_INDEX_PAGE,PATH_DATA,PATH_TEXT,PATH_GENSS,PATH_EXCEL,PATH_INDEX_LOGOUT);
	//	$name_menu = array('Highcharts','Jeasyui','TinyMCE','Generate','Tax Rate','Logout');
	
		$link_menu = array(PATH_INDEX_PAGE,PATH_ASSETS,PATH_WORDER,'#','#','#',PATH_INDEX_LOGOUT);
		$name_menu = array('Dashboard','Asset','Work Order','Preventive','Master','Misc','Logout');
		$child_link = array('','','',array(PATH_PMCHEK,PATH_PMSCHE,PATH_PMGENE,PATH_PMLIST),array(PATH_ASSCAT,PATH_ASSETS,PATH_DEPART,PATH_EMPLOY,PATH_FALCOD,PATH_LOCATN,PATH_SUPPLY),array(PATH_PRIORY,PATH_WSTATE,PATH_WRTYPE,PATH_WARRAN,PATH_ASSTAT,PATH_WTRADE,PATH_CRITIC,PATH_POSITI),'');
		$child_menu = array('','','',array('PM Task List','PM Schedule','PM Generation','PM List'),array('Asset Category','Asset','Department','Employee','Failure Code','Location','Supplier'),array('Work Priority List','Work Status List','Work Type List','Warranty / Contract','Asset Status List','Work Trade','Asset Critically','Position'),'');
	//========================================================================
	
	//memanggil fungsi daftar menu ===========================================
		//if(!ISSET($_REQUEST['blankpage']))
			//echo get_menu(array($link_menu,$name_menu,$child_link,$child_menu,'id="cssmenu"'));
		/*if(strcmp($_REQUEST['page'],'genss')!=0){
			echo get_gendatetime();
		}*/
	//========================================================================
	
	//memanggil fungsi menampilkan halaman ===================================
	//olah data anda pada halaman ini=========================================
		//echo get_page();
	//========================================================================
	?>
	<!--*******************************************************************************************************------->
	
	<!--*********************************TEMPLATE BARU ********************************************************------>
	<?php if(!ISSET($_REQUEST['blankpage'])){ ?>
	<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; z-index:2;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?php echo $_SESSION['app']?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
				<?php echo task_work_order();?>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						<li><a href="#"><i class="fa fa-user fa-fw"></i><?php echo $_SESSION['user']?></a></li>
						<li class="divider"></li>
                        <li><a href="<?php echo PATH_INDEX_LOGOUT; ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="<?php echo PATH_INDEX_PAGE;?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
						<li><a href="<?php echo PATH_SCHEDU;?>"><i class="fa fa-clock-o fa-fw"></i> Schedule</a></li>
						<li><a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Asset<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li><a href="<?php echo PATH_ASSETS;?>">List Asset</a></li>
								<li><a href="<?php echo PATH_EXPAS;?>">Export Excel</a></li>
                            </ul>
                        </li>
						<li><a href="#"><i class="fa fa-tasks fa-fw"></i> Work Order<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li><a href="<?php echo PATH_WORDER;?>">List Work Order</a></li>
								<li><a href="<?php echo PATH_EXPWO;?>">Export Excel</a></li>
                            </ul>
                        </li>
						<li><a href="#"><i class="fa fa-wrench fa-fw"></i> Preventive<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li><a href="<?php echo PATH_PMCHEK;?>">PM Task List</a></li>
								<li><a href="<?php echo PATH_PMSCHE;?>">PM Schedule</a></li>
								<li><a href="<?php echo PATH_PMGENE;?>">PM Generation</a></li>
								<li><a href="<?php echo PATH_PMLIST;?>">PM List</a></li>
                            </ul>
                        </li>
						<li><a href="#"><i class="fa fa-check fa-fw"></i> Daily Checking<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
                                <li><a href="<?php echo PATH_ICHECK;?>">Item Checklist</a></li>
								<li><a href="<?php echo PATH_LCHECK;?>">Master Checklist</a></li>
								<li><a href="<?php echo PATH_FORMCK;?>">Form Checklist</a></li>
								<li><a href="<?php echo PATH_DAILYC;?>">History Checklist</a></li>
                            </ul>
                        </li>
						<?php if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_){?>
						<li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> Master<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="<?php echo PATH_ASSCAT;?>">Asset Category</a></li>                              
								<li><a href="<?php echo PATH_DEPART;?>">Department</a></li>
								<li><a href="<?php echo PATH_EMPLOY;?>">Employee</a></li>
								<li><a href="<?php echo PATH_FALCOD;?>">Failure Code</a></li>
								<li><a href="<?php echo PATH_LOCATN;?>">Location</a></li>
								<li><a href="<?php echo PATH_SUPPLY;?>">Supplier</a></li>
							</ul>
                        </li>
						<?php }?>
						<?php if(_FULL_){?>
						<li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Misc<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="<?php echo PATH_PRIORY;?>">Work Priority List</a></li>
                                <li><a href="<?php echo PATH_WSTATE;?>">Work Status List</a></li>
								<li><a href="<?php echo PATH_WRTYPE;?>">Work Type List</a></li>
								<li><a href="<?php echo PATH_WARRAN;?>">Warranty / Contract</a></li>
								<li><a href="<?php echo PATH_ASSTAT;?>">Asset Status List</a></li>
								<li><a href="<?php echo PATH_WTRADE;?>">Work Trade</a></li>
								<li><a href="<?php echo PATH_CRITIC;?>">Asset Critically</a></li>
								<li><a href="<?php echo PATH_POSITI;?>">Position</a></li>
							</ul>
                        </li>
						<?php }?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
	</div>
	
	<?php if(!ISSET($_REQUEST['home'])){?>
	<div id="page-wrapper">
        <div class="row">
			<div class="col-lg-12">
                    <div class="panel panel-default">
                        <?php echo get_page().get_new_page(); ?>
					</div>
			</div>		
		</div>
	</div>
	
	<?php }else{?>
	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
            </div>
                <!-- /.col-lg-12 -->
			<?php echo get_page(); ?>
        </div>
	</div>
	<?php }}else{ echo get_page();}?>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo _ROOT_;?>template/startbootstrap/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo _ROOT_;?>template/startbootstrap/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo _ROOT_;?>template/startbootstrap/dist/js/sb-admin-2.js"></script>
	<!--************************************************************************************************************-->
	</body>
</html>