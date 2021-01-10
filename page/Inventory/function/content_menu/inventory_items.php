<?php
	function inventory_items(){
		if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_){
			$content .= detail_item(array(TITEM));
		}
		$content .= '<br/><div class="ade">'.TITEM.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 89%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,400,200,200,100,100,105,80,80,80,80,100,100,120,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(ITEM);
			//-------get header pada sql----------
			$name = gen_mysql_head(ITEM);
			//-------set header pada handson------
			$sethead = "['Item ID','Item Name','Brand Name','Category'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Critical Level','Unit','Min','Max','Stock','Last Price','Avg Price','Warehouse','Location']";
			//-------set id pada handson----------
			$setid = "[{data:'Item_ID',className: 'htLeft',renderer: 'html'},{data:'Item_Name',className: 'htLeft'},{data:'Brand_Name',className: 'htLeft'},{data:'Category',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Critical_Level',className: 'htLeft'},{data:'Unit',className: 'htLeft'},{data:'Min',className: 'htLeft'},{data:'Max',className: 'htLeft'},{data:'Stock',className: 'htLeft'},{data:'Last_Price',className: 'htLeft'},{data:'Avg_Price',className: 'htLeft'},{data:'Warehouse',className: 'htLeft'},{data:'Location',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(ITEM,$field,array('Edit','Delete'),array(PATH_ITEM.EDIT,PATH_ITEM.DELETE),array('0'),PATH_ITEM);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TAITEM.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Item Code','Brand','Category','Critical Level','Unit','Warehouse','Currency','Location','Minimum Quantity','Maximum Quantity','Item Name','Remark 1','Remark 2','Remark 3','Remark 4','Remark 5');
				$input_type=array(
							text_je(array('itemcode','','false')),
							combo_je(array(COMBRAND,'brand','brand',250,'','')),
							combo_je(array(COMITEMCAT,'itemcat','itemcat',250,'','')),
							combo_je(array(COMBCRLEVEL,'crlevel','crlevel',250,'','')),
							combo_je(array(COMBUNIT,'unit','unit',250,'','')),
							combo_je(array(COMBWRHOUSE,'wrhouse','wrhouse',250,'','')),
							combo_je(array(COMBCURR,'curr','curr',250,'','')),
							combo_je(array(COMBLOCATION,'location','location',250,'','')),
							text_je(array('min','','false')),
							text_je(array('max','','false')),
							text_je(array('itemname','','false')),
							text_area_je(array('remark1','','true')),
							text_area_je(array('remark2','','true')),
							text_area_je(array('remark3','','true')),
							text_area_je(array('remark4','','true')),
							text_area_je(array('remark5','','true'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>','','','','','','');
				$content .= create_form(array(FAITEM,PATH_ITEM.ADD.POST,1,$name_field,$input_type,$signtofill));
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					//-- Check item code already exist or not --// 
					$querydat = ITEM.' AND IT.item_id="'.$_REQUEST['itemcode'].'"';
					$result = mysql_exe_query(array($querydat,1)); $numrow=mysql_exe_num_rows(array($result,1)); 
					if($numrow>0){
						$content = empty_info(array('Item Code Already Exist')).$content;
					}else if(!empty($_REQUEST['itemcode']) && !empty($_REQUEST['brand']) && !empty($_REQUEST['itemcat']) && !empty($_REQUEST['crlevel']) && !empty($_REQUEST['unit']) && !empty($_REQUEST['wrhouse']) && !empty($_REQUEST['curr']) && !empty($_REQUEST['location'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'item_id', 
								'brand_id',
								'item_category_code',
								'item_description',
								'critical_id',
								'min',
								'max',
								'remark_1',
								'remark_2',
								'remark_3',
								'remark_4',
								'remark_5',
								'id_unit',
								'warehouse_id',
								'currency_id',
								'id_location');
						$value = array(
								'"'.$_REQUEST['itemcode'].'"',
								'"'.$_REQUEST['brand'].'"',
								'"'.$_REQUEST['itemcat'].'"',
								'"'.$_REQUEST['itemname'].'"',
								'"'.$_REQUEST['crlevel'].'"',
								'"'.$_REQUEST['min'].'"',
								'"'.$_REQUEST['max'].'"',
								'"'.$_REQUEST['remark1'].'"',
								'"'.$_REQUEST['remark2'].'"',
								'"'.$_REQUEST['remark3'].'"',
								'"'.$_REQUEST['remark4'].'"',
								'"'.$_REQUEST['remark5'].'"',
								'"'.$_REQUEST['unit'].'"',
								'"'.$_REQUEST['wrhouse'].'"',
								'"'.$_REQUEST['curr'].'"',
								'"'.$_REQUEST['location'].'"'); 
						$query = mysql_stat_insert(array('invent_item',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = ITEM.' AND IT.item_id="'.$_REQUEST['itemcode'].'"';
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,400,200,200,100,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(ITEM);
						//-------get header pada sql----------
						$name = gen_mysql_head(ITEM);
						//-------set header pada handson------
						$sethead = "['Item ID','Item Name','Brand Name','Category'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand_Name',className: 'htLeft'},{data:'Category',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_ITEM.EDIT,PATH_ITEM.DELETE),array(),PATH_ITEM);
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
					if(!empty($_REQUEST['brand']) && !empty($_REQUEST['itemcat']) && !empty($_REQUEST['crlevel']) && !empty($_REQUEST['unit']) && !empty($_REQUEST['wrhouse']) && !empty($_REQUEST['curr'])){
						//-- Update data--//
						$field = array(
								'brand_id',
								'item_category_code',
								'item_description',
								'critical_id',
								'min',
								'max',
								'remark_1',
								'remark_2',
								'remark_3',
								'remark_4',
								'remark_5',
								'id_unit',
								'warehouse_id',
								'currency_id',
								'id_location');
						$value = array(
								'"'.$_REQUEST['brand'].'"',
								'"'.$_REQUEST['itemcat'].'"',
								'"'.$_REQUEST['itemname'].'"',
								'"'.$_REQUEST['crlevel'].'"',
								'"'.$_REQUEST['min'].'"',
								'"'.$_REQUEST['max'].'"',
								'"'.$_REQUEST['remark1'].'"',
								'"'.$_REQUEST['remark2'].'"',
								'"'.$_REQUEST['remark3'].'"',
								'"'.$_REQUEST['remark4'].'"',
								'"'.$_REQUEST['remark5'].'"',
								'"'.$_REQUEST['unit'].'"',
								'"'.$_REQUEST['wrhouse'].'"',
								'"'.$_REQUEST['curr'].'"',
								'"'.$_REQUEST['location'].'"'); 
						$query = mysql_stat_update(array('invent_item',$field,$value,'item_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = ITEM.' AND IT.item_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,400,200,200,100,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(ITEM);
						//-------get header pada sql----------
						$name = gen_mysql_head(ITEM);
						//-------set header pada handson------
						$sethead = "['Item ID','Item Name','Brand Name','Category'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand_Name',className: 'htLeft'},{data:'Category',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_ITEM.EDIT,PATH_ITEM.DELETE),array(),PATH_ITEM);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EITEM.' WHERE item_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$brand=$resultnow[1]; $itemcat=$resultnow[2]; $itemname=$resultnow[3]; $remark1=$resultnow[4]; $remark2=$resultnow[5]; $remark3=$resultnow[6]; $remark4=$resultnow[7]; $remark5=$resultnow[8]; $crlevel=$resultnow[9]; $min=$resultnow[10]; $max=$resultnow[11]; $unit=$resultnow[12]; $wrhouse= $resultnow[13]; $curr=$resultnow[14]; $location=$resultnow[15];
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EAITEM.$itemname.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ITEM.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Brand','Category','Critical Level','Unit','Warehouse','Currency','Location','Minimum Quantity','Maximum Quantity','Item Name','Remark 1','Remark 2','Remark 3','Remark 4','Remark 5');
				$input_type=array(
							combo_je(array(COMBRAND,'brand','brand',250,'',$brand)),
							combo_je(array(COMITEMCAT,'itemcat','itemcat',250,'',$itemcat)),
							combo_je(array(COMBCRLEVEL,'crlevel','crlevel',250,'',$crlevel)),
							combo_je(array(COMBUNIT,'unit','unit',250,'',$unit)),
							combo_je(array(COMBWRHOUSE,'wrhouse','wrhouse',250,'',$wrhouse)),
							combo_je(array(COMBCURR,'curr','curr',250,'',$curr)),
							combo_je(array(COMBLOCATION,'location','location',250,'',$location)),
							text_je(array('min',$min,'false')),
							text_je(array('max',$max,'false')),
							text_je(array('itemname',$itemname,'false')),
							text_area_je(array('remark1',$remark1,'true')),
							text_area_je(array('remark2',$remark2,'true')),
							text_area_je(array('remark3',$remark3,'true')),
							text_area_je(array('remark4',$remark4,'true')),
							text_area_je(array('remark5',$remark5,'true'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>','','','','','','');
				$content .= create_form(array(FAITEMCAT,PATH_ITEM.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
			
			//------------Jika ada halaman rp data-------//
			if(isset($_REQUEST['rp'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['brand']) && !empty($_REQUEST['itemcat']) && !empty($_REQUEST['crlevel']) && !empty($_REQUEST['unit']) && !empty($_REQUEST['wrhouse']) && !empty($_REQUEST['curr'])){
						//-- Update data--//
						$field = array(
								'brand_id',
								'item_category_code',
								'item_description',
								'critical_id',
								'min',
								'max',
								'remark_1',
								'remark_2',
								'remark_3',
								'remark_4',
								'remark_5',
								'id_unit',
								'warehouse_id',
								'currency_id');
						$value = array(
								'"'.$_REQUEST['brand'].'"',
								'"'.$_REQUEST['itemcat'].'"',
								'"'.$_REQUEST['itemname'].'"',
								'"'.$_REQUEST['crlevel'].'"',
								'"'.$_REQUEST['min'].'"',
								'"'.$_REQUEST['max'].'"',
								'"'.$_REQUEST['remark1'].'"',
								'"'.$_REQUEST['remark2'].'"',
								'"'.$_REQUEST['remark3'].'"',
								'"'.$_REQUEST['remark4'].'"',
								'"'.$_REQUEST['remark5'].'"',
								'"'.$_REQUEST['unit'].'"',
								'"'.$_REQUEST['wrhouse'].'"',
								'"'.$_REQUEST['curr'].'"'); 
						$query = mysql_stat_update(array('invent_item',$field,$value,'item_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = ITEM.' AND IT.item_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,400,200,200,100,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(ITEM);
						//-------get header pada sql----------
						$name = gen_mysql_head(ITEM);
						//-------set header pada handson------
						$sethead = "['Item ID','Item Name','Brand Name','Category'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand_Name',className: 'htLeft'},{data:'Category',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_ITEM.EDIT,PATH_ITEM.DELETE),array(),PATH_ITEM);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EITEM.' WHERE item_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$brand=$resultnow[1]; $itemcat=$resultnow[2]; $itemname=$resultnow[3]; $remark1=$resultnow[4]; $remark2=$resultnow[5]; $remark3=$resultnow[6]; $remark4=$resultnow[7]; $remark5=$resultnow[8]; $crlevel=$resultnow[9]; $min=$resultnow[10]; $max=$resultnow[11]; $unit=$resultnow[12]; $wrhouse= $resultnow[13]; $curr=$resultnow[14]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.EAITEM.$itemname.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ITEM.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Brand','Category','Critical Level','Unit','Warehouse','Currency','Minimum Quantity','Maximum Quantity','Item Name','Remark 1','Remark 2','Remark 3','Remark 4','Remark 5');
				$input_type=array(
							combo_je(array(COMBRAND,'brand','brand',250,'',$brand)),
							combo_je(array(COMITEMCAT,'itemcat','itemcat',250,'',$itemcat)),
							combo_je(array(COMBCRLEVEL,'crlevel','crlevel',250,'',$crlevel)),
							combo_je(array(COMBUNIT,'unit','unit',250,'',$unit)),
							combo_je(array(COMBWRHOUSE,'wrhouse','wrhouse',250,'',$wrhouse)),
							combo_je(array(COMBCURR,'curr','curr',250,'',$curr)),
							text_je(array('min',$min,'false')),
							text_je(array('max',$max,'false')),
							text_je(array('itemname',$itemname,'false')),
							text_area_je(array('remark1',$remark1,'true')),
							text_area_je(array('remark2',$remark2,'true')),
							text_area_je(array('remark3',$remark3,'true')),
							text_area_je(array('remark4',$remark4,'true')),
							text_area_je(array('remark5',$remark5,'true'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>','','','','','','');
				$content .= create_form(array(FAITEMCAT,PATH_ITEM.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content = $error.$content.$info;
			}
			
			//------------Jika upload excel -------------------//
			if(isset($_REQUEST['upload'])){
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">Upload Excel For Item</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ITEM.'">View</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('','Item Data');
				$input_type=array(
							'',
							text_filebox(array('item',''))
						);
				$signtofill = array('<small><a href="'._ROOT_.'file/item.xls">Download excel format for upload data</a></small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>');
				$content .= create_form(array('',PATH_ITEM.UPLOAD.POST,1,$name_field,$input_type,$signtofill));
				
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'file/';
						$target_file = $target_dir.basename($_FILES['item']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= empty_info(array('Sorry, only XLS files are allowed'));
							$typeupload = 0;
						}
						
						if($_FILES['item']['size']>500000){
							$content .= empty_info(array('Sorry, your files is too large (Max 500KB)'));
							$sizeupload = 0;
						}
						
						if($typeupload==0 || $sizeupload==0){
							$content .= empty_info(array('Sorry, your file not uploaded'));
						}else{
							if(!move_uploaded_file($_FILES['item']['tmp_name'],$target_file)){
								throw new RuntimeException(empty_info(array('Failed to move uploaded file. Your file still open')));
							}else{
								parseExcel($target_file,0,'item');
								$content .= success_info(array('The File '.basename($_FILES['item']['name']).' has been uploaded and success generated'));
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			
			//------------Jika ada halaman delete data-------//
			if(isset($_REQUEST['delete'])){
				$content = query_delete(array(PATH_ITEM,'invent_item','item_id="'.$_REQUEST['rowid'].'"'));
			}
		return $content;
	}
	
	function detail_item($data){
		$title = $_REQUEST['dataid'];
		
		//--------------Insert Path QRCODE ke database----------------------------------
		if(ISSET($_REQUEST['qrcode'])){
			$field = array(
				'qrpath');
			$value = array(
					'"'.$_REQUEST['qrcode'].'"'); 
			$query = mysql_stat_update(array('invent_item',$field,$value,'item_id="'.$_REQUEST['dataid'].'"')); 
			mysql_exe_query(array($query,1));
		}
		
		$query = ITEM.' AND  IT.item_id="'.$_REQUEST['dataid'].'"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1)); 
		//--------------Generate QR CODE------------------------------------------------
		if(empty($result_now[12])){
			$target_dir = _ROOT_.'file/qrcode/';
			$qrcodeFilePath = $target_dir.md5($_REQUEST['dataid']).'.png';
			QRcode::png($_REQUEST['dataid'], $qrcodeFilePath,QR_ECLEVEL_L, 4);   
			$page = PATH_ITEM.'&dataid='.$_REQUEST['dataid'].'#popup-article';
			$qrform .= '
				<div style="width:300px;">
					<form action="'.$page.'" method="post" enctype="multipart/form-data">
						<input type="hidden" name="qrcode" value="'.$qrcodeFilePath.'"
						<p><input class="form-submit" type="submit" value="Get QR Code"></p>
					</form>
				</div>
			';	
		}else{
			$qrform = '<a class="btn btn-success" href="'.$result_now[12].'" role="button">Download QR Code</a>';
		}
		
		//## KETIKA UPDATE STATE ##//
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$result_now[0].'</h1>'.$qrform.'
				<img src="'.$result_now[12].'" class="popup__media popup__media_right" alt="No QR Code of WO" style="max-width:300px;max-height:300px;">
				<table class="text-popup">
				<tr height="30"><td>Item Name </td><td> : </td><td>'.$result_now[1].'</td>
				<tr height="30"><td>Brand Name </td><td> : </td><td>'.$result_now[2].'</td>
				<tr height="30"><td>Category </td><td> : </td><td>'.$result_now[3].'</td>
				<tr height="30"><td>Critical Level </td><td> : </td><td>'.$result_now[4].'</td>
				<tr height="30"><td>Min Stock </td><td> : </td><td>'.$result_now[5].'</td>
				<tr height="30"><td>Max Stock </td><td> : </td><td>'.$result_now[6].'</td>
				<tr height="30"><td>Unit </td><td> : </td><td>'.$result_now[7].'</td>
				<tr height="30"><td>Stock </td><td> : </td><td>'.$result_now[8].'</td>
				<tr height="30"><td>Last Price </td><td> : </td><td>'.$result_now[9].'</td>
				<tr height="30"><td>Avarage Price</td><td> : </td><td>'.$result_now[10].'</td>
				<tr height="30"><td>Warehouse</td><td> : </td><td>'.$result_now[11].'</td>
				<tr height="30"><td>Location</td><td> : </td><td>'.$result_now[14].'</td>
				</table>
				
				
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		return $content;
	}
?>