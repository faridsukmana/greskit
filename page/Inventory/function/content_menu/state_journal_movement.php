<?php
	function state_journal_movement(){
		$content .= '<br/><div class="ade">'.TSJVMOVE.'</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
		$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom ------------- 
		$width = "[200,200,80]";
		//-------get id pada sql -------------
		$field = gen_mysql_id(SJVMOVE);
		//-------get header pada sql----------
		$name = gen_mysql_head(SJVMOVE);
		//-------set header pada handson------
		$sethead = "['ID','State'"._USER_EDIT_SETHEAD_."]";
		//-------set id pada handson----------
		$setid = "[{data:'ID',className: 'htLeft'},{data:'State',className: 'htLeft'}"._USER_EDIT_SETID_."]";
		//-------get data pada sql------------
		$dt = array(SJVMOVE,$field,array('Edit'),array(PATH_SJVMOVE.EDIT),array(),PATH_SJVMOVE);
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		if (_VIEW_) $content .= get_handson($sethandson);
		//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TSJVMOVE.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('State');
				$input_type=array(
							text_je(array('state','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_SJVMOVE.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['state'])){
						//-- Generate a new id untuk kategori aset --// 
						$sjvid=get_new_code(array('SJVST',$numrow,1));  
						//-- Insert data pada kategori aset --//
						$field = array(
								'state_journal_movement_id',
								'state_journal_movement');
						$value = array(
								'"'.$sjvid.'"',
								'"'.$_REQUEST['state'].'"'); 
						$query = mysql_stat_insert(array('invent_state_journal_movement',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = SJVMOVE.' WHERE state_journal_movement_id="'.$sjvid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom ------------- 
						$width = "[200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(SJVMOVE);
						//-------get header pada sql----------
						$name = gen_mysql_head(SJVMOVE);
						//-------set header pada handson------
						$sethead = "['ID','State'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'State',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_SJVMOVE.EDIT),array(),PATH_SJVMOVE);
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
					if(!empty($_REQUEST['state'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'state_journal_movement');
						$value = array(
								'"'.$_REQUEST['state'].'"'); 
						$query = mysql_stat_update(array('invent_state_journal_movement',$field,$value,'state_journal_movement_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = SJVMOVE.' WHERE state_journal_movement_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom ------------- 
						$width = "[200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(SJVMOVE);
						//-------get header pada sql----------
						$name = gen_mysql_head(SJVMOVE);
						//-------set header pada handson------
						$sethead = "['ID','State'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'State',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_SJVMOVE.EDIT),array(),PATH_SJVMOVE);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = SJVMOVE.' WHERE state_journal_movement_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$state=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.TSJVMOVE.$state.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_SJVMOVE.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('State');
				$input_type=array(
							text_je(array('state',$state,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_SJVMOVE.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
			
		return $content;
	}
?>