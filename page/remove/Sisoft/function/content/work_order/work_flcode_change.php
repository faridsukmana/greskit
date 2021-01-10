<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//---- Query update Failure Code WO------//
	$query = 'UPDATE work_order SET FailureCauseID="'.$_POST['flcode'].'" WHERE WorkOrderNo="'.$_POST['wo'].'"';
	$result = mysql_exe_query(array($query,1));
    
	if($result){
		echo 'Sucessed update';
	}else{
		echo 'Failed Update';
	}
?>