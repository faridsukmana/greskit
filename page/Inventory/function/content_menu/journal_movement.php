<?php
	function journal_movement(){
		if(isset($_REQUEST['delete'])){
			$jv_query = 'SELECT state FROM invent_journal_movement WHERE jvmovement_id="'.$_REQUEST['rowid'].'"';
			$rjv = mysql_exe_query(array($jv_query,1));
			$rn_jv = mysql_exe_fetch_array(array($rjv,1));
			$state = $rn_jv['state'];
			if($state=="SJVST181120050127"){
				$content .= "<script>alert('Sorry this data already confirmed, cant delete it.')</script>";
			}else{
				$del_query = 'DELETE FROM invent_journal_movement WHERE jvmovement_id="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($del_query,1));
				$content .= "<script>alert('Your data was delete.')</script>";
			}
		}
	
		//==============Mendefinisikan hak akses masing-masing level permission=================//
		if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && _FULL_){ // jika manager level 2
			$content .= modal_jmovement(array(TJVMOVEMENT));
			$jmove = JVMOVEMENT.' AND (S.state_journal_movement_id = "SJVST181012013921" OR S.state_journal_movement_id = "SJVST181015082513" OR S.state_journal_movement_id = "SJVST181017012129")';
		}else if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // jika manager level 1
			$content .= modal_jmovement(array(TJVMOVEMENT));
			$jmove = JVMOVEMENT.' AND (S.state_journal_movement_id = "SJVST181015082513" OR S.state_journal_movement_id = "SJVST181120050127")';
		}else if(_VIEW_ && !_DELETE_ && _EDIT_ && _INSERT_){ // jika technician
			$jmove = JVMOVEMENT.' AND (S.state_journal_movement_id = "SJVST181012013921")';
		}
		
		$content .= '<br/><div class="ade">'.TJVMOVEMENT.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 89%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,100,200,150,250,100,100,130,150,100,200,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id($jmove);
			//-------get header pada sql----------
			$name = gen_mysql_head($jmove);
			//-------set header pada handson------
			$sethead = "['ID','Date','Item Name','Brand','Cost Center','Warehouse','State','Take By','Number of Stock', 'Work Order', 'Site'"._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'ID',className: 'htLeft'},{data:'Date',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand',className: 'htLeft'},{data:'Cost_Center',className: 'htLeft'},{data:'Warehouse',className: 'htLeft'},{data:'State',className: 'htLeft', renderer: 'html'},{data:'Take_By',className: 'htLeft'},{data:'Number_of_Stock',className: 'htLeft'},{data:'Work_Order',className: 'htLeft'},{data:'Site',className: 'htLeft'}"._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array($jmove,$field,array('Edit','Delete'),array(PATH_JVMOVEMENT.EDIT,PATH_JVMOVEMENT.DELETE),array('6'),PATH_JVMOVEMENT);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">'.TJVMOVEMENT.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				
				$table = '
				<table id="itemdata" class="table table-bordered" style="width:100%;font-size: 14px; ">
					<thead>
						<tr>
							<th> No </th>
							<th> Item Code </th>
							<th> Item Name </th>
							<th> Quantity </th>
							<th> Remark </th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>	
				</table>
				';
				
				$input = '<div>
							<form action="'.PATH_JVMOVEMENT.ADD.POST.'" method="post" enctype="multipart/form-data">
								<div class="d-flex justify-content-center">
									<div><label>Date</label>'.date_je(array('date','')).'</div>
								</div>
								<div class="d-flex justify-content-center">
									'.combo_je(array(COMBWORDER,'worder','worder',250,'<option value="">Choose WO Number ...</option>','')).'
								</div>
								<div class="d-flex justify-content-center">
									<input class="btn btn-success btn-lg" style="width:250px;" type="submit" value="Submit">
								</div>
								<div class="p-2 d-flex justify-content-center" >
									<div class="alert alert-primary" style="text-align:center;" id="progress">
										Loading Process.......................
									</div>
								</div>
								<div class="p-2 row">
									<div class="col-1"></div><div class="col-10">'.$table.'</div><div class="col-1"></div>
								<div class="row">
							</form>
						  </div>';
				
				$content .= $input.js_topup().js_movement();
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['worder']) && !empty($_REQUEST['date'])){
						$query = 'SELECT A.item_id, A.item_description, B.request_quantity FROM invent_item A, invent_item_work_order B WHERE A.item_id=B.itemspare AND WorkOrderNo="'.$_REQUEST['worder'].'"';
						$result = mysql_exe_query(array($query,1)); $info='';$i=1;
						while($resultnow = mysql_exe_fetch_array(array($result,1))){
							//-- Cek stock di dalam inventory //
							$qstock = 'SELECT stock, last_price FROM invent_item WHERE item_id="'.$result_now[0].'"';
							$resultstock = mysql_exe_query(array($qstock,1));
							$resultnowstock = mysql_exe_fetch_array(array($resultstock,1)); $stock_now=$resultnowstock[0]; $price=$resultnowstock[1];
							if($_REQUEST['stock']>$stock_now){
								$info .= empty_info(array('Availeble Stock in inventory '.$resultnow[1].' is '.$stock_now)).$content;
							}else if(isset($_REQUEST['check_'.$resultnow[0]])){
							//-- Generate a new id untuk kategori aset --// 
							$jvmovementid=get_new_code(array('JVMOVET',$numrow+$i,1)).$i;  
							//-- Insert data pada kategori aset --//
							$field = array(
									'jvmovement_id',
									'item_id',
									'id_cost_center',
									'take_by',
									'number_of_stock',
									'state',
									'remark1',
									'remark2',
									'date_jvmovement',
									'WorkOrderNo',
									'id_site');
							$value = array(
									'"'.$jvmovementid.'"',
									'"'.$resultnow[0].'"',
									'"CCENT181103120129"',
									'"'.$_SESSION['user'].'"',
									'"'.$resultnow[2].'"',
									'"SJVST181012013921"',
									'"'.$_REQUEST['text_'.$resultnow[0]].'"',
									'""',
									'"'.$_REQUEST['date'].'"',
									'"'.$_REQUEST['worder'].'"',
									'""'); 
							$query = mysql_stat_insert(array('invent_journal_movement',$field,$value));  
							mysql_exe_query(array($query,1)); 
							}
							$i++;
						}
						
						$content .= $info;
						//-- Ambil data baru dari database --//
						$querydat = JVMOVEMENT.' AND WorkOrderNo="'.$_REQUEST['worder'].'"'; 
						$content .= '<br/><div id="example1" style="width: 100%; height: 100%; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,100,200,150,250,100,100,130,100,80]";
						//-------get id pada sql -------------
						$field = gen_mysql_id(JVMOVEMENT);
						//-------get header pada sql----------
						$name = gen_mysql_head(JVMOVEMENT);
						//-------set header pada handson------
						$sethead = "['ID','Date','Item Name','Brand','Cost Center','Warehouse','Take By','Number of Stock','State'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'ID',className: 'htLeft'},{data:'Date',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand',className: 'htLeft'},{data:'Cost_Center',className: 'htLeft'},{data:'Warehouse',className: 'htLeft'},{data:'Take_By',className: 'htLeft'},{data:'Number_of_Stock',className: 'htLeft'},{data:'State',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						//-------get data pada sql------------
						$dt = array($querydat,$field,array('Edit'),array(PATH_JVMOVEMENT.EDIT),array(),PATH_JVMOVEMENT);
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
	
	function modal_jmovement($data){
		$title = $_REQUEST['dataid'];
		//## KETIKA UPDATE STATE ##//
		if(ISSET($_REQUEST['state'])){
			$state = $_REQUEST['state'];
			$field = array(
					'state');
			$value = array(
					'"'.$_REQUEST['state'].'"'); 
			
			if($_REQUEST['state']=='SJVST181015082513' || $_REQUEST['state']=='SJVST181017012129'){
				//-- Update State---//
				$query = mysql_stat_update(array('invent_journal_movement',$field,$value,'jvmovement_id="'.$_REQUEST['dataid'].'"')); 
				mysql_exe_query(array($query,1));
			}
			
			//Jika state yang diupdate adalah accept maka
			if($_REQUEST['state']=='SJVST181120050127'){
				$qjmove = 'SELECT item_id, number_of_stock, remark1, CONCAT("Jurnal Movement - ",jvmovement_id) FROM invent_journal_movement WHERE jvmovement_id="'.$_REQUEST['dataid'].'"';
				$resultjmove=mysql_exe_query(array($qjmove,1));
				$resultnowjmove=mysql_exe_fetch_array(array($resultjmove,1));
				
				//-- Cek stock di dalam inventory //
				$qstock = 'SELECT stock FROM invent_item WHERE item_id="'.$resultnowjmove[0].'"';
				$resultstock = mysql_exe_query(array($qstock,1));
				$resultnowstock = mysql_exe_fetch_array(array($resultstock,1)); $stock_now=$resultnowstock[0];
				
				//--- Tidak diperkenankan stok yang direquest kurang dari stok yang tersedia ------
				$note = ''; 
				if($stock_now>=$resultnowjmove[1]){			
					//-- Update State---//
					$query = mysql_stat_update(array('invent_journal_movement',$field,$value,'jvmovement_id="'.$_REQUEST['dataid'].'"')); 
					mysql_exe_query(array($query,1));
					//-- Update stok pada invent_item----//
					$queryup = 'UPDATE invent_item SET stock=stock-'.$resultnowjmove[1].' WHERE item_id="'.$resultnowjmove[0].'"';
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
								'"'.$resultnowjmove[0].'"',
								'"'.date('Y-m-d').'"',
								'"'.$resultnowjmove[1].'"',
								'"Withdraw"',
								'"'.$resultnowjmove[2].'"',
								'"'.$resultnowjmove[3].'"',); 
					$query = mysql_stat_insert(array('invent_movement',$field,$value)); 
					mysql_exe_query(array($query,1));

					//==== Jika stok kurang dari min maka lakukan request Plan PO
					//-- Cek stock di dalam inventory sekarang //
					$pstock = 'SELECT stock, min, max, item_id FROM invent_item WHERE item_id="'.$resultnowjmove[0].'"';
					$resultpstock = mysql_exe_query(array($pstock,1));
					$resultnowpstock = mysql_exe_fetch_array(array($resultpstock,1)); $pstock_now=$resultnowpstock[0]; $min = $resultnowpstock[1]; $max = $resultnowpstock[2]; $date = date('Y-m-d'); $item_id = $resultnowpstock[3]; 
					//-- Create Plan PO jika stok yang tersedia kurang dari min
					if($pstock_now<$min){
						//-- Generate a new id untuk RP ID --// 
						$rpid=get_new_code(array('PLANPR',$numrow,1));
						$need_stock = $max-$pstock_now;
						//-- Insert data pada RP --//
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
								'"'.$item_id.'"',
								'"DP000001"',
								'"'.$need_stock.'"',
								'"Plan PO for request Item ID : '.$item_id.'"',
								'""',
								'"'.$_SESSION['user'].'"',
								'"'.$date.'"',
								'"General"'); 
						$query = mysql_stat_insert(array('invent_rp',$field,$value)); 
						mysql_exe_query(array($query,1)); 
					//==================================================
					}
				}else{
					$note = empty_info(array('Sorry cant request the stock because the stock only : '.$stock_now));					
				}
			}
		}
		
		//### FORM STATE##//
		$query = UPSTAMV.' WHERE jvmovement_id="'.$_REQUEST['dataid'].'"';
		$result=mysql_exe_query(array($query,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $stateid = $resultnow[0];
		//### MENDEFINISIKAN COMBSTATE JIKA STATUS ADALAH Send Approve atau Refused //
		if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && _FULL_){ // manager level 1
			if($stateid=='SJVST181012013921')
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181012013921","SJVST181120050127")';
			else
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
		}else if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // manager level 2/SC suppliy chain
			if($stateid=='SJVST181017012129'){
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
			}else if($stateid=='SJVST181015082513'){
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129")';
			}else{
				$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
			}
		}else if(_VIEW_ && !_DELETE_ && _EDIT_ && _INSERT_ && !_FULL_){ // technician
			$qstate = COMBSTATE.' WHERE state_journal_movement_id NOT IN ("SJVST181015082513","SJVST181012013921","SJVST181017012129","SJVST181120050127")';
		}else{
			$qstate = COMBSTATE;
		} 
		$page = PATH_JVMOVEMENT.'&dataid='.$_REQUEST['dataid'].'#popup-article';
		$name_field=array('State');
		$input_type=array(
							combo_je(array($qstate,'state','state',300,'',''))
		);
		$signtofill = array('<small id="fill" class="form-text text-muted">Update state after send.</small>');
		$form = create_form(array('',$page,1,$name_field,$input_type,$signtofill));
		//### ############//
		
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$title.'</h1>
				'.$form.$note.'
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		return $content;
	}
	
	function js_movement(){
		$content = "<script>
						$(document).ready(function(){
							$('#progress').hide();
						})
						
						$('#itemdata').DataTable({
							'paging':false,
							'searching':false
						});
						
						$('#worder').on('change',function(){
							$('#itemdata').empty();
							var wo = $('#worder').val(); 
							$.ajax({
								type: 'POST',
								url:'"._ROOT_."function/content_menu/journal_movement/wo_item.php',
								data: {'wo':wo},
								crossDomain: true,
								cache: false,
								beforeSend: function(){
									$('#progress').show();
								},	
								success:function(data){ 
									$('#progress').hide();
									$('#itemdata').append(data);
								}
							})
						})
					</script>";
		return $content;
	}
?>