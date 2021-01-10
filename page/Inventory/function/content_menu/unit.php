<?php
	function unit(){
		$content .= '<br/><div class="ade">'.TUNIT.'</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
		$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom ------------- 
		$width = "[200,200,200,80]";
		//-------get id pada sql -------------
		$field = gen_mysql_id(UNIT);
		//-------get header pada sql----------
		$name = gen_mysql_head(UNIT);
		//-------set header pada handson------
		$sethead = "['ID','Unit','Detail Description'"._USER_EDIT_SETHEAD_."]";
		//-------set id pada handson----------
		$setid = "[{data:'ID',className: 'htLeft'},{data:'Unit',className: 'htLeft'},{data:'Detail_Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
		//-------get data pada sql------------
		$dt = array(UNIT,$field,array('Edit'),array(PATH_UNIT.EDIT),array(),PATH_UNIT);
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		if (_VIEW_) $content .= get_handson($sethandson);
		//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TUNIT.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Unit','Detail Description');
				$input_type=array(
							text_je(array('unit','','false')),
							text_je(array('detail','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_UNIT.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['unit']) && !empty($_REQUEST['detail'])){
						//-- Generate a new id untuk kategori aset --// 
						$unitid=get_new_code(array('UNIT',$numrow,1));  
						//-- Insert data pada kategori aset --//
						$field = array(
								'id_unit',
								'unit',
								'detail');
						$value = array(
								'"'.$unitid.'"',
								'"'.$_REQUEST['unit'].'"',
								'"'.$_REQUEST['detail'].'"'); 
						$query = mysql_stat_insert(array('invent_unit',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = UNIT.' WHERE id_unit="'.$unitid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom ------------- 
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(UNIT);
						//-------get header pada sql----------
						$name = gen_mysql_head(UNIT);
						//-------set header pada handson------
						$sethead = "['ID','Unit','Detail Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Unit',className: 'htLeft'},{data:'Detail_Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_UNIT.EDIT),array(),PATH_UNIT);
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
					if(!empty($_REQUEST['unit']) && !empty($_REQUEST['detail'])){
						//-- Edit data pada kategori aset --//
						$field = array(
								'unit',
								'detail');
						$value = array(
								'"'.$_REQUEST['unit'].'"',
								'"'.$_REQUEST['detail'].'"'); 
						$query = mysql_stat_update(array('invent_unit',$field,$value,'id_unit="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = UNIT.' WHERE id_unit="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom ------------- 
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(UNIT);
						//-------get header pada sql----------
						$name = gen_mysql_head(UNIT);
						//-------set header pada handson------
						$sethead = "['ID','Unit','Detail Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Unit',className: 'htLeft'},{data:'Detail_Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_UNIT.EDIT),array(),PATH_UNIT);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = UNIT.' WHERE id_unit="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$unit=$resultnow[1]; $detail=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.TUNIT.$unit.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_UNIT.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Unit','Detail Description');
				$input_type=array(
							text_je(array('unit',$unit,'false')),
							text_je(array('detail',$detail,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_UNIT.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
			
		return $content;
	}
?>