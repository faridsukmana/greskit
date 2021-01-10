<?php
	function master_checklist(){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM checklist_master WHERE AssetID="'.$_REQUEST['rowid'].'"'; 
				mysql_exe_query(array($query,1));  
			}
		
			$content = '<br/><div class="ade">MASTER CHECKLIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,300,80,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(QMLCHECK);
			//-------get header pada sql----------
			$name = gen_mysql_head(QMLCHECK);
			//-------set header pada handson------
			$sethead = "['Asset No' ,'Asset Name'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Asset_No',className: 'htLeft'},{data:'Asset',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(QMLCHECK,$field,array('Edit','Delete'),array(PATH_LCHECK.EDIT,PATH_LCHECK.DELETE),array());
			if (_VIEW_) $data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				//***********CHECKLIST*********************		
				$query = QICHECK.' ORDER BY id_item_check ASC'; 
				
				$thead = '<thead><tr><th scope="col"><b>No</b></th><th scope="col"><b>Item Check</b></th><th scope="col"><b>Check</b></th></tr></thead>';
				$result = mysql_exe_query(array($query,1));
				$i =1; 
				while($result_now=mysql_exe_fetch_array(array($result,1))){
					$checklist .= '<tr><td>'.$i.'</td><td>'.$result_now[1].'</td><td><input type="checkbox" name="clist_'.$result_now[0].'" value="v" /></td></tr>';
					$i++;
				}
				$table_checklist = '<div class="col-sm-2"></div><div class="col-sm-8">'.$table_checklist.'<table id="tb_checklist" class="table table-bordered table-striped" style="font-size: 12px">'.$thead.'<tbody>'.$checklist.'</tbody></table></div>';
				//******************************************
				
				$content = '<br/><div class="ade">ADD DATA FOR MASTER CHECKLIST</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					$info = '';
					if(!empty($_REQUEST['asset'])){
						$q_check = QICHECK.' ORDER BY id_item_check ASC'; 
						$r_check = mysql_exe_query(array($q_check,1));
						
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/lcheck.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code;
						while($rn_check=mysql_exe_fetch_array(array($r_check,1))){ 
							if(!empty($_REQUEST['clist_'.$rn_check[0]])){
								$ncode++;
								//-- Generate a new id untuk kategori aset --//
								 $wpid=get_new_code('LC',$ncode); 
								//-- Insert data pada kategori aset --//
								$query = 'INSERT INTO checklist_master (id_master_checklist ,AssetID, id_item_check) VALUES("'.$wpid.'","'.$_REQUEST['asset'].'","'.$rn_check[0].'")'; 
								mysql_exe_query(array($query,1));
							}
						}
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Ambil data baru dari database --//
						/*$querydat = QLCHECK.' AND id_master_checklist="'.$wpid.'"';  
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,300,300,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);*/
						//-------set header pada handson------
						//$sethead = "['ID Master Checklist','Asset','Item Check'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						/*$setid = "[{data:'ID',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Item_Check',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_LCHECK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);*/
						//$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$info .= '<div class="alert alert-success" align="center" role="alert">Insert Successed</div>';
					}else{
						//$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$info .= '<div class="alert alert-danger" align="center" role="alert">Insert Failed, some field is empty</div>';
					}
				}
				
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><form action="'.PATH_LCHECK.ADD.POST.'" method="post" enctype="multipart/form-data">
							<div class="form-style-1"><fieldset><div class="card-header text-center">Master Checklist</div>
								<table>
									<tr><td width="150"><span class="name"> Asset </td><td>:</td> </span></td><td>'.combo_je(array(COMASSETS_B,'asset','asset',250,'<option value=""> - </option>','')).' *</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</div>
							'.$info.$table_checklist.'</form>';
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['rowid'])){
						//-- Update data pada master checklist --//
						$q_check = QICHECK.' ORDER BY id_item_check ASC'; 
						$r_check = mysql_exe_query(array($q_check,1));
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/lcheck.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code;
						while($rn_check=mysql_exe_fetch_array(array($r_check,1))){ 
							if(!empty($_REQUEST['clist_'.$rn_check[0]])){
								$query_check = 'SELECT id_master_checklist FROM checklist_master WHERE AssetID="'.$_REQUEST['rowid'].'" AND id_item_check="'.$rn_check[0].'"';
								$r_query_check = mysql_exe_query(array($query_check,1));
								$num_row = mysql_exe_num_rows(array($r_query_check,1));	
								if($num_row==0){
									$ncode++;
									//-- Generate a new id untuk kategori aset --//
									 $wpid=get_new_code('LC',$ncode); 
									//-- Insert data pada kategori aset --//
									$query = 'INSERT INTO checklist_master (id_master_checklist ,AssetID, id_item_check) VALUES("'.$wpid.'","'.$_REQUEST['rowid'].'","'.$rn_check[0].'")'; 
									mysql_exe_query(array($query,1));
								}	
							}else{
								$query = 'DELETE FROM checklist_master WHERE AssetID="'.$_REQUEST['rowid'].'" AND id_item_check="'.$rn_check[0].'"'; 
								mysql_exe_query(array($query,1));
							}
						}
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						//-- Ambil data baru dari database --//
						/*$querydat = QLCHECK.' AND id_master_checklist="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,300,300,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);*/
						//-------set header pada handson------
						//$sethead = "['ID Master Checklist','Asset','Item Check'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						/*$setid = "[{data:'ID',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Item_Check',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_LCHECK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);*/
						$info .= '<div class="alert alert-success" align="center" role="alert">Update Successed</div>';
					}else{
						$info .= '<div class="alert alert-danger" align="center" role="alert">Update Failed</div>';
					}
				}
				
				$ascheck = $_REQUEST['rowid'];
				$query = ASSETS.' AND A.AssetID ="'.$ascheck.'"';
				$result = mysql_exe_query(array($query,1));
				$result_now=mysql_exe_fetch_array(array($result,1)); $asset_name = $result_now[1].' - '.$result_now[2];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA MASTER CHECKLIST FOR '.$asset_name.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				
				//***********CHECKLIST*********************		
				$query = QICHECK.' ORDER BY id_item_check ASC';  
				
				$thead = '<thead><tr><th scope="col"><b>No</b></th><th scope="col"><b>Item Check</b></th><th scope="col"><b>Check</b></th></tr></thead>';
				$result = mysql_exe_query(array($query,1));
				$i =1; 
				while($result_now=mysql_exe_fetch_array(array($result,1))){ 
					$q_cform = 'SELECT COUNT(*) FROM checklist_master WHERE AssetID="'.$_REQUEST['rowid'].'" AND id_item_check="'.$result_now[0].'"'; 
					$r_cform = mysql_exe_query(array($q_cform,1));
					$rn_cform=mysql_exe_fetch_array(array($r_cform,1));
					$numrow = $rn_cform[0];
					if($numrow>0){
						$checklist .= '<tr><td>'.$i.'</td><td>'.$result_now[1].'</td><td><input type="checkbox" name="clist_'.$result_now[0].'" value="v" checked/></td></tr>';
					}else{
						$checklist .= '<tr><td>'.$i.'</td><td>'.$result_now[1].'</td><td><input type="checkbox" name="clist_'.$result_now[0].'" value="v" /></td></tr>';
					}
					$i++;
				}
				$table_checklist = '<div class="col-sm-2"></div><div class="col-sm-8">'.$table_checklist.'<table id="tb_checklist" class="table table-bordered table-striped" style="font-size: 12px">'.$thead.'<tbody>'.$checklist.'</tbody></table></div>';
				//******************************************
				
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><form action="'.PATH_LCHECK.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<div class="form-style-1"><fieldset><div class="card-header text-center">Master Checklist</div>
								<table>
									<tr><td width=210></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</div>
							'.$info.$table_checklist.'</form>';
			}
			
			$content .= master_checklist_js();
			return $content;
	}
	
	function master_checklist_js(){
		$content = "
					<script>
						$('#tb_checklist').DataTable();
					</script>
		";
		return $content;
	}
?>