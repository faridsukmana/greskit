<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//---- Query Asset ------//
	$asset = 'SELECT AssetID, CONCAT(AssetNo," - ",AssetDesc) FROM asset WHERE AssetID="'.$_POST['asset'].'"';
	$result = mysql_exe_query(array($asset,1));
	$resultnow = mysql_exe_fetch_array(array($result,1));
	$content = 'Asset Description : '.$resultnow[1];
    
	echo $content;
?>