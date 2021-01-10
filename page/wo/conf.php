<?php
	date_default_timezone_set('Asia/Jakarta');
	DEFINE('host','localhost');
	DEFINE('user','root');
	DEFINE('pass','');
	DEFINE('dbase','db_dev');
	DEFINE('_FORM_PM_','../Sisoft/');
	
	//============Generate kode baru sebagai ID pada database==========
	function get_new_code($name,$val){
		if($val<10){
			$content = $name.'00000'.$val;
		}else if($val>=10 && $val<100){
			$content = $name.'0000'.$val;
		}else if($val>=100 && $val<1000){
			$content = $name.'000'.$val;
		}else if($val>=1000 && $val<10000){
			$content = $name.'00'.$val;
		}else if($val>=10000 && $val<100000){
			$content = $name.'0'.$val;
		}else if($val>=100000 && $val<1000000){
			$content = $name.$val;
		}
		return $content;
	}
?>