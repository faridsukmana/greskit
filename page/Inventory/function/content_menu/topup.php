<?php
	function topup(){
		//==============Mendefinisikan hak akses masing-masing level permission=================//
		if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && _FULL_){ // jika manager level 2
			$content .= modal_topup(array(TTOPUP));
			$viewin = _USER_VIEW_._USER_INSERT_;
			$topup = TOPUP.' AND (IJ.state_journal_movement_id = "SJVST181012013921" OR IJ.state_journal_movement_id = "SJVST181015082513" OR IJ.state_journal_movement_id = "SJVST181017012129")';
		}else if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // jika manager level 1
			$content .= modal_topup(array(TTOPUP));
			$viewin = _USER_VIEW_._USER_INSERT_;
			$topup = TOPUP.' AND (IJ.state_journal_movement_id = "SJVST181015082513" OR IJ.state_journal_movement_id = "SJVST181120050127" OR IJ.state_journal_movement_id = "SJVST181012013921")';
		}else if(_VIEW_ && !_DELETE_ && _EDIT_ && _INSERT_){ // jika technician
			$viewin = _USER_VIEW_;
			$topup = TOPUP.' AND (IJ.state_journal_movement_id = "SJVST181012013921")';
		}
		
		$content .= '<br/><div class="ade">'.TTOPUP.'</div>';
		$content .= '<div class="toptext" align="center">'.$viewin.'</div>';
		$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom ------------- 
		$width = "[150,300,80,250,80,150,80,100]";
		//-------get id pada sql -------------
		$field = gen_mysql_id($topup);
		//-------get header pada sql----------
		$name = gen_mysql_head($topup);
		//-------set header pada handson------
		$sethead = "['ID','Spare Part Name','Unit','Vendor','Qty','Price','State','PO Number']";
		//-------set id pada handson----------
		$setid = "[{data:'ID',className: 'htLeft'},{data:'Spare_Part_Name',className: 'htLeft'},{data:'Unit',className: 'htLeft'},{data:'Vendor',className: 'htLeft'},{data:'Qty',className: 'htLeft'},{data:'Price',type: 'numeric',format:'0,0.00'},{data:'State',className: 'htLeft', renderer: 'html'},{data:'PO_Number',className: 'htLeft'}]";
		//-------get data pada sql------------
		$dt = array($topup,$field,array('Edit'),array(PATH_TOPUP.EDIT),array('6'),PATH_TOPUP);
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		if (_VIEW_) $content .= get_handson($sethandson);
		//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TTOPUP.'</div>';
				$content .= '<div class="toptext" align="center">'.$viewin.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Date TopUp','Spare Part Name','Vendor Name','PO Number','Price','Qty');
				$input_type=array(
							date_je(array('date','')),
							combo_je(array(COMBITEM,'spare','spare',150,'','')),
							combo_je(array(COMBVENDOR,'vendor','vendor',150,'','')),
							text_je(array('po','','false')),
							text_je(array('price','','false')),
							text_je(array('qty','','false')),
						);
				$signtofill = array('','<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340000</small>',
									'<small id="fill" class="form-text text-muted">Format number ex. 340</small>');
				$content .= create_form(array('',PATH_TOPUP.ADD.POST,1,$name_field,$input_type,$signtofill)).js_topup();
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['spare']) && !empty($_REQUEST['vendor']) && !empty($_REQUEST['po']) && !empty($_REQUEST['price']) && !empty($_REQUEST['qty']) && !empty($_REQUEST['date'])){
						//-- Generate a new id untuk kategori aset --// 
						$topupid=get_new_code(array('TOPUP',$numrow,1));  
						//-- Insert data pada kategori aset --//
						$field = array(
								'id_topup',
								'item_id',
								'price',
								'vendor_id',
								'po_number',
								'qty',
								'state_journal_movement_id',
								'movement_type_id',
								'date_topup');
						$value = array(
								'"'.$topupid.'"',
								'"'.$_REQUEST['spare'].'"',
								'"'.$_REQUEST['price'].'"',
								'"'.$_REQUEST['vendor'].'"',
								'"'.$_REQUEST['po'].'"',
								'"'.$_REQUEST['qty'].'"',
								'"SJVST181012013921"',
								'"MOVET181011093620"',
								'"'.$_REQUEST['date'].'"'); 
						$query = mysql_stat_insert(array('invent_topup',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = TOPUP.' AND id_topup="'.$topupid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom ------------- 
						$width = "[150,300,80,250,80,150,100,80,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(TOPUP);
						//-------get header pada sql----------
						$name = gen_mysql_head(TOPUP);
						//-------set header pada handson------
						$sethead = "['ID','Spare Part Name','Unit','Vendor','Qty','Price','PO Number','State']";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Spare_Part_Name',className: 'htLeft'},{data:'Unit',className: 'htLeft'},{data:'Vendor',className: 'htLeft'},{data:'Qty',className: 'htLeft'},{data:'Price',type: 'numeric',format:'0,0.00'},{data:'PO_Number',className: 'htLeft'},{data:'State',className: 'htLeft'}]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_TOPUP.EDIT),array(),PATH_TOPUP);
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content = empty_info(array('Some field is empty')).$content;
					}
				}
			}
		
		return $content;
	}
	
	function modal_topup($data){
		$title = $_REQUEST['dataid'];
		//## KETIKA UPDATE STATE ##//
		if(ISSET($_REQUEST['state'])){
			$state = $_REQUEST['state'];
			$field = array(
					'state_journal_movement_id');
			$value = array(
					'"'.$_REQUEST['state'].'"'); 
			$query = mysql_stat_update(array('invent_topup',$field,$value,'id_topup="'.$_REQUEST['dataid'].'"')); 
			mysql_exe_query(array($query,1));
			//Jika state yang diupdate adalah accept maka
			if($_REQUEST['state']=='SJVST181120050127'){ // jika status confirmed
				//$qtopup = 'SELECT item_id, qty, price FROM invent_topup WHERE id_topup="'.$_REQUEST['dataid'].'"';
				$qtopup = 'SELECT IT.item_id, IO.qty, IO.price, IO.po_number, CONCAT("Purchase"," ",IT.item_description," from vendor ",IV.vendor_name) FROM invent_item IT, invent_vendor IV, invent_topup IO WHERE IT.item_id=IO.item_id AND IV.vendor_id=IO.vendor_id AND id_topup="'.$_REQUEST['dataid'].'"';
				$resulttopup=mysql_exe_query(array($qtopup,1));
				$resultnowtopup=mysql_exe_fetch_array(array($resulttopup,1)); 
				//-- Update stok pada invent_item----//
				$queryavg = 'SELECT AVG(price) FROM invent_topup WHERE item_id="'.$resultnowtopup[0].'"';
				$resultavg = mysql_exe_query(array($queryavg,1));
				$resultnowavg=mysql_exe_fetch_array(array($resultavg,1));
				$avg=$resultnowavg[0];
				$queryup = 'UPDATE invent_item SET stock=stock+'.$resultnowtopup[1].', last_price="'.$resultnowtopup[2].'", avg_price="'.$avg.'" WHERE item_id="'.$resultnowtopup[0].'"';
				mysql_exe_query(array($queryup,1)); 
				//-- Upadate for movement --//
				$movmntid=get_new_code(array('MOVMNT',$numrow,1));  
				//-- Insert data pada tabel movement --//
				$field = array(
							'movement_id',
							'id_topup',
							'item_id',
							'movement_date',
							'qty',
							'type',
							'remark1',
							'remark2');
				$value = array(
							'"'.$movmntid.'"',
							'"'.$_REQUEST['dataid'].'"',
							'"'.$resultnowtopup[0].'"',
							'"'.date('Y-m-d').'"',
							'"'.$resultnowtopup[1].'"',
							'"Top Up"',
							'"'.$resultnowtopup[3].'"',
							'"'.$resultnowtopup[4].'"',); 
				$query = mysql_stat_insert(array('invent_movement',$field,$value)); 
				mysql_exe_query(array($query,1)); 
			}
		}
		
		//### FORM STATE##//
		$query = UPSTATE.' WHERE id_topup="'.$_REQUEST['dataid'].'"';
		$result=mysql_exe_query(array($query,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $stateid = $resultnow[0];
		//### MENDEFINISIKAN COMBSTATE JIKA STATUS ADALAH Send Approve atau Refused //
		if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && _FULL_){ // manager
			if($stateid=='SJVST181012013921')
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181012013921","SJVST181120050127")';
			else
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
		}else if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // technician/SC suppliy chain
			if($stateid=='SJVST181017012129'){
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
			}else if($stateid=='SJVST181015082513'){
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129")';
			}else{
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
			}
		}else if(_VIEW_ && !_DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // user
			$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
		}else{
			$qstate = COMBSTATE;
		} 
		
		$page = PATH_TOPUP.'&dataid='.$_REQUEST['dataid'].'#popup-article';
		$name_field=array('State');
		$input_type=array(
							combo_je(array($qstate,'state','state',300,'',$state))
		);
		$signtofill = array('<small id="fill" class="form-text text-muted">Update state after send.</small>');
		$form = create_form(array('',$page,1,$name_field,$input_type,$signtofill));
		//### ############//
		
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$title.'</h1>
				'.$form.'
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		return $content;
	}
?>