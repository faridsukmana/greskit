<?php
	function create_daily_checklist(){
		/**----- Delete -------------------*/
		if(isset($_REQUEST['delete'])){
			$query = 'DELETE FROM checklist_history WHERE id_checklist_history="'.$_REQUEST['rowid'].'"';
			mysql_exe_query(array($query,1)); 
		}
	
		$content = '<br/><div class="ade">HISTORY CHECKLIST</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
		$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom -------------
		$width = "[200,200,200,80,80]";
		//-------get id pada sql -------------
		$field = gen_mysql_id(QDAILYC.' GROUP BY A.id_checklist_history ORDER BY date DESC');
		//-------get header pada sql----------
		$name = gen_mysql_head(QDAILYC.' GROUP BY A.id_checklist_history ORDER BY date DESC');
		//-------set header pada handson------
		$sethead = "['ID Form','Form Name','Date'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
		//-------set id pada handson----------
		$setid = "[{data:'ID',className: 'htLeft'},{data:'Form_Name',className: 'htLeft'},{data:'Date',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
		//-------get data pada sql------------
		$dt = array(QDAILYC.' GROUP BY A.id_checklist_history ORDER BY date DESC',$field,array('Edit','Delete'),array(PATH_DAILYC.EDIT,PATH_DAILYC.DELETE),array());
		if (_VIEW_) $data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		$content .= get_handson($sethandson);
		//------------Jika ada halaman tambah data-------//
		
		if(isset($_REQUEST['add'])){
			$content = '<br/><div class="ade">ADD DATA FOR MASTER CHECKLIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			//----- Buat Form Isian Berikut-----
			$content .= '<br/><div class="form-style-1"><form action="'.PATH_DAILYC.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Priority</div>
								<table>
									<tr><td width="150"><span class="name"> Form Name </td><td>:</td> </span></td><td>'.combo_je(array(COMBFORMCK,'form','form',250,'<option value=""> - </option>','')).' *</td></tr>
									<td width="120"><span class="name"> Date </td><td>:</td> </span></td><td>'.date_je(array('dateh','')).' *</td>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
			//------ Aksi ketika post menambahkan data -----//
			if(isset($_REQUEST['post'])){
				if(!empty($_REQUEST['form']) && !empty($_REQUEST['dateh'])){
					$dateh = convert_date(array($_REQUEST['dateh'],2));
					//-- Read Text to new code ---//
					$myFile = _ROOT_."function/inc/hcheck.txt";
					$fh = fopen($myFile, 'r');
					$code = fread($fh, 21);
					fclose($fh);
					$ncode = $code+1;
					$fh = fopen($myFile, 'w+') or die("Can't open file.");
					fwrite($fh, $ncode);
						
					//-- Generate a new id untuk checklist --//
					$wpid=get_new_code('HC',$ncode); 
					//-- Insert data pada checklist --//
					$query_c = 'SELECT id_form_checklist, id_master_checklist FROM checklist_form_master WHERE id_form_checklist="'.$_REQUEST['form'].'"';
					$result_c = mysql_exe_query(array($query_c,1));
					while($result_now_c=mysql_exe_fetch_array(array($result_c,1))){
						$query = 'INSERT INTO checklist_history (id_checklist_history ,date, id_form_checklist, id_master_checklist) VALUES("'.$wpid.'","'.$dateh.'","'.$result_now_c[0].'","'.$result_now_c[1].'")'; 
						mysql_exe_query(array($query,1));
					}
					//-- Ambil data baru dari database --//
					$querydat = QDAILYC.' AND id_checklist_history="'.$wpid.'" GROUP BY A.id_checklist_history ORDER BY date DESC';  
					$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
					$width = "[200,200,200,80,80]";
					$field = gen_mysql_id($querydat);
					$name = gen_mysql_head($querydat);
					//-------set header pada handson------
					$sethead = "['ID Form','Form Name','Date'"._USER_EDIT_SETHEAD_."]";
					//-------set id pada handson----------
					$setid = "[{data:'ID',className: 'htLeft'},{data:'Form_Name',className: 'htLeft'},{data:'Date',className: 'htLeft'}"._USER_EDIT_SETID_."]";
					$dt = array($querydat,$field,array('Edit'),array(PATH_DAILYC.EDIT),array());
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
				if(!empty($_REQUEST['rowid'])){
					//-- Insert checklist in form --------//
					$q_check = 'SELECT id_master_checklist FROM checklist_history WHERE id_checklist_history="'.$_REQUEST['rowid'].'"';
					$r_check = mysql_exe_query(array($q_check,1));
					while($rn_check=mysql_exe_fetch_array(array($r_check,1))){ 
						if(!empty($_REQUEST['text_'.$rn_check[0]])){
							$q_update = 'UPDATE checklist_history SET description="'.$_REQUEST['text_'.$rn_check[0]].'" WHERE id_checklist_history="'.$_REQUEST['rowid'].'" AND id_master_checklist="'.$rn_check[0].'"'; 
							mysql_exe_query(array($q_update,1));
						}
					}
					$info .= '<div class="alert alert-success" align="center" role="alert">Update Successed</div>';
				}else{
					$info .= '<div class="alert alert-danger" align="center" role="alert">Update Failed, some field is empty</div>';
				}
			}
			//-----Ambil nilai semua data yang terkait dengan id data------//
			$querydat =QDAILYC.' AND id_checklist_history="'.$_REQUEST['rowid'].'" GROUP BY A.id_checklist_history ORDER BY date DESC'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
			$form_name=$resultnow[1]; 
			//-----Tampilan judul pada pengeditan------
			$content = '<br/><div class="ade">EDIT HISTORY CHECKLIST FOR '.$_REQUEST['rowid'].'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				
			//***********CHECKLIST*********************		
			$querydat = QDAILYH.' AND id_checklist_history="'.$_REQUEST['rowid'].'"'; 
			$thead = '<thead><tr><th scope="col"><b>Asset</b></th><th scope="col"><b>Item</b></th><th scope="col"><b>Description</b></th></tr></thead>';
			$result = mysql_exe_query(array($querydat,1));
			$i =0; 
			while($result_now=mysql_exe_fetch_array(array($result,1))){
				$checklist .= '<tr><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td width="500"><input class="form-control" type="text" name="text_'.$result_now[4].'" value="'.$result_now[3].'" /></td></tr>';
				$i++;
			}
			$table_checklist = '<div class="col-sm-12">'.$table_checklist.'<table class="table table-bordered table-striped" style="font-size: 12px">'.$thead.'<tbody>'.$checklist.'</tbody></table></div>';
				
			//**********************************************
			//----- Buat Form Isian Edit Data Berikut-----
			$content .= '<br/><form action="'.PATH_DAILYC.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							'.$table_checklist.'
							<div class="form-style-1">
							<table>
								<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
							</table>
							</div>
						</form>';
			$content.=$info;
		}
		
		return $content;
	}
?>