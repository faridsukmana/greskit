<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
	$wo = $_POST['wo'];
	
	$query = 'SELECT A.PMTaskID, B.ChecklistName, B.Task, B.id_form_checklist, C.form_name, A.id_checklist_history FROM work_order A, pm_checklist B , checklist_form_name C WHERE A.PMTaskID=B.CheckListNo AND B.id_form_checklist=C.id_form_checklist AND A.WorkOrderNo="'.$wo.'"';
	$result = mysqli_query($con,$query);
	$data = mysqli_fetch_assoc($result);
	$taskname = $data['ChecklistName'];
	$tasklist = $data['Task'];
	$idform = $data['id_form_checklist'];
	$form_name = $data['form_name'];
	$id_history = $data['id_checklist_history'];
	
	//**** Insert data to history *****//
	$date_now = date('Y-m-d'); 
	
	if(empty($id_history)){ 
		//-- Read Text to new code ---//
		$myFile = _FORM_PM_."function/inc/hcheck.txt";
		$fh = fopen($myFile, 'r');
		$code = fread($fh, 21);
		fclose($fh);
		$ncode = $code+1;
		$fh = fopen($myFile, 'w+') or die("Can't open file.");
		fwrite($fh, $ncode);
		//-- Generate a new id untuk checklist --//
		$wpid=get_new_code('HC',$ncode); 
		$query = 'UPDATE work_order SET id_checklist_history="'.$wpid.'" WHERE WorkOrderNo="'.$wo.'"';
		mysqli_query($con,$query);
					
		//-- Get Asset -----
		$q_asset = 'SELECT AssetID FROM work_order WHERE WorkOrderNo="'.$wo.'"';
		$r_asset = mysqli_query($con,$q_asset);
		$r_now_asset=mysqli_fetch_assoc($r_asset);
		$asset_id = $r_now_asset['AssetID'];
					
		//-- Insert data pada checklist --//
		//--- Berdasarkan master form tanpa asset--
		//$query_c = 'SELECT id_form_checklist, id_master_checklist FROM checklist_form_master WHERE id_form_checklist="'.$idform.'"';
		//--- Berdasarkan master form dan asset--
		$query_c = 'SELECT A.id_form_checklist, A.id_master_checklist FROM checklist_form_master A, checklist_master B WHERE A.id_master_checklist=B.id_master_checklist AND id_form_checklist="'.$idform.'" AND B.AssetID="'.$asset_id.'"';
					
		$result_c = mysqli_query($con,$query_c);
		while($result_now_c=mysqli_fetch_assoc($result_c)){ 
			$query = 'INSERT INTO checklist_history (id_checklist_history ,date, id_form_checklist, id_master_checklist) VALUES("'.$wpid.'","'.$date_now.'","'.$result_now_c['id_form_checklist'].'","'.$result_now_c['id_master_checklist'].'")'; 
			mysqli_query($con,$query);
		}
	}else{
		$wpid=$id_history; 
		$query = 'SELECT date FROM checklist_history WHERE id_checklist_history="'.$wpid.'"';
		$result = mysqli_query($con,$query);
		$result_now=mysqli_fetch_assoc($result);
		$date_now = $result_now['date'];
		
		//-- Get Asset -----
		$q_asset = 'SELECT AssetID FROM work_order WHERE WorkOrderNo="'.$wo.'"';
		$r_asset = mysqli_query($con,$q_asset);
		$r_now_asset=mysqli_fetch_assoc($r_asset);
		$asset_id = $r_now_asset['AssetID'];
		
		//--- Berdasarkan master form dan asset--
		$query_c = 'SELECT A.id_form_checklist, A.id_master_checklist FROM checklist_form_master A, checklist_master B WHERE A.id_master_checklist=B.id_master_checklist AND id_form_checklist="'.$idform.'" AND B.AssetID="'.$asset_id.'"';
					
		$result_c = mysqli_query($con,$query_c);
		while($result_now_c=mysqli_fetch_assoc($result_c)){ 
			$q_check = 'SELECT COUNT(*) count FROM checklist_history WHERE id_form_checklist="'.$result_now_c['id_form_checklist'].'" AND id_master_checklist="'.$result_now_c['id_master_checklist'].'"';
			$r_check = mysqli_query($con,$q_check);
			$rn_check=mysqli_fetch_assoc($r_check);
			if($rn_check['count']==0){
				$query = 'INSERT INTO checklist_history (id_checklist_history ,date, id_form_checklist, id_master_checklist) VALUES("'.$wpid.'","'.$date_now.'","'.$result_now_c['id_form_checklist'].'","'.$result_now_c['id_master_checklist'].'")'; 
				mysqli_query($con,$query);
			}
		}
	}
	
	//***********CHECKLIST*********************		
	$querydat = 'SELECT B.form_name Form_Name, CONCAT(D.AssetNo," - ",D.AssetDesc) Asset, C.description Item_Check, A.description Description, A.id_master_checklist, C.default_val Default_Val FROM checklist_history A, checklist_form_name B, asset D, checklist_item C, checklist_master M WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=M.id_master_checklist AND D.AssetID=M.AssetID AND C.id_item_check=M.id_item_check AND id_checklist_history="'.$wpid.'"'; 
	$result = mysqli_query($con,$querydat);
	$list_item = ''; $i =0;
	while($result_now=mysqli_fetch_assoc($result)){
		
		if(isset($result_now['Description'])){
			$def = $result_now['Description'];
		}else{
			$def = $result_now['Default_Val'];
		}
		
		$list_item .= '
						<div class="item">
							<div class="left">
							  <i class="icon ion-checkmark text-green"></i>
							</div>
							<h2>'.$result_now['Item_Check'].'</h2>
							<input id="list_'.$i.'" name="'.$result_now['id_master_checklist'].'" type="text" placeholder="Result" value="'.$def.'">
						</div>
		';
		$i++;
	}
	
	$list = '
			<input type="hidden" id="history" value="'.$wpid.'">
			<input type="hidden" id="listcount" value="'.$i.'">
			<div class="padding border-green shadow radius mark">
			  <p>
				<b>Form Name </b>: '.$form_name.'
			  </p>
			  <p>
				<b>Work Order </b>: '.$wo.'
			  </p>
			</div>
			<div style="margin-top:5px;"></div>
			<div class="padding border-orange shadow radius mark">
			  <p>
				<b>PM Name : '.$taskname.'</b>
			  </p>
			  <p>
			  '.$tasklist.'
			  </p>
			</div>
			<div style="margin-top:5px;"></div>
			<div class="list">
				<ul>
				'.$list_item.'
			</div>
	';
	$content = $list;
    echo $content;
?>