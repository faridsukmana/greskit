<?php
	function rp(){ 
		$content .= '<br/><div class="ade">'.TPLANRP.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[150,400,300,100,100,100,250,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(PLANRP);
			//-------get header pada sql----------
			$name = gen_mysql_head(PLANRP);
			//-------set header pada handson------
			$sethead = "['ID','Item Name','Vendor','Date'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Department','Quantity']";
			//-------set id pada handson----------
			$setid = "[{data:'ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Vendor',className: 'htLeft'},{data:'Date',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Department',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(PLANRP,$field,array('Edit','Delete'),array(PATH_PLANRP.EDIT,PATH_PLANRP.DELETE),array(),PATH_PLANRP);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TPLANRP.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Date','Item Name','Vendor','Department','Quantity','Remark 1','Remark 2');
				$input_type=array(
							date_je(array('date','')),
							combo_je(array(COMBITEM,'item','item',250,'','')),
							combo_je(array(COMBVENDOR,'vendor','vendor',250,'','')),
							combo_je(array(COMBDEPARTMENT,'dept','dept',250,'','')),
							text_je(array('qty','','false')),
							text_area_je(array('remark1','','true')),
							text_area_je(array('remark2','','true'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>','','');
				$content .= create_form(array('',PATH_PLANRP.ADD.POST,1,$name_field,$input_type,$signtofill)).js_topup();
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['date']) && !empty($_REQUEST['item']) && !empty($_REQUEST['dept']) && !empty($_REQUEST['qty'])){
						//-- Generate a new id untuk kategori aset --// 
						$rpid=get_new_code(array('PLANPR',$numrow,1));   
						//-- Insert data pada kategori aset --//
						$field = array(
								'rp_id',
								'item_id', 
								'departmentid',
								'qty',
								'remark1',
								'remark2',
								'created_by',
								'date_rp',
								'vendor_id');
						$value = array(
								'"'.$rpid.'"',
								'"'.$_REQUEST['item'].'"',
								'"'.$_REQUEST['dept'].'"',
								'"'.$_REQUEST['qty'].'"',
								'"'.$_REQUEST['remark1'].'"',
								'"'.$_REQUEST['remark2'].'"',
								'"'.$_SESSION['user'].'"',
								'"'.$_REQUEST['date'].'"',
								'"'.$_REQUEST['vendor'].'"'); 
						$query = mysql_stat_insert(array('invent_rp',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = PLANRP.' AND rp_id="'.$rpid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,400,300,100,100,100,250,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(PLANRP);
						//-------get header pada sql----------
						$name = gen_mysql_head(PLANRP);
						//-------set header pada handson------
						$sethead = "['ID','Item Name','Vendor','Date'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Department','Quantity']";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Vendor',className: 'htLeft'},{data:'Date',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Department',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_PLANRP.EDIT,PATH_PLANRP.DELETE),array(),PATH_PLANRP);
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
					if(!empty($_REQUEST['date']) && !empty($_REQUEST['item']) && !empty($_REQUEST['dept']) && !empty($_REQUEST['qty'])){
						//-- Insert data pada kategori aset --//
						$field = array(
								'item_id', 
								'departmentid',
								'qty',
								'remark1',
								'remark2',
								'date_rp',
								'vendor_id');
						$value = array(
								'"'.$_REQUEST['item'].'"',
								'"'.$_REQUEST['dept'].'"',
								'"'.$_REQUEST['qty'].'"',
								'"'.$_REQUEST['remark1'].'"',
								'"'.$_REQUEST['remark2'].'"',
								'"'.$_REQUEST['date'].'"',
								'"'.$_REQUEST['vendor'].'"'); 
						$query = mysql_stat_update(array('invent_rp',$field,$value,'rp_id="'.$_REQUEST['rowid'].'"')); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = PLANRP.' AND rp_id="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[150,400,300,100,100,100,250,100]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(PLANRP);
						//-------get header pada sql----------
						$name = gen_mysql_head(PLANRP);
						//-------set header pada handson------
						$sethead = "['ID','Item Name','Vendor','Date'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Department','Quantity']";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Vendor',className: 'htLeft'},{data:'Date',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Department',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_PLANRP.EDIT,PATH_PLANRP.DELETE),array(),PATH_PLANRP);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$error = empty_info(array('Some field is empty')).$info;
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDPLANRP.' WHERE rp_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$date=$resultnow[1]; $item=$resultnow[2]; $vendor=$resultnow[3]; $dept=$resultnow[4]; $qty=$resultnow[5]; $remark1=$resultnow[6]; $remark2=$resultnow[7]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">'.TPLANRP.$shortname.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_PLANRP.'">View</a></span></div>';
				$content .= '<div align="center">
								<a href="'.PATH_PLANRP.TPRINT.'&rowid='.$_REQUEST['rowid'].'&blankpage=ok" rel="noopener noreferrer" target="_blank" class="btn btn-success btn-lg">
									<span class="glyphicon glyphicon-print"></span> Print 
								</a>
							</div>';
				$name_field=array('Date','Item Name','Vendor','Department','Quantity','Remark 1','Remark 2');
				$input_type=array(
							date_je(array('date',$date)),
							combo_je(array(COMBITEM,'item','item',250,'',$item)),
							combo_je(array(COMBVENDOR,'vendor','vendor',250,'',$vendor)),
							combo_je(array(COMBDEPARTMENT,'dept','dept',250,'',$dept)),
							text_je(array('qty',$qty,'false')),
							text_area_je(array('remark1',$remark1,'true')),
							text_area_je(array('remark2',$remark2,'true'))
						);
				$signtofill = array('<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>','','');
				$content .= create_form(array('',PATH_PLANRP.EDIT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill)).js_topup();
				$content = $error.$content.$info;
			}
			
			if(isset($_REQUEST['print'])){
				$content = print_rp();
			}
			
			//------------Jika ada halaman delete data-------//
			if(isset($_REQUEST['delete'])){
				$content = query_delete(array(PATH_PLANRP,'invent_rp','rp_id="'.$_REQUEST['rowid'].'"'));
			}
			
		return $content;
	}
	
	function print_rp(){
		$querydat = PLANRP.' AND rp_id="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
		
		$content = '<body onload="window.print()">
						<center>
						<h2>PLAN PURCHASE ORDER : '.$_REQUEST['rowid'].'</h2>
						</center>
						<hr>
						<table class="table table-bordered" style="margin-bottom: 10px">
							<tr>
								<th>ID</th>
								<th>Item Name</th>
								<th>Date</th>
								<th>Vendor</th>
								<th>Department</th>
								<th>Quantity</th>
								<th>Remark 1</th>
								<th>Remark 2</th>
							</tr>
							<tr>
								<td>'.$resultnow[0].'</th>
								<td>'.$resultnow[1].'</th>
								<td>'.$resultnow[2].'</th>
								<td>'.$resultnow[3].'</th>
								<td>'.$resultnow[4].'</th>
								<td>'.$resultnow[5].'</th>
								<td>'.$resultnow[6].'</th>
								<td>'.$resultnow[7].'</th>
							</tr>
						</table>
						
						<div style="margin-left:800px;">
							<table style="border:none;">
								<tr width="400"><br/><br/><br/>Manager : </tr>
								<tr width="400"><br/><br/><br/><br/><br/>.................................</tr>
							</table>
						</div>
					</body>';
		return $content;
	}
?>