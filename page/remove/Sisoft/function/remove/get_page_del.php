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
			$qpreve = 'SELECT COUNT(*) FROM work_order WHERE WorkTypeID="WT000002" AND Hidden="no"'; $result = mysql_exe_query(array($qpreve,1)); $resultnow=mysql_exe_fetch_array(array($result,1));$count_preve=$resultnow[0];
			$qorder = 'SELECT COUNT(*) FROM work_order WHERE Hidden="no"'; $result = mysql_exe_query(array($qorder,1)); $resultnow=mysql_exe_fetch_array(array($result,1));$count_order=$resultnow[0];
			$content = '
			<div class="row">
                <div class="col-lg-4 col-md-6">
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
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-wrench fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$count_preve.'</div>
                                    <div>Total Preventive!</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_PMLIST.'">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$count_order.'</div>
                                    <div>Total Work Order!</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_WORDER.'">
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
			
			//=======Row 2 =======
			$content .= get_js_graph(array(GSTATEBYYEAR,'3d-pie','Total Work Order '.date('Y'),'Percent Work Order','container','300','360','typequery1',PATH_INDEX_PAGE,'Total Work Order'));
			$content .= get_js_graph(array(GRAPHPLNSTATE,'3d-pie','Condition of Status Asset','Percent Asset','container2','300','360','typequery1',PATH_INDEX_PAGE,'Total Asset')); 
			//$content .= get_js_graph(array(GSTATEBYMONTH,'3d-pie','Total Work Order '.date('M').' '.date('Y'),'Percent Work Order','container2','420','360','typequery1',PATH_INDEX_PAGE,'Total Work Order'));
			$content .= get_js_graph(array(GSCHEDULEWO,'3d-pie','Schedule Work Order','Percent Work Order','container3','300','360','typequery1',PATH_INDEX_PAGE,'Total Work Order'));
			
			//***********WO NOT PLANNED PERFORMED***********//
			$width = "[100,380,100,450]";
			$field = gen_mysql_id(NOTPLANPERFORMED);
			$name = gen_mysql_head(NOTPLANPERFORMED);
			$sethead = "['WO','Asset','Work Status','Description']";
			$setid = "[{data:'WO',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Description',className: 'htLeft'}]";
			$dt = array(NOTPLANPERFORMED,$field,array('Delete'),array(PATH_INDEX_PAGE.'&wo='.$_REQUEST['rowid'].DELETE),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'notplan');
			$notplan= '<div id="notplan" style="width: 1040px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********PERFORMED WORK ORDERS THIS YEAR***********//
			$width = "[100,380,100,450]";
			$field = gen_mysql_id(PERFORMED);
			$name = gen_mysql_head(PERFORMED);
			$sethead = "['WO','Asset','Work Status','Description']";
			$setid = "[{data:'WO',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Description',className: 'htLeft'}]";
			$dt = array(PERFORMED,$field,array('Delete'),array(PATH_INDEX_PAGE.'&wo='.$_REQUEST['rowid'].DELETE),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'plan');
			$plan= '<div id="plan" style="width: 1040px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			$table .= '
					<table>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">Last Modified, Not Planned Work Order</div></td></tr>
							<tr><td>'.$notplan.'</td></tr>
							</table>
						</td>
						</tr>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">Last Modified, Performed Work Order'.date('Y').'</div></td></tr>
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
                            <i class="fa fa-table fa-fw"></i> Table
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="tab1">'.$table.'</div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-4">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> Pie 1
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="container"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-4">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> Pie 2
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="container2"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
				</div>
				<div class="col-lg-4">
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-table fa-fw"></i> Pie 3
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="container3"></div>
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
			$sethead = "['Asset Category ID','Asset Category Code','Asset Category'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Asset_Category_ID',className: 'htLeft'},{data:'Asset_Category_Code',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
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
							<fieldset><legend>Upload Excel Employee</legend>
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
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['empex']['size']>50000){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 && $sizeupload==0){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['asscat']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="toptext" align="center" style="color:red"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'asscat');
								$content .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['asscat']['name']).' has been uploaded</div>';
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
							<fieldset><legend>Asset Category</legend>
								<table>
									<tr><td width="150"><span class="name"> Asset Category Code </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascode" value="'.$reval_ax.'"></td></tr>
									<tr><td width="150"><span class="name"> Asset Category </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascat" value="'.$reval_ax.'"></td></tr>
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
						$sethead = "['Asset Category ID','Asset Category Code','Asset Category'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Asset_Category_ID',className: 'htLeft'},{data:'Asset_Category_Code',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSCAT.EDIT),array(),PATH_ASSCAT);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$sethead = "['Asset Category ID','Asset Category Code','Asset Category'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Asset_Category_ID',className: 'htLeft'},{data:'Asset_Category_Code',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSCAT.EDIT),array(),PATH_ASSCAT);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Asset Category</legend>
								<table>
									<tr><td width="150"><span class="name"> Asset Category Code </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascode" value="'.$ascode.'"></td></tr>
									<tr><td width="150"><span class="name"> Asset Category </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="ascat" value="'.$ascat.'"></td></tr>
									<tr><td width="150"></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}	
		}
		//=======NEW PAGE=====================
		//------ FAILURE CODE ----------------
		else if(strcmp($_REQUEST['page'],'assets')==0){
			/*------Hanya kasus untuk hapus data---**/
			if(isset($_REQUEST['delete'])){
				$query = 'UPDATE asset SET Hidden="yes" WHERE AssetID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			/*------Get Pop Up Windows---------*/
			$content = pop_up('assets');
			
			$content .= '<br/><div class="ade">ASSETS</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			if(_DELETE_) $width = "[150,150,200,80,80,100,100,100,200,200,200,150,150,150,200,200,200,200,200,150,150,150]";
			else $width = "[150,150,200,80,100,100,100,200,200,200,150,150,150,200,200,200,200,200,150,150,150]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(ASSETS.' ORDER BY A.AssetID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(ASSETS.' ORDER BY A.AssetID DESC');
			//-------set header pada handson------
			$sethead = "['Asset ID','Asset No','Asset Desc'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_._USER_SPARE_SETHEAD_._USER_HISTORY_SETHEAD_._USER_DOC_SETHEAD_.",'Location Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold']";
			//-------set id pada handson----------
			$setid = "[{data:'Asset_ID',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_._USER_SPARE_SETID_._USER_HISTORY_SETID_._USER_DOC_SETID_.",{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}]";
			//-------get data pada sql------------
			$dt = array(ASSETS.' ORDER BY A.AssetID DESC',$field,array('Edit','Delete','View','History','Attachment'),array(PATH_ASSETS.EDIT,PATH_ASSETS.DELETE,PATH_ASSETS.SPARE,PATH_ASSETS.HISTORY,PATH_ASSETS.DOCUMENT),array(0),PATH_ASSETS);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=3;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD ASSET DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSETS.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Upload Excel Asset</legend>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'file/asset.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> Asset Data </td><td>:</td> </span></td><td>'.text_filebox(array('assup','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'file/';
						$target_file = $target_dir.basename($_FILES['assup']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['assup']['size']>500000){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 500KB)</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 || $sizeupload==0){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['assup']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="toptext" align="center" style="color:red"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'asset');
								$content .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['assup']['name']).' has been uploaded</div>';
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR ASSETS</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ASSETS.'">View</a></span> || <span><a href="'.PATH_ASSETS.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_ASSETS.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Assets</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Asset No </td><td>:</td><td>'.text_je(array('asno','','false')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Desc </td><td>:</td><td>'.text_je(array('asdes','','false')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Location Desc </td><td>:</td><td>'.combo_je(array(COMLOCATN,'locdes','locdes',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Department Desc </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Asset Category </td><td>:</td><td>'.combo_je(array(COMASSCAT,'ascat','ascat',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Status </td><td>:</td></td><td>'.combo_je(array(COMASSTAT,'assta','assta',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Criticality </td><td>:</td><td>'.combo_je(array(COMCRITIC,'critic','critic',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Auth. Employee </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'employ','employ',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Supplier </td><td>:</td><td>'.combo_je(array(COMSUPPLY,'supply','supply',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty </td><td>:</td><td>'.combo_je(array(COMWARRAN,'warran','warran',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Manufacturer </td><td>:</td><td>'.text_je(array('manuf','','false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Model No </td><td>:</td><td>'.text_je(array('mono','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Serial No </td><td>:</td><td>'.text_je(array('sn','','false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty Expired </td><td>:</td><td>'.date_je(array('wardat','')).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Warranty Notes </td><td>:</td><td>'.text_je(array('warnot','','true','style="width:100%;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Notes </td><td>:</td><td>'.text_je(array('assnot','','true','style="width:100%;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Date Acquired </td><td>:</td><td>'.date_je(array('datacq','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Date Disposed </td><td>:</td><td>'.date_je(array('datdis','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td><td width="20"><td><td width="120"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Parent </td><td>:</td><td colspan="4">'.combo_je(array(COMASSETS,'parent','parent',250,'<option value=""> - </option>','')).'</td>
										
									</tr>
		
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){ 
					if(!empty($_REQUEST['asno']) && !empty($_REQUEST['asdes']) && !empty($_REQUEST['ascat']) && !empty($_REQUEST['assta']) && !empty($_REQUEST['critic']) && !empty($_REQUEST['employ']) && !empty($_REQUEST['supply']) && !empty($_REQUEST['warran']) && !empty($_REQUEST['datacq'])){
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/asset/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>500000){ 
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 500KB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$info ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of image</div>.';
								}else{
									$info .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTASSETS,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $asid=get_new_code('AS',$numrow); 
						$wardat=convert_date(array($_REQUEST['wardat'],2)); $datacq=convert_date(array($_REQUEST['datacq'],2)); $datdis=convert_date(array($_REQUEST['datdis'],2));
						//-- Insert data pada kategori aset --//
						if(empty(basename($_FILES['image']['name']))){
						$query = 'INSERT INTO asset (AssetID,AssetNo,AssetDesc,locationID,DepartmentID,AssetCategoryID,AssetStatusID,CriticalID, EmployeeID,SupplierID,Manufacturer,ModelNumber,SerialNumber,WarrantyID,WarrantyNotes, WarrantyDate,AssetNote,DateAcquired,DateSold,ParentID) VALUES("'.$asid.'","'.$_REQUEST['asno'].'","'.$_REQUEST['asdes'].'","'.$_REQUEST['locdes'].'","'.$_REQUEST['depdes'].'","'.$_REQUEST['ascat'].'","'.$_REQUEST['assta'].'","'.$_REQUEST['critic'].'","'.$_REQUEST['employ'].'","'.$_REQUEST['supply'].'","'.$_REQUEST['manuf'].'","'.$_REQUEST['mono'].'","'.$_REQUEST['sn'].'","'.$_REQUEST['warran'].'","'.$_REQUEST['warnot'].'","'.$wardat.'","'.$_REQUEST['assnot'].'","'.$datacq.'","'.$datdis.'","'.$_REQUEST['parent'].'")';
						}else{
						$query = 'INSERT INTO asset (AssetID,AssetNo,AssetDesc,locationID,DepartmentID,AssetCategoryID,AssetStatusID,CriticalID, EmployeeID,SupplierID,Manufacturer,ModelNumber,SerialNumber,WarrantyID,WarrantyNotes, WarrantyDate,AssetNote,DateAcquired,DateSold,ParentID,ImagePath) VALUES("'.$asid.'","'.$_REQUEST['asno'].'","'.$_REQUEST['asdes'].'","'.$_REQUEST['locdes'].'","'.$_REQUEST['depdes'].'","'.$_REQUEST['ascat'].'","'.$_REQUEST['assta'].'","'.$_REQUEST['critic'].'","'.$_REQUEST['employ'].'","'.$_REQUEST['supply'].'","'.$_REQUEST['manuf'].'","'.$_REQUEST['mono'].'","'.$_REQUEST['sn'].'","'.$_REQUEST['warran'].'","'.$_REQUEST['warnot'].'","'.$wardat.'","'.$_REQUEST['assnot'].'","'.$datacq.'","'.$datdis.'","'.$_REQUEST['parent'].'","'.$target_file.'")';
						} mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = ASSETS.' AND AssetID="'.$asid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,150,200,200,200,200,150,150,150,200,200,200,200,200,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Asset ID','Asset No','Asset Desc','Location Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold'"._USER_EDIT_SETHEAD_."]";
						$setid = "[{data:'Asset_ID',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'},{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSETS.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=3;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson).$info;
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){ //echo $_REQUEST['datacq'];
					if(!empty($_REQUEST['asno']) && !empty($_REQUEST['asdes']) && !empty($_REQUEST['ascat']) && !empty($_REQUEST['assta']) && !empty($_REQUEST['critic']) && !empty($_REQUEST['employ']) && !empty($_REQUEST['supply']) && !empty($_REQUEST['warran']) && !empty($_REQUEST['datacq'])){
						
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/asset/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>500000){ 
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 500KB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$addinfo ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of image</div>.';
								}else{
									$addinfo .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						
						
						//-- Update data pada kategori aset --//
						$wardat=convert_date(array($_REQUEST['wardat'],2)); $datacq=convert_date(array($_REQUEST['datacq'],2)); $datdis=convert_date(array($_REQUEST['datdis'],2));
						
						if(empty(basename($_FILES['image']['name']))){
						$query = 'UPDATE asset SET AssetNo="'.$_REQUEST['asno'].'", AssetDesc="'.$_REQUEST['asdes'].'", locationID="'.$_REQUEST['locdes'].'", DepartmentID="'.$_REQUEST['depdes'].'", AssetCategoryID="'.$_REQUEST['ascat'].'", AssetStatusID="'.$_REQUEST['assta'].'", CriticalID="'.$_REQUEST['critic'].'",  EmployeeID="'.$_REQUEST['employ'].'", SupplierID="'.$_REQUEST['supply'].'", Manufacturer="'.$_REQUEST['manuf'].'", ModelNumber="'.$_REQUEST['mono'].'", SerialNumber="'.$_REQUEST['sn'].'", WarrantyID="'.$_REQUEST['warran'].'", WarrantyNotes="'.$_REQUEST['warnot'].'",  WarrantyDate="'.$wardat.'", AssetNote="'.$_REQUEST['assnot'].'", DateAcquired="'.$datacq.'", DateSold="'.$datdis.'", ParentID="'.$_REQUEST['parent'].'" WHERE AssetID="'.$_REQUEST['rowid'].'"';
						}else{
						$query = 'UPDATE asset SET AssetNo="'.$_REQUEST['asno'].'", AssetDesc="'.$_REQUEST['asdes'].'", locationID="'.$_REQUEST['locdes'].'", DepartmentID="'.$_REQUEST['depdes'].'", AssetCategoryID="'.$_REQUEST['ascat'].'", AssetStatusID="'.$_REQUEST['assta'].'", CriticalID="'.$_REQUEST['critic'].'",  EmployeeID="'.$_REQUEST['employ'].'", SupplierID="'.$_REQUEST['supply'].'", Manufacturer="'.$_REQUEST['manuf'].'", ModelNumber="'.$_REQUEST['mono'].'", SerialNumber="'.$_REQUEST['sn'].'", WarrantyID="'.$_REQUEST['warran'].'", WarrantyNotes="'.$_REQUEST['warnot'].'",  WarrantyDate="'.$wardat.'", AssetNote="'.$_REQUEST['assnot'].'", DateAcquired="'.$datacq.'", DateSold="'.$datdis.'", ParentID="'.$_REQUEST['parent'].'", ImagePath="'.$target_file.'" WHERE AssetID="'.$_REQUEST['rowid'].'"';
						} 
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = ASSETS.' AND AssetID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,150,200,200,200,200,150,150,150,200,200,200,200,200,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Asset ID','Asset No','Asset Desc','Location Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold'"._USER_EDIT_SETHEAD_."]";
						$setid = "[{data:'Asset_ID',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'},{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSETS.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=3;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson).$addinfo;
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$asno=$resultnow[1]; $asdes=$resultnow[2]; $locdes=$resultnow[3]; $depdes=$resultnow[4]; $ascat=$resultnow[5]; $assta=$resultnow[6]; $critic=$resultnow[7]; $employ=$resultnow[8]; $supply=$resultnow[9]; $manuf=$resultnow[10]; $mono=$resultnow[11]; $sn=$resultnow[12]; $warran=$resultnow[13]; $warnot=$resultnow[14]; $wardat=convert_date(array($resultnow[15],3)); $assnot=$resultnow[16]; $datacq=convert_date(array($resultnow[17],3)); $datdis=convert_date(array($resultnow[18],3)); $parent=$resultnow[19];
				
				//-----Tampilan judul pada pengeditan------ 
				$content = '<br/><div class="ade">EDIT DATA FOR ASSET CATEGORY FOR '.$asdes.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_ASSETS.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Assets</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Asset No </td><td>:</td> </span></td><td>'.text_je(array('asno',$asno,'false')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Desc </td><td>:</td> </span></td><td>'.text_je(array('asdes',$asdes,'false')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Location Desc </td><td>:</td> </span></td><td>'.combo_je(array(COMLOCATN,'locdes','locdes',180,'',$locdes)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Department Desc </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',180,'',$depdes)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Asset Category </td><td>:</td> </span></td><td>'.combo_je(array(COMASSCAT,'ascat','ascat',180,'',$ascat)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Status </td><td>:</td> </span></td><td>'.combo_je(array(COMASSTAT,'assta','assta',180,'',$assta)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Criticality </td><td>:</td> </span></td><td>'.combo_je(array(COMCRITIC,'critic','critic',180,'',$critic)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Auth. Employee </td><td>:</td> </span></td><td>'.combo_je(array(COMEMPLOY,'employ','employ',180,'',$employ)). '*</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Supplier </td><td>:</td> </span></td><td>'.combo_je(array(COMSUPPLY,'supply','supply',180,'',$supply)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty </td><td>:</td> </span></td><td>'.combo_je(array(COMWARRAN,'warran','warran',180,'',$warran)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Manufacturer </td><td>:</td> </span></td><td>'.text_je(array('manuf',$manuf,'false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Model No </td><td>:</td> </span></td><td>'.text_je(array('mono',$mono,'false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Serial No </td><td>:</td> </span></td><td>'.text_je(array('sn',$sn,'false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty Expired </td><td>:</td> </span></td><td>'.date_je(array('wardat',$wardat)).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Warranty Notes </td><td>:</td> </span></td><td>'.text_je(array('warnot',$warnot,'true','style="width:100%;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Notes </td><td>:</td> </span></td><td>'.text_je(array('assnot',$assnot,'true','style="width:100%;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Date Acquired </td><td>:</td> </span></td><td>'.date_je(array('datacq',$datacq)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Date Disposed </td><td>:</td> </span></td><td>'.date_je(array('datdis',$datdis)).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td><td width="20"><td><td width="120"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Parent </td><td>:</td><td>'.combo_je(array(COMASSETS,'parent','parent',180,'<option value=""> - </option>',$parent)).'</td>
										<td width="20"><td>
										<td width="120"></td><td></td><td><span class="editlink"><a href="'.PATH_ASSETS.CHILD.'&rowid='.$_REQUEST['rowid'].'">Get Childs or Siblings</a></span></td>
									</tr>
		
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['child'])){ 
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = ASSETS.' AND A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$asdes=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------ 
				$content = '<br/><div class="ade">CHILD FROM ASSETS DATA  '.$asdes.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ASSETS.EDIT.'&rowid='.$_REQUEST['rowid'].'">View</a></span></div>';
				
				//----- Buat Form Tambah Child Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSETS.CHILD.POST.'&rowid='.$_REQUEST['rowid'].'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Add Child</legend>
								<table>
									<tr><td width="150"><span class="name"> Child </td><td>:</td> </span></td><td>'.combo_je(array(COMASSETS,'child','child',250,'<option value=""> - </option>','')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
							
				//------ Aksi ketika post menambahkan pada child -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['child'])){
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTACHILD,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; 
						$chid='CH'.date('y').date('m').date('d').date('h').date('i').date('s');
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO siblings (SiblingsID,AssetID,ChildID) VALUES("'.$chid.'","'.$_REQUEST['rowid'].'","'.$_REQUEST['child'].'")'; mysql_exe_query(array($query,1));
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//------ Aksi ketika menghapus data pada child -----//
				if(isset($_REQUEST['delete'])){
					$con = 'SiblingsID="'.$_REQUEST['rowid'].'"'; 
					$content = query_delete(array(PATH_ASSETS.CHILD.'&rowid='.$_REQUEST['assetid'], 'siblings', $con));	
				}
				
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,200,200,200,200,80]";
				//-------get id pada sql -------------
				$field = gen_mysql_id(ACHILD.' AND S.AssetID="'.$_REQUEST['rowid'].'"');
				//-------get header pada sql----------
				$name = gen_mysql_head(ACHILD.' AND S.AssetID="'.$_REQUEST['rowid'].'"');
				//-------set header pada handson------
				$sethead = "['Sibling ID','Asset No','Asset','Child No','Child'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Siblings_ID',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Child_No',className: 'htLeft'},{data:'Child',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array(ACHILD.' AND S.AssetID="'.$_REQUEST['rowid'].'"',$field,array('Delete'),array(PATH_ASSETS.CHILD.DELETE.'&assetid='.$_REQUEST['rowid']),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
			
			//------------Jika ada halaman spare data-------//
			if(isset($_REQUEST['spare'])){
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$assetname=$resultnow[2];  
				$content = '<br/><div class="ade">'.TSPARE.' '.$assetname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//-----------------POST-------------------
				if(isset($_REQUEST['post'])){
					//-- Insert data pada kategori aset --//
					$field = array(
							'AssetID', 
							'item_id');
					$value = array(
							'"'.$_REQUEST['rowid'].'"',
							'"'.$_REQUEST['item'].'"'); 
					$query = mysql_stat_insert(array('invent_item_spare_asset',$field,$value)); 
					mysql_exe_query(array($query,1)); 
				}
				//------ Aksi ketika menghapus data pada spare -----//
				if(isset($_REQUEST['delete'])){
					$con = 'AssetID="'.$_REQUEST['assetid'].'" AND item_id="'.$_REQUEST['rowid'].'"'; 
					$content = query_delete(array(PATH_ASSETS.SPARE.'&rowid='.$_REQUEST['assetid'], 'invent_item_spare_asset', $con));	
				}
				//-----DEFINE-------------------
				DEFINE('_SPARE_ASSET_',$_REQUEST['rowid']); 
				//DEFINE('SPAREP','SELECT ISA.item_id Item_Code, AST.AssetDesc Asset_Name ,IT.item_description Item_Name, IO.quantity Quantity FROM invent_item_spare_asset ISA, invent_item IT, invent_stock IO, asset AST WHERE ISA.item_id=IT.item_id AND IT.item_id=IO.item_id AND ISA.AssetID=AST.AssetID AND AST.AssetID="'._SPARE_ASSET_.'"');
				DEFINE('SPAREP','SELECT ISA.item_id Item_Code, AST.AssetDesc Asset_Name ,IT.item_description Item_Name, IT.stock Quantity FROM invent_item_spare_asset ISA, invent_item IT, asset AST WHERE ISA.item_id=IT.item_id AND ISA.AssetID=AST.AssetID AND AST.AssetID="'._SPARE_ASSET_.'"');
				DEFINE('COMBSPAREP','SELECT item_id, item_description FROM invent_item WHERE item_id NOT IN (SELECT item_id FROM invent_item_spare_asset WHERE AssetID="'._SPARE_ASSET_.'")');  
				//-------------------------------------------------//
				
				$name_field=array('Item Name');
				$input_type=array(
							combo_je(array(COMBSPAREP,'item','item',200,'',''))
						);
				$signtofill = array('*');
				$content .= create_form(array(FASPAREP,PATH_ASSETS.SPARE.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,400,400,100,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id(SPAREP);
				//-------get header pada sql----------
				$name = gen_mysql_head(SPAREP);
				//-------set header pada handson------
				$sethead = "['Item Code','Asset Name','Item Name','Quantity'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Item_Code',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array(SPAREP,$field,array('Delete'),array(PATH_ASSETS.SPARE.DELETE.'&assetid='.$_REQUEST['rowid']),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
			
			//------------Jika ada halaman history-------//
			if(isset($_REQUEST['history'])){
				/*------Get Pop Up Windows---------*/
				$content = pop_up('worder');
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$assetname=$resultnow[2];  
				$content .= '<br/><div class="ade">WORK ORDER HISTORY FOR '.$assetname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
				//-------get id pada sql -------------
				$field = gen_mysql_id(WORDER.' AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(WORDER.' AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC');
				//-------set header pada handson------
				$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array(WORDER.' AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC',$field,array(),array(),array(0),PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid']);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
			
			//------------Jika ada halaman docoment-------//
			if(isset($_REQUEST['doc'])){ $addinfo='';
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$assetname=$resultnow[2];  
				$content = '<br/><div class="ade">DOCUMENT ATTACHMENT FOR '.$assetname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				if(isset($_REQUEST['post'])){
						if(!empty($_REQUEST['docname'])){
							$upload = 0;
					//--------Post Doc File------------------
							try{
								$existupload=1; $typeupload = 1; $sizeupload = 1;
								$target_dir = _ROOT_.'file/assetdoc/';
								$target_file = $target_dir.basename($_FILES['doc']['name']);
								$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
								$expensions= array("pdf");
								if(file_exists($target_file)){
									$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, File already exist</div>';
									$typeupload = 0;
								}
								
								if(in_array($filetype,$expensions)===false){
									$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, only PDF files are allowed</div>';
									$typeupload = 0;
								}
								
								if($_FILES['image']['size']>2000000){ 
									$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 2MB)</div>';
									$sizeupload = 0;
								}
								
								if($existupload==0 || $typeupload==0 || $sizeupload==0){
									$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, You have failed upload document</div>';
								}else{
									if(!move_uploaded_file($_FILES['doc']['tmp_name'],$target_file)){
										$addinfo ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of document</div>.';
									}else{
										$addinfo .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['doc']['name']).' has been uploaded</div>';
										$upload = 1;
									}
								}
							}catch(RuntimeException $e){
								$addinfo = '<br/>'.$e->getMessage();
							}
						
							
							//-- Generate a new id untuk kategori aset --// 
							$result = mysql_exe_query(array(COUNTQASSETDOC,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; //$docid=get_new_code('DT',$numrow); 
							$docid='DT'.date('y').date('m').date('d').date('h').date('i').date('s');
							//-- Insert data pada kategori aset --//
							$field = array(
									'AssetDocID', 
									'AssetID',
									'NameDoc',
									'DocPath',
									'PathFile');
							$value = array(
									'"'.$docid.'"',
									'"'.$_REQUEST['rowid'].'"',
									'"'.$_REQUEST['docname'].'"',
									'"<span class=\"editlink\"><a href=\"'.$target_file.'\"</a>Download</span>"',
									'"'.$target_file.'"'); 
							$query = mysql_stat_insert(array('asset_document',$field,$value)); 
							if($upload==1)
								mysql_exe_query(array($query,1)); 
						}else{
							$addinfo = '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
						}
				}
				//------ Aksi ketika menghapus data pada spare -----//
				if(isset($_REQUEST['delete'])){
					$query = 'SELECT * FROM asset_document';
					$result = mysql_exe_query(array($query,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $path = $resultnow[4];
					unlink($path);
					$con = 'AssetID="'.$_REQUEST['assetid'].'" AND AssetDocID="'.$_REQUEST['rowid'].'"'; 
					$content = query_delete(array(PATH_ASSETS.DOCUMENT.'&rowid='.$_REQUEST['assetid'], 'asset_document', $con));	
				}
				
				//----- Buat Form Isian Berikut-----
				$name_field=array('Name of Document','Attachment');
				$input_type=array(
							text_je(array('docname',$sn,'false')),
							text_filebox(array('doc','','false'))
						);
				$signtofill = array(' * ',' <span style="color:red; font-size:12;"> PDF Max (2MB)</span>');
				$content .= create_form(array(ASSETDOC,PATH_ASSETS.DOCUMENT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill)).$addinfo;
				
				$query = QASSETDOC.' AND AD.AssetID="'.$_REQUEST['rowid'].'"';
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,350,350,200,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id($query);
				//-------get header pada sql----------
				$name = gen_mysql_head($query);
				//-------set header pada handson------
				$sethead = "['Doc ID','Asset Name','Document Name','Download'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Doc_ID',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Doc_Name',className: 'htLeft'},{data:'Path',renderer:'html'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($query,$field,array('Delete'),array(PATH_ASSETS.DOCUMENT.DELETE.'&assetid='.$_REQUEST['rowid']),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
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
							<fieldset><legend>Failure Code</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Asset Category</legend>
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
			$width = "[150,150,150,150,150,150,250,150,150,150,150,150,150,150,150,80,80]";
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
							<fieldset><legend>Upload Excel Employee</legend>
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
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['empex']['size']>50000){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 && $sizeupload==0){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['empex']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="toptext" align="center" style="color:red"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'employee');
								$content .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['empex']['name']).' has been uploaded</div>';
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
							<fieldset><legend>Employee</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Employee</legend>
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
			
			$content = '<br/><div class="ade">DEPARTMENT</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,400,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(DEPART.' ORDER BY DepartmentID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(DEPART.' ORDER BY DepartmentID DESC');
			//-------set header pada handson------
			$sethead = "['Department ID','Department No','Department Desc'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
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
							<fieldset><legend>Department</legend>
								<table>
									<tr><td width="150"><span class="name"> Department No </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="deptno" value=""></td></tr>
									<tr><td width="150"><span class="name"> Department Desc. </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="depdes" value=""></td></tr>
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
						$sethead = "['Department ID','Department No','Department Desc'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Department_ID',className: 'htLeft'},{data:'Department_No',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_DEPART.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$sethead = "['Department ID','Department No','Department Desc'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Department_ID',className: 'htLeft'},{data:'Department_No',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_DEPART.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Department</legend>
								<table>
									<tr><td width="150"><span class="name"> Department No </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="deptno" value="'.$deptno.'"></td></tr>
									<tr><td width="150"><span class="name"> Department Desc. </td><td>:</td> </span></td><td><input type="text" class="easyui-textbox" name="depdes" value="'.$depdes.'"></td></tr>
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
			
			$content = '<br/><div class="ade">LOCATION</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[110,110,200,200,250,120,120,120,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(LOCATN.' ORDER BY L.LocationId DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(LOCATN.' ORDER BY L.LocationId DESC');
			//-------set header pada handson------
			$sethead = "['Location ID','Location No','Location Description','Department Desc','Note To Tech','District','State','Country'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Location_ID',className: 'htLeft'},{data:'Location_No',className: 'htLeft'},{data:'Location_Description',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Note_To_Tech',className: 'htLeft'},{data:'District',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(LOCATN.' ORDER BY L.LocationId DESC',$field,array('Edit','Delete'),array(PATH_LOCATN.EDIT,PATH_LOCATN.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=3;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR LOCATION</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_LOCATN.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Location</legend>
								<table>
									<tr><td width="150"><span class="name"> Location No </td><td>:</td> </span></td><td>'.text_je(array('locno','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Location Desc. </td><td>:</td> </span></td><td>'.text_je(array('locdes','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Department. </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',250,'<option value=""> - </option>','')).' *</td></tr>
									<tr><td width="150"><span class="name"> Note to Technician </td><td>:</td> </span></td><td>'.text_je(array('notetec','','true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td width="150"><span class="name"> District </td><td>:</td> </span></td><td>'.text_je(array('district','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> State </td><td>:</td> </span></td><td>'.text_je(array('state','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Country </td><td>:</td> </span></td><td>'.text_je(array('country','','false')).'</td></tr>
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
						$sethead = "['Location ID','Location No','Location Description','Department Desc','Note To Tech','District','State','Country'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Location_ID',className: 'htLeft'},{data:'Location_No',className: 'htLeft'},{data:'Location_Description',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Note_To_Tech',className: 'htLeft'},{data:'District',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_LOCATN.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$sethead = "['Location ID','Location No','Location Description','Department Desc','Note To Tech','District','State','Country'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Location_ID',className: 'htLeft'},{data:'Location_No',className: 'htLeft'},{data:'Location_Description',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Note_To_Tech',className: 'htLeft'},{data:'District',className: 'htLeft'},{data:'State',className: 'htLeft'},{data:'Country',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_LOCATN.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDLOCATN.' WHERE L.LocationID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$locno=$resultnow[1]; $locdes=$resultnow[2]; $depdes=$resultnow[3]; $notetec=$resultnow[4]; $district=$resultnow[5]; $state=$resultnow[6]; $country=$resultnow[7]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA FOR LOCATION FOR '.$locno.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_LOCATN.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Location</legend>
								<table>
									<tr><td width="150"><span class="name"> Location No </td><td>:</td> </span></td><td>'.text_je(array('locno',$locno,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Location Desc. </td><td>:</td> </span></td><td>'.text_je(array('locdes',$locdes,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Department. </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',250,'<option value=""> - </option>',$depdes)).' *</td></tr>
									<tr><td width="150"><span class="name"> Note to Technician </td><td>:</td> </span></td><td>'.text_je(array('notetec',$notetec,'true','style="width:100%;height:80px"')).'</td></tr>
									<tr><td width="150"><span class="name"> District </td><td>:</td> </span></td><td>'.text_je(array('district',$district,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> State </td><td>:</td> </span></td><td>'.text_je(array('state',$state,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Country </td><td>:</td> </span></td><td>'.text_je(array('country',$country,'false')).'</td></tr>
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
							<fieldset><legend>Supplier</legend>
								<table>
									<tr><td width="150"><span class="name"> Supplier No </td><td>:</td> </span></td><td>'.text_je(array('spno','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Supplier Name </td><td>:</td> </span></td><td>'.text_je(array('ctnm','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Designation </td><td>:</td> </span></td><td>'.text_je(array('desig','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Address </td><td>:</td> </span></td><td>'.text_je(array('addres','','true','style="width:100%;height:80px"')).' *</td></tr>
									<tr><td width="150"><span class="name"> Postal Code </td><td>:</td> </span></td><td>'.text_je(array('poco','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> City </td><td>:</td> </span></td><td>'.text_je(array('city','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> State </td><td>:</td> </span></td><td>'.text_je(array('state','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Country </td><td>:</td> </span></td><td>'.text_je(array('counr','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Telephone No </td><td>:</td> </span></td><td>'.text_je(array('telp','','false')). ' *</td></tr>
									<tr><td width="150"><span class="name"> Fax No </td><td>:</td> </span></td><td>'.text_je(array('fax','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> Services </td><td>:</td> </span></td><td>'.text_je(array('service','','true','style="width:100%;height:80px"')).'</td></tr>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Supplier</legend>
								<table>
									<tr><td width="150"><span class="name"> Supplier No </td><td>:</td> </span></td><td>'.text_je(array('spno',$spno,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Contact Name </td><td>:</td> </span></td><td>'.text_je(array('ctnm',$ctnm,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Designation </td><td>:</td> </span></td><td>'.text_je(array('desig',$desig,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Address </td><td>:</td> </span></td><td>'.text_je(array('addres',$addres,'true','style="width:100%;height:80px"')).' *</td></tr>
									<tr><td width="150"><span class="name"> Postal Code </td><td>:</td> </span></td><td>'.text_je(array('poco',$poco,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> City </td><td>:</td> </span></td><td>'.text_je(array('city',$city,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> State </td><td>:</td> </span></td><td>'.text_je(array('state',$state,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Country </td><td>:</td> </span></td><td>'.text_je(array('counr',$counr,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Telephone No </td><td>:</td> </span></td><td>'.text_je(array('telp',$telp,'false')). ' *</td></tr>
									<tr><td width="150"><span class="name"> Fax No </td><td>:</td> </span></td><td>'.text_je(array('fax',$fax,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> Services </td><td>:</td> </span></td><td>'.text_je(array('service',$service,'true','style="width:100%;height:80px"')).'</td></tr>
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
							<fieldset><legend>Work Priority</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Work Priority</legend>
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
			$width = "[200,200,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WSTATE.' ORDER BY WorkStatusID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WSTATE.' ORDER BY WorkStatusID DESC');
			//-------set header pada handson------
			$sethead = "['Work Status ID','Work Status'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Status_ID',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
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
				$content = '<br/><div class="ade">ADD DATA FOR WARRANTY CONTRACT</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WSTATE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Status</legend>
								<table>
									<tr><td width="150"><span class="name"> Work Status </td><td>:</td> </span></td><td>'.text_je(array('wstate','','false')).'</td></tr>
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
						$query = 'INSERT INTO work_status (WorkStatusID ,WorkStatus) VALUES("'.$wsid.'","'.$_REQUEST['wstate'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WSTATE.' AND WorkStatusID="'.$wsid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Status ID','Work Status'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Status_ID',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WSTATE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['wstate'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE work_status SET WorkStatus="'.$_REQUEST['wstate'].'" WHERE WorkStatusID="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = WSTATE.' AND WorkStatusID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Work Status ID','Work Status'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Status_ID',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WSTATE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = WSTATE.' AND WorkStatusID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wstate=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK STATUS FOR '.$wstate.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WSTATE.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Status</legend>
								<table>
									<tr><td width="150"><span class="name"> Work Status </td><td>:</td> </span></td><td>'.text_je(array('wstate',$wstate,'false')).'</td></tr>
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
							<fieldset><legend>Work Type</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Work Type</legend>
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
							<fieldset><legend>Warranty Contract</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Warranty Contract</legend>
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
							<fieldset><legend>Department</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Asset Status</legend>
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
			
			$content = '<br/><div class="ade">WORK TRADE</div>';
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
			$sethead = "['Work Trade ID','Work Trade'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
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
				$content = '<br/><div class="ade">ADD DATA FOR WORK TRADE</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_WTRADE.'">View</a></span> || <span><a href="'.PATH_WTRADE.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WTRADE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Criticality</legend>
								<table>
									<tr><td width="150"><span class="name"> Work Trade </td><td>:</td> </span></td><td>'.text_je(array('wtrade','','false')).'</td></tr>
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
						$sethead = "['Work Trade ID','Work Trade'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Trade_ID',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WTRADE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = WTRADE.' WHERE WorkTradeID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wtrade=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK TRADE FOR '.$wtrade.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WTRADE.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Trade</legend>
								<table>
									<tr><td width="150"><span class="name"> Work Trade </td><td>:</td> </span></td><td>'.text_je(array('wtrade',$wtrade,'false')).'</td></tr>
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
							<fieldset><legend>Criticality</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Asset Status</legend>
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
							<fieldset><legend>Position Employee</legend>
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
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
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
							<fieldset><legend>Employee Position</legend>
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
		
		//============Halaman MENU WORK ORDER Untuk Preventive============= 
		//=======NEW PAGE=====================
		//------ Work Order --------------
		else if(strcmp($_REQUEST['page'],'worder')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'UPDATE work_order SET Hidden="yes" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			} 
			
			/*------Get Pop Up Windows---------*/
			$content = pop_up('worder');
			
			$content .= '<br/><div class="ade">WORK ORDER</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			if(_DELETE_) $width = "[200,200,110,110,80,80,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
			else $width = "[200,200,110,110,80,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WORDER.' ORDER BY WO.WorkOrderNo DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WORDER.' ORDER BY WO.WorkOrderNo DESC'); 
			//-------set header pada handson------
			$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',renderer: 'html',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(WORDER.' ORDER BY WO.WorkOrderNo DESC',$field,array('Edit','Delete'),array(PATH_WORDER.EDIT,PATH_WORDER.DELETE),array(0),PATH_WORDER);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=1;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman upload excel-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD WO DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WORDER.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Upload Excel Employee</legend>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'/file/worder.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> Excel WO </td><td>:</td> </span></td><td>'.text_filebox(array('worder','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'/file/';
						$target_file = $target_dir.basename($_FILES['worder']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['worder']['size']>50000){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 && $sizeupload==0){
							$content .= '<div class="toptext" align="center" style="color:red">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['worder']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="toptext" align="center" style="color:red"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'worder');
								$content .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['worder']['name']).' has been uploaded</div>';
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$recdat = date('m/d/Y H:i'); //echo convert_date_time(array($recdat,1));
				$content = '<br/><div class="ade">ADD DATA FOR WORK ORDER</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Jika status sebagai manager ---------------//
				if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_){
					$addassignto = '
					<td width="120"><span class="name"> Assign to </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'assign','assign',180,'',$resultnow[9])).'</td>
						<td width="20"><td>
						<td width="120"></td>
					</tr>
					';
				}else{
					$addassignto = '';
				}
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_WORDER.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Order</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.datetime_je(array('recdate',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Require Date </td><td>:</td><td>'.datetime_je(array('reqdate',$recdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Estimated Date Start</td><td>:</td><td>'.datetime_je(array('eststart',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Estimated Date End </td><td>:</td><td>'.datetime_je(array('estend',$recdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Actual Date Start</td><td>:</td><td>'.datetime_je(array('actstart','',200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Actual Date End </td><td>:</td><td>'.datetime_je(array('actend','',200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Hand Over Date </td><td>:</td><td>'.datetime_je(array('hanover','',200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Accepted By </td><td>:</td><td>'.text_je(array('accept','','false')).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Department </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'department','department',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'','')).'</td>
									</tr>
									<tr>
									'.$addassignto.'
									<tr>
										<td width="120"><span class="name"> Requestor </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'request','request',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'>','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Problem Desc </td><td>:</td><td>'.text_je(array('prodesc','','true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Cause Desc </td><td>:</td><td>'.text_je(array('cause','','true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Action Taken </td><td>:</td><td>'.text_je(array('action','','true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Prevention Taken </td><td>:</td><td>'.text_je(array('prevent','','true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['recdate']) && !empty($_REQUEST['reqdate']) && !empty($_REQUEST['eststart']) && !empty($_REQUEST['estend'])){
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWORDER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $woid=get_new_code('WO',$numrow); 
						//-- Insert data pada kategori aset --//
						$recdate = convert_date_time(array($_REQUEST['recdate'],1)); $reqdate = convert_date_time(array($_REQUEST['reqdate'],1));
						$eststart = convert_date_time(array($_REQUEST['eststart'],1)); $estend = convert_date_time(array($_REQUEST['estend'],1));
						$actstart = convert_date_time(array($_REQUEST['actstart'],1)); $actend = convert_date_time(array($_REQUEST['actend'],1));
						$hanover = convert_date_time(array($_REQUEST['hanover'],1));
						
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/workorder/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>500000){ 
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 500KB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$info ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of image</div>.';
								}else{
									$info .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}

						//---Jika assign id yang update bukan manager maka---/
						if(empty($_REQUEST['assign']))
							$assign = 'EP000001';
						else
							$assign = $_REQUEST['assign'];
						
						if(empty(basename($_FILES['image']['name']))){
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,Created_By,DepartmentID) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$assign.'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$_SESSION['user'].'","'.$_REQUEST['department'].'")'; 
						}else{
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,ImagePath,Created_By,DepartmentID) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$assign.'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$target_file.'","'.$_REQUEST['department'].'")';
						} //echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WORDER.' AND WorkOrderNo="'.$woid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WORDER.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson).$info;
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}if(isset($_REQUEST['edit'])){ $info='';
				//------------Jika ada halaman edit data-------//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['recdate']) && !empty($_REQUEST['reqdate']) && !empty($_REQUEST['eststart']) && !empty($_REQUEST['estend'])){
						//-- Update data pada kategori aset --//
						$recdate = convert_date_time(array($_REQUEST['recdate'],1)); $reqdate = convert_date_time(array($_REQUEST['reqdate'],1));
						$eststart = convert_date_time(array($_REQUEST['eststart'],1)); $estend = convert_date_time(array($_REQUEST['estend'],1));
						$actstart = convert_date_time(array($_REQUEST['actstart'],1)); $actend = convert_date_time(array($_REQUEST['actend'],1));
						$hanover = convert_date_time(array($_REQUEST['hanover'],1));
						
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/workorder/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>500000){ 
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 500KB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$addinfo ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of image</div>.';
								}else{
									$addinfo .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						
						//---Jika assign id yang update bukan manager maka---/
						if(empty($_REQUEST['assign']))
							$assign = '';
						else
							$assign = ',  AssignID="'.$_REQUEST['assign'].'"';

						if(empty(basename($_FILES['image']['name']))){
							$qstate = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['rowid'].'"';
							$restate=mysql_exe_query(array($qstate,1)); $rnstate=mysql_exe_fetch_array(array($restate,1)); $wostate = $rnstate['15'];
							if($wostate==$_REQUEST['wostat']){
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}else{
								$date_mod=date('Y-m-d'); 
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", State_modified_date="'.$date_mod.'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}
							
						}else{
							$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", ImagePath="'.$target_file.'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
						}
						mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = WORDER.' AND WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_WORDER.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson).$addinfo;
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wonum=$resultnow[0]; $recdat = convert_date_time(array($resultnow[1],2)); $reqdat = convert_date_time(array($resultnow[2],2));
				$eststart = convert_date_time(array($resultnow[3],2)); $estend = convert_date_time(array($resultnow[4],2)); $actstart = convert_date_time(array($resultnow[5],2)); $actend = convert_date_time(array($resultnow[6],2)); $hanover = convert_date_time(array($resultnow[7],2));
				$pmstart = convert_date_time(array($resultnow[22],2)); $pmcompleted = convert_date_time(array($resultnow[23],2)); $pmtask = $resultnow[24]; $pmname = $resultnow[25]; $department=$resultnow[26];		
				//-----Cek if work type is preventive ----//
				$querycheck = 'SELECT WorkTypeDesc FROM work_type WHERE worktypeid="'.$resultnow[13].'"'; $resqcheck = mysql_exe_query(array($querycheck,1));
				$resnowqcheck = mysql_exe_fetch_array(array($resqcheck,1)); 
				if(strcmp($resnowqcheck[0],'Preventive')==0){
					$addfield ='
								<tr>
									<td width="120"><span class="name"> PM Traget Start</td><td>:</td><td>'.datetime_je(array('pmstart',$pmstart,200)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Target Completed </td><td>:</td><td>'.datetime_je(array('pmcompleted',$pmcompleted,200)).'</td>
									<td width="20"><td>
								</tr>
								<tr>
									<td width="120"><span class="name"> PM Name</td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmname','pname',180,'',$pmtask)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Task </td><td>:</td><td>'.combo_je(array(COMBPMGENG,'pmtask','pmtask',180,'',$pmname)).'</td>
									<td width="20"><td>
								</tr>
					'; 
				}else{
					$addfield ='';
				}
				
				//*********************Menggunakan fungsi create form******************//
				//2.&&&&---Form ke 2. Buat Form Step Of Work--&&&&
				//-----Eksekusi jika insert dilakukan--------
				if(isset($_REQUEST['stepwork'])){
					//-- Update Step Of Work dalam WO --//
					$field = array(
							'StepofWork');
					$value = array(
							'"'.$_REQUEST['stepw'].'"'); 
					$querystep = mysql_stat_update(array('work_order',$field,$value,'WorkOrderNo="'.$_REQUEST['rowid'].'"')); 
					mysql_exe_query(array($querystep,1)); 
				}
				$querystepwork2 = QSTEPWORK.' WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
				$resultstepwork2 = mysql_exe_query(array($querystepwork2,1)); $resultnowstepwork2=mysql_exe_fetch_array(array($resultstepwork2,1)); $stepwork=$resultnowstepwork2[0];
				$name_field=array('Step of Work');
				$input_type=array(
							text_je(array('stepw',$stepwork,'true','style="width:350px;height:300px"'))
						);
				$signtofill = array('');
				$stepwork = '<div title="Step of Work" style="padding:10px">'.create_form(array(TSTEPWORK,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].STEPWORK,1,$name_field,$input_type,$signtofill)).'</div>';
				
				//3.&&&&&&&&--Form ke 3. Buat Form Spare Part--&&&&
				if(isset($_REQUEST['spare'])){
					//-- Insert data pada kategori aset --//
					$field = array(
							'WorkOrderNo', 
							'itemspare');
					$value = array(
							'"'.$_REQUEST['rowid'].'"',
							'"'.$_REQUEST['spare'].'"'); 
					$query = mysql_stat_insert(array('invent_item_work_order',$field,$value)); 
					mysql_exe_query(array($query,1)); 
				}
				if(isset($_REQUEST['delspare']) && isset($_REQUEST['delete'])){
					$con = 'WorkOrderNo="'.$_REQUEST['wo'].'" AND itemspare="'.$_REQUEST['rowid'].'"'; 
					$sparepart = query_delete(array(PATH_WORDER.EDIT.'&rowid='.$_REQUEST['wo'], 'invent_item_work_order', $con));	
				}
	
				DEFINE('COMBSPAREWO','SELECT item_id, item_description FROM invent_item WHERE item_id NOT IN (SELECT itemspare FROM invent_item_work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'")');  
				$name_field=array('Spare Part');
				$input_type=array(
							combo_je(array(COMBSPAREWO,'spare','spare',180,'',''))
						);
				$signtofill = array('');
				$sparepart .= '<div title="Spare Part" style="padding:10px">'.create_form(array(TSPAREPART,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].PSPARE,1,$name_field,$input_type,$signtofill));
				
				$queryspare = QSPAREPART2.' AND WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				//-------set lebar kolom -------------
				$width = "[200,400,100,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id($queryspare);
				//-------get header pada sql----------
				$name = gen_mysql_head($queryspare);
				//-------set header pada handson------
				$sethead = "['Item Code','Item Name','Quantity'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Item_Code',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($queryspare,$field,array('Delete'),array(PATH_WORDER.EDIT.'&wo='.$_REQUEST['rowid'].DELPSPARE),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'sparepart');
				//--------fungsi hanya untuk meload data
				$sparepart.= '
							<div id="sparepart" style="width: 780px; height: 280px; overflow: hidden; font-size=10px;"></div>'.get_handson_id($sethandson).'</div>';
				
				//4.&&&&&&&&--Form ke 4. Buat Form Man Power--&&&&
				if(isset($_REQUEST['power'])){
					//-- Insert data pada kategori aset --//
					$field = array(
							'WorkOrderNo', 
							'EmployeeID');
					$value = array(
							'"'.$_REQUEST['rowid'].'"',
							'"'.$_REQUEST['mpow'].'"'); 
					$query = mysql_stat_insert(array('work_order_manpower',$field,$value)); 
					mysql_exe_query(array($query,1)); 
				}
				if(isset($_REQUEST['delmanpow']) && isset($_REQUEST['delete'])){
					$con = 'WorkOrderNo="'.$_REQUEST['wo'].'" AND EmployeeID="'.$_REQUEST['rowid'].'"'; 
					$sparepart = query_delete(array(PATH_WORDER.EDIT.'&rowid='.$_REQUEST['wo'], 'work_order_manpower', $con));	
				}
				DEFINE('COMBMANPOW','SELECT EmployeeID, FirstName FROM employee WHERE EmployeeID NOT IN (SELECT EmployeeID FROM work_order_manpower WHERE WorkOrderNo="'.$_REQUEST['rowid'].'")');  
				$name_field=array('Employee Name');
				$input_type=array(
							combo_je(array(COMBMANPOW,'mpow','mpow',180,'',''))
						);
				$signtofill = array('');
				$manpower = '<div title="Man Power" style="padding:10px">'.create_form(array(TMANPOWER,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].MANPOW,1,$name_field,$input_type,$signtofill));
				
				$queryspare = QMANPOWER.' AND WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				//-------set lebar kolom -------------
				$width = "[150,150,300,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id($queryspare);
				//-------get header pada sql----------
				$name = gen_mysql_head($queryspare);
				//-------set header pada handson------
				$sethead = "['ID','No ID','Name'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'ID',className: 'htLeft'},{data:'No_ID',className: 'htLeft'},{data:'Name',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($queryspare,$field,array('Delete'),array(PATH_WORDER.EDIT.'&wo='.$_REQUEST['rowid'].DELMANPOW),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'manpower');
				//--------fungsi hanya untuk meload data
				$manpower.= '
							<div id="manpower" style="width: 780px; height: 280px; overflow: hidden; font-size=10px;"></div>'.get_handson_id($sethandson).'</div>';
				//5.&&&&&&&&--Form ke 5. Buat Form Total Expense--&&&&
				if(isset($_REQUEST['expense'])){
					$field = array(
							'TotalExpense');
					$value = array(
							'"'.$_REQUEST['totalexp'].'"'); 
					$query = mysql_stat_update(array('work_order',$field,$value,'WorkOrderNo="'.$_REQUEST['rowid'].'"')); 
					mysql_exe_query(array($query,1)); 
				}
				$queryexp = 'SELECT TotalExpense FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				$resexp = mysql_exe_query(array($queryexp,1)); $resnowexp = mysql_exe_fetch_array(array($resexp,1)); 
				$name_field=array('Total Expense');
				$input_type=array(
							text_je(array('totalexp',$resnowexp[0],'false'))
						);
				$signtofill = array('<span style="color:red; font-size:12;"> Number</span>');
				$totalexp = '<div title="Total Expense" style="padding:10px">'.create_form(array(TMANPOWER,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].TEXP,1,$name_field,$input_type,$signtofill)).'</div>';
				
				//-----INDUK FORM----------------------------
				//-----Form ke 1. Buat Form Work Order-----
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK ORDER FOR '.$wonum.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_PRINT_.'</div>';
				//----- Jika status sebagai manager ---------------//
				if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_){
					$addassignto = '
					<td width="120"><span class="name"> Assign to </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'assign','assign',180,'',$resultnow[9])).'</td>
						<td width="20"><td>
						<td width="120"></td>
					</tr>
					';
				}else{
					$addassignto = '';
				}
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<div class="easyui-tabs" style="width:800px;height:500px;margin:auto">
							<div title="Work Order" style="padding:10px">
							<br/><div class="form-style-2"><form action="'.PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Order</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.datetime_je(array('recdate',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Require Date </td><td>:</td><td>'.datetime_je(array('reqdate',$reqdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Estimated Date Start</td><td>:</td><td>'.datetime_je(array('eststart',$eststart,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Estimated Date End </td><td>:</td><td>'.datetime_je(array('estend',$estend,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Actual Date Start</td><td>:</td><td>'.datetime_je(array('actstart',$actstart,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Actual Date End </td><td>:</td><td>'.datetime_je(array('actend',$actend,200)).'</td>
										<td width="20"><td>
									</tr>
									'.$addfield.'
									<tr>
										<td width="120"><span class="name"> Hand Over Date </td><td>:</td><td>'.datetime_je(array('hanover',$hanover,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Accepted By </td><td>:</td><td>'.text_je(array('accept',$resultnow[8],'false')).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Department </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'department','department',180,'',$resultnow[26])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'',$resultnow[10])).'</td>
									</tr>
									'.$addassignto.'
									<tr>
										<td width="120"><span class="name"> Requestor </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'request','request',180,'',$resultnow[11])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'',$resultnow[12])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'',$resultnow[13])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'',$resultnow[14])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'',$resultnow[15])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'',$resultnow[16])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,$resultnow[17],'')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Problem Desc </td><td>:</td><td>'.text_je(array('prodesc',$resultnow[18],'true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Cause Desc </td><td>:</td><td>'.text_je(array('cause',$resultnow[19],'true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Action Taken </td><td>:</td><td>'.text_je(array('action',$resultnow[20],'true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Prevention Taken </td><td>:</td><td>'.text_je(array('prevent',$resultnow[21],'true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div></div>
							'.$stepwork.$sparepart.$manpower.$totalexp.'
							</div>';
				$content.=$info;
			}if(isset($_REQUEST['print'])){
				$content = get_print(array('workderdoc',$_REQUEST['wo']));
			}
		}
		
		//============Halaman MENU MISC Untuk Preventive============= 
		//=======NEW PAGE=====================
		//------ PM Task List --------------
		else if(strcmp($_REQUEST['page'],'pmchek')==0){
			$content = '<br/><div class="ade">PM TASK LIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,300,800,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(PMCHEK);
			//-------get header pada sql----------
			$name = gen_mysql_head(PMCHEK);
			//-------set header pada handson------
			$sethead = "['Check List No','Check List Name','Task'"._USER_EDIT_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Check_List_No',className: 'htLeft'},{data:'Check_List_Name',className: 'htLeft'},{data:'Task',className: 'htLeft'}"._USER_EDIT_SETID_."]";
			//-------get data pada sql------------
			$dt = array(PMCHEK,$field,array('Edit'),array(PATH_PMCHEK.EDIT),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR PM TASK LIST</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_PMCHEK.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>PM Task List</legend>
								<table>
									<tr><td width="150"><span class="name"> PM Task Name </td><td>:</td> </span></td><td>'.text_je(array('pmname','','false')).'</td></tr>
									<tr><td width="150"><span class="name"> PM Check List </td><td>:</td> </span></td><td>'.text_je(array('pmlist','','true','style="width:150%;height:80px"')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['pmname']) && !empty($_REQUEST['pmlist'])){
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTPMCHEK,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $pmid=get_new_code('PM',$numrow); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO pm_checklist (CheckListNo ,CheckListName, Task) VALUES("'.$pmid.'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmlist'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = PMCHEK.' WHERE CheckListNo="'.$pmid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,300,800,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Check List No','Check List Name','Task'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Check_List_No',className: 'htLeft'},{data:'Check_List_Name',className: 'htLeft'},{data:'Task',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_CHEK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['pmname']) && !empty($_REQUEST['pmlist'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE pm_checklist SET CheckListName="'.$_REQUEST['pmname'].'", Task="'.$_REQUEST['pmlist'].'" WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = PMCHEK.' WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,300,800,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Check List No','Check List Name','Task'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Check_List_No',className: 'htLeft'},{data:'Check_List_Name',className: 'htLeft'},{data:'Task',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMCHEK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = PMCHEK.' WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$pmname=$resultnow[1]; $pmlist=$resultnow[2];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA PM TASK LIST FOR '.$pmname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_PMCHEK.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>PM Task List</legend>
								<table>
									<tr><td width="150"><span class="name"> PM Task Name </td><td>:</td> </span></td><td>'.text_je(array('pmname',$pmname,'false')).'</td></tr>
									<tr><td width="150"><span class="name"> PM Check List </td><td>:</td> </span></td><td>'.text_je(array('pmlist',$pmlist,'true','style="width:150%;height:80px"')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		
		//=======NEW PAGE=====================
		//------ PM Schedule --------------
		else if(strcmp($_REQUEST['page'],'pmsche')==0){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'UPDATE pm_schedule SET Hidden="yes" WHERE PM_ID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">Preventive Maintenance SCHEDULE</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			if(_DELETE_) $width = "[200,200,400,200,200,200,200,150,150,150,150,150,80,80]";
			else $width = "[200,200,400,200,200,200,200,150,150,150,150,150,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(PMSCHE.' ORDER BY PM_ID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(PMSCHE.' ORDER BY PM_ID DESC');
			//-------set header pada handson------
			$sethead = "['PM ID','PM Name','PM Task','Asset','Location','Work Trade','PM State','Frequency Unit','Initiate Date','Target Start Date','Target Comp_Date','Next Date'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'PM_ID',className: 'htLeft'},{data:'PM_Name',className: 'htLeft'},{data:'PM_Task',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Location',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'PM_State',className: 'htLeft'},{data:'Frequency_Unit',className: 'htLeft'},{data:'Initiate_Date',className: 'htLeft'},{data:'Target_Start_Date',className: 'htLeft'},{data:'Target_Comp_Date',className: 'htLeft'},{data:'Next_Date',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(PMSCHE.' ORDER BY PM_ID DESC',$field,array('Edit','Delete'),array(PATH_PMSCHE.EDIT,PATH_PMSCHE.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR Preventive Maintenance SCHEDULE SCHEDULE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Cek form pm yang digunakan berdasarkan asset atau location untuk mendefinisikan query berdasarkan kondisi tersebut ------//
				if(strcmp($_REQUEST['pmby'],'Asset')==0){
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
				}else if(strcmp($_REQUEST['pmby'],'Location')==0){
					$qpmby = COMLOCATN;
					$tpmby = 'Location';
				}else{
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
				}
				
				//----- Get Value for field work type for preventive  ----------
				$query = 'SELECT WorkTypeDesc FROM work_type WHERE WorkTypeDesc="Preventive"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1));
				//----- Buat Form Isian Berikut-----
				$indate = date('m/d/Y');
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMSCHE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>PM Schedule</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> PM By </span></td><td>:</td><td>'.combo_je_arr(array(array('Asset','Location'),'pmby','pmby',180,'',$_REQUEST['pmby'])).combobox_onselect(array(PATH_PMSCHE.ADD,'pmby',1)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> '.$tpmby.' </span></td><td>:</td><td>'.combo_je(array($qpmby,'pmbytype','pmbytype',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Generation Type </span></td><td>:</td><td>'.combo_je_arr(array(array('Schedule','Actual'),'pmgen','pmgen',180,'',$_REQUEST['dest'])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </span></td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </span></td><td>:</td><td>'.text_je(array('wotype',$result_now[0],'false','','','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Name </span></td><td>:</td><td>'.text_je(array('pmname','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Task </span></td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmtask','pmtask',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Status </span></td><td>:</td><td>'.combo_je_arr(array(array('Enable','Disable'),'pmstat','pmstat',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Frequency Unit </span></td><td>:</td><td>'.combo_je_arr(array(array('Days','Weeks','Months','Years'),'frequ','frequ',180,'','')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'frequ')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Frequency </span></td><td>:</td><td>'.text_je(array('freq','0','false','','freq')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'freq')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Days </span></td><td>:</td><td>'.text_je(array('days','0','false','','days','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Periode Days </span></td><td>:</td><td>'.text_je(array('wpdays','0','false','','wpdays')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'wpdays')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Initiate Date </span></td><td>:</td><td>'.date_je(array('indate',$indate)).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'indate')).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Target Start Date </span></td><td>:</td><td>'.date_je(array('tarsdate','')).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Target Completed Date </span></td><td>:</td><td>'.date_je(array('tarcdate','')).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Next Start Date </span></td><td>:</td><td>'.date_je(array('nextdate','')).' </td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['pmname'])){//convert_date(array($_REQUEST['wardat'],2));
						$indate = convert_date(array($_REQUEST['indate'],2)); $tarsdate = convert_date(array($_REQUEST['tarsdate'],2));
						$tarcdate = convert_date(array($_REQUEST['tarcdate'],2)); $nextdate = convert_date(array($_REQUEST['nextdate'],2));
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTPMSCHE,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $shid=get_new_code('SH',$numrow); 
						//-- Insert data pada kategori aset --//
						//----- Get Value for field work type id for preventive  ----------
						$query = 'SELECT WorkTypeID FROM work_type WHERE WorkTypeDesc="Preventive"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1));
						if(strcmp($_REQUEST['pmby'],'Asset')==0){
						$query = 'INSERT INTO pm_schedule (PM_ID,AssetID,PMGenType,PMWOTrade,WorkTypeId,PMName,ChecklistNo,PMState,FreqUnits,Frequency,PeriodDays,InitiateDate,TargetStartDate,TargetCompDate,NextDate) VALUES("'.$shid.'","'.$_REQUEST['pmbytype'].'","'.$_REQUEST['pmgen'].'","'.$_REQUEST['wotrade'].'","'.$result_now[0].'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmtask'].'","'.$_REQUEST['pmstat'].'","'.$_REQUEST['frequ'].'","'.$_REQUEST['freq'].'","'.$_REQUEST['wpdays'].'","'.$indate.'","'.$tarsdate.'","'.$tarcdate.'","'.$nextdate.'")'; 
						}
						else if(strcmp($_REQUEST['pmby'],'Location')==0){
						$query = 'INSERT INTO pm_schedule (PM_ID,LocationID,PMGenType,PMWOTrade,WorkTypeId,PMName,ChecklistNo,PMState,FreqUnits,Frequency,PeriodDays,InitiateDate,TargetStartDate,TargetCompDate,NextDate) VALUES("'.$shid.'","'.$_REQUEST['pmbytype'].'","'.$_REQUEST['pmgen'].'","'.$_REQUEST['wotrade'].'","'.$result_now[0].'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmtask'].'","'.$_REQUEST['pmstat'].'","'.$_REQUEST['frequ'].'","'.$_REQUEST['freq'].'","'.$_REQUEST['wpdays'].'","'.$indate.'","'.$tarsdate.'","'.$tarcdate.'","'.$nextdate.'")'; 
						}
						//echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = PMSCHE.' AND PM_ID="'.$shid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,200,200,200,200,150,150,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['PM ID','PM Name','PM Task','Asset','Location','Work Trade','PM State','Frequency Unit','Initiate Date','Target Start Date','Target Comp_Date','Next Date'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'PM_ID',className: 'htLeft'},{data:'PM_Name',className: 'htLeft'},{data:'PM_Task',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Location',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'PM_State',className: 'htLeft'},{data:'Frequency_Unit',className: 'htLeft'},{data:'Initiate_Date',className: 'htLeft'},{data:'Target_Start_Date',className: 'htLeft'},{data:'Target_Comp_Date',className: 'htLeft'},{data:'Next_Date',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMSCHE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['pmname'])){
						$indate = convert_date(array($_REQUEST['indate'],2)); $tarsdate = convert_date(array($_REQUEST['tarsdate'],2));
						$tarcdate = convert_date(array($_REQUEST['tarcdate'],2)); $nextdate = convert_date(array($_REQUEST['nextdate'],2));
						$query_locas = 'SELECT assetid, locationid FROM pm_schedule WHERE PM_ID="'.$_REQUEST['rowid'].'"'; 
						$result = mysql_exe_query(array($query_locas,1)); $result_now=mysql_exe_fetch_array(array($result,1)); $asset=$result_now[0]; $location=$result_now[1];
						
						//----- Get Value for field work type id for preventive  ----------
						$query = 'SELECT WorkTypeID FROM work_type WHERE WorkTypeDesc="Preventive"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1)); $worktype=$result_now[0];
						//-- Update data pada kategori aset --//
						if(!empty($asset)){
						$query = 'UPDATE pm_schedule SET AssetID="'.$_REQUEST['pmbytype'].'", PMGenType="'.$_REQUEST['pmgen'].'", PMWOTrade="'.$_REQUEST['wotrade'].'", WorkTypeId="'.$worktype.'", PMName="'.$_REQUEST['pmname'].'", ChecklistNo="'.$_REQUEST['pmtask'].'", PMState="'.$_REQUEST['pmstat'].'", FreqUnits="'.$_REQUEST['frequ'].'",Frequency="'.$_REQUEST['freq'].'", PeriodDays="'.$_REQUEST['wpdays'].'", InitiateDate="'.$indate.'", TargetStartDate="'.$tarsdate.'", TargetCompDate="'.$tarcdate.'",NextDate="'.$nextdate.'" WHERE PM_ID="'.$_REQUEST['rowid'].'"'; 
						}else if(!empty($location)){
						$query = 'UPDATE pm_schedule SET LocationID="'.$_REQUEST['pmbytype'].'", PMGenType="'.$_REQUEST['pmgen'].'", PMWOTrade="'.$_REQUEST['wotrade'].'", WorkTypeId="'.$worktype.'", PMName="'.$_REQUEST['pmname'].'", ChecklistNo="'.$_REQUEST['pmtask'].'", PMState="'.$_REQUEST['pmstat'].'", FreqUnits="'.$_REQUEST['frequ'].'",Frequency="'.$_REQUEST['freq'].'", PeriodDays="'.$_REQUEST['wpdays'].'", InitiateDate="'.$indate.'", TargetStartDate="'.$tarsdate.'", TargetCompDate="'.$tarcdate.'",NextDate="'.$nextdate.'" WHERE PM_ID="'.$_REQUEST['rowid'].'"';
						}
						//echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = PMSCHE.' AND PM_ID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,200,200,200,200,150,150,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['PM ID','PM Name','PM Task','Asset','Location','Work Trade','PM State','Frequency Unit','Initiate Date','Target Start Date','Target Comp_Date','Next Date'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'PM_ID',className: 'htLeft'},{data:'PM_Name',className: 'htLeft'},{data:'PM_Task',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Location',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'PM_State',className: 'htLeft'},{data:'Frequency_Unit',className: 'htLeft'},{data:'Initiate_Date',className: 'htLeft'},{data:'Target_Start_Date',className: 'htLeft'},{data:'Target_Comp_Date',className: 'htLeft'},{data:'Next_Date',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMSCHE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDPMSCHE.' WHERE PM_ID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $result_now=mysql_exe_fetch_array(array($result,1));
				$assetid = $result_now[0]; $locationid = $result_now[1]; $worktrade = $result_now[2]; $pmname = $result_now[3]; $pmtask = $result_now[4]; $pmstate = $result_now[5]; $frequnit = $result_now[6]; $frequency = $result_now[11]; $perioddays = $result_now[12]; 
				$worktype = $result_now[13]; $pmgentype = $result_now[14];
				$indate = convert_date(array($result_now[7],3)); $tarsdate = convert_date(array($result_now[8],3));
				$tarcdate = convert_date(array($result_now[9],3)); $nextdate = convert_date(array($result_now[10],3));
				$days = 0;
				if(strcmp($frequnit,'Days')==0) $days=$frequency*1; else if(strcmp($frequnit,'Weeks')==0) $days=$frequency*7;
				else if(strcmp($frequnit,'Months')==0) $days=$frequency*28; else if(strcmp($frequnit,'Years')==0) $days=$frequency*365;
				
				//----- Get Value for field work type for preventive  ----------
				$query = 'SELECT WorkTypeDesc FROM work_type WHERE WorkTypeID="'.$worktype.'"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1)); $worktype = $result_now[0];
				
				//----- Cek form pm yang digunakan berdasarkan asset atau location untuk mendefinisikan query berdasarkan kondisi tersebut ------//
				if(!empty($assetid)){
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
					$idpmby = $assetid;
				}else if(!empty($locationid)){
					$qpmby = COMLOCATN;
					$tpmby = 'Location';
					$idpmby = $locationid;
				}else{
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
				}
				
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA PM SCHEDULE FOR '.$pmname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMSCHE.EDIT.POST.'&rowid='.$_REQUEST['rowid'].'" method="post" enctype="multipart/form-data">
							<fieldset><legend>PM Schedule</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> '.$tpmby.' </span></td><td>:</td><td>'.combo_je(array($qpmby,'pmbytype','pmbytype',180,'',$idpmby)).'</td>
										<td width="20"><td>
										<td width="120"></td><td></td><td></td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Generation Type </span></td><td>:</td><td>'.combo_je_arr(array(array('Schedule','Actual'),'pmgen','pmgen',180,'',$pmgentype)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </span></td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'',$worktrade)).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </span></td><td>:</td><td>'.text_je(array('wotype',$worktype,'false','','','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Name </span></td><td>:</td><td>'.text_je(array('pmname',$pmname,'false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Task </span></td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmtask','pmtask',180,'',$pmtask)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Status </span></td><td>:</td><td>'.combo_je_arr(array(array('Enable','Disable'),'pmstat','pmstat',180,'',$pmstate)).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Frequency Unit </span></td><td>:</td><td>'.combo_je_arr(array(array('Days','Weeks','Months','Years'),'frequ','frequ',180,'',$frequnit)).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'frequ')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Frequency </span></td><td>:</td><td>'.text_je(array('freq',$frequency,'false','','freq')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'freq')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Days </span></td><td>:</td><td>'.text_je(array('days',$days,'false','','days','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Periode Days </span></td><td>:</td><td>'.text_je(array('wpdays',$perioddays,'false','','wpdays')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'wpdays')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Initiate Date </span></td><td>:</td><td>'.date_je(array('indate',$indate)).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'indate')).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Target Start Date </span></td><td>:</td><td>'.date_je(array('tarsdate',$tarsdate)).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Target Completed Date </span></td><td>:</td><td>'.date_je(array('tarcdate',$tarcdate)).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Next Start Date </span></td><td>:</td><td>'.date_je(array('nextdate',$nextdate)).' </td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
		}
		
		//=======NEW PAGE=====================
		//------ PM Schedule --------------
		else if(strcmp($_REQUEST['page'],'pmgene')==0){ 
			$content = '<br/><div class="ade">Preventive Maintenance Generation</div>';
			$content .= '<form action="'.PATH_PMGENE.GEN.POST.'" method="post" enctype="multipart/form-data">';
			$content .= '<br/><div align="center"><span class="name"> PM Name : </span>'.combo_je(array(COMBPMGENE,'pmgene','pmgene',180,'',$_REQUEST['pmgene'])).'</div>
						<div align="center" style="margin:4 1 2 1;">'.date_je(array('start',$_REQUEST['start'])).' - '.date_je(array('end',$_REQUEST['end'])).'</div>
						<div align="center" style="margin:4 1 1 1;"><input class="form-submit" type="submit" value="Show More Planning PM Schedule"></div>';
			$content .= '</form>'; 
			
			//---------------------Update pmschedule and create a new WO-------------------------
			if(isset($_REQUEST['wo'])){
				$query = 'UPDATE pm_schedule SET TargetStartDate="'.$_REQUEST['startdate'].'", TargetCompDate="'.$_REQUEST['compdate'].'", NextDate="'.$_REQUEST['nextdate'].'" WHERE PM_ID="'.$_REQUEST['pmid'].'"';
				mysql_exe_query(array($query,1));
				$inquery .= str_replace('+-*','"',$_REQUEST['inquery']);
				mysql_exe_query(array($inquery,1));
				//echo $query.'<br/>'.$inquery;
				$content .= '<div class="toptext" align="center" style="color:green">Already Create Work Order for PM '.$_REQUEST['pmid'].'</div>';
			}
			
			if(isset($_REQUEST['gen'])){
				if(isset($_REQUEST['post'])){ 
					$query = 'SELECT P.FreqUnits, P.Frequency, P.PeriodDays, P.TargetStartDate, P.PM_ID, P.PMGenType, P.AssetID, P.LocationID, P.PMWOTrade, P.ChecklistNo, M.CheckListName, P.WorkTypeId FROM pm_schedule P, pm_checklist M WHERE P.ChecklistNo=M.CheckListNo AND P.PM_ID="'.$_REQUEST['pmgene'].'"';
					$result = mysql_exe_query(array($query,1)); $result_now = mysql_exe_fetch_array(array($result,1));
					$fun = $result_now[0]; $freq = $result_now[1]; $Pdays = $result_now[2]; $TstartDate = $result_now[3]; $PMName = $result_now[4];
					$PMGenType = $result_now[5]; $asset = $result_now[6]; $location = $result_now[7]; $wotrade = $result_now[8]; $pmtask = $result_now[9]; $problem = $result_now[10]; $wotype = $result_now[11]; //echo $wotype;
					if(strcmp($fun,'Days')==0) $freq=$freq*1; else if(strcmp($fun,'Weeks')==0) $freq=$freq*7; else if(strcmp($fun,'Months')==0) $freq=$freq*28; else if(strcmp($fun,'Years')==0) $freq=$freq*365; 
					//$TstartDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days')); 
					
					//=====Get date from posting and define all variable ===========
					$start = convert_date(array($_REQUEST['start'],2)); $end = convert_date(array($_REQUEST['end'],2)); $data = array(); $value='';
					if($TstartDate<$start || $TstartDate>$end){
						$content .= '<div class="toptext" align="center" style="color:red">Target Start Date of '.$PMName.' Out Of This Date Range</div>';
						if($TstartDate<$start){
							$content .= '<div class="toptext" align="center" style="color:red">Target Start Date less than Input of Start Date</div>';
						}else if($TstartDate>$end){
							$content .= '<div class="toptext" align="center" style="color:red">Target Start Date more than Input of End Date</div>';
						}
					}else{
						//-- Get last id --//
						$result = mysql_exe_query(array(COUNTWORDER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1;
						if(strcmp($PMGenType,'Schedule')==0){
							if(!empty($asset)){
								$queryasset = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND AssetID="'.$asset.'" AND AssetStatusID="AK000001"'; $asres = mysql_exe_query(array($queryasset,1)); $asres_now = mysql_exe_fetch_array(array($asres,1));
								//------Hanya untuk mengecek asset yang diquery tidak bernilai 0 atau status aktif--
								$rows = mysql_exe_num_rows(array($asres,1)); 
								//---------------------------------------------------------------------------------
								$i=0;
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days'));
								while($TstartDate<=$end && $rows>0){
									$data[$i][0]=$PMName; $data[$i][1]=$asres_now[1]; $data[$i][2]=$asres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
									$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$asres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
									//$content.= $PMName.' -- '.$asres_now[1].' -- '.$asres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
									$TstartDate = $TnextDate;
									$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
									$i++;
								}
							}else if(!empty($location)){
								$querylocation = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND L.LocationID="'.$location.'" AND AssetStatusID="AK000001"'; $locres = mysql_exe_query(array($querylocation,1)); 
								$i=0;
								$dateStart = $TstartDate;
								while($locres_now = mysql_exe_fetch_array(array($locres,1))){
									$TstartDate = $dateStart;
									$TcompDate = date ("Y-m-d", strtotime ($dateStart .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($dateStart .'+'.$freq.' days'));
									while($TstartDate<=$end){
										$data[$i][0]=$PMName; $data[$i][1]=$locres_now[1]; $data[$i][2]=$locres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
										$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$locres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
										//$content.= $PMName.' -- '.$locres_now[1].' -- '.$locres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
										$TstartDate = $TnextDate;
										$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
										$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
										$i++;
									}	
								}	
							}
							
						}else if(strcmp($PMGenType,'Actual')==0){
							if(!empty($asset)){
								$queryasset = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND AssetID="'.$asset.'" AND AssetStatusID="AK000001"'; $asres = mysql_exe_query(array($queryasset,1)); $asres_now = mysql_exe_fetch_array(array($asres,1));
								$i=0;
								//------Hanya untuk mengecek asset yang diquery tidak bernilai 0 atau status aktif--
								$rows = mysql_exe_num_rows(array($asres,1)); 
								//----------------------------------------------------------------------------------
								if($rows>0){
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days'));
								$data[$i][0]=$PMName; $data[$i][1]=$asres_now[1]; $data[$i][2]=$asres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
								$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$asres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
								//----Define for nedt date pm -------------
								$TstartDate = $TnextDate;
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
								}
								//$content.= $PMName.' -- '.$asres_now[1].' -- '.$asres_now[3].' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
							}else if(!empty($location)){
								$querylocation = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND L.LocationID="'.$location.'" AND AssetStatusID="AK000001"'; $locres = mysql_exe_query(array($querylocation,1)); 
								$i=0;
								$dateStart = $TstartDate;
								while($locres_now = mysql_exe_fetch_array(array($locres,1))){
									$TstartDate = $dateStart;
									$TcompDate = date ("Y-m-d", strtotime ($dateStart .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($dateStart .'+'.$freq.' days'));
									$data[$i][0]=$PMName; $data[$i][1]=$locres_now[1]; $data[$i][2]=$locres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate;
									$data[$i][6]=get_new_code('WO',$numrow++);
									$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$locres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
									//----Define for nedt date pm -------------
									$TstartDate = $TnextDate;
									$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
									//$content.= $PMName.' -- '.$locres_now[1].' -- '.$locres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
									$i++;
								}
							}
						}
						//print_r($data);
						$inquery =  substr('INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,PMID,PMTaskID,PMTarStartDate,PMTarCompDate,Created_By) VALUES '.$value,0,-1); 
						$inquery = str_replace('"','+-*',$inquery);
						
						//--------------------- Add form for generate WO from PO ------------------/
						if(_USER_INSERT_){
						$content .= '
							<form style="margin:4 1 1 1;" action="'.PATH_PMGENE.WO.'" method="post" enctype="multipart/form-data">
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="inquery" value="'.$inquery.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="pmid" value="'.$PMName.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="startdate" value="'.$TstartDate.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="compdate" value="'.$TcompDate.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="nextdate" value="'.$TnextDate.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input class="form-submit" type="submit" value="Generate Work Order" /></div>
							</form>
						';
						}
						$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,400,150,150,150,150]";
						//-------get id pada sql -------------
						$field = array('pmname','asset','location','startdate','compdate','nextdate');
						//-------get header pada sql----------
						//$name = gen_mysql_head(POSITI.' ORDER BY PositionID DESC');
						//-------set header pada handson------
						$sethead = "['PM Name','Asset','Location','Start Date','Complete Date','Next Date']";
						//-------set id pada handson----------
						$setid = "[{data:'pmname',className: 'htLeft'},{data:'asset',className: 'htLeft'},{data:'location',className: 'htLeft'},{data:'startdate',className: 'htLeft'},{data:'compdate',className: 'htLeft'},{data:'nextdate',className: 'htLeft'}]";
						//-------get data pada sql------------
						$dt = array($data,$field,'','');
						$data = get_data_handson_array($dt);
						//----Fungsi memanggil data handsontable melalui javascript---
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						//--------fungsi hanya untuk meload data
						$content .= get_handson($sethandson);
					}
				}
			}
		}
		
		//------ Work Order --------------
		else if(strcmp($_REQUEST['page'],'pmlist')==0){
			/*------Get Pop Up Windows---------*/
			$content = pop_up('pmlist');
			
			$content .= '<br/><div class="ade">PREVENTIVE MAINTENANCE LIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,200,80,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC');
			//-------set header pada handson------
			$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status'"._USER_EDIT_SETHEAD_.",'Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
			//-------set id pada handson----------
			$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'}"._USER_EDIT_SETID_.",{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC',$field,array('Edit'),array(PATH_PMLIST.EDIT),array(0),PATH_PMLIST);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=1;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$recdat = date('m/d/Y H:i'); //echo convert_date_time(array($recdat,1));
				$content = '<br/><div class="ade">ADD DATA FOR PREVENTIVE MAINTENANCE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMLIST.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Order</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.datetime_je(array('recdate',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Require Date </td><td>:</td><td>'.datetime_je(array('reqdate',$recdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Estimated Date Start</td><td>:</td><td>'.datetime_je(array('eststart',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Estimated Date End </td><td>:</td><td>'.datetime_je(array('estend',$recdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Actual Date Start</td><td>:</td><td>'.datetime_je(array('actstart','',200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Actual Date End </td><td>:</td><td>'.datetime_je(array('actend','',200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Hand Over Date </td><td>:</td><td>'.datetime_je(array('hanover','',200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Accepted By </td><td>:</td><td>'.text_je(array('accept','','false')).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Assign to </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'assign','assign',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Requestor </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'request','request',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'>','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Problem Desc </td><td>:</td><td>'.text_je(array('prodesc','','true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Cause Desc </td><td>:</td><td>'.text_je(array('cause','','true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Action Taken </td><td>:</td><td>'.text_je(array('action','','true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Prevention Taken </td><td>:</td><td>'.text_je(array('prevent','','true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['recdate']) && !empty($_REQUEST['reqdate']) && !empty($_REQUEST['eststart']) && !empty($_REQUEST['estend'])){
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWORDER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $woid=get_new_code('WO',$numrow); 
						//-- Insert data pada kategori aset --//
						$recdate = convert_date_time(array($_REQUEST['recdate'],1)); $reqdate = convert_date_time(array($_REQUEST['reqdate'],1));
						$eststart = convert_date_time(array($_REQUEST['eststart'],1)); $estend = convert_date_time(array($_REQUEST['estend'],1));
						$actstart = convert_date_time(array($_REQUEST['actstart'],1)); $actend = convert_date_time(array($_REQUEST['actend'],1));
						$hanover = convert_date_time(array($_REQUEST['hanover'],1));
						
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/workorder/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>2000000){ 
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 2MB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$info .= '<div class="toptext" align="center" style="color:red">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$info ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of image</div>.';
								}else{
									$info .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						
						if(empty(basename($_FILES['image']['name']))){
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,Created_By) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$_REQUEST['assign'].'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$_SESSION['user'].'")'; 
						}else{
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,ImagePath,Created_By) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$_REQUEST['assign'].'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$target_file.'","'.$_SESSION['user'].'")';
						} //echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WORDER.' AND WorkOrderNo="'.$woid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMLIST.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson).$info;
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}if(isset($_REQUEST['edit'])){ $info='';
				//------------Jika ada halaman edit data-------//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['recdate']) && !empty($_REQUEST['reqdate']) && !empty($_REQUEST['eststart']) && !empty($_REQUEST['estend'])){
						//-- Update data pada kategori aset --//
						$recdate = convert_date_time(array($_REQUEST['recdate'],1)); $reqdate = convert_date_time(array($_REQUEST['reqdate'],1));
						$eststart = convert_date_time(array($_REQUEST['eststart'],1)); $estend = convert_date_time(array($_REQUEST['estend'],1));
						$actstart = convert_date_time(array($_REQUEST['actstart'],1)); $actend = convert_date_time(array($_REQUEST['actend'],1));
						$hanover = convert_date_time(array($_REQUEST['hanover'],1));
						
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/workorder/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>2000000){ 
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, your files is too large (Max 2MB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$addinfo .= '<div class="toptext" align="center" style="color:red">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$addinfo ='<div class="toptext" align="center" style="color:red"> You havent upload image. Empty Field of image</div>.';
								}else{
									$addinfo .= '<div class="toptext" align="center" style="color:green"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						
						//---Jika assign id yang update bukan manager maka---/
						if(empty($_REQUEST['assign']))
							$assign = '';
						else
							$assign = ',  AssignID="'.$_REQUEST['assign'].'"';
						
						if(empty(basename($_FILES['image']['name']))){
							$qstate = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['rowid'].'"';
							$restate=mysql_exe_query(array($qstate,1)); $rnstate=mysql_exe_fetch_array(array($restate,1)); $wostate = $rnstate['15'];
							if($wostate==$_REQUEST['wostat']){
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}else{
								$date_mod=date('Y-m-d'); 
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", State_modified_date="'.$date_mod.'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}
						}
						mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = WORDER.' AND WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMLIST.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson).$addinfo;
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wonum=$resultnow[0]; $recdat = convert_date_time(array($resultnow[1],2)); $reqdat = convert_date_time(array($resultnow[2],2));
				$eststart = convert_date_time(array($resultnow[3],2)); $estend = convert_date_time(array($resultnow[4],2)); $actstart = convert_date_time(array($resultnow[5],2)); $actend = convert_date_time(array($resultnow[6],2)); $hanover = convert_date_time(array($resultnow[7],2));
				$pmstart = convert_date_time(array($resultnow[22],2)); $pmcompleted = convert_date_time(array($resultnow[23],2)); $pmtask = $resultnow[24]; $pmname = $resultnow[25]; $department = $resultnow[26];		
				//-----Cek if work type is preventive ----//
				$querycheck = 'SELECT WorkTypeDesc FROM work_type WHERE worktypeid="'.$resultnow[13].'"'; $resqcheck = mysql_exe_query(array($querycheck,1));
				$resnowqcheck = mysql_exe_fetch_array(array($resqcheck,1)); 
				if(strcmp($resnowqcheck[0],'Preventive')==0){
					$addfield ='
								<tr>
									<td width="120"><span class="name"> PM Traget Start</td><td>:</td><td>'.datetime_je(array('pmstart',$pmstart,200)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Target Completed </td><td>:</td><td>'.datetime_je(array('pmcompleted',$pmcompleted,200)).'</td>
									<td width="20"><td>
								</tr>
								<tr>
									<td width="120"><span class="name"> PM Name</td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmname','pname',180,'',$pmname)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Task </td><td>:</td><td>'.combo_je(array(COMBPMGENG,'pmtask','pmtask',180,'',$pmtask)).'</td>
									<td width="20"><td>
								</tr>
					'; 
				}else{
					$addfield ='';
				}
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA PREVENTIVE MAINTENANCE FOR '.$wonum.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Jika status sebagai manager ---------------//
				if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_){
					$addassignto = '
					<td width="120"><span class="name"> Assign to </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'assign','assign',180,'',$resultnow[9])).'</td>
						<td width="20"><td>
						<td width="120"></td>
					</tr>
					';
				}else{
					$addassignto = '';
				}
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Employee Position</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.datetime_je(array('recdate',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Require Date </td><td>:</td><td>'.datetime_je(array('reqdate',$reqdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Estimated Date Start</td><td>:</td><td>'.datetime_je(array('eststart',$eststart,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Estimated Date End </td><td>:</td><td>'.datetime_je(array('estend',$estend,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Actual Date Start</td><td>:</td><td>'.datetime_je(array('actstart',$actstart,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Actual Date End </td><td>:</td><td>'.datetime_je(array('actend',$actend,200)).'</td>
										<td width="20"><td>
									</tr>
									'.$addfield.'
									<tr>
										<td width="120"><span class="name"> Hand Over Date </td><td>:</td><td>'.datetime_je(array('hanover',$hanover,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Accepted By </td><td>:</td><td>'.text_je(array('accept',$resultnow[8],'false')).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Department </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'department','department',180,'',$resultnow[26])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'',$resultnow[10])).'</td>
									</tr>
									<tr>
									'.$addassignto.'
									<tr>
										<td width="120"><span class="name"> Requestor </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'request','request',180,'',$resultnow[11])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'',$resultnow[12])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'',$resultnow[13])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'',$resultnow[14])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'',$resultnow[15])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'',$resultnow[16])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,$resultnow[17],'')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Problem Desc </td><td>:</td><td>'.text_je(array('prodesc',$resultnow[18],'true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Cause Desc </td><td>:</td><td>'.text_je(array('cause',$resultnow[19],'true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Action Taken </td><td>:</td><td>'.text_je(array('action',$resultnow[20],'true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Prevention Taken </td><td>:</td><td>'.text_je(array('prevent',$resultnow[21],'true','style="width:200px;height:80px"')).'</td>
									</tr>
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
	
	function pop_up($definepage){ $content = '';
	
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
			$page = PATH_ASSETS.'&dataid='.$_REQUEST['dataid'].'#popup-article';
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

		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
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
		if(strcmp($definepage,'worder')==0){
			$page = PATH_WORDER.'&dataid='.$_REQUEST['dataid'].'#popup-article';
		}else if(strcmp($definepage,'pmlist')==0){
			$page = PATH_PMLIST.'&dataid='.$_REQUEST['dataid'].'#popup-article';
		}
		
		//--------------Generate QR CODE------------------------------------------------
		if(empty($result_now[22])){
			$target_dir = _ROOT_.'file/qrcode/';
			$qrcodeFilePath = $target_dir.md5($_REQUEST['dataid']).'.png';
			QRcode::png($_REQUEST['dataid'], $qrcodeFilePath,QR_ECLEVEL_L, 4);   
			$page = PATH_WORDER.'&dataid='.$_REQUEST['dataid'].'#popup-article';
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
				<img src="'.$result_now[21].'" class="popup__media popup__media_right" alt="No Image of Asset" style="max-width:300px;max-height:300px;">
				<img src="'.$result_now[22].'" class="popup__media popup__media_right" alt="No QR Code of WO" style="max-width:300px;max-height:300px;">
				<table class="text-popup">
				<tr height="30"><td>WO State </td><td> : </td><td><form action="'.$page.'" method="post" enctype="multipart/form-data">'.combo_je(array(COMWOSTAT,'state','state',180,'',$edresult_now[15])).' <input class="form-submit" type="submit" value="Update"></form>
				</td>
				<tr height="30"><td>Asset Name </td><td> : </td><td>'.$result_now[11].'</td>
				<tr height="30"><td>WO Priority </td><td> : </td><td>'.$result_now[10].'</td>
				<tr height="30"><td>WO Type </td><td> : </td><td>'.$result_now[13].'</td>
				<tr height="30"><td>WO Trade </td><td> : </td><td>'.$result_now[15].'</td>
				<tr height="30"><td>Created By </td><td> : </td><td>'.$result_now[9].'</td>
				<tr height="30"><td>Requestor </td><td> : </td><td>'.$result_now[10].'</td>
				<tr height="30"><td>Assign To </td><td> : </td><td>'.$result_now[8].'</td>
				<tr height="30"><td>Receive Date </td><td> : </td><td>'.$result_now[1].'</td>
				<tr height="30"><td>Require Date </td><td> : </td><td>'.$result_now[2].'</td>
				<tr height="30"><td>Estimate Date Start</td><td> : </td><td>'.$result_now[3].'</td>
				<tr height="30"><td>Estimate Date End</td><td> : </td><td>'.$result_now[4].'</td>
				<tr height="30"><td>Actual Date Start</td><td> : </td><td>'.$result_now[5].'</td>
				<tr height="30"><td>Actual Date Start</td><td> : </td><td>'.$result_now[6].'</td>
				<tr height="30"><td>Handover Date Start</td><td> : </td><td>'.$result_now[7].'</td>
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
#########################################################################################################################################	
?>