<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	$id_form = $_POST['id_form'];
	$id_master = $_POST['id_master'];
	
	$q_delete = 'DELETE FROM checklist_form_master WHERE id_form_checklist="'.$id_form.'" AND id_master_checklist="'.$id_master.'"';
	mysql_exe_query(array($q_delete,1));
	
	echo $id_form.' - '.$id_master;
?>