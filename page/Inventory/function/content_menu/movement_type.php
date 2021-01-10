<?php
	function movement_type(){
		$content .= '<br/><div class="ade">'.TMOVETYPE.'</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
		$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom -------------
		$width = "[200,200,80]";
		//-------get id pada sql -------------
		$field = gen_mysql_id(MOVETYPE);
		//-------get header pada sql----------
		$name = gen_mysql_head(MOVETYPE);
		//-------set header pada handson------
		$sethead = "['ID','Movement Type'"._USER_EDIT_SETHEAD_."]";
		//-------set id pada handson----------
		$setid = "[{data:'ID',className: 'htLeft'},{data:'Movement_Type',className: 'htLeft'}"._USER_EDIT_SETID_."]";
		//-------get data pada sql------------
		$dt = array(MOVETYPE,$field,array('Edit'),array(PATH_MOVETYPE.EDIT),array(),PATH_MOVETYPE);
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		if (_VIEW_) $content .= get_handson($sethandson);
		//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TMOVETYPE.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Movement Type');
				$input_type=array(
							text_je(array('movetype','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_MOVETYPE.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['movetype'])){
						//-- Generate a new id untuk kategori aset --// 
						$movetyid=get_new_code(array('MOVET',$numrow,1));  
						//-- Insert data pada kategori aset --//
						$field = array(
								'movement_type_id',
								'movement_type');
						$value = array(
								'"'.$movetyid.'"',
								'"'.$_REQUEST['movetype'].'"'); 
						$query = mysql_stat_insert(array('invent_movement_type',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = MOVETYPE.' WHERE movement_type_id="'.$movetyid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(MOVETYPE);
						//-------get header pada sql----------
						$name = gen_mysql_head(MOVETYPE);
						//-------set header pada handson------
						$sethead = "['ID','Movement Type'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Movement_Type',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_MOVETYPE.EDIT),array(),PATH_MOVETYPE);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content = empty_info(array('Some field is empty')).$content;
					}
				}
			}
			
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['movetype'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'movement_type');
						$value = array(
								'"'.$_REQUEST['movetype'].'"'); 
						$query = mysql_stat_update(array('invent_movement_type',$field,$value,'movement_type_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = MOVETYPE.' WHERE movement_type_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(MOVETYPE);
						//-------get header pada sql----------
						$name = gen_mysql_head(MOVETYPE);
						//-------set header pada handson------
						$sethead = "['ID','Movement Type'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Movement_Type',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_MOVETYPE.EDIT),array(),PATH_MOVETYPE);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = MOVETYPE.' WHERE movement_type_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$movetype=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.TMOVETYPE.$movetype.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_MOVETYPE.'">View</a></span></div>';
				$name_field=array('Movement Type');
				$input_type=array(
							text_je(array('movetype',$movetype,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_MOVETYPE.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
		return $content;
	}
?>