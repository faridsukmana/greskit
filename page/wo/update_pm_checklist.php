<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
	$id_checklist = $_POST['id_checklist'];
	$id_value = $_POST['id_value'];
	$id_history = $_POST['id_history'];
	
	$id_cl = json_decode($id_checklist);
	$id_val = json_decode($id_value);
	
	$i=0; $content = ''; $error = '';
	while($i<sizeof($id_cl)){
		$query = 'UPDATE checklist_history SET description="'.$id_val[$i].'" WHERE id_master_checklist="'.$id_cl[$i].'" AND id_checklist_history="'.$id_history.'"';
		$result = mysqli_query($con,$query);
		if(!$result){
			$error = 'Checklist '.$id_val[$i].' failed to update <br/>';
		}
		$i++;
	}
	
	if(empty($error)){
		$content = 'Update data successed';
	}else{
		$content = $error;
	}
	
	echo $content;
    //echo $id_checklist.'<br/>'.$id_value.'<br/>'.$id_history;
?>