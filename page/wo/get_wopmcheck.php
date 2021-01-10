<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
	
	$con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
	
	$num=array();
	
	$query_wo = 'SELECT COUNT(*) WO FROM work_order WHERE WorkTypeID<>"WT000002"';
	$result_wo = mysqli_query($con,$query_wo);
	$data = mysqli_fetch_assoc($result_wo);
	$num['wo'] = $data['WO'];
	
	$query_pm = 'SELECT COUNT(*) PM FROM work_order WHERE WorkTypeID="WT000002"';
	$result_pm = mysqli_query($con,$query_pm);
	$data = mysqli_fetch_assoc($result_pm);
	$num['pm'] = $data['PM'];
	
	$query_ck = 'SELECT COUNT(*) CK FROM (SELECT * FROM checklist_history GROUP BY id_checklist_history) A WHERE A.id_form_checklist NOT IN (SELECT id_form_checklist FROM pm_checklist WHERE id_form_checklist<>"" OR id_form_checklist <> NULL GROUP BY id_form_checklist)';
	$result_ck = mysqli_query($con,$query_ck);
	$data = mysqli_fetch_assoc($result_ck);
	$num['ck'] = $data['CK'];

	echo json_encode($num);
?>