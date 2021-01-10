<?php
	error_reporting (E_ALL ^ E_NOTICE);
	function get_permitted($sql,$syntax){
		$bool = false;
		$result = mysql_query($sql) or die('not connected');
		
		if(strcmp($syntax,'access')==0){
			$num_row = mysql_num_rows($result);
			if($num_row>0)
				$bool = true;
		}
		else if(strcmp($syntax,'view')==0){
			$result_now = mysql_fetch_array($result);
			$edit = $result_now['view_data'];
			if(strcmp($edit,'Yes')==0)
				$bool = true;
		}
		else if(strcmp($syntax,'insert')==0){
			$result_now = mysql_fetch_array($result);
			$edit = $result_now['insert_data'];
			if(strcmp($edit,'Yes')==0)
				$bool = true;
		}
		else if(strcmp($syntax,'edit')==0){
			$result_now = mysql_fetch_array($result);
			$edit = $result_now['edit_data'];
			if(strcmp($edit,'Yes')==0)
				$bool = true;
		}else if(strcmp($syntax,'delete')==0){
			$result_now = mysql_fetch_array($result);
			$edit = $result_now['delete_data'];
			if(strcmp($edit,'Yes')==0)
				$bool = true;
		}
		else if(strcmp($syntax,'full')==0){
			$result_now = mysql_fetch_array($result);
			$full = $result_now['full_control'];
			if(strcmp($full,'Yes')==0)
				$bool = true;
		}
		return $bool; 
	}
	
	DEFINE('NAME','Internal IT Support'); 
	//	DEFINE('ACCESS','SELECT * FROM tb_permit WHERE user_p="'.$_SESSION['user'].'" AND application="'.$_SESSION['app'].'"');	
	DEFINE('ACCESS','SELECT A.user_p, A.application, B.insert_data, B.view_data, B.delete_data, B.edit_data, B.full_control FROM tb_permit A, tb_user_group B WHERE user_p="'.$_SESSION['user'].'" AND application="'.$_SESSION['app'].'" AND A.id_group=B.id_group');
	
	DEFINE('CMDACCESS','YOUR ACCOUNT IS TPCINDO GROUP BUT DONT HAVE ACCESS THIS APPLICATION');
	DEFINE('CMDSHOW','YOUR ACCOUNT WAS LOCK BY ADMINISTRATOR TO ACCESS THIS DATA');
?>