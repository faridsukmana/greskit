<?php
	function form_name_checklist(){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM checklist_form_master WHERE id_form_checklist="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));
				$query = 'DELETE FROM checklist_form_name WHERE id_form_checklist="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
		
			$content = '<br/><div class="ade">FORM NAME CHECKLIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,300,80,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(QFORMCK.' ORDER BY id_form_checklist DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(QFORMCK.' ORDER BY id_form_checklist DESC');
			//-------set header pada handson------
			$sethead = "['ID Form','Form Name'"._USER_EDIT_SETHEAD_._USER_DETAIL_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'ID',className: 'htLeft'},{data:'Form',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DETAIL_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(QFORMCK.' ORDER BY id_form_checklist DESC',$field,array('Edit','Detail','Delete'),array(PATH_FORMCK.EDIT,PATH_FORMCK.DETAIL,PATH_FORMCK.DELETE),array());
			if (_VIEW_) $data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				//***********CHECKLIST*********************		
				$query = QLCHECK.' ORDER BY A.AssetID ASC'; 
				
				$thead = '<thead><tr><th scope="col"><b>No</b></th><th scope="col"><b>Asset</b></th><th scope="col"><b>Item</b></th><th scope="col"><b>Check</b></th></tr></thead>';
				$result = mysql_exe_query(array($query,1));
				$i =1; 
				while($result_now=mysql_exe_fetch_array(array($result,1))){
					$checklist .= '<tr><td>'.$i.'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td><input type="checkbox" name="clist_'.$result_now[0].'" value="v" /></td></tr>';
					$i++;
				}
				$table_checklist = '<div class="col-sm-12">'.$table_checklist.'<table id="tb_form" class="table table-bordered table-striped" style="font-size: 12px">'.$thead.'<tbody>'.$checklist.'</tbody></table></div>';
				
				//**********************************************
			
				$content = '<br/><div class="ade">ADD DATA FORM NAME CHECKLIST</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
						
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){ $info = '';
					if(!empty($_REQUEST['form_name'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/ncheck.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$wpid=get_new_code('FN',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO checklist_form_name (id_form_checklist ,form_name) VALUES("'.$wpid.'","'.$_REQUEST['form_name'].'")'; mysql_exe_query(array($query,1));
						
						//-- Insert checklist in form --------//
						$q_check = QLCHECK;
						$r_check = mysql_exe_query(array($q_check,1));
						while($rn_check=mysql_exe_fetch_array(array($r_check,1))){ 
							if(!empty($_REQUEST['clist_'.$rn_check[0]])){
								$q_insert = 'INSERT INTO checklist_form_master (id_form_checklist, id_master_checklist) VALUES ("'.$wpid.'","'.$rn_check[0].'")';
								mysql_exe_query(array($q_insert,1));
							}
						}
						//------------------------------------//
						
						//-- Ambil data baru dari database --//
						$querydat = QFORMCK.' WHERE id_form_checklist="'.$wpid.'"'; 
						//$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,300,80,80,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['ID Form','Form Name'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Form',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_FORMCK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						//$content .= get_handson($sethandson);
						$info .= '<div class="alert alert-success" align="center" role="alert">Insert Successed</div>';
					}else{
						//$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$info .= '<div class="alert alert-danger" align="center" role="alert">Insert Failed, some field is empty</div>';
					}
				}
				
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><form action="'.PATH_FORMCK.ADD.POST.'" method="post" enctype="multipart/form-data">
							<div class="form-style-1"><fieldset><div class="card-header text-center">Form Name</div>
								<table>
									<tr><td width="150"><span class="name"> Form Name </td><td>:</td> </span></td><td>'.text_je(array('form_name','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</div>
							'.$info.$table_checklist.'</form>';
			}
			
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['form_name'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE checklist_form_name SET form_name="'.$_REQUEST['form_name'].'" WHERE id_form_checklist="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						
						//-- Insert checklist in form --------//
						mysql_exe_query(array('DELETE FROM checklist_form_master WHERE id_form_checklist="'.$_REQUEST['rowid'].'"',1));
						$q_check = QLCHECK;
						$r_check = mysql_exe_query(array($q_check,1));
						while($rn_check=mysql_exe_fetch_array(array($r_check,1))){ 
							if(!empty($_REQUEST['clist_'.$rn_check[0]])){
								$q_insert = 'INSERT INTO checklist_form_master (id_form_checklist, id_master_checklist) VALUES ("'.$_REQUEST['rowid'].'","'.$rn_check[0].'")';
								mysql_exe_query(array($q_insert,1));
							}
						}
						//------------------------------------//
						
						//-- Ambil data baru dari database --//
						$querydat = QFORMCK.' WHERE id_form_checklist="'.$_REQUEST['rowid'].'"'; 
						//$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,300,80,80,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['ID Form','Form Name'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Form',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_FORMCK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						//$info .= get_handson($sethandson);
						$info .= '<div class="alert alert-success" align="center" role="alert">Update Successed</div>';
					}else{
						//$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$info .= '<div class="alert alert-danger" align="center" role="alert">Update Failed, some field is empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = QFORMCK.' WHERE id_form_checklist="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$form_name=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT FORM NAME CHECKLIST FOR '.$icheck.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				
				//***********CHECKLIST*********************		
				$query = QLCHECK.' ORDER BY A.AssetID ASC'; 
				
				$thead = '<thead><tr><th scope="col"><b>No</b></th><th scope="col"><b>Asset</b></th><th scope="col"><b>Item</b></th><th scope="col"><b>Check</b></th></tr></thead>';
				$result = mysql_exe_query(array($query,1));
				$i =1; 
				while($result_now=mysql_exe_fetch_array(array($result,1))){
					$q_cform = 'SELECT COUNT(*) FROM checklist_form_master WHERE id_form_checklist="'.$_REQUEST['rowid'].'" AND id_master_checklist="'.$result_now[0].'"'; 
					$r_cform = mysql_exe_query(array($q_cform,1));
					$rn_cform=mysql_exe_fetch_array(array($r_cform,1));
					$numrow = $rn_cform[0];
					if($numrow>0){
						$checklist .= '<tr><td>'.$i.'</td><td>'.$result_now[1].'</td><td width="300">'.$result_now[2].'</td><td><input type="checkbox" name="clist_'.$result_now[0].'" value="v" checked/></td></tr>';
					}else{
						$checklist .= '<tr><td>'.$i.'</td><td>'.$result_now[1].'</td><td width="300">'.$result_now[2].'</td><td><input type="checkbox" name="clist_'.$result_now[0].'" value="v" /></td></tr>';
					}
					$i++;
				}
				$table_checklist = '<div class="col-sm-12">'.$table_checklist.'<table id="tb_form" class="table table-bordered table-striped" style="font-size: 12px">'.$thead.'<tbody>'.$checklist.'</tbody></table></div>';
				
				//**********************************************
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><form action="'.PATH_FORMCK.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<div class="form-style-1">
							<fieldset><div class="card-header text-center">Form Name</div>
								<table>
									<tr><td width="150"><span class="name"> Form Name </td><td>:</td> </span></td><td>'.text_je(array('form_name',$form_name,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</div>
							'.$info.$table_checklist.'
							</form>';
				//$content.=$info;
			}
			
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['detail'])){
				$query = QDETFORM.' AND A.id_form_checklist="'.$_REQUEST['rowid'].'" ORDER BY D.AssetDesc, C.description ASC';
				$result = mysql_exe_query(array($query,1));
				$result_now=mysql_exe_fetch_array(array($result,1));
				$content = '<br/><div class="ade">DETAIL CHECKLIST FOR '.$result_now[0].'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[400,400]";
				//-------get id pada sql -------------
				$field = gen_mysql_id($query);
				//-------get header pada sql----------
				$name = gen_mysql_head($query);
				//-------set header pada handson------
				$sethead = "['Asset','Item Checklist']";
				//-------set id pada handson----------
				$setid = "[{data:'Asset',className: 'htLeft'},{data:'Item_Check',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array($query,$field,array(),array(),array());
				$data = get_data_handson_func($dt);
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				$content .= get_handson($sethandson);
			}
		
		$content .= form_js();
		return $content;
	}
	
	function form_js(){
		$content = "
					<script>
						$('#tb_form').DataTable({
						    'paging':false
						});
					</script>
		";
		return $content;
	}
?>