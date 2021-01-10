<?php
	function categories(){
		$content .= '<br/><div class="ade">'.TITEMCAT.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(ITEMCAT.' ORDER BY item_category_code DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(ITEMCAT.' ORDER BY item_category_code DESC');
			//-------set header pada handson------
			$sethead = "['Category Code','No Code','Description'"._USER_EDIT_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Category_Code',className: 'htLeft'},{data:'No_Code',className: 'htLeft'},{data:'Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
			//-------get data pada sql------------
			$dt = array(ITEMCAT.' ORDER BY item_category_code DESC',$field,array('Edit'),array(PATH_ITEMCAT.EDIT),array(),PATH_ITEMCAT);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TAITEMCAT.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('No Code','Category Description');
				$input_type=array(
							text_je(array('nocode','','false')),
							text_je(array('categorydescription','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array(FAITEMCAT,PATH_ITEMCAT.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['nocode']) && !empty($_REQUEST['categorydescription'])){
						//-- Generate a new id untuk kategori aset --// 
						$result = mysql_exe_query(array(COUNTITEMCAT,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $catid=get_new_code(array('IM',$numrow,2)); 
						//-- Insert data pada kategori aset --//
						$field = array(
								'item_category_code', 
								'item_category_description',
								'item_no_code');
						$value = array(
								'"'.$catid.'"',
								'"'.$_REQUEST['categorydescription'].'"',
								'"'.$_REQUEST['nocode'].'"'); 
						$query = mysql_stat_insert(array('invent_item_categories',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = ITEMCAT.' WHERE item_category_code="'.$catid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(ITEMCAT.' ORDER BY item_category_code DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(ITEMCAT.' ORDER BY item_category_code DESC');
						//-------set header pada handson------
						$sethead = "['Category Code','No Code','Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Category_Code',className: 'htLeft'},{data:'No_Code',className: 'htLeft'},{data:'Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_ITEMCAT.EDIT),array(),PATH_ITEMCAT);
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
					if(!empty($_REQUEST['nocode']) && !empty($_REQUEST['categorydescription'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'item_category_description',
								'item_no_code');
						$value = array(
								'"'.$_REQUEST['categorydescription'].'"',
								'"'.$_REQUEST['nocode'].'"'); 
						$query = mysql_stat_update(array('invent_item_categories',$field,$value,'item_category_code="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = ITEMCAT.' WHERE item_category_code="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(ITEMCAT.' ORDER BY item_category_code DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(ITEMCAT.' ORDER BY item_category_code DESC');
						//-------set header pada handson------
						$sethead = "['Category Code','No Code','Description'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Category_Code',className: 'htLeft'},{data:'No_Code',className: 'htLeft'},{data:'Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_ITEMCAT.EDIT),array(),PATH_ITEMCAT);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = ITEMCAT.' WHERE item_category_code="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$item_category_description=$resultnow[1]; $item_no_code=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EAITEMCAT.$item_category_description.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ITEMCAT.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('No Code','Category Description');
				$input_type=array(
							text_je(array('nocode',$item_no_code,'false')),
							text_je(array('categorydescription',$item_category_description,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array(FAITEMCAT,PATH_ITEMCAT.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
		return $content;
	}
?>