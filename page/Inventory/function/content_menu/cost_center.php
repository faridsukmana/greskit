<?php
	function cost_center(){
		$content .= '<br/><div class="ade">'.TCCENTER.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(CCENTER);
			//-------get header pada sql----------
			$name = gen_mysql_head(CCENTER);
			//-------set header pada handson------
			$sethead = "['ID','Cost Center'"._USER_EDIT_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'ID',className: 'htLeft'},{data:'Cost_Center',className: 'htLeft'}"._USER_EDIT_SETID_."]";
			//-------get data pada sql------------
			$dt = array(CCENTER,$field,array('Edit'),array(PATH_CCENTER.EDIT),array(),PATH_CCENTER);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TCCENTER.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Cost Center');
				$input_type=array(
							text_je(array('ccenter','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_CCENTER.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['ccenter'])){
						//-- Generate a new id untuk kategori aset --//  
						$ccentid=get_new_code(array('CCENT',$numrow,1));   
						//-- Insert data pada kategori aset --//
						$field = array(
								'id_cost_center',
								'cost_center');
						$value = array(
								'"'.$ccentid.'"',
								'"'.$_REQUEST['ccenter'].'"'); 
						$query = mysql_stat_insert(array('cost_center',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = CCENT.' WHERE id_cost_center="'.$ccentid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(CCENTER);
						//-------get header pada sql----------
						$name = gen_mysql_head(CCENTER);
						//-------set header pada handson------
						$sethead = "['ID','Cost Center'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Cost_Center',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array(CCENTER,$field,array('Edit'),array(PATH_CCENTER.EDIT),array(),PATH_CCENTER);
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
					if(!empty($_REQUEST['ccenter'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'cost_center');
						$value = array(
								'"'.$_REQUEST['ccenter'].'"'); 
						$query = mysql_stat_update(array('cost_center',$field,$value,'id_cost_center="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = CCENTER.' WHERE id_cost_center="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(CCENTER);
						//-------get header pada sql----------
						$name = gen_mysql_head(CCENTER);
						//-------set header pada handson------
						$sethead = "['ID','Cost Center'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Cost_Center',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_CCENTER.EDIT),array(),PATH_CCENTER);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = CCENTER.' WHERE id_cost_center="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$ccenter=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.$ccenter.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_CCENTER.'">View</a></span></div>';
				$name_field=array('Cost Center');
				$input_type=array(
							text_je(array('ccenter',$ccenter,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_CCENTER.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
		return $content;
	}
?>