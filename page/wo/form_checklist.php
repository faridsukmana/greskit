<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
	$id = $_POST['id'];
	$asset = $_POST['asset'];
	
	$total = 0;
	if($asset=='no'){
		$id_data = $id; $data='history'; $detail_info='';
		$query = 'SELECT B.form_name Form_Name, CONCAT(D.AssetNo," - ",D.AssetDesc) Asset, C.description Item_Check, A.description Description, A.id_master_checklist, C.default_val Default_Val FROM checklist_history A, checklist_form_name B, asset D, checklist_item C, checklist_master M WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=M.id_master_checklist AND D.AssetID=M.AssetID AND C.id_item_check=M.id_item_check AND id_checklist_history="'.$id.'"';
		$result = mysqli_query($con,$query); 
		$form_name=''; $list_item=''; $i=0;
		while($result_now=mysqli_fetch_assoc($result)){
			$form_name = '<b>Form Name : '.$result_now['Form_Name'].'</b>';
			$list_item .= '
							<div class="item">
								<div class="left">
								  <i class="icon ion-checkmark text-green"></i>
								</div>
								<h2>'.$result_now['Asset'].' : '.$result_now['Item_Check'].'</h2>
								<input id="list_'.$i.'" name="'.$result_now['id_master_checklist'].'" type="text" placeholder="Result" value="'.$result_now['Description'].'">
							</div>
			';
			$i++;
		}
	}
	else if($id=='no'){
		$id_data = $asset; $data='asset';
		
		$q_asset = 'SELECT AssetNo, AssetDesc FROM asset WHERE AssetID="'.$id_data.'"'; 
		$r_asset = mysqli_query($con,$q_asset); 
		$rn_asset=mysqli_fetch_assoc($r_asset);
		$detail_info='Code : '.$rn_asset['AssetNo'].' ,Name : '.$rn_asset['AssetDesc'];

		$query = 'SELECT COUNT(*) total FROM checklist_history A, checklist_master B WHERE A.id_master_checklist=B.id_master_checklist AND B.AssetID="'.$asset.'" AND A.id_form_checklist NOT IN (SELECT id_form_checklist FROM pm_checklist WHERE id_form_checklist<>"" OR id_form_checklist <> NULL GROUP BY id_form_checklist) AND A.date=CURDATE()';
		$result = mysqli_query($con,$query);
		$result_now=mysqli_fetch_assoc($result);
		$total = $result_now['total']; 
		if($total>0){
			$query = 'SELECT B.form_name Form_Name, CONCAT(D.AssetNo," - ",D.AssetDesc) Asset, C.description Item_Check, A.description Description, CONCAT(A.id_checklist_history,"_",A.id_master_checklist) master_checklist, C.default_val Default_Val FROM checklist_history A, checklist_form_name B, asset D, checklist_item C, checklist_master M WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=M.id_master_checklist AND D.AssetID=M.AssetID AND C.id_item_check=M.id_item_check AND M.AssetID="'.$asset.'" AND A.date=CURDATE()';
		}else{
			//$query = 'SELECT A.id_form_checklist form FROM checklist_form_master A, checklist_form_name B, checklist_master C WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=C.id_master_checklist AND C.AssetID="'.$asset.'" AND A.id_form_checklist NOT IN (SELECT id_form_checklist FROM pm_checklist WHERE id_form_checklist<>"" OR id_form_checklist <> NULL GROUP BY id_form_checklist) GROUP BY A.id_form_checklist';
			$query = 'SELECT A.id_form_checklist form FROM checklist_form_master A, checklist_form_name B, checklist_master C WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=C.id_master_checklist AND C.AssetID="'.$asset.'" AND B.daily_checklist="yes" AND A.id_form_checklist NOT IN (SELECT id_form_checklist FROM pm_checklist WHERE id_form_checklist<>"" OR id_form_checklist <> NULL GROUP BY id_form_checklist) GROUP BY A.id_form_checklist';
			$result = mysqli_query($con,$query); 
			$dateh = date('Y-m-d'); 
			
			while($result_now=mysqli_fetch_assoc($result)){
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
				$query_c = 'SELECT A.id_form_checklist Form_ID, A.id_master_checklist Master_ID, C.default_val Descr FROM checklist_form_master A, checklist_master B, checklist_item C WHERE A.id_master_checklist=B.id_master_checklist AND B.id_item_check=C.id_item_check AND A.id_form_checklist="'.$result_now['form'].'"'; 
				$result_c = mysqli_query($con,$query_c);
				while($result_now_c=mysqli_fetch_assoc($result_c)){
					$query_data = 'INSERT INTO checklist_history (id_checklist_history ,date, id_form_checklist, id_master_checklist, description) VALUES("'.$wpid.'","'.$dateh.'","'.$result_now_c['Form_ID'].'","'.$result_now_c['Master_ID'].'","'.$result_now_c['Descr'].'")'; 
					mysqli_query($con,$query_data);
				}
			}
			
			$query = 'SELECT B.form_name Form_Name, CONCAT(D.AssetNo," - ",D.AssetDesc) Asset, C.description Item_Check, A.description Description, CONCAT(A.id_checklist_history,"_",A.id_master_checklist) master_checklist, C.default_val Default_Val FROM checklist_history A, checklist_form_name B, asset D, checklist_item C, checklist_master M WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=M.id_master_checklist AND D.AssetID=M.AssetID AND C.id_item_check=M.id_item_check AND M.AssetID="'.$asset.'" AND A.date=CURDATE()';
			
		}
	
		$result = mysqli_query($con,$query);
		$form_name = '<b>Asset Name : </b>'; 
		$list_item=''; $i=0;
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
								<h2>'.$result_now['Item_Check'].' , Form : '.$result_now['Form_Name'].'</h2>
								<input id="list_'.$i.'" name="'.$result_now['master_checklist'].'" type="text" placeholder="Result" value="'.$def.'">
							</div>
			';
			$i++;
		}
	}
	
	$list = '
			<input type="hidden" id="history" value="'.$id_data.'">
			<input type="hidden" id="listcount" value="'.$i.'">
			<input type="hidden" id="type" value="'.$data.'">
			<div class="padding border-orange shadow radius mark">
			  <p>
				'.$form_name.'
			  </p>
			  <p>
			  '.$detail_info.'
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