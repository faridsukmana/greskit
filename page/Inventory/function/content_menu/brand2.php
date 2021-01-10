<?php
	function brand2(){
		$content .= '<br/><div class="ade">'.TBRAND2.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(BRAND2.' ORDER BY brand_id DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(BRAND2.' ORDER BY brand_id DESC');
			//-------set header pada handson------
			$sethead = "['Brand ID','Short Name','Full Name'"._USER_EDIT_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Brand_ID',className: 'htLeft'},{data:'Short_Name',className: 'htLeft'},{data:'Full_Name',className: 'htLeft'}"._USER_EDIT_SETID_."]";
			//-------get data pada sql------------
			$dt = array(BRAND2.' ORDER BY brand_id DESC',$field,array('Edit'),array(PATH_BRAND2.EDIT),array(),PATH_BRAND2);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TABRAND2.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Short Name','Full Name');
				$input_type=array(
							text_je(array('shortname','','false')),
							text_je(array('fullname','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>','');
				$content .= create_form(array(FABRAND,PATH_BRAND2.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['shortname'])){
						//-- Generate a new id untuk kategori aset --// 
						$result = mysql_exe_query(array(COUNTBRAND,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $brid=get_new_code(array('BR',$numrow,2));  
						//-- Insert data pada kategori aset --//
						$field = array(
								'brand_id',
								'brand_short_name', 
								'brand_full_name');
						$value = array(
								'"'.$brid.'"',
								'"'.$_REQUEST['shortname'].'"',
								'"'.$_REQUEST['fullname'].'"'); 
						$query = mysql_stat_insert(array('invent_brand',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = BRAND.' WHERE brand_id="'.$brid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(BRAND.' ORDER BY brand_id DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(BRAND.' ORDER BY brand_id DESC');
						//-------set header pada handson------
						$sethead = "['Brand ID','Short Name','Full Name'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Brand_ID',className: 'htLeft'},{data:'Short_Name',className: 'htLeft'},{data:'Full_Name',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array(BRAND.' ORDER BY brand_id DESC',$field,array('Edit'),array(PATH_BRAND.EDIT),array(),PATH_BRAND);
						$data = get_data_handson_func($dt);
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_BRAND.EDIT),array(),PATH_BRAND);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content = empty_info(array('Ada field yang kosong mohon diisi')).$content;
					}
				}
			}
			
			
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['shortname'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'brand_short_name', 
								'brand_full_name');
						$value = array(
								'"'.$_REQUEST['shortname'].'"',
								'"'.$_REQUEST['fullname'].'"'); 
						$query = mysql_stat_update(array('invent_brand',$field,$value,'brand_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = BRAND.' WHERE brand_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(BRAND2.' ORDER BY brand_id DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(BRAND2.' ORDER BY brand_id DESC');
						//-------set header pada handson------
						$sethead = "['Brand ID','Short Name','Full Name'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Brand_ID',className: 'htLeft'},{data:'Short_Name',className: 'htLeft'},{data:'Full_Name',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_BRAND.EDIT),array(),PATH_BRAND);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = BRAND2.' WHERE brand_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$shortname=$resultnow[1]; $fullname=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EABRAND.$shortname.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_BRAND.'">View</a></span></div>';
				$name_field=array('Short Name','Full Name');
				$input_type=array(
							text_je(array('shortname',$shortname,'false')),
							text_je(array('fullname',$fullname,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>','');
				$content .= create_form(array(FAITEMCAT,PATH_BRAND2.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
		return $content;
	}
?>