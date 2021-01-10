<?php
	//===========DEFINE VARIABLE FOR DATABASE==============
	DEFINE('host','localhost');
	DEFINE('user','root');
	DEFINE('pass','');
	DEFINE('dbase','db_dev');
	
	//===================================connection MySQL====================================================
	mysql_connect(host, user, pass) or die("Can't start DB");
	mysql_select_db(dbase) or die ("DB not connect");
	
	//===================================connection SQL Server===============================================
	$ADODB_COUNTRECS = false;
	function con_DB_Open_SS($ssServer, $ssUser, $ssPass, $ssDB){
		$conn = new COM ("ADODB.Connection") or die("Cannot start ADO");
		//mendefiniskan koneksi string, drifer yang dispesifikasi
		$connStr = "PROVIDER=SQLOLEDB;SERVER=".$ssServer.";UID=".$ssUser.";PWD=".$ssPass.";DATABASE=".$ssDB;
		$conn->open($connStr); //membuka koneksi database
		
		return $conn;
	}
	
	function con_DB_close_SS($conn){
		$conn->Close();
		$conn = null;
	}
	
	function execute_query_SS($conn, $query){
		$rs = $conn->execute($query);
		return $rs;
	}
	
	function close_query_SS($rs){
		$rs->Close();
		$rs=null;
	}
	
	//====================Function execute mysql query===================
	//-------delete data----------
	function query_delete($data){
		$page = $data[0];
		$table = $data[1];
		$whercon = $data[2];
		$query = 'DELETE FROM '.$table.' WHERE '.$whercon; 
		mysql_exe_query(array($query,1)); 
		$content = '<script>location.href="'.$page.'";</script>'; 
		return $content;
	}
	
	//-------create statement update--------
	function mysql_stat_update($data){
		$table = $data[0];
		$field = $data[1];
		$value = $data[2];
		$conid = $data[3];
		$setval = '';
		$i=0;
		while($i<sizeof($field)){
			$setval .= $field[$i].'='.$value[$i].',';
			$i++;
		}
		$setval = substr($setval,0,-1);
		$content = 'UPDATE '.$table.' SET '.$setval.' WHERE '.$conid;
		return $content;
	}
	
	//------create statement insert---------
	function mysql_stat_insert($data){
		$table = $data[0];
		$field = $data[1];
		$value = $data[2];
		$concat_field ='';
		$concat_value ='';
		$i=0;
		while($i<sizeof($field)){
			$concat_field .= $field[$i].',';
			$concat_value .= $value[$i].',';
			$i++;
		}
		$concat_field = '('.substr($concat_field,0,-1).')'; //add sign of () and remove last string
		$concat_value = '('.substr($concat_value,0,-1).')'; //add sign of () and remove last string
		
		$content = 'INSERT INTO '.$table.' '.$concat_field.' VALUES '.$concat_value;
		return $content;
	}
	
	//---------execution mysql-------------
	function mysql_exe_query($data){
		$querytext = $data[0];// echo $querytext;
		$type_mysql = $data[1]; 
		if($type_mysql==1){
			$content = mysql_query($querytext) or die('Cant compile query of '.$querytext);
		}
		return $content;
	}
	
	//--------execution fetch_array-----------
	function mysql_exe_fetch_array($data){
		$resultquery = $data[0];
		$type_mysql = $data[1];
		if($type_mysql==1){
			$content = mysql_fetch_array($resultquery);
		}
		return $content;
	}
	
	//--------execution num field-----------
	function mysql_exe_num_fields($data){
		$resultquery = $data[0];
		$type_mysql = $data[1];
		if($type_mysql==1){
			$content = mysql_num_fields($resultquery);
		}
		return $content;
	}

	//--------execution num rows-----------
	function mysql_exe_num_rows($data){
		$resultquery = $data[0];
		$type_mysql = $data[1];
		if($type_mysql==1){
			$content = mysql_num_rows($resultquery);
		}
		return $content;
	}
?>