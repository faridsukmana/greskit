<?php
	require_once('../../../../connect.php');
	require_once('../../define.php');
	
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	
	$query = EXAMPLE;
	$rs = mysql_query($query);
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	$query = EXAMPLE." LIMIT $offset,$rows";
	$rs = mysql_query($query);
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	
	echo json_encode($result);
?>