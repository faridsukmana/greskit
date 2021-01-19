<?php
########################################################## KHUSUS HALAMAN WEB#############################################################
	function get_page(){ 
	if(_ACCESS_){	
		//========Menuju get_page_con1==============
		$content = get_page_con1();
		
		//========Halaman jika terjadi logout=======
		if(isset($_REQUEST['logout'])){ 
			$content = logout();
		}
		
		//========Halaman contoh penggunaan Highchart=======
		else if(isset($_REQUEST['home'])){
			//======= Row 1=====
			$qasset = 'SELECT COUNT(*) FROM asset WHERE Hidden="no"'; $result = mysql_exe_query(array($qasset,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $count_asset=$resultnow[0];
			$qpreve = 'SELECT COUNT(*) FROM work_order WHERE WorkTypeID="WT000002" AND WorkStatusID NOT IN (SELECT WorkStatusID FROM work_status WHERE WorkStatusID="WS000020" OR WorkStatusID="WS000021") AND Hidden="no"'; $result = mysql_exe_query(array($qpreve,1)); $resultnow=mysql_exe_fetch_array(array($result,1));$count_preve=$resultnow[0];
			$qactive = 'SELECT COUNT(*) FROM work_order WHERE WorkTypeID<>"WT000002" AND WorkStatusID NOT IN (SELECT WorkStatusID FROM work_status WHERE WorkStatusID="WS000020" OR WorkStatusID="WS000021") AND Hidden="no"'; $result = mysql_exe_query(array($qactive,1)); $resultnow=mysql_exe_fetch_array(array($result,1));$count_active=$resultnow[0];
			$qorder = 'SELECT COUNT(*) FROM work_order WHERE WorkTypeID<>"WT000002" AND WorkStatusID="WS000020" AND Hidden="no"'; $result = mysql_exe_query(array($qorder,1)); $resultnow=mysql_exe_fetch_array(array($result,1));$count_order=$resultnow[0];
			
			$content = '
			<div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$count_asset.'</div>
                                    <div>Total Asset!</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_ASSETS.'">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$count_active.'</div>
                                    <div>Total WO Active!</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_WORDER.'&dashwoact=true">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$count_order.'</div>
                                    <div>Total WO Close!</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_WORDER.'&dashwoclose=true">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>';
        
        if($_SESSION['groupID']=="GROUP181120033150" OR $_SESSION['groupID']=="GROUP200926105919" OR $_SESSION['groupID']=="GROUP200927074425"){
        $content .= '
                 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-wrench fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$count_preve.'</div>
                                    <div>Total PM Active!</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_PMLIST.'&dashpm=true">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
			';
            }
			
			//=======Grouping table 1 dan 2==============
			if($_SESSION['groupID']=="GROUP200927074425"){
			    $title1 = 'WAITING APPROVAL WORK ORDER';
    			$querytab1 = WAITAPPR;
    			$title2 = 'WAITING EXECUTION WORK ORDER';
    			$querytab2 = WAITEXEC;   
			}else if($_SESSION['groupID']=="GROUP181120033150"){
			    if(strtolower($_SESSION['user'])=="mgr"){
			        $title1 = 'WAITING EXECUTION WORK ORDER';
        			$querytab1 = WAITEXECMGR;
        			$title2 = 'CLOSE WORK ORDER';
        			$querytab2 = CLOSE; 
			    }else{
			        $title1 = 'OPEN WORK ORDER';
        			$querytab1 = OPEN;
        			$title2 = 'WAITING EXECUTION WORK ORDER';
        			$querytab2 = WAITEXEC;    
			    }
			}else{
			    $title1 = 'CREATED WORK ORDER';
    			$querytab1 = CREATED;
    			$title2 = 'WAITING EXECUTION WORK ORDER';
    			$querytab2 = WAITEXEC;   
			}
			
			//***********TABLE 1***********//
			$width = "[100,120,120,80,200,200,450]";
			$field = gen_mysql_id($querytab1);
			$name = gen_mysql_head($querytab1);
			$sethead = "['WO','Plant','Asset No'"._USER_EDIT_SETHEAD_.",'Work_Type','Work Status','Description']";
			$setid = "[{data:'WO',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Asset',className: 'htLeft'}"._USER_EDIT_SETID_.",{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Description',className: 'htLeft'}]";
			$dt = array($querytab1,$field,array('Edit'),array(PATH_WORDER.EDIT),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'notplan');
			$notplan= '<div id="notplan" style="width: 1040px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********TABLE 2***********//
			$width = "[100,120,120,80,200,200,450]";
			$field = gen_mysql_id($querytab2);
			$name = gen_mysql_head($querytab2);
			$sethead = "['WO','Plant','Asset No'"._USER_EDIT_SETHEAD_.",'Work_Type','Work Status','Description']";
			$setid = "[{data:'WO',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Asset',className: 'htLeft'}"._USER_EDIT_SETID_.",{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Description',className: 'htLeft'}]";
			$dt = array($querytab2,$field,array('Edit'),array(PATH_WORDER.EDIT),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'plan');
			$plan= '<div id="plan" style="width: 1040px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			$table .= '
					<table>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">'.$title1.'</div></td></tr>
							<tr><td>'.$notplan.'</td></tr>
							</table>
						</td>
						</tr>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">'.$title2.'</div></td></tr>
							<tr><td>'.$plan.'</td></tr>
							</table>
						</td>
						</tr>
					</table>
				';
			
			
			$content .= '
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
                        <div class="panel-heading">
							<a href="'.PATH_WORDER.ADD.'"><i class="fa fa-plus fa-fw"></a></i> Create Work Order
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="tab1">'.$table.'</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>';
			
			//=======Tabel 1 for 1st row=========//
			$query_data = HISBREAKDOWN;
			$result_data = mysql_exe_query(array($query_data,1));
			$data_table = ''; $i =1;
			while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
				$data_table .= '
					<tr>
						<td>'.$i.'</td>
						<td>'.$result_data_now[0].'</td>
						<td>'.$result_data_now[1].'</td>
						<td>'.$result_data_now[2].'</td>
						<td>'.$result_data_now[3].'</td>
						<td>'.$result_data_now[4].'</td>
						<!--<td>'.$result_data_now[5].'</td>
						<td>'.$result_data_now[6].'</td>
						<td>'.$result_data_now[7].'</td>-->
						<td>'.$result_data_now[8].'</td>
				';
				$i++;
			}
			
			//=======SECOND ROW =======
			$content .= get_js_graph(array(DETWOSTATUS,'3d-column-interactive','DETAIL WORK ORDER STATUS','WO Status','detwostatus','500','500','typequery1',PATH_WORDER.'&state=','USD'));
			
			$content .= get_js_graph(array(WOBACKLOG,'3d-pie','WO BACKLOG','Percent Work Order','wobacklog','450','450','typequery1',PATH_WORDER.'&section=','Total Work Order'));
			$query = WOBACKLOG; $detail='';
			$result = mysql_exe_query(array($query,1)); 
			$i=0;
			while($result_now=mysql_exe_fetch_array(array($result,1))){
				$detail_wobacklog .= '<button type="button" class="btn badge-secondary" style="margin-top:3px;">
							  '.$result_now[0].' <span class="badge badge-info">'.$result_now[1].'</span>
							</button> ';
				$i++;
			}
			
			$content .= ' 
				<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> DETAIL WORK ORDER STATUS
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="detwostatus"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-6">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> WO BACKLOG
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="wobacklog"></div>
							<div class="text-center">'.$detail_wobacklog.'</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-12">
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">HISTORICAL BREAKDOWN FROM CMMS</h4>
							<table id="his-breakdown" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
									<th rowspan="2"> No </th>
									<th rowspan="2"> Plant </th>
									<th rowspan="2"> Asset Number </th>
									<th colspan="3" style="text-align: center;"> Breakdown Unschedule </th>
									<th rowspan="2"> Status </th>
								</tr>
								<tr>
									<th>Start Date</th>
									<th>Finished Date</th>
									<th>Duration (Day)</th>
									<!--<th>Start Time</th>
									<th>Finished Time</th>
									<th>Duration (Hour)</th>-->
								</tr>
							  </thead>
							  <tbody>
									'.$data_table.'
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  <!-- content-wrapper ends -->
				</div>
				</div>
			';
			
			//=======Table 2 for first row==============
			$query_data = CALCULATION;
			$result_data = mysql_exe_query(array($query_data,1));
			$data_table = ''; $i =1;
			while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
				$data_table .= '
					<tr>
						<td>'.$i.'</td>
						<td>'.$result_data_now[0].'</td>
						<td>'.$result_data_now[2].'</td>
						<td>'.$result_data_now[3].'</td>
						<td>'.$result_data_now[4].'</td>
						<!--<td>'.$result_data_now[5].'</td>-->
						<td>'.$result_data_now[8].'</td>
						<!--<td>'.$result_data_now[9].'</td>-->
						<td>'.$result_data_now[6].'</td>
						<!--<td>'.$result_data_now[7].'</td>-->
				';
				$i++;
			}
			
			$content .= ' 
				<div class="row">
				<div class="col-lg-12">
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">MTBF & MTTR CALCULATION PER ASSET</h4>
							<table id="his-calculation" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
									<th rowspan="2"> No </th>
									<th rowspan="2"> Plant </th>
									<th rowspan="2"> Asset Number </th>
									<th rowspan="2"> Freq. CM </th>
									<th colspan="1" style="text-align: center;"> Total <br/> Downtime </th>
									<th colspan="1" style="text-align: center;"> MTBF </th>
									<th colspan="1" style="text-align: center;"> MTTR </th>
								</tr>
								<tr>
									<th>Day</th>
									<!--<th>Hour</th>-->
									<th>Day</th>
									<!--<th>Hour</th>-->
									<th>Day</th>
									<!--<th>Hour</th>-->
								</tr>
							  </thead>
							  <tbody>
								'.$data_table.'	
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  <!-- content-wrapper ends -->
				</div>
				</div>
				'.dashboard_js();
			
			//=======2nd ROW ========
			$content .= get_js_graph(array(ALL_PLANT_MTBF_DAY_KR,'3d-pie','ALL PLANT MTBF (DAYS) KERAWANG','Percent MTBF','mtbfdaykr','450','450','typequery1',PATH_INDEX_PAGE,'MTBF'));
			$content .= get_js_graph(array(ALL_PLANT_MTBF_DAY_TG,'3d-pie','ALL PLANT MTBF (DAYS) TANGERANG','Percent MTBF','mtbfdaytg','450','450','typequery1',PATH_INDEX_PAGE,'MTBF'));
			//=======3rd ROW ========
			$content .= get_js_graph(array(ALL_PLANT_MTTR_DAY_KR,'3d-pie','ALL PLANT MTTR (DAYS) KERAWANG','Percent MTTR','mttrdaykr','450','450','typequery1',PATH_INDEX_PAGE,'MTTR'));
			$content .= get_js_graph(array(ALL_PLANT_MTTR_DAY_TG,'3d-pie','ALL PLANT MTTR (DAYS) TANGERANG','Percent MTTR','mttrdaytg','450','450','typequery1',PATH_INDEX_PAGE,'MTTR'));
			
			$content .= '
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> ALL PLANT MTBF (DAY) KERAWANG
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="mtbfdaykr"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-6">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> ALL PLANT MTBF (DAY) TANGERANG
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="mtbfdaytg"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-6">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> ALL PLANT MTTR (DAY) KERAWANG
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="mttrdaykr"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-6">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> ALL PLANT MTTR (DAY) TANGERANG
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="mttrdaytg"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
            </div
			';
			return $content;
		}
		
		//=======Dashboard Halaman Template Lama ===========
		else if(isset($_REQUEST['home#'])){
			$content .= get_js_graph(array(GSTATEBYYEAR,'3d-pie','Total Work Order '.date('Y'),'Percent Work Order','container','420','360','typequery1',PATH_INDEX_PAGE,'Total Work Order'));
			$content .= get_js_graph(array(GRAPHPLNSTATE,'3d-pie','Condition of Asset Class A','Percent Asset','container2','420','360','typequery1',PATH_INDEX_PAGE,'Total Asset'));
			//$content .= get_js_graph(array(GSTATEBYMONTH,'3d-pie','Total Work Order '.date('M').' '.date('Y'),'Percent Work Order','container2','420','360','typequery1',PATH_INDEX_PAGE,'Total Work Order'));
			$content .= get_js_graph(array(GSCHEDULEWO,'3d-pie','Schedule Work Order','Percent Work Order','container3','420','360','typequery1',PATH_INDEX_PAGE,'Total Work Order'));
			
			//***********WO NOT PLANNED PERFORMED***********//
			$width = "[100,200,100,300]";
			$field = gen_mysql_id(NOTPLANPERFORMED);
			$name = gen_mysql_head(NOTPLANPERFORMED);
			$sethead = "['WO','Asset','Work Status','Description']";
			$setid = "[{data:'WO',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Description',className: 'htLeft'}]";
			$dt = array(NOTPLANPERFORMED,$field,array('Delete'),array(PATH_INDEX_PAGE.'&wo='.$_REQUEST['rowid'].DELETE),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'notplan');
			$notplan= '<div id="notplan" style="width: 620px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********PERFORMED WORK ORDERS THIS YEAR***********//
			$width = "[100,200,300]";
			$field = gen_mysql_id(PERFORMED);
			$name = gen_mysql_head(PERFORMED);
			$sethead = "['WO','Asset','Description']";
			$setid = "[{data:'WO',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Description',className: 'htLeft'}]";
			$dt = array(PERFORMED,$field,array('Delete'),array(PATH_INDEX_PAGE.'&wo='.$_REQUEST['rowid'].DELETE),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'plan');
			$plan= '<div id="plan" style="width: 620px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			$content .= '
					<table>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">Top 15 - Not Planned Work Order</div></td></tr>
							<tr><td>'.$notplan.'</td></tr>
							</table>
						</td>
						<td>
							<table>
							<tr><td><div class="ade">Performed Work Order '.date('Y').'</div></td></tr>
							<tr><td>'.$plan.'</td></tr>
							</table>
						</td>
						</tr>
					</table>
					<table>
						<tr><td id="container"></td><td id="container2"></td><td id="container3"></td></tr>
					</table>
				';
			return $content;			
		}
		
		//========Halaman contoh penggunaan Jeasyui=======
		else if(strcmp($_REQUEST['page'],'data')==0){
			//Mendefinisikan variabel yang digunakan dalam konten Jeasyui//
			//------Set id pada sql-------
			$field = gen_mysql_id(EXAMPLE);
			$width = array(80,120,170,380,120,60);
			//------Set header pada sql---
			$name = gen_mysql_head(EXAMPLE);
			//------Fungsi mendapatkan konten table Jeasyui--//
			$setdata = array($field,$width,$name,'get_example.php');
			$content = table_jeasyui($setdata);
		}
		
		
		//========Halaman contoh penggunaan TinyMCT=======
		else if(strcmp($_REQUEST['page'],'text')==0){
			$area_1 = textarea_mct(array('elm1','elm1',15,80,'80%'));
			$area_2 = textarea_mct(array('small','small',15,80,'80%'));
			$content ='
			<div>
			<form method="post" action="http://www.tinymce.com/dump.php?example=true">
				<div>'.$area_1.'<br />'.$area_2.'</div>
			</form>
			</div>
			';
		}
			
		//========Halaman contoh penggunaan Handsontable=
		//========Non aktifkan TinyMCT untuk menggunakan fungsi handsontable
		else if(strcmp($_REQUEST['page'],'excel')==0){
			if($edit){
				$content = '<p>
							<button class="butt" name="save">Save</button>
						  </p>';
				$teks = 'Click "Save" to save data in server';
			}else{
				$teks = '';
			}
			$content .= '
						<div id="exampleConsole" class="console">'.$teks.'</div>
						<div id="example1" style="width: 460px; height: 500px; overflow: hidden;"></div>';
			
			//-------set lebar kolom -------------
			$width = "[100,100,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(FXRATE);
			//-------get header pada sql----------
			$name = gen_mysql_head(FXRATE);
			//-------set header pada handson------
			$sethead = set_head($name);
			//-------set id pada handson----------
			$setid = set_id($field);
		//	$setid = "[{data:'FX_Date',className: 'htCenter'},{data:'Currency',className: 'htCenter'},{data:'TAX',type: 'numeric',format: '0,0'},{data:'BI',type: 'numeric',format: '0,0'}]";
			//-------get data pada sql------------
			$dt = array(FXRATE,$field);
			$data = get_data_handson($dt);
			//-------set url ---------------------
			$url = _ROOT_.'function/data/save_data.php';
			//----Fungsi memanggil data handsontable melalui javascript---
			$sethandson = array($sethead,$setid,$data,$width,$url);
			
			//--------fungsi hanya untuk meload data
			//$content .= get_handson($sethandson);
			
			//--------fungsi untuk load data, save, data, reset data dan autosave
			$content .= get_handson_loadsave($sethandson);
		}
		
		//============Halaman MENU MASTER Untuk CMSIF============= 
		//=======NEW PAGE=====================
		//------ ASSET CATEGORY --------------
		else if(strcmp($_REQUEST['page'],'asscat')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM asset_category WHERE AssetCategoryID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content .= '<br/><div class="ade">ASSET CATEGORY</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,400,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(ASSCAT.' ORDER BY AssetCategoryID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(ASSCAT.' ORDER BY AssetCategoryID DESC');
			//-------set header pada handson------
			$sethead = "['Asset Category ID','Asset Category Code','Asset Category Description'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Asset_Category_ID',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Category_Code',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(ASSCAT.' ORDER BY AssetCategoryID DESC',$field,array('Edit','Delete'),array(PATH_ASSCAT.EDIT,PATH_ASSCAT.DELETE),array(),PATH_ASSCAT);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			
			//------------Jika ada halaman upload data-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD ASSET CATEGORY DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSCAT.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Upload Excel Employee</div>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'/file/asscat.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> Excel Asset Category </td><td>:</td> </span></td><td>'.text_filebox(array('asscat','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'/file/';
						$target_file = $target_dir.basename($_FILES['asscat']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="alert alert-danger" align="center">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['empex']['size']>50000){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your files is too large</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 && $sizeupload==0){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['asscat']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="alert alert-danger" align="center"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'asscat');
								$content .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['asscat']['name']).' has been uploaded</div>';
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR ASSET CATEGORY</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSCAT.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset Category</div>
								<table>
									<tr><td width="150"><span class="name"> Asset Category Desc </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascode" value="'.$reval_ax.'"></td></tr>
									<tr><td width="150"><span class="name"> Asset Category Code</td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascat" value="'.$reval_ax.'"></td></tr>
									<tr><td width="150"></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['ascode']) && !empty($_REQUEST['ascat'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/asscat.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTASSCAT,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $assid=get_new_code('AT',$ncode); //echo $assid;
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO asset_category VALUES("'.$assid.'","'.$_REQUEST['ascode'].'","'.$_REQUEST['ascat'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = ASSCAT.' WHERE AssetCategoryID="'.$assid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Asset Category ID','Asset Category Code','Asset Category Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Asset_Category_ID',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Category_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSCAT.EDIT),array(),PATH_ASSCAT);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['ascode']) && !empty($_REQUEST['ascat'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE asset_category SET AssetCatCode="'.$_REQUEST['ascode'].'", Assetcategory="'.$_REQUEST['ascat'].'" WHERE AssetCategoryID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = ASSCAT.' WHERE AssetCategoryID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Asset Category ID','Asset Category Code','Asset Category Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Asset_Category_ID',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Category_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSCAT.EDIT),array(),PATH_ASSCAT);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = ASSCAT.' WHERE AssetCategoryID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$ascode=$resultnow[1]; $ascat=$resultnow[2];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA FOR ASSET CATEGORY FOR '.$ascode.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSCAT.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset Category</div>
								<table>
									<tr><td width="150"><span class="name"> Asset Category Desc </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascode" value="'.$ascode.'"></td></tr>
									<tr><td width="150"><span class="name"> Asset Category Code</td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascat" value="'.$ascat.'"></td></tr>
									<tr><td width="150"></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}	
		}

		//=======NEW PAGE=====================
		//------ FAILURE CODE ----------------
		else if(strcmp($_REQUEST['page'],'falcod')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM failure_cause WHERE FailureCauseID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">FAILURE CODE</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,400,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(FALCOD.' ORDER BY FailureCauseID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(FALCOD.' ORDER BY FailureCauseID DESC');
			//-------set header pada handson------
			$sethead = "['Failure ID','Failure Code','Failure Description'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Failure_ID',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Failure_Description',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(FALCOD.' ORDER BY FailureCauseID DESC',$field,array('Edit','Delete'),array(PATH_FALCOD.EDIT,PATH_FALCOD.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR FAILURE CODE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_FALCOD.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Failure Code</div>
								<table>
									<tr><td width="150"><span class="name"> Failure Code </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="flcode" value=""></td></tr>
									<tr><td width="150"><span class="name"> Failure Desc. </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="fldesc" value=""></td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['flcode']) && !empty($_REQUEST['fldesc'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/falcod.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTFALCOD,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $flid=get_new_code('FL',$ncode); //echo $assid;
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO failure_cause (FailureCauseID,FailureCauseCode,FailureCauseDesc) VALUES("'.$flid.'","'.$_REQUEST['flcode'].'","'.$_REQUEST['fldesc'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = FALCOD.' WHERE FailureCauseID="'.$flid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Failure ID','Failure Code','Failure Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Failure_ID',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Failure_Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_FALCOD.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['flcode']) && !empty($_REQUEST['fldesc'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE failure_cause SET FailureCauseCode="'.$_REQUEST['flcode'].'", FailureCauseDesc="'.$_REQUEST['fldesc'].'" WHERE FailureCauseID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = FALCOD.' WHERE FailureCauseID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Failure ID','Failure Code','Failure Description'"._USER_EDIT_SETHEAD_._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Failure_ID',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Failure_Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_FALCOD.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = FALCOD.' WHERE FailureCauseID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); 
				$flcode=$resultnow[1]; $fldesc=$resultnow[2];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA FOR ASSET CATEGORY FOR '.$flcode.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_FALCOD.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset Category</div>
								<table>
									<tr><td width="150"><span class="name"> Failure Code </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="flcode" value="'.$flcode.'"></td></tr>
									<tr><td width="150"><span class="name"> Failure Desc. </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="fldesc" value="'.$fldesc.'"></td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ EMPLOYEE ------------------
		else if(strcmp($_REQUEST['page'],'employ')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM employee WHERE EmployeeID="'.$_REQUEST['rowid'].'"'; 
				mysql_exe_query(array($query,1));  
			}
		
			$content = '<br/><div class="ade">EMPLOYEE</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[150,150,150,150,200,300,250,150,150,150,150,150,150,150,150,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(EMPLOY.' ORDER BY E.EmployeeID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(EMPLOY.' ORDER BY E.EmployeeID DESC');
			//-------set header pada handson------
			$sethead = "['Employee ID','Employee No','First Name','Last Name','Position','Department Desc','Work Phone','Hand Phone','Address','Office Location'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Employee_ID',className: 'htLeft'},{data:'Employee_No',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Position',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Work_Phone',className: 'htLeft'},{data:'Hand_Phone',className: 'htLeft'},{data:'Address',className: 'htLeft'},{data:'Office_Location',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(EMPLOY.' ORDER BY E.EmployeeID DESC',$field,array('Edit','Delete'),array(PATH_EMPLOY.EDIT,PATH_EMPLOY.DELETE),array());
			if (_VIEW_) $data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=4;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD EMPLOYEE DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_EMPLOY.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Upload Excel Employee</div>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'/file/employee.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> Excel Employee </td><td>:</td> </span></td><td>'.text_filebox(array('empex','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'/file/';
						$target_file = $target_dir.basename($_FILES['empex']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="alert alert-danger" align="center">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['empex']['size']>50000){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your files is too large</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 && $sizeupload==0){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['empex']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="alert alert-danger" align="center"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'employee');
								$content .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['empex']['name']).' has been uploaded</div>';
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR EMPLOYEE</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_EMPLOY.'">View</a></span> || <span><a href="'.PATH_EMPLOY.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_EMPLOY.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Employee</div>
								<table>
									<tr><td width="150"><span class="name"> Employee No </td><td>:</td> </span></td><td>'.text_je(array('empno','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> First Name </td><td>:</td> </span></td><td>'.text_je(array('finame','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Last Name </td><td>:</td> </span></td><td>'.text_je(array('laname','','false')).' </td></tr>
									<tr><td width="150"><span class="name"> Department. </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',250,'<option value=""> - </option>','')).' *</td></tr>
									<tr><td width="150"><span class="name"> Position. </td><td>:</td> </span></td><td>'.combo_je(array(COMPOSITI,'positi','positi',250,'<option value=""> - </option>','')).' *</td></tr>
									<tr><td width="150"><span class="name"> Work Phone</td><td>:</td> </span></td><td>'.text_je(array('wrpone','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Hand Phone</td><td>:</td> </span></td><td>'.text_je(array('hnpone','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Address </td><td>:</td> </span></td><td>'.text_je(array('addres','','true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td width="150"><span class="name"> Office Location </td><td>:</td> </span></td><td>'.text_je(array('ofloc','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['empno']) && !empty($_REQUEST['finame']) && !empty($_REQUEST['depdes'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/employ.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTEMPLOY,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $empid=get_new_code('EP',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO employee (EmployeeID, EmployeeNo, FirstName, LastName, Positions, DepartmentID, WorkPhone, HandPhone, Address, OfficeLocation) VALUES("'.$empid.'","'.$_REQUEST['empno'].'","'.$_REQUEST['finame'].'","'.$_REQUEST['laname'].'","'.$_REQUEST['positi'].'","'.$_REQUEST['depdes'].'","'.$_REQUEST['wrpone'].'","'.$_REQUEST['hnpone'].'","'.$_REQUEST['addres'].'","'.$_REQUEST['ofloc'].'")'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = EMPLOY.' AND EmployeeID="'.$empid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,150,150,150,150,250,150,150,150,150,150,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Employee ID','Employee No','First Name','Last Name','Position','Department Desc','Work Phone','Hand Phone','Address','Office Location'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Employee_ID',className: 'htLeft'},{data:'Employee_No',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Position',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Work_Phone',className: 'htLeft'},{data:'Hand_Phone',className: 'htLeft'},{data:'Address',className: 'htLeft'},{data:'Office_Location',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_EMPLOY.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){ 
					if(!empty($_REQUEST['empno']) && !empty($_REQUEST['finame']) && !empty($_REQUEST['depdes']) && !empty($_REQUEST['positi'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE employee SET EmployeeNo="'.$_REQUEST['empno'].'", FirstName="'.$_REQUEST['finame'].'", LastName="'.$_REQUEST['laname'].'", Positions="'.$_REQUEST['positi'].'", DepartmentID="'.$_REQUEST['depdes'].'", WorkPhone="'.$_REQUEST['wrpone'].'", HandPhone="'.$_REQUEST['hnpone'].'", Address="'.$_REQUEST['addres'].'", OfficeLocation="'.$_REQUEST['ofloc'].'" WHERE EmployeeID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1)); //echo $query;
						//-- Ambil data baru dari database --//
						$querydat = EMPLOY.' AND EmployeeID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,150,150,150,150,250,150,150,150,150,150,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Employee ID','Employee No','First Name','Last Name','Position','Department Desc','Work Phone','Hand Phone','Address','Office Location'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Employee_ID',className: 'htLeft'},{data:'Employee_No',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Position',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Work_Phone',className: 'htLeft'},{data:'Hand_Phone',className: 'htLeft'},{data:'Address',className: 'htLeft'},{data:'Office_Location',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_EMPLOY.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDEMPLOY.' WHERE E.EmployeeID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$empno=$resultnow[1]; $finame=$resultnow[2]; $laname=$resultnow[3]; $positi=$resultnow[4]; $depdes=$resultnow[5]; $wrpone=$resultnow[6]; $hnpone=$resultnow[7]; $addres=$resultnow[8]; $ofloc=$resultnow[9];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA EMPLOYEE FOR '.$empno.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_EMPLOY.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Employee</div>
								<table>
									<tr><td width="150"><span class="name"> Employee No </td><td>:</td> </span></td><td>'.text_je(array('empno',$empno,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> First Name </td><td>:</td> </span></td><td>'.text_je(array('finame',$finame,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Last Name </td><td>:</td> </span></td><td>'.text_je(array('laname',$laname,'false')).' </td></tr>
									<tr><td width="150"><span class="name"> Department. </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',250,'<option value=""> - </option>',$depdes)).' *</td></tr>
									<tr><td width="150"><span class="name"> Position. </td><td>:</td> </span></td><td>'.combo_je(array(COMPOSITI,'positi','positi',250,'<option value=""> - </option>',$positi)).' *</td></tr>
									<tr><td width="150"><span class="name"> Work Phone</td><td>:</td> </span></td><td>'.text_je(array('wrpone',$wrpone,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Hand Phone</td><td>:</td> </span></td><td>'.text_je(array('hnpone',$hnpone,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Address </td><td>:</td> </span></td><td>'.text_je(array('addres',$addres,'true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td width="150"><span class="name"> Office Location </td><td>:</td> </span></td><td>'.text_je(array('ofloc',$ofloc,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ DEPARTMENT ------------------
		else if(strcmp($_REQUEST['page'],'depart')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM department WHERE DepartmentID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">DEPARTEMENT</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,400,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(DEPART.' ORDER BY DepartmentID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(DEPART.' ORDER BY DepartmentID DESC');
			//-------set header pada handson------
			$sethead = "['Department ID','Departement Code','Departement Desc'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Department_ID',className: 'htLeft'},{data:'Department_No',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(DEPART.' ORDER BY DepartmentID DESC',$field,array('Edit','Delete'),array(PATH_DEPART.EDIT,PATH_DEPART.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR DEPARTMENT</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_DEPART.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Departement</div>
								<table>
									<tr><td width="150"><span class="name"> Departement Code </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="deptno" value=""></td></tr>
									<tr><td width="150"><span class="name"> Departement Desc. </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="depdes" value=""></td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['deptno']) && !empty($_REQUEST['depdes'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/depart.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTDEPART,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $deptid=get_new_code('DP',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO department (DepartmentID,DepartmentNo,DepartmentDesc) VALUES("'.$deptid.'","'.$_REQUEST['deptno'].'","'.$_REQUEST['depdes'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = DEPART.' WHERE DepartmentID="'.$deptid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Departement ID','Departement Code','Departement Desc'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Department_ID',className: 'htLeft'},{data:'Department_No',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_DEPART.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['deptno']) && !empty($_REQUEST['depdes'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE department SET DepartmentNo="'.$_REQUEST['deptno'].'", DepartmentDesc="'.$_REQUEST['depdes'].'" WHERE DepartmentID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = DEPART.' WHERE DepartmentID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Departement ID','Departement Code','Department Desc'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Department_ID',className: 'htLeft'},{data:'Department_No',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_DEPART.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = DEPART.' WHERE DepartmentID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$deptno=$resultnow[1]; $depdes=$resultnow[2];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA DEPARTMENT FOR '.$deptno.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_DEPART.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Departement</div>
								<table>
									<tr><td width="150"><span class="name"> Departement Code </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="deptno" value="'.$deptno.'"></td></tr>
									<tr><td width="150"><span class="name"> Departement Desc. </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="depdes" value="'.$depdes.'"></td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		
		//=======NEW PAGE=====================
		//------ LOCATION ------------------
		else if(strcmp($_REQUEST['page'],'locatn')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM location WHERE LocationId="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">PROCESS UNIT</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[110,150,200,200,250,120,120,120,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(LOCATN.' ORDER BY L.LocationId DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(LOCATN.' ORDER BY L.LocationId DESC');
			//-------set header pada handson------
			$sethead = "['Process Unit ID','Process Unit Name','Process Unit Description','Remark 1','Remark 2','Remark 3'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Location_ID',className: 'htLeft'},{data:'Location_No',className: 'htLeft'},{data:'Location_Description',className: 'htLeft'},{data:'District',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(LOCATN.' ORDER BY L.LocationId DESC',$field,array('Edit','Delete'),array(PATH_LOCATN.EDIT,PATH_LOCATN.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=3;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR PROCESS UNIT</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_LOCATN.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Process Unit</div>
								<table>
									<tr><td width="150"><span class="name"> Process Unit Name </td><td>:</td> </span></td><td>'.text_je(array('locno','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Process Unit Desc. </td><td>:</td> </span></td><td>'.text_je(array('locdes','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Department. </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',250,'<option value=""> - </option>','')).' *</td></tr>
									<tr><td width="150"><span class="name"> Location Information </td><td>:</td> </span></td><td>'.text_je(array('notetec','','true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td width="150"><span class="name"> Remark 1 </td><td>:</td> </span></td><td>'.text_je(array('district','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Remark 2 </td><td>:</td> </span></td><td>'.text_je(array('state','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Remark 3 </td><td>:</td> </span></td><td>'.text_je(array('country','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['locno']) && !empty($_REQUEST['locdes']) && !empty($_REQUEST['depdes'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/locatn.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTLOCATN,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $locid=get_new_code('LC',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO location (LocationId,LocationNo,LocationDescription,DepartmentID,NotetoTech,District,State,Country) VALUES("'.$locid.'","'.$_REQUEST['locno'].'","'.$_REQUEST['locdes'].'","'.$_REQUEST['depdes'].'","'.$_REQUEST['notetec'].'","'.$_REQUEST['district'].'","'.$_REQUEST['state'].'","'.$_REQUEST['country'].'")'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = LOCATN.' AND L.LocationId="'.$locid.'"';
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[110,110,200,200,250,120,120,120,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Process Unit ID','Process Unit Name','Process Unit Description','Department Desc','Process Unit Information','Remark 1','Remark 2','Remark 3'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Location_ID',className: 'htLeft'},{data:'Location_No',className: 'htLeft'},{data:'Location_Description',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Note_To_Tech',className: 'htLeft'},{data:'District',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_LOCATN.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['locno']) && !empty($_REQUEST['locdes']) && !empty($_REQUEST['depdes'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE location SET LocationNo="'.$_REQUEST['locno'].'", LocationDescription="'.$_REQUEST['locdes'].'", DepartmentID="'.$_REQUEST['depdes'].'", NotetoTech="'.$_REQUEST['notetec'].'", District="'.$_REQUEST['district'].'", State="'.$_REQUEST['state'].'", Country="'.$_REQUEST['country'].'" WHERE LocationId="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = LOCATN.' AND L.LocationId="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[110,110,200,200,250,120,120,120,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Process Unit ID','Process Unit Name','Process Unit Description','Department Desc','Process Unit Information','Remark 1','Remark 2','Remark 3'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Location_ID',className: 'htLeft'},{data:'Location_No',className: 'htLeft'},{data:'Location_Description',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Note_To_Tech',className: 'htLeft'},{data:'District',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_LOCATN.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDLOCATN.' WHERE L.LocationID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$locno=$resultnow[1]; $locdes=$resultnow[2]; $depdes=$resultnow[3]; $notetec=$resultnow[4]; $district=$resultnow[5]; $state=$resultnow[6]; $country=$resultnow[7]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA FOR PROCESS UNIT FOR '.$locno.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_LOCATN.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Process Unit</div>
								<table>
									<tr><td width="150"><span class="name"> Process Unit Name </td><td>:</td> </span></td><td>'.text_je(array('locno',$locno,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Process Unit Desc. </td><td>:</td> </span></td><td>'.text_je(array('locdes',$locdes,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Department. </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',250,'<option value=""> - </option>',$depdes)).' *</td></tr>
									<tr><td width="150"><span class="name"> Location Information </td><td>:</td> </span></td><td>'.text_je(array('notetec',$notetec,'true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td width="150"><span class="name"> Remark 1 </td><td>:</td> </span></td><td>'.text_je(array('district',$district,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Remark 2 </td><td>:</td> </span></td><td>'.text_je(array('state',$state,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Remark 3 </td><td>:</td> </span></td><td>'.text_je(array('country',$country,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ WORK PRIORITY --------------
		else if(strcmp($_REQUEST['page'],'supply')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM supplier WHERE Supplier_ID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">SUPPLIER</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,200,200,200,200,200,200,200,200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(SUPPLY.' ORDER BY Supplier_ID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(SUPPLY.' ORDER BY Supplier_ID DESC');
			//-------set header pada handson------
			$sethead = "['Supplier ID','Supplier No','Supplier Name','Designation','Address','Postal Code','City','State','Country','Telephone No','Fax No','Service'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Supplier_ID',className: 'htLeft'},{data:'Supplier_No',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Designation',className: 'htLeft'},{data:'Address',className: 'htLeft'},{data:'Postal_Code',className: 'htLeft'},{data:'City',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'},{data:'Telephone_No',className: 'htLeft'},{data:'Fax_No',className: 'htLeft'},{data:'Service',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(SUPPLY.' ORDER BY Supplier_ID DESC',$field,array('Edit','Delete'),array(PATH_SUPPLY.EDIT,PATH_SUPPLY.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=3;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR SUPPLIER</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_SUPPLY.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Supplier</div>
								<table>
									<tr><td width="150"><span class="name"> Supplier No </td><td>:</td> </span></td><td>'.text_je(array('spno','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Supplier Name </td><td>:</td> </span></td><td>'.text_je(array('ctnm','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Contact Name </td><td>:</td> </span></td><td>'.text_je(array('desig','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Address </td><td>:</td> </span></td><td>'.text_je(array('addres','','true','style="width:100%;height:80px"')).' *</td></tr>
									<tr><td width="150"><span class="name"> Postal Code </td><td>:</td> </span></td><td>'.text_je(array('poco','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> City </td><td>:</td> </span></td><td>'.text_je(array('city','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> State </td><td>:</td> </span></td><td>'.text_je(array('state','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Country </td><td>:</td> </span></td><td>'.text_je(array('counr','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Telephone No </td><td>:</td> </span></td><td>'.text_je(array('telp','','false')). ' *</td></tr>
									<tr><td width="150"><span class="name"> Email </td><td>:</td> </span></td><td>'.text_je(array('fax','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Services / Supply </td><td>:</td> </span></td><td>'.text_je(array('service','','true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['ctnm']) && !empty($_REQUEST['spno']) && !empty($_REQUEST['addres']) && !empty($_REQUEST['telp']) && !empty($_REQUEST['city'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/supply.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTSUPPLY,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $spid=get_new_code('SP',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO supplier (Supplier_ID, SupplierNo, SupplierName, Designation, Address, PostalCode, City, State, Country, TelpNo , FaxNumber, Service) VALUES("'.$spid.'","'.$_REQUEST['spno'].'","'.$_REQUEST['ctnm'].'","'.$_REQUEST['desig'].'","'.$_REQUEST['addres'].'","'.$_REQUEST['poco'].'","'.$_REQUEST['city'].'","'.$_REQUEST['state'].'","'.$_REQUEST['counr'].'","'.$_REQUEST['telp'].'","'.$_REQUEST['fax'].'","'.$_REQUEST['service'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = SUPPLY.' WHERE Supplier_ID="'.$spid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Supplier ID','Supplier No','Supplier Name','Designation','Address','Postal Code','City','State','Country','Telephone No','Fax No','Service'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Supplier_ID',className: 'htLeft'},{data:'Supplier_No',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Designation',className: 'htLeft'},{data:'Address',className: 'htLeft'},{data:'Postal_Code',className: 'htLeft'},{data:'City',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'},{data:'Telephone_No',className: 'htLeft'},{data:'Fax_No',className: 'htLeft'},{data:'Service',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_SUPPLY.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}			
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['ctnm']) && !empty($_REQUEST['spno']) && !empty($_REQUEST['addres']) && !empty($_REQUEST['telp']) && !empty($_REQUEST['city'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE supplier SET SupplierNo="'.$_REQUEST['spno'].'", SupplierName="'.$_REQUEST['ctnm'].'", Designation="'.$_REQUEST['desig'].'", Address="'.$_REQUEST['addres'].'", PostalCode="'.$_REQUEST['poco'].'", City="'.$_REQUEST['city'].'", State="'.$_REQUEST['state'].'", Country="'.$_REQUEST['counr'].'", TelpNo="'.$_REQUEST['telp'].'", FaxNumber="'.$_REQUEST['fax'].'", Service="'.$_REQUEST['service'].'" WHERE Supplier_ID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = SUPPLY.' WHERE Supplier_ID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Supplier ID','Supplier No','Supplier Name','Designation','Address','Postal Code','City','State','Country','Telephone No','Fax No','Service'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Supplier_ID',className: 'htLeft'},{data:'Supplier_No',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Designation',className: 'htLeft'},{data:'Address',className: 'htLeft'},{data:'Postal_Code',className: 'htLeft'},{data:'City',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'},{data:'Telephone_No',className: 'htLeft'},{data:'Fax_No',className: 'htLeft'},{data:'Service',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_SUPPLY.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = SUPPLY.' WHERE Supplier_ID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$spno=$resultnow[1]; $ctnm=$resultnow[2]; $desig=$resultnow[3]; $addres=$resultnow[4]; $poco=$resultnow[5]; $city=$resultnow[6]; $stae=$resultnow[7]; $counr=$resultnow[8]; $telp=$resultnow[9]; $fax=$resultnow[10]; $service=$resultnow[11]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA SUPPLIER FOR '.$spno.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_SUPPLY.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Supplier</div>
								<table>
									<tr><td width="150"><span class="name"> Supplier No </td><td>:</td> </span></td><td>'.text_je(array('spno',$spno,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Contact Name </td><td>:</td> </span></td><td>'.text_je(array('ctnm',$ctnm,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Supplier Name </td><td>:</td> </span></td><td>'.text_je(array('desig',$desig,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Address </td><td>:</td> </span></td><td>'.text_je(array('addres',$addres,'true','style="width:100%;height:80px"')).' *</td></tr>
									<tr><td width="150"><span class="name"> Postal Code </td><td>:</td> </span></td><td>'.text_je(array('poco',$poco,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> City </td><td>:</td> </span></td><td>'.text_je(array('city',$city,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> State </td><td>:</td> </span></td><td>'.text_je(array('state',$state,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Country </td><td>:</td> </span></td><td>'.text_je(array('counr',$counr,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Telephone No </td><td>:</td> </span></td><td>'.text_je(array('telp',$telp,'false')). ' *</td></tr>
									<tr><td width="150"><span class="name"> Email </td><td>:</td> </span></td><td>'.text_je(array('fax',$fax,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Services / Supply </td><td>:</td> </span></td><td>'.text_je(array('service',$service,'true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		
		//============Halaman MENU MISC Untuk CMSIF============= 
		//=======NEW PAGE=====================
		//------ WORK PRIORITY --------------
		else if(strcmp($_REQUEST['page'],'priory')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM work_priority WHERE WorkPriorityID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
		
			$content = '<br/><div class="ade">WORK PRIORITY</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(PRIORY.' ORDER BY WorkPriorityID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(PRIORY.' ORDER BY WorkPriorityID DESC');
			//-------set header pada handson------
			$sethead = "['Work Priority ID','Work Priority'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Priority_ID',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(PRIORY.' ORDER BY WorkPriorityID DESC',$field,array('Edit','Delete'),array(PATH_PRIORY.EDIT,PATH_PRIORY.DELETE),array());
			if (_VIEW_) $data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR WORK PRIORITY</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_PRIORY.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Priority</div>
								<table>
									<tr><td width="150"><span class="name"> Work Priority </td><td>:</td> </span></td><td>'.text_je(array('priory','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['priory'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/priory.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTPRIORY,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $wpid=get_new_code('WP',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO work_priority (WorkPriorityID ,WorkPriority) VALUES("'.$wpid.'","'.$_REQUEST['priory'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = PRIORY.' WHERE WorkPriorityID="'.$wpid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Priority ID','Work Priority'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Priority_ID',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PRIORY.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['priory'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE work_priority SET WorkPriority="'.$_REQUEST['priory'].'" WHERE WorkPriorityID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = PRIORY.' WHERE WorkPriorityID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Priority ID','Work Priority'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Priority_ID',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PRIORY.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = PRIORY.' WHERE WorkPriorityID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$priory=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK PRIORITY FOR '.$priory.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_PRIORY.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Priority</div>
								<table>
									<tr><td width="150"><span class="name"> Work Priority </td><td>:</td> </span></td><td>'.text_je(array('priory',$priory,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
			
		}
		//=======NEW PAGE=====================
		//------ WORK STATUS --------------
		else if(strcmp($_REQUEST['page'],'wstate')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM work_status WHERE WorkStatusID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
		
			$content = '<br/><div class="ade">WORK STATUS</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WSTATE.' ORDER BY WorkStatusID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WSTATE.' ORDER BY WorkStatusID DESC');
			//-------set header pada handson------
			$sethead = "['Work Status ID','Work Status','Group User'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Status_ID',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Name_group',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(WSTATE.' ORDER BY WorkStatusID DESC',$field,array('Edit','Delete'),array(PATH_WSTATE.EDIT,PATH_WSTATE.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$query_group = 'SELECT id_group,group_name FROM tb_user_group';
				$content = '<br/><div class="ade">ADD DATA FOR WARRANTY CONTRACT</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WSTATE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Status</div>
								<table>
									<tr><td width="150"><span class="name"> Work Status </td><td>:</td> </span></td><td>'.text_je(array('wstate','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Group Name </td><td>:</td> </span></td><td>'.combo_je(array($query_group,'group','group',225,'<option value="">-</option>','')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wstate'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/wstate.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWSTATE,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $wsid=get_new_code('WS',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO work_status (WorkStatusID ,WorkStatus,id_group) VALUES("'.$wsid.'","'.$_REQUEST['wstate'].'","'.$_REQUEST['group'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WSTATE.' AND WorkStatusID="'.$wsid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Status ID','Work Status','Group User'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Status_ID',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Name_group',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WSTATE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wstate'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE work_status SET WorkStatus="'.$_REQUEST['wstate'].'",id_group="'.$_REQUEST['group'].'" WHERE WorkStatusID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = WSTATE.' AND WorkStatusID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Status ID','Work Status','Group User'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Status_ID',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Name_group',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WSTATE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$query_group = 'SELECT id_group,group_name FROM tb_user_group';
				$querydat = WSTATE.' AND WorkStatusID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); 
				$resultnow=mysql_exe_fetch_array(array($result,1));
				$wstate=$resultnow[1]; 
				$group=$resultnow[3]; 
				/*print_r($resultnow);*/
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK STATUS FOR '.$wstate.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WSTATE.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Status</div>
								<table>
									<tr><td width="150"><span class="name"> Work Status </td><td>:</td> </span></td><td>'.text_je(array('wstate',$wstate,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Work Status </td><td>:</td> </span></td><td>'.combo_je(array($query_group,'group','group',225,'<option value="">-</option>',$group)).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ WARRANTY --------------
		else if(strcmp($_REQUEST['page'],'wrtype')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM work_type WHERE WorkTypeID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">WORK TYPE</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WRTYPE.' ORDER BY WorkTypeID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WRTYPE.' ORDER BY WorkTypeID DESC');
			//-------set header pada handson------
			$sethead = "['Work Type ID','Work Type'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Type_ID',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(WRTYPE.' ORDER BY WorkTypeID DESC',$field,array('Edit','Delete'),array(PATH_WRTYPE.EDIT,PATH_WRTYPE.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR WORK TYPE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WRTYPE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Type</div>
								<table>
									<tr><td width="150"><span class="name"> Work Type </td><td>:</td> </span></td><td>'.text_je(array('wrtype','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wrtype'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/wrtype.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWRTYPE,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $wtid=get_new_code('WT',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO work_type (WorkTypeID ,WorkTypeDesc) VALUES("'.$wtid.'","'.$_REQUEST['wrtype'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WRTYPE.' AND WorkTypeID="'.$wtid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Type ID','Work Type'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Type_ID',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WRTYPE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';	
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wrtype'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE work_type SET WorkTypeDesc="'.$_REQUEST['wrtype'].'" WHERE WorkTypeID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = WRTYPE.' AND WorkTypeID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Type ID','Work Type'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Type_ID',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WRTYPE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = WRTYPE.' AND WorkTypeID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wrtype=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK TYPE FOR '.$wrtype.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WRTYPE.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Type</div>
								<table>
									<tr><td width="150"><span class="name"> Warranty </td><td>:</td> </span></td><td>'.text_je(array('wrtype',$wrtype,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ WARRANTY --------------
		else if(strcmp($_REQUEST['page'],'warran')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM warranty_contract WHERE WarrantyID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">WARRANTY CONTRACT</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WARRAN.' ORDER BY WarrantyID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WARRAN.' ORDER BY WarrantyID DESC');
			//-------set header pada handson------
			$sethead = "['Warranty ID','Warranty'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Warranty_ID',className: 'htLeft'},{data:'Warranty',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(WARRAN.' ORDER BY WarrantyID DESC',$field,array('Edit','Delete'),array(PATH_WARRAN.EDIT,PATH_WARRAN.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR WARRANTY CONTRACT</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WARRAN.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Warranty Contract</div>
								<table>
									<tr><td width="150"><span class="name"> Warranty </td><td>:</td> </span></td><td>'.text_je(array('warran','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['warran'])){					
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/warran.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWARRAN,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $asstid=get_new_code('WR',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO warranty_contract (WarrantyID ,Warranty) VALUES("'.$asstid.'","'.$_REQUEST['warran'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WARRAN.' WHERE WarrantyID="'.$asstid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Warranty ID','Warranty'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Warranty_ID',className: 'htLeft'},{data:'Warranty',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WARRAN.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['warran'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE warranty_contract SET Warranty="'.$_REQUEST['warran'].'" WHERE WarrantyID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = WARRAN.' WHERE WarrantyID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Warranty ID','Warranty'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Warranty_ID',className: 'htLeft'},{data:'Warranty',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WARRAN.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = WARRAN.' WHERE WarrantyID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$warran=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WARRANTY CONTRACT FOR '.$warran.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WARRAN.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Warranty Contract</div>
								<table>
									<tr><td width="150"><span class="name"> Warranty </td><td>:</td> </span></td><td>'.text_je(array('warran',$warran,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		
		//=======NEW PAGE=====================
		//------ ASSET STATUS --------------
		else if(strcmp($_REQUEST['page'],'asstat')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM asset_status WHERE AssetStatusID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">ASSET STATUS</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(ASSTAT.' ORDER BY AssetStatusID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(ASSTAT.' ORDER BY AssetStatusID DESC');
			//-------set header pada handson------
			$sethead = "['Asset Status ID','Asset Status Desc'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Asset_Status_ID',className: 'htLeft'},{data:'Asset_Status_Desc',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(ASSTAT.' ORDER BY AssetStatusID DESC',$field,array('Edit','Delete'),array(PATH_ASSTAT.EDIT,PATH_ASSTAT.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR ASSET STATUS</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSTAT.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset Status</div>
								<table>
									<tr><td width="150"><span class="name"> Asset Status </td><td>:</td> </span></td><td>'.text_je(array('asstat','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['asstat'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/asstat.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTASSTAT,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $asstid=get_new_code('AK',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO asset_status (AssetStatusID ,AssetStatusDesc) VALUES("'.$asstid.'","'.$_REQUEST['asstat'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = ASSTAT.' AND AssetStatusID="'.$asstid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Asset Status ID','Asset Status Desc'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Asset_Status_ID',className: 'htLeft'},{data:'Asset_Status_Desc',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSTAT.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['asstat'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE asset_status SET AssetStatusDesc="'.$_REQUEST['asstat'].'" WHERE AssetStatusID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = ASSTAT.' AND AssetStatusID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Asset Status ID','Asset Status Desc'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Asset_Status_ID',className: 'htLeft'},{data:'Asset_Status_Desc',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSTAT.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = ASSTAT.' AND AssetStatusID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$asstat=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA ASSET STATUS FOR '.$asstat.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSTAT.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset Status</div>
								<table>
									<tr><td width="150"><span class="name"> Asset Status </td><td>:</td> </span></td><td>'.text_je(array('asstat',$asstat,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ ASSET CRITICALLY --------------
		else if(strcmp($_REQUEST['page'],'wtrade')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM work_trade WHERE WorkTradeID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">SECTION</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WTRADE.' ORDER BY WorkTradeID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WTRADE.' ORDER BY WorkTradeID DESC');
			//-------set header pada handson------
			$sethead = "['Section ID','Section'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Trade_ID',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(WTRADE.' ORDER BY WorkTradeID DESC',$field,array('Edit','Delete'),array(PATH_WTRADE.EDIT,PATH_WTRADE.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR SECTION</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_WTRADE.'">View</a></span> || <span><a href="'.PATH_WTRADE.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WTRADE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Section</div>
								<table>
									<tr><td width="150"><span class="name"> Section </td><td>:</td> </span></td><td>'.text_je(array('wtrade','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wtrade'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/wtrade.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWTRADE,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $wrid=get_new_code('WR',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO work_trade (WorkTradeID ,WorkTrade) VALUES("'.$wrid.'","'.$_REQUEST['wtrade'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WTRADE.' WHERE WorkTradeID="'.$wrid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Section ID','Section'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Trade_ID',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WTRADE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wtrade'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE work_trade SET WorkTrade="'.$_REQUEST['wtrade'].'" WHERE WorkTradeID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = WTRADE.' WHERE WorkTradeID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Trade ID','Work Trade'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Trade_ID',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WTRADE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = WTRADE.' WHERE WorkTradeID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wtrade=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA SECTION FOR '.$wtrade.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WTRADE.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Section</div>
								<table>
									<tr><td width="150"><span class="name"> Section </td><td>:</td> </span></td><td>'.text_je(array('wtrade',$wtrade,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		//=======NEW PAGE=====================
		//------ ASSET CRITICALLY --------------
		else if(strcmp($_REQUEST['page'],'critic')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM critically WHERE CriticalID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">ASSET CRITICALLY</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(CRITIC.' ORDER BY CriticalID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(CRITIC.' ORDER BY CriticalID DESC');
			//-------set header pada handson------
			$sethead = "['Critical ID','Criticality'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Critical_ID',className: 'htLeft'},{data:'Criticality',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(CRITIC.' ORDER BY CriticalID DESC',$field,array('Edit','Delete'),array(PATH_CRITIC.EDIT,PATH_CRITIC.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR ASSET CRITICALLY</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_CRITIC.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Criticality</div>
								<table>
									<tr><td width="150"><span class="name"> Criticality </td><td>:</td> </span></td><td>'.text_je(array('critic','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['critic'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/critic.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTCRITIC,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $asstid=get_new_code('CR',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO critically (CriticalID ,Criticaly) VALUES("'.$asstid.'","'.$_REQUEST['critic'].'")'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = CRITIC.' WHERE CriticalID="'.$asstid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Critical ID','Criticality'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Critical_ID',className: 'htLeft'},{data:'Criticality',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_CRITIC.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['critic'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE critically SET Criticaly="'.$_REQUEST['critic'].'" WHERE CriticalID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = CRITIC.' WHERE CriticalID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Critical ID','Criticality'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Critical_ID',className: 'htLeft'},{data:'Criticality',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_CRITIC.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = CRITIC.' WHERE CriticalID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$critic=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA ASSET CRITICALLY FOR '.$critic.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_CRITIC.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset Status</div>
								<table>
									<tr><td width="150"><span class="name"> Criticality </td><td>:</td> </span></td><td>'.text_je(array('critic',$critic,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		
		//=======NEW PAGE=====================
		//------ POSITION --------------
		else if(strcmp($_REQUEST['page'],'positi')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM position WHERE PositionID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">POSITION EMPLOYEE</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,250,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(POSITI.' ORDER BY PositionID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(POSITI.' ORDER BY PositionID DESC');
			//-------set header pada handson------
			$sethead = "['Position ID','Position Code','Position Name'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Position_ID',className: 'htLeft'},{data:'Position_Code',className: 'htLeft'},{data:'Position_Name',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(POSITI.' ORDER BY PositionID DESC',$field,array('Edit','Delete'),array(PATH_POSITI.EDIT,PATH_POSITI.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR POSITION EMPLOYEE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_POSITI.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Position Employee</div>
								<table>
									<tr><td width="150"><span class="name"> Position Code </td><td>:</td> </span></td><td>'.text_je(array('poscode','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Position Name </td><td>:</td> </span></td><td>'.text_je(array('posname','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['poscode']) && !empty($_REQUEST['posname'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/positi.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(COUNTPOSITI,1); $resultnow=mysql_exe_fetch_array($result,1); $numrow=$resultnow[0]+1; $posid=get_new_code('PS',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO position (PositionID ,PositionCode, PositionName) VALUES("'.$posid.'","'.$_REQUEST['poscode'].'","'.$_REQUEST['posname'].'")'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = POSITI.' WHERE PositionID="'.$posid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,250,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Position ID','Position Code','Position Name'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Position_ID',className: 'htLeft'},{data:'Position_Code',className: 'htLeft'},{data:'Position_Name',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_POSITI.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['poscode']) && !empty($_REQUEST['posname'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE position SET PositionCode="'.$_REQUEST['poscode'].'", PositionName="'.$_REQUEST['posname'].'" WHERE PositionID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = POSITI.' WHERE PositionID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,250,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Position ID','Position Code','Position Name'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Position_ID',className: 'htLeft'},{data:'Position_Code',className: 'htLeft'},{data:'Position_Name',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_POSITI.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = POSITI.' WHERE PositionID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$poscode=$resultnow[1]; $posname=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA EMPLOYEE POSITION FOR '.$poscode.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_POSITI.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Employee Position</div>
								<table>
									<tr><td width="150"><span class="name"> Position Code </td><td>:</td> </span></td><td>'.text_je(array('poscode',$poscode,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Position Name </td><td>:</td> </span></td><td>'.text_je(array('posname',$posname,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
	}else{
		$content = logout();
	}
		
		return $content;
	}
	
	//-------Fungsi untuk mendapatkan waktu terakhir mengenerate data AR -------
	function get_gendatetime(){
		$query = 'SELECT gen_datetime FROM ar_gendatetime';
		$result = mysql_exe_query(array($query,1));
		$result_now = mysql_exe_fetch_array(array($result,1));
		$content = '<div class="title" align="right"><i>Last Update Data : '.$result_now[0].'</i></div>';
		return $content;
	}
	
	//------Fungsi generate data ke excel -------------------------------------
	function gen_data_excel($data){
		$sql = $data[0];
		$page = $data[1];
		$content = ''; 
		$result = mysql_exe_query(array($sql,1)) or die ('FAILED TO EXPORT EXCEL'); 
		error_reporting(E_ALL);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("TPC INDO PLASTIC AND CHEMICALS")
							 ->setLastModifiedBy("TPC INDO PLASTIC AND CHEMICALS")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("document for Office 2007 XLSX, generated using PHP.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("TPC INDO PLASTIC AND CHEMICALS");
		
		if(strcmp($page,'summarydes')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINATION');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CUST ACC');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'CUSTOMER');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CURR');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'CREDIT TERM');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'COFACE');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'INTERNAL CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'OVER IN CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'TOTAL CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'OVER CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'TOTAL AR');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'CURRENT');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'DAYS 1 TO 7');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'DAYS 8 TO 15');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'DAYS 16 TO 30');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'DAYS 31 TO 60');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'DAYS 61 TO 90');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'DAYS 90 TO 120');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'DAYS 121 TO 150');
			$objPHPExcel->getActiveSheet()->setCellValue('T1', 'DAYS OVER 150');
			
			$i=2;
			$j=1;
			while($result_now= mysql_exe_fetch_array(array($result,1))){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $result_now[0]);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $result_now[1]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $result_now[2]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $result_now[3]);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result_now[4]);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $result_now[5]);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $result_now[6]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[7]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result_now[8]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $result_now[9]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $result_now[10]);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $result_now[11]);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result_now[12]);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $result_now[13]);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $result_now[14]);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $result_now[15]);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $result_now[16]);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $result_now[17]);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $result_now[18]);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $result_now[19]);
				$i++; $j++;
			}
		}else if(strcmp($page,'summary')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'CUST ACC');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CUSTOMER');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'AR INCL VAT USD EQ');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CURRENT');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'DAYS 1 TO 7');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'DAYS 8 TO 15');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'DAYS 16 TO 30');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'DAYS 31 TO 60');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'DAYS 61 TO 90');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'DAYS 90 TO 120');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'DAYS 121 TO 150');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'DAYS OVER 150');
			
			$i=2;
			$j=1;
			while($result_now= mysql_exe_fetch_array(array($result,1))){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $result_now[0]);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $result_now[1]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $result_now[2]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $result_now[3]);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result_now[4]);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $result_now[5]);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $result_now[6]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[7]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result_now[8]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $result_now[9]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $result_now[10]);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result_now[11]);
				$i++; $j++;
			}
		}else if(strcmp($page,'detail')==0 || strcmp($page,'detailidr')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'MARKET');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CUST ACC');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'CUSTOMER');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'INV DATE');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'DUE DATE');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'TAX FX');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'INVOICE NO');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'CURR');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'AR INCL VAT');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'AR EXCL VAT');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'VAT USD');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'VAT IDR EQUIVALENT');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'DAYS OVERDUE');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'NO OF DAYS');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'AR INCL VAT USD EQ');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'CURRENT');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'DAYS 1 TO 7');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'DAYS 8 TO 15');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'DAYS 16 TO 30');
			$objPHPExcel->getActiveSheet()->setCellValue('T1', 'DAYS 31 TO 60');
			$objPHPExcel->getActiveSheet()->setCellValue('U1', 'DAYS 61 TO 90');
			$objPHPExcel->getActiveSheet()->setCellValue('V1', 'DAYS 90 TO 120');
			$objPHPExcel->getActiveSheet()->setCellValue('W1', 'DAYS 121 TO 150');
			$objPHPExcel->getActiveSheet()->setCellValue('X1', 'DAYS OVER 150');
			
			
			$i=2;
			$j=1;
			while($result_now= mysql_exe_fetch_array(array($result,1))){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $result_now[0]);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $result_now[1]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $result_now[2]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $result_now[3]);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result_now[4]);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $result_now[5]);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $result_now[6]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[7]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result_now[8]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $result_now[9]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $result_now[10]);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $result_now[11]);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result_now[12]);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $result_now[13]);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $result_now[14]);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $result_now[15]);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $result_now[16]);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $result_now[17]);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $result_now[18]);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $result_now[19]);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $result_now[20]);
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $result_now[21]);
				$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $result_now[22]);
				$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $result_now[23]);
				$i++; $j++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('AR REPORT');	
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.'Ar_Report.xlsx'));
		
		return $content;
	}
	
	//================Halaman print ==================
	function get_print($variable){
		$doc = $variable[0]; 
		if($doc=='workderdoc'){
			$title = '<br/><div class="ade">WORK ORDER FOR '.$_REQUEST['wo'].'</div>';
			$wonumber = $variable[1];
			$query = 'SELECT WO.StepofWork, WO.TotalExpense, WO.ProblemDesc Problem_Desc, WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WO.WorkOrderNo="'.$wonumber.'"';
			$result = mysql_exe_query(array($query,1));
			$resultnow=mysql_exe_fetch_array(array($result,1));
			
			//--------spare part ---------
			$sparepart = '';
			$qspare = QSPAREPART.' AND WO.WorkOrderNo="'.$wonumber.'"';
			$rspare = mysql_exe_query(array($qspare,1));
			while($rnspare=mysql_exe_fetch_array(array($rspare,1))){$sparepart .= $rnspare[1].', ';} $sparepart=substr($sparepart,0,-2);
			//--------Man Power ----------
			$manpow='';
			$qman = QMANPOWER.' AND WO.WorkOrderNo="'.$wonumber.'"';
			$rman = mysql_exe_query(array($qman,1));
			while($rnman=mysql_exe_fetch_array(array($rman,1))){$manpow .= $rnman[2].', ';} $manpow=substr($manpow,0,-2);
			$content .= '
					<div id="box">
					<main id="center">
					'.$title.'
					<table class="printtable">
						<thead>
						  <tr>
							<th width="200px">Info</th>
							<th width="600px">Description</th>
						  </tr>
						</thead>
						<tbody>
						  <tr>
							<td>Image</td>
							<td><img src="'.$resultnow['ImagePath'].'" class="popup__media popup__media_left" alt="Image of Asset"></td>
						  </tr>
						  <tr>
							<td>Problem Description</td>
							<td>'.$resultnow[2].'</td>
						  </tr>
						  <tr>
							<td>Work Type</td>
							<td>'.$resultnow['Work_Type'].'</td>
						  </tr>
						  <tr>
							<td>Work Status</td>
							<td>'.$resultnow['Work_Status'].'</td>
						  </tr>
						  <tr>
							<td>Work Priority</td>
							<td>'.$resultnow['Work_Priority'].'</td>
						  </tr>
						  <tr>
							<td>Work Trade</td>
							<td>'.$resultnow['Work_Trade'].'</td>
						  </tr>
						  <tr>
							<td>Receive Date</td>
							<td>'.$resultnow['Receive_Date'].'</td>
						  </tr>
						  <tr>
							<td>Require Date</td>
							<td>'.$resultnow['Required_Date'].'</td>
						  </tr>
						  <tr>
							<td>Estimated Date Start</td>
							<td>'.$resultnow['Estimated_Date_Start'].'</td>
						  </tr>
						  <tr>
							<td>Estimated Date End</td>
							<td>'.$resultnow['Estimated_Date_End'].'</td>
						  </tr>
						  <tr>
							<td>Step of Work</td>
							<td>'.$resultnow[0].'</td>
						  </tr>
						  <tr>
							<td>Total Expense</td>
							<td>'.number_format($resultnow[1],2,',','.').'</td>
						  </tr>
						  <tr>
							<td>Spare Part</td>
							<td>'.$sparepart.'</td>
						  </tr>
						  <tr>
							<td>Man Power</td>
							<td>'.$manpow.'</td>
						  </tr>
						</tbody>
					  </table>
					  </main>
					</div>
				';
		}
		return $content;
	}
	
	echo "<script>
	function printContent(el,titleName){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
		document.title=titleName;
		window.print();
		document.body.innerHTML = restorepage;
	}
	</script>";
	
	function pop_up($data){ 
		$content = '';
		$definepage = $data[0];
		$page = $data[1].'&dataid='.$_REQUEST['dataid'].'#popup-article';
		
		if(strcmp($definepage,'assets')==0 && isset($_REQUEST['dataid'])){	

			//--------------Insert Path QRCODE ke database----------------------------------
			if(ISSET($_REQUEST['qrcode'])){
				$field = array(
					'QRPath');
				$value = array(
						'"'.$_REQUEST['qrcode'].'"'); 
				$query = mysql_stat_update(array('asset',$field,$value,'AssetID="'.$_REQUEST['dataid'].'"')); 
				mysql_exe_query(array($query,1));
			}

			$query = ASSETS.' AND  A.AssetID="'.$_REQUEST['dataid'].'"'; $result=mysql_exe_query(array($query,1)); 
			$result_now=mysql_exe_fetch_array(array($result,1)); 
			
			//--------------Generate QR CODE------------------------------------------------
			if(empty($result_now[20])){
				$target_dir = _ROOT_.'file/qrcode/';
				$qrcodeFilePath = $target_dir.md5($_REQUEST['dataid']).'.png';
				QRcode::png($_REQUEST['dataid'], $qrcodeFilePath,QR_ECLEVEL_L, 4);   
				//$page = PATH_ASSETS.'&dataid='.$_REQUEST['dataid'].'#popup-article';
				$form .= '
					<div style="width:300px;">
						<form action="'.$page.'" method="post" enctype="multipart/form-data">
							<input type="hidden" name="qrcode" value="'.$qrcodeFilePath.'"
							<p><input class="form-submit" type="submit" value="Get QR Code"></p>
						</form>
					</div>
				';	
			}else{
				$form = '';
			}
			
			$form .= '<button class="form-submit" onclick="printContent(\'print_me\',\''.$result_now[0].'\')">Print this page</button>';
			//------------------------------------------------------------------------------
			
			$nav = '
					<input type="hidden" id="asset_id" value="'.$_REQUEST['dataid'].'">
					<ul class="list-group list-group-horizontal">
					  <li class="list-group-item"><button id="info" type="button" class="btn btn-success btn-lg">Info</button></li>
					  <li class="list-group-item"><button id="pm" type="button" class="btn btn-success btn-lg">PM</button></li>
					  <li class="list-group-item"><button id="wo" type="button" class="btn btn-success btn-lg">WO</button></li>
					  <li class="list-group-item"><button id="part" type="button" class="btn btn-success btn-lg">Part</button></li>
					  <li class="list-group-item"><button id="report" type="button" class="btn btn-success btn-lg">Report</button></li>
					</ul>
			';
			
			$content = '	
				<div id="popup-article" class="popup">
				  <div class="popup__block">
					'.$nav.'
					<div id="info_detail">
						<h1 class="popup__title">'.$result_now[2].'</h1>
						'.$form.'
						<div id="print_me">
							<img src="'.$result_now[19].'" class="popup__media popup__media_right" alt="No Image of Asset" style="max-width:300px;max-height:300px;">
							<img src="'.$result_now[20].'" class="popup__media popup__media_right" alt="No QR Code of Asset" style="max-width:300px;max-height:300px;">
							<table class="text-popup">
							<tr height="30"><td>Asset Number</td><td> : </td><td>'.$result_now[0].'</td></tr>
							<tr height="30"><td>Location </td><td> : </td><td>'.$result_now[3].'</td>
							<tr height="30"><td>Department </td><td> : </td><td>'.$result_now[4].'</td>
							<tr height="30"><td>Asset Category </td><td> : </td><td>'.$result_now[5].'</td>
							<tr height="30"><td>Asset Status <td> : </td><td>'.$result_now[6].'</td>
							<tr height="30"><td>Criticaly </td><td> : </td><td>'.$result_now[7].'</td>
							<tr height="30"><td>Supplier Name </td><td> : </td><td>'.$result_now[9].'</td>
							<tr height="30"><td>Manufacturer </td><td> : </td><td>'.$result_now[10].'</td>
							<tr height="30"><td>Model Number </td><td> : </td><td>'.$result_now[11].'</td>
							<tr height="30"><td>Serial Number </td><td> : </td><td>'.$result_now[12].'</td>
							<tr height="30"><td>Warranty </td><td>: </td><td>'.$result_now[13].'</td>
							<tr height="30"><td>Warranty Date </td><td> : </td><td>'.$result_now[15].'</td>
							<tr height="30"><td>Warranty Acquired </td><td> : </td><td>'.$result_now[17].'</td>
							<tr height="30"><td>Warranty Note </td><td> : </td><td>'.$result_now[14].'</td>
							<tr height="30"><td>Asset Note </td><td> : </td><td>'.$result_now[16].'</td>
							</table>
						</div>
					</div>
					
					<div id="info_pm">'.pop_detail_pm().'</div>
					<div id="info_wo">'.pop_detail_wo().'</div>
					<div id="info_part">'.pop_detail_part().'</div>
					<div id="info_report">'.pop_detail_report().'</div>
					
					<a href="#" class="popup__close">close</a>
				  </div>
				</div>
				';
		}
		
		else if((strcmp($definepage,'worder')==0 || strcmp($definepage,'pmlist')==0) && isset($_REQUEST['dataid'])){

			//--------------Insert Path QRCODE ke database----------------------------------
			if(ISSET($_REQUEST['qrcode'])){
				$field = array(
					'QRPath');
				$value = array(
						'"'.$_REQUEST['qrcode'].'"'); 
				$query = mysql_stat_update(array('work_order',$field,$value,'WorkOrderNo="'.$_REQUEST['dataid'].'"')); 
				mysql_exe_query(array($query,1));
			}
			
			//--------------Update state WO di database--------------------------------------
			if(ISSET($_REQUEST['state'])){
				$date_mod = date('Y-m-d');
				$state = $_REQUEST['state'];
				$field = array(
						'WorkStatusID',
						'State_modified_date',
						'Modified_By');
				$value = array(
						'"'.$_REQUEST['state'].'"',
						'"'.$date_mod.'"',
						'"'.$_SESSION['user'].'"'); 
				$query = mysql_stat_update(array('work_order',$field,$value,'WorkOrderNo="'.$_REQUEST['dataid'].'"')); 
				mysql_exe_query(array($query,1));
			}
			
			$query = WORDER.' AND  WO.WorkOrderNo="'.$_REQUEST['dataid'].'"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1));
			$edquery = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['dataid'].'"'; $edresult=mysql_exe_query(array($edquery,1)); $edresult_now=mysql_exe_fetch_array(array($edresult,1));
			/*if(strcmp($definepage,'worder')==0){
				$page = PATH_WORDER.'&dataid='.$_REQUEST['dataid'].'#popup-article';
			}else if(strcmp($definepage,'pmlist')==0){
				$page = PATH_PMLIST.'&dataid='.$_REQUEST['dataid'].'#popup-article';
			}*/
			
			//--------------Generate QR CODE------------------------------------------------
			if(empty($result_now[22])){
				$target_dir = _ROOT_.'file/qrcode/';
				$qrcodeFilePath = $target_dir.md5($_REQUEST['dataid']).'.png';
				QRcode::png($_REQUEST['dataid'], $qrcodeFilePath,QR_ECLEVEL_L, 4);   
				//$page = PATH_WORDER.'&dataid='.$_REQUEST['dataid'].'#popup-article';
				$qrform .= '
					<div style="width:300px;">
						<form action="'.$page.'" method="post" enctype="multipart/form-data">
							<input type="hidden" name="qrcode" value="'.$qrcodeFilePath.'"
							<p><input class="form-submit" type="submit" value="Get QR Code"></p>
						</form>
					</div>
				';	
			}else{
				$qrform = '';
			}
			//------------------------------------------------------------------------------
			$qrform .= '<button class="form-submit" onclick="printContent(\'print_me\',\''.$result_now[0].'\')">Print this page</button>';
			$content = '	
				<div id="popup-article" class="popup">
				  <div class="popup__block">
					<h1 class="popup__title">'.$result_now[0].'</h1>'.$qrform.'
					<div id="print_me">
					<img src="'.$result_now[21].'" class="popup__media popup__media_right" alt="No Image of WO" style="max-width:300px;max-height:300px;">
					<img src="'.$result_now[22].'" class="popup__media popup__media_right" alt="No QR Code of WO" style="max-width:300px;max-height:300px;">
					<table class="text-popup">
					<!--<tr height="30"><td>WO State </td><td> : </td><td><form action="'.$page.'" method="post" enctype="multipart/form-data">'.combo_je(array(COMWOSTAT,'state','state',180,'',$edresult_now[15])).' <input class="form-submit" type="submit" value="Update"></form>
					</td>-->
					<tr height="30"><td>WO State </td><td> : </td><td>'.$result_now[14].'</td>
					<tr height="30"><td>Asset No </td><td> : </td><td>'.$result_now[24].'</td>
					<tr height="30"><td>Asset Name </td><td> : </td><td>'.$result_now[11].'</td>
					<tr height="30"><td>WO Priority </td><td> : </td><td>'.$result_now[13].'</td>
					<tr height="30"><td>WO Type </td><td> : </td><td>'.$result_now[12].'</td>
					<tr height="30"><td>MU Section </td><td> : </td><td>'.$result_now[15].'</td>
					<tr height="30"><td>Requestor </td><td> : </td><td>'.$result_now[10].'</td>
					<tr height="30"><td>Request Date </td><td> : </td><td>'.$result_now[1].'</td>
					<tr height="30"><td>Require Date </td><td> : </td><td>'.$result_now[2].'</td>
					<tr height="30"><td>Plan Date Start</td><td> : </td><td>'.$result_now[3].'</td>
					<tr height="30"><td>Plan Date End</td><td> : </td><td>'.$result_now[4].'</td>
					<tr height="30"><td>Actual Date Start</td><td> : </td><td>'.$result_now[5].'</td>
					<tr height="30"><td>Actual Date Start</td><td> : </td><td>'.$result_now[6].'</td>
					<tr height="30"><td>Failure Code </td><td> : </td><td>'.$result_now[16].'</td>
					<tr height="30"><td>Problem Desc </td><td> : </td><td>'.$result_now[17].'</td>
					<tr height="30"><td>Cause Desc </td><td> : </td><td>'.$result_now[18].'</td>
					<tr height="30"><td>Solution </td><td> : </td><td>'.$result_now[19].'</td>
					<tr height="30"><td>Prevention </td><td> : </td><td>'.$result_now[20].'</td>
					</table>
					</div>
					
					
					<a href="#" class="popup__close">close</a>
				  </div>
				</div>
				';
		}
		
		return $content;
	}
	
	//======= Script JS for dashboard ==============
	function dashboard_js(){
		$content = "
				<script>
					$('#his-breakdown').DataTable();
					$('#his-calculation').DataTable();
				</script>
		";
		return $content;
	}
#########################################################################################################################################	
?>