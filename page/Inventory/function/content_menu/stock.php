<?php
	function stock(){
		$content .= '<br/><div class="ade">'.TSTOCK.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(STOCK.' ORDER BY IT.item_description DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(STOCK.' ORDER BY IT.item_description DESC');
			//-------set header pada handson------
			$sethead = "['Item ID','Item Name','Stock'"._USER_EDIT_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Item_ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Stock',className: 'htRight'}"._USER_EDIT_SETID_."]";
			//-------get data pada sql------------
			$dt = array(STOCK.' ORDER BY IT.item_description DESC',$field,array('Edit'),array(PATH_STOCK.EDIT),array(),PATH_STOCK);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TASTOCK.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Item Name','Stock');
				$input_type=array(
							combo_je(array(COMSTOCKITEM,'item','item',200,'','')),
							text_je(array('stock','','false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>','');
				$content .= create_form(array(FASTOCK,PATH_STOCK.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['item']) && !empty($_REQUEST['stock'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'item_id', 
								'quantity');
						$value = array(
								'"'.$_REQUEST['item'].'"',
								'"'.$_REQUEST['stock'].'"'); 
						$query = mysql_stat_insert(array('invent_stock',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = STOCK.' AND IT.item_id="'.$_REQUEST['item'].'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(STOCK.' ORDER BY IT.item_description DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(STOCK.' ORDER BY IT.item_description DESC');
						//-------set header pada handson------
						$sethead = "['Item ID','Item Name','Stock'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Stock',className: 'htRight'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_STOCK.EDIT),array(),PATH_STOCK);
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
					if(!empty($_REQUEST['stock']) && is_numeric($_REQUEST['stock'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'quantity');
						$value = array(
								'"'.$_REQUEST['stock'].'"'); 
						$query = mysql_stat_update(array('invent_stock',$field,$value,'item_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = STOCK.' AND IT.item_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,200,200,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(STOCK.' ORDER BY IT.item_description DESC');
						//-------get header pada sql----------
						$name = gen_mysql_head(STOCK.' ORDER BY IT.item_description DESC');
						//-------set header pada handson------
						$sethead = "['Item ID','Item Name','Stock'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Stock',className: 'htRight'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_STOCK.EDIT),array(),PATH_STOCK);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = ESTOCK.' WHERE item_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$stock=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EASTOCK.$_REQUEST['rowid'].'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_STOCK.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Stock');
				$input_type=array(
							text_je(array('stock',$stock,'false'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>','');
				$content .= create_form(array(FASTOCK,PATH_STOCK.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
		return $content;
	}
?>