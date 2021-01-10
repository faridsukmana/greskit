<?php
//error_reporting(0);
########################################################## KHUSUS HALAMAN WEB#############################################################
	function get_page(){
	/*---------------------------------------
	$access = get_permitted(ACCESS,'access');
	$view = get_permitted(ACCESS,'view');
	$edit = get_permitted(ACCESS,'edit'); 
	---------------------------------------*/
	
	if(_ACCESS_){	
		//========Halaman jika terjadi logout=======
		if(isset($_REQUEST['logout'])){ 
			$content = logout();
		}
		
		//========Halaman contoh penggunaan Highchart=======
		else if(isset($_REQUEST['home'])){
			$level['Administrator'] = 0; $level['Manager Level 1'] = 0;
			$level['Technician'] = 0; $level['Manager Level 2'] = 0;
			$query = 'SELECT D.group_name Group_Name, COUNT(D.group_name) Total FROM tb_permit C, tb_user_group D WHERE C.id_group=D.id_group GROUP BY D.group_name';
			$result = mysql_exe_query(array($query,1)); 
			while ($resultnow=mysql_exe_fetch_array(array($result,1))){
				$level[$resultnow[0]]=$resultnow[1];
			}
		
			$content = '
			<div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$level['Administrator'].'</div>
                                    <div>Administrator</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_PERM.'&idgroup=GROUP181120033150">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bolt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$level['Technician'].'</div>
                                    <div>Technician</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_PERM.'&idgroup=GROUP181120025602">
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
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$level['Manager Level 1'].'</div>
                                    <div>Manager Level 1</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_PERM.'&idgroup=GROUP181120051048">
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
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">'.$level['Manager Level 2'].'</div>
                                    <div>Manager Level 2</div>
                                </div>
                            </div>
                        </div>
                        <a href="'.PATH_PERM.'&idgroup=GROUP181120024659">
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
			
			//***********SERVICE MAINTENANCE***********//
			$query = 'SELECT C.id_permit Permit_ID, C.user_p Username, B.first_name First_Name, B.last_name Last_Name, C.application Application, D.group_name Group_Apps FROM tb_user B, tb_permit C, tb_user_group D WHERE C.id_group=D.id_group AND B.username=C.user_p AND C.application="Service and Maintenance"';
			$width = "[240,240,240,240]";
			$field = gen_mysql_id($query);
			$name = gen_mysql_head($query);
			$sethead = "['Username','First Name','Last Name','Group']";
			$setid = "[{data:'Username',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Group_Apps',className: 'htLeft'}]";
			$dt = array($query,$field,array(),array(),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'service');
			$service= '<div id="service" style="width: 1040px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********ADMINISTRATION***********//
			$query = 'SELECT C.id_permit Permit_ID, C.user_p Username, B.first_name First_Name, B.last_name Last_Name, C.application Application, D.group_name Group_Apps FROM tb_user B, tb_permit C, tb_user_group D WHERE C.id_group=D.id_group AND B.username=C.user_p AND C.application="Administration"';
			$width = "[240,240,240,240]";
			$field = gen_mysql_id($query);
			$name = gen_mysql_head($query);
			$sethead = "['Username','First Name','Last Name','Group']";
			$setid = "[{data:'Username',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Group_Apps',className: 'htLeft'}]";
			$dt = array($query,$field,array(),array(),array());
			$data = get_data_handson_func($dt);
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'admin');
			$admin= '<div id="admin" style="width: 1040px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			$table .= '
					<table>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">Administration</div></td></tr>
							<tr><td>'.$admin.'</td></tr>
							</table>
						</td>
						</tr>
						<tr>
						<td>
							<table>
							<tr><td><div class="ade">Service Maintenance</div></td></tr>
							<tr><td>'.$service.'</td></tr>
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
								<i class="fa  fa-info fa-fw"></i> Info
							</div>
							<!-- /.panel-heading -->
							<div class="panel-body">
								<div id="tab1">'.$table.'</div>
							</div>
							<!-- /.panel-body -->
						</div>
						<!-- /.panel -->
					</div>
				</div>
			';			
		
			//return $content;			
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
		
		//=====================*******************************MENU ACCOUNT*****************************=====================
		//=======NEW PAGE=====================
		//------ Account --------------
		else if(strcmp($_REQUEST['page'],'user')==0){
			$result = mysql_exe_query(array(COUNTUSER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]; 
			$content .= '<br/><div class="ade">'.TUSER.'</div>';
			if($numrow==10 || $numrow>10)
			$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_USER.'">View</a></div>';
			else
			$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_USER.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_USER.ADD.'">Add</a></span></div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[100,100,150,150,150,200,150,80,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(USER.' ORDER BY id_user DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(USER.' ORDER BY id_user DESC');
			//-------set header pada handson------
			$sethead = "['User ID','Username','First_name','Nick Name','Last Name','Email','Employee','Modified','Password']";
			//-------set id pada handson----------
			$setid = "[{data:'User_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Nick_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Email',className: 'htLeft'},{data:'Employee',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Change',renderer: 'html'}]";
			//-------get data pada sql------------
			$dt = array(USER.' ORDER BY id_user DESC LIMIT 0,10',$field,array('Edit','Change'),array(PATH_USER.EDIT,PATH_USER.PASS),array(),PATH_USER);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TAUSER.'</div>';
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_USER.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_USER.ADD.'">Add</a></span></div>';
				//-----Quey data employee untuk isian combobox tambah data user
				$query_employee = 'SELECT EmployeeID, FirstName FROM employee';
				//----- Buat Form Isian Berikut-----
				$name_field=array('First Name','Nick Name','Last Name','Email','Username','Password','employee');
				$input_type=array(
							text_je(array('firstname','','false')),
							text_je(array('nickname','','false')),
							text_je(array('lastname','','false')),
							text_je(array('email','','false')),
							text_je(array('username','','false')),
							text_pass(array('password','','false')),
							combo_je(array($query_employee,'employee','employee',225,'<option value="">-</option>',''))
						);
				$signtofill = array('*','','','','*','*');
				$content .= create_form(array(FAUSER,PATH_USER.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['firstname']) && !empty($_REQUEST['username']) && !empty($_REQUEST['password'])){
						//-- Generate a new id untuk kategori aset --// 
						$result = mysql_exe_query(array(COUNTUSER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $userid=get_new_code(array('US',$numrow,2)); 
						//-- Insert data pada kategori aset --//
						$field = array(
								'id_user', 
								'username', 
								'password', 
								'first_name', 
								'nick_name', 
								'last_name', 
								'email',
								'id_employee');
						$value = array(
								'"'.$userid.'"',
								'"'.$_REQUEST['username'].'"',
								'SHA1("'.$_REQUEST['password'].'")',
								'"'.$_REQUEST['firstname'].'"',
								'"'.$_REQUEST['nickname'].'"',
								'"'.$_REQUEST['lastname'].'"',
								'"'.$_REQUEST['email'].'"',
								'"'.$_REQUEST['employee'].'"'); 
						$query = mysql_stat_insert(array('tb_user',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = USER.' WHERE id_user="'.$userid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[100,100,150,150,150,200,150,80,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(USER.' ORDER BY id_user DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(USER.' ORDER BY id_user DESC');
						//-------set header pada handson------
						$sethead = "['User ID','Username','First_name','Nick Name','Last Name','Email','Employee','Modified','Password']";
						//-------set id pada handson----------
						$setid = "[{data:'User_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Nick_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Email',className: 'htLeft'},{data:'Employee',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Change',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Change'),array(PATH_USER.EDIT,PATH_USER.PASS),array(),PATH_USER);
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
					if(!empty($_REQUEST['firstname']) && !empty($_REQUEST['username'])){
						//-- Update data pada kategori aset --//
						$field = array(
								'username',  
								'first_name', 
								'nick_name', 
								'last_name', 
								'email',
								'id_employee');
						$value = array(
								'"'.$_REQUEST['username'].'"',
								'"'.$_REQUEST['firstname'].'"',
								'"'.$_REQUEST['nickname'].'"',
								'"'.$_REQUEST['lastname'].'"',
								'"'.$_REQUEST['email'].'"',
								'"'.$_REQUEST['employee'].'"');
						$query = mysql_stat_update(array('tb_user',$field,$value,'id_user="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = USER.' WHERE id_user="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[100,100,150,150,150,200,150,80,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(USER.' ORDER BY id_user DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(USER.' ORDER BY id_user DESC');
						//-------set header pada handson------
						$sethead = "['User ID','Username','First_name','Nick Name','Last Name','Email','Employee','Modified','Password']";
						//-------set id pada handson----------
						$setid = "[{data:'User_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Nick_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Email',className: 'htLeft'},{data:'Employee',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Change',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Change'),array(PATH_USER.EDIT,PATH_USER.PASS),array(),PATH_USER);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = USER.' WHERE id_user="'.$_REQUEST['rowid'].'"';
				
				$result=mysql_exe_query(array($querydat,1));
				 $resultnow=mysql_exe_fetch_array(array($result,1));
				
				$username=$resultnow[1]; 
				//$password=$resultnow[6]; 
				$firstname=$resultnow[2]; 
				$nickname=$resultnow[3]; 
				$lastname=$resultnow[4]; 
				$email=$resultnow[5];
				$employee=$resultnow[6];
				
				//-----Quey data employee untuk isian combobox tambah data user
				$query_employee2 = 'SELECT EmployeeID, FirstName FROM employee';
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EAUSER.$firstname.' '.$lastname.'</div>';
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_USER.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('First Name','Nick Name','Last Name','Email','Username','employee');
				$input_type=array(
							text_je(array('firstname',$firstname,'false')),
							text_je(array('nickname',$nickname,'false')),
							text_je(array('lastname',$lastname,'false')),
							text_je(array('email',$email,'false')),
							text_je(array('username',$username,'false')),
							combo_je(array($query_employee2,'employee','employee',225,'<option value="">-</option>',$employee))
						);
				$signtofill = array('','','','','','','');
				$content .= create_form(array(FAUSER,PATH_USER.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content .= $info;
			}
			
			//------------Jika ada halaman change password data-------//
			if(isset($_REQUEST['pass'])){ $info='';
				if(isset($_REQUEST['post'])){
					if($_REQUEST['password']==$_REQUEST['confpass']){
						//-- Update data pada kategori aset --//
						$field = array(
								'password',  
								);
						$value = array(
								'SHA1("'.$_REQUEST['password'].'")'); 
						$query = mysql_stat_update(array('tb_user',$field,$value,'id_user="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = USER.' WHERE id_user="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[100,100,150,150,150,200,150,80,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(USER.' ORDER BY id_user DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(USER.' ORDER BY id_user DESC');
						//-------set header pada handson------
						$sethead = "['User ID','Username','First_name','Nick Name','Last Name','Email','Employee','Modified','Password']";
						//-------set id pada handson----------
						$setid = "[{data:'User_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'First_Name',className: 'htLeft'},{data:'Nick_Name',className: 'htLeft'},{data:'Last_Name',className: 'htLeft'},{data:'Email',className: 'htLeft'},{data:'Employee',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Change',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Change'),array(PATH_USER.EDIT,PATH_USER.PASS),array(),PATH_USER);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Your Password Not Match</div>';
					}
				}
				$querydat = USERPASS.' WHERE id_user="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$password=$resultnow[3]; $firstname=$resultnow[1]; $lastname=$resultnow[2];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.CAUSER.$firstname.' '.$lastname.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_USER.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Password','Confirm Password');
				$input_type=array(
							text_pass(array('password','12345678','false')),
							text_pass(array('confpass','12345678','false')),
						);
				$signtofill = array('','','','','','');
				$content .= create_form(array(FAUSERPASS,PATH_USER.PASS.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content .= $info;
			}
		} 
		
		//=======NEW PAGE=====================
		//------ Application --------------
		else if(strcmp($_REQUEST['page'],'apps')==0){
			$content .= '<br/><div class="ade">'.TAPPS.'</div>';
			$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_APPS.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_APPS.ADD.'">Add</a></span></div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[120,250,800,80,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(APPS.' ORDER BY application ASC');
			//-------get header pada sql----------
			$name = gen_mysql_head(APPS.' ORDER BY application ASC');
			//-------set header pada handson------
			$sethead = "['Application ID','Application','Description','Modified']";
			//-------set id pada handson----------
			$setid = "[{data:'Application_ID',className: 'htLeft'},{data:'Application',className: 'htLeft'},{data:'Description',className: 'htLeft'},{data:'Edit',renderer: 'html'}]";
			//-------get data pada sql------------
			$dt = array(APPS.' ORDER BY application ASC',$field,array('Edit'),array(PATH_APPS.EDIT),array(),PATH_APPS);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TAAPPS.'</div>';
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_APPS.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_APPS.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Application','Description');
				$input_type=array(
							text_je(array('application','','false')),
							text_je(array('description','','true','style="width:150%;height:80px"'))
						);
				$signtofill = array('*','*');
				$content .= create_form(array(FAAPPS,PATH_APPS.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['application']) && !empty($_REQUEST['description'])){
						//-- Generate a new id untuk kategori aset --// 
						$result = mysql_exe_query(array(COUNTAPPS,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $appsid=get_new_code(array('AL',$numrow,2)); 
						//-- Insert data pada kategori aset --//
						$field = array(
								'id_apps',
								'application', 
								'description');
						$value = array(
								'"'.$appsid.'"',
								'"'.$_REQUEST['application'].'"',
								'"'.$_REQUEST['description'].'"'); 
						$query = mysql_stat_insert(array('tb_application',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = APPS.' WHERE id_apps="'.$appsid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[120,250,800,80,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(APPS.' ORDER BY application ASC');
						//-------get header pada sql----------
						$name = gen_mysql_head(APPS.' ORDER BY application ASC');
						//-------set header pada handson------
						$sethead = "['Application ID','Application','Description','Modified']";
						//-------set id pada handson----------
						$setid = "[{data:'Application_ID',className: 'htLeft'},{data:'Application',className: 'htLeft'},{data:'Description',className: 'htLeft'},{data:'Edit',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_APPS.EDIT),array(),PATH_APPS);
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
					if(!empty($_REQUEST['application']) && !empty($_REQUEST['description'])){
						//-- Update data pada kategori aset --//
						$field = array(
								'application',  
								'description');
						$value = array(
								'"'.$_REQUEST['application'].'"',
								'"'.$_REQUEST['description'].'"'); 
						$query = mysql_stat_update(array('tb_application',$field,$value,'id_apps="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = APPS.' WHERE id_apps="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[120,250,800,80,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(APPS.' ORDER BY application ASC');
						//-------get header pada sql----------
						$name = gen_mysql_head(APPS.' ORDER BY application ASC');
						//-------set header pada handson------
						$sethead = "['Application ID','Application','Description','Modified']";
						//-------set id pada handson----------
						$setid = "[{data:'Application_ID',className: 'htLeft'},{data:'Application',className: 'htLeft'},{data:'Description',className: 'htLeft'},{data:'Edit',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_APPS.EDIT),array(),PATH_APPS);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = APPS.' WHERE id_apps="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$application=$resultnow[1]; $description=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EAAPPS.$application.'</div>';
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_APPS.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Application','Description');
				$input_type=array(
							text_je(array('application',$application,'false')),
							text_je(array('description',$description,'true','style="width:150%;height:80px"'))
						);
				$signtofill = array('*','*');
				$content .= create_form(array(FAAPPS,PATH_APPS.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content .= $info;
			}
		}
		
		//------ Application --------------
		else if(strcmp($_REQUEST['page'],'grup')==0){
			$content = group();
		}
		
		//=======NEW PAGE=====================
		//------ Permitiion --------------
		else if(strcmp($_REQUEST['page'],'perm')==0){
			$content .= '<br/><div class="ade">'.TPERM.'</div>';
			
			if(!ISSET($_REQUEST['idgroup'])){
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PERM.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PERM.ADD.'">Add</a></span></div>';
			}else{
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_INDEX_PAGE.'">Back</a></span></div>';
			}
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[120,120,250,150,100,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(PERM.' AND C.id_group LIKE "%'.$_REQUEST['idgroup'].'%" ORDER BY id_permit ASC');
			//-------get header pada sql----------
			$name = gen_mysql_head(PERM.' AND C.id_group LIKE "%'.$_REQUEST['idgroup'].'%" ORDER BY id_permit ASC');
			//-------set header pada handson------
			$sethead = "['Permit ID','Username','Application','Group','Edit','Remove']";
			//-------set id pada handson----------
			$setid = "[{data:'Permit_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'Application',className: 'htLeft'},{data:'Group_Name',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Delete',renderer: 'html'}]";
			//-------get data pada sql------------
			$dt = array(PERM.' AND C.id_group LIKE "%'.$_REQUEST['idgroup'].'%" ORDER BY id_permit ASC',$field,array('Edit','Delete'),array(PATH_PERM.EDIT,PATH_PERM.DELETE),array(),PATH_PERM);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson); 
			//------------Jika ada halaman tambah data-------// 
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TAPERM.'</div>';
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PERM.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PERM.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('User','Application','Group');
				$input_type=array(
							combo_je(array(COMUSER,'user','user',150,'','')),
							combo_je(array(COMAPPS,'application','application',150,'','')),
							combo_je(array(COMGRUP,'group','group',150,'','')),
						);
				$signtofill = array('','','','','','');
				$content .= create_form(array(FAPERM,PATH_PERM.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'user_p', 
								'application',	
								'id_group');
						$value = array(
								'"'.$_REQUEST['user'].'"',
								'"'.$_REQUEST['application'].'"',
								'"'.$_REQUEST['group'].'"'); 
						$query = mysql_stat_insert(array('tb_permit',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Generate a new id untuk kategori aset --// 
						$result = mysql_exe_query(array(COUNTPERM,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]; $permid=$numrow; 
						//-- Ambil data baru dari database --//
						$querydat = PERM.' AND C.id_permit="'.$permid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[120,120,250,150,100,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(PERM.' ORDER BY id_permit ASC');
						//-------get header pada sql----------
						$name = gen_mysql_head(PERM.' ORDER BY id_permit ASC');
						//-------set header pada handson------
						$sethead = "['Permit ID','Username','Application','Group','Edit','Remove']";
						//-------set id pada handson----------
						$setid = "[{data:'Permit_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'Application',className: 'htLeft'},{data:'Group_Name',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Delete',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_PERM.EDIT,PATH_PERM.DELETE),array(),PATH_PERM);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
				}
			}
			
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					
						//-- Update data pada kategori aset --//
						$field = array(
								'user_p', 
								'application',
								'id_group');
						$value = array(
								'"'.$_REQUEST['user'].'"',
								'"'.$_REQUEST['application'].'"',
								'"'.$_REQUEST['group'].'"'); 
						$query = mysql_stat_update(array('tb_permit',$field,$value,'id_permit="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = PERM.' AND C.id_permit="'.$_REQUEST['rowid'].'"';
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[120,250,250,100,100,100,100,130,100,100]";
						//-------set lebar kolom -------------
						$width = "[120,120,250,150,100,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(PERM.' ORDER BY id_permit ASC');
						//-------get header pada sql----------
						$name = gen_mysql_head(PERM.' ORDER BY id_permit ASC');
						//-------set header pada handson------
						$sethead = "['Permit ID','Username','Application','Group','Edit','Remove']";
						//-------set id pada handson----------
						$setid = "[{data:'Permit_ID',className: 'htLeft'},{data:'Username',className: 'htLeft'},{data:'Application',className: 'htLeft'},{data:'Group_Name',className: 'htLeft'},{data:'Edit',renderer: 'html'},{data:'Delete',renderer: 'html'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_PERM.EDIT,PATH_PERM.DELETE),array(),PATH_PERM);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EPERM.' WHERE id_permit="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$user=$resultnow[1]; $application=$resultnow[2]; $group=$resultnow[3]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EAPERM.'</div>';
				$content .= '<div class="" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PERM.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('User','Application','Group');
				$input_type=array(
							combo_je(array(COMUSER,'user','user',150,'',$user)),
							combo_je(array(COMAPPS,'application','application',150,'',$application)),
							combo_je(array(COMGRUP,'group','group',150,'',$group)),
						);
				$signtofill = array('','','');
				$content .= create_form(array(FAPERM,PATH_PERM.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content .= $info;
			}
			
			//------------Jika ada halaman delete data-------//
			if(isset($_REQUEST['delete'])){
				$content = query_delete(array(PATH_PERM,'tb_permit','id_permit="'.$_REQUEST['rowid'].'"'));
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
		$result = mysql_query($query);
		$result_now = mysql_fetch_array($result);
		$content = '<div class="title" align="right"><i>Last Update Data : '.$result_now[0].'</i></div>';
		return $content;
	}
	
	//------Fungsi generate data ke excel -------------------------------------
	function gen_data_excel($data){
		$sql = $data[0];
		$page = $data[1];
		$content = ''; 
		$result = mysql_query($sql) or die ('FAILED TO EXPORT EXCEL'); 
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
			while($result_now= mysql_fetch_array($result)){
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
			while($result_now= mysql_fetch_array($result)){
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
			while($result_now= mysql_fetch_array($result)){
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
	
	function pop_up($definepage){ $content = '';
		if(strcmp($definepage,'assets')==0 && isset($_REQUEST['dataid'])){
		$query = ASSETS.' AND  A.AssetID="'.$_REQUEST['dataid'].'"'; $result=mysql_query($query); $result_now=mysql_fetch_array($result);
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$result_now[2].'</h1>
				
				<img src="'.$result_now[19].'" class="popup__media popup__media_right" alt="Image of Asset">
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
				
				
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		}
		
		else if(strcmp($definepage,'worder')==0 && isset($_REQUEST['dataid'])){
		$query = WORDER.' AND  WO.WorkOrderNo="'.$_REQUEST['dataid'].'"'; $result=mysql_query($query); $result_now=mysql_fetch_array($result);
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$result_now[0].'</h1>
				<img src="'.$result_now[21].'" class="popup__media popup__media_right" alt="Image of Asset">
				<table class="text-popup">
				<tr height="30"><td>Asset Name </td><td> : </td><td>'.$result_now[11].'</td>
				<tr height="30"><td>WO State </td><td> : </td><td>'.$result_now[14].'</td>
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
				
				
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		}
		return $content;
	}
#########################################################################################################################################	
?>