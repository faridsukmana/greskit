<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//---- Query Asset ------//
	/*$asset = 'SELECT AssetID, CONCAT(AssetNo," - ",AssetDesc) FROM asset WHERE AssetID="'.$_POST['asset'].'"';
	$result = mysql_exe_query(array($asset,1));
	$resultnow = mysql_exe_fetch_array(array($result,1));
	$content = 'Asset Description : '.$resultnow[1];*/
	
	//---- Query Asset ------//
	$option=''; $comasset = 'SELECT AssetID, AssetNo FROM asset WHERE Hidden="no" AND PlantID="'.$_POST['plant'].'" ORDER BY AssetNo, AssetDesc ASC';
	$result = mysql_exe_query(array($comasset,1));
	while($resultnow = mysql_exe_fetch_array(array($result,1))){
		if($resultnow[0]==$_POST['asset'])
			$option .= '<option value="'.$resultnow[0].'" selected>'.$resultnow[1].'</option>';
		else
			$option .= '<option value="'.$resultnow[0].'">'.$resultnow[1].'</option>';
	}
	$content = $option;
    
	echo $content;
?>