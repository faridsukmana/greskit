<?php
	function manual_return(){
		//==============Mendefinisikan hak akses masing-masing level permission=================//
		if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && _FULL_){ // jika manager level 2
			$content .= modal_return(array(TMRETURN));
			$mreturn = MRETURN.' AND (J.state_journal_movement_id = "SJVST181012013921" OR J.state_journal_movement_id = "SJVST181015082513" OR J.state_journal_movement_id = "SJVST181017012129")';
		}else if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // jika manager level 1
			$content .= modal_return(array(TMRETURN));
			$mreturn = MRETURN.' AND (J.state_journal_movement_id = "SJVST181015082513" OR J.state_journal_movement_id = "SJVST181120050127")';
		}else if(_VIEW_ && !_DELETE_ && _EDIT_ && _INSERT_){ // jika technician
			$mreturn = MRETURN.' AND (J.state_journal_movement_id = "SJVST181012013921")';
		}
		
		$content .= '<br/><div class="ade">'.TMRETURN.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 89%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,150,300,250,100,100,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id($mreturn);
			//-------get header pada sql----------
			$name = gen_mysql_head($mreturn);
			//-------set header pada handson------
			$sethead = "['ID','Return Date','Item Name','Brand','State','Quantity']";
			//-------set id pada handson----------
			$setid = "[{data:'ID',className: 'htLeft'},{data:'Return_Date',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand',className: 'htLeft'},{data:'State',className: 'htLeft',renderer: 'html'},{data:'Quantity',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array($mreturn,$field,array('Edit'),array(PATH_MRETURN.EDIT),array('4'),PATH_MRETURN);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TMRETURN.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$name_field=array('Date Journal Movement','Spare Part Name','Quantity','Remark 1','Remark 2');
				$input_type=array(
							date_je(array('date','')),
							combo_je(array(COMBITEM,'spare','spare',250,'','')),
							text_je(array('quantity','','false')),
							text_area_je(array('remark1','','true')),
							text_area_je(array('remark2','','true'))
						);
				$signtofill = array('','<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'<small id="fill" class="form-text text-muted">Please fill this field.</small>',
									'',
									'');
				$content .= create_form(array('',PATH_MRETURN.ADD.POST,1,$name_field,$input_type,$signtofill)).js_topup();
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['spare']) && !empty($_REQUEST['quantity']) && !empty($_REQUEST['date'])){
						$mreturnid=get_new_code(array('MRETUN',$numrow,1));  
						//-- Update quantity inventory item after return item----//
						//$queryup = 'UPDATE invent_item SET stock=stock+'.$_REQUEST['quantity'].' WHERE item_id="'.$_REQUEST['spare'].'"';
						//mysql_exe_query(array($queryup,1)); 
						//-- Upadate for movement --//
						$movmntid=get_new_code(array('MOVMNT',$numrow,1));  
						//-- Insert data pada tabel movement --//
						/*$field = array(
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
									'"'.$mreturnid.'"',
									'"'.$_REQUEST['spare'].'"',
									'"'.date('Y-m-d').'"',
									'"'.$_REQUEST['quantity'].'"',
									'"Manual Return"',
									'"'.$_REQUEST['remark1'].'"',
									'"Manual Return - '.$mreturnid.'"',); 
						$query = mysql_stat_insert(array('invent_movement',$field,$value)); 
						mysql_exe_query(array($query,1)); */
						//-- Insert data pada kategori aset --//
						$field = array(
								'manualreturn_id',
								'item_id',
								'quantity',
								'remark1',
								'remark2',
								'date_return',
								'state_journal_movement_id');
						$value = array(
								'"'.$mreturnid.'"',
								'"'.$_REQUEST['spare'].'"',
								'"'.$_REQUEST['quantity'].'"',
								'"'.$_REQUEST['remark1'].'"',
								'"'.$_REQUEST['remark2'].'"',
								'"'.$_REQUEST['date'].'"',
								'"SJVST181012013921"'); 
						$query = mysql_stat_insert(array('invent_manual_return',$field,$value)); 
						mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = MRETURN.' AND manualreturn_id="'.$mreturnid.'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,150,300,250,100,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(MRETURN);
						//-------get header pada sql----------
						$name = gen_mysql_head(MRETURN);
						//-------set header pada handson------
						$sethead = "['ID','Return Date','Item Name','Brand','Quantity']";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Return_Date',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}]";
						//-------get data pada sql------------
						$dt = array(MRETURN.' AND  M.manualreturn_ID="'.$mreturnid.'"',$field,array('Edit'),array(PATH_MRETURN.EDIT),array(),PATH_MRETURN);
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
	
	function modal_return($data){
		$title = $_REQUEST['dataid'];
		//## KETIKA UPDATE STATE ##//
		if(ISSET($_REQUEST['state'])){
			$state = $_REQUEST['state'];
			$field = array(
					'state_journal_movement_id');
			$value = array(
					'"'.$_REQUEST['state'].'"'); 
			$query = mysql_stat_update(array('invent_manual_return',$field,$value,'manualreturn_id="'.$_REQUEST['dataid'].'"')); 
			mysql_exe_query(array($query,1));
			//Jika state yang diupdate adalah accept maka
			if($_REQUEST['state']=='SJVST181120050127'){ // jika status confirmed
				//$qtopup = 'SELECT item_id, qty, price FROM invent_topup WHERE id_topup="'.$_REQUEST['dataid'].'"';
				$qret = 'SELECT item_id, quantity, remark1, remark2, date_return, state_journal_movement_id FROM invent_manual_return WHERE manualreturn_id="'.$_REQUEST['dataid'].'"';
				$resultret=mysql_exe_query(array($qret,1));
				$resultnowret=mysql_exe_fetch_array(array($resultret,1)); 
				//-- Update stok pada invent_item----//
				$queryup = 'UPDATE invent_item SET stock=stock+'.$resultnowret['quantity'].' WHERE item_id="'.$resultnowret['item_id'].'"';
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
							'"'.$resultnowret[0].'"',
							'"'.date('Y-m-d').'"',
							'"'.$resultnowret[1].'"',
							'"Return"',
							'"'.$resultnowret[2].'"',
							'"'.$resultnowret[3].'"',); 
				$query = mysql_stat_insert(array('invent_movement',$field,$value)); 
				mysql_exe_query(array($query,1)); 
			}
		}
		
		//### FORM STATE##//
		$query = UPSTAMN.' WHERE manualreturn_id="'.$_REQUEST['dataid'].'"';
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
		
		$page = PATH_MRETURN.'&dataid='.$_REQUEST['dataid'].'#popup-article';
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