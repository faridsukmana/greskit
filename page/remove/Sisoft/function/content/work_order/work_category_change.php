<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//===============================Doc==================
	$option=''; $p_cat = 'SELECT item_id, CONCAT(item_id," - ",item_description) FROM invent_item WHERE item_category_code="'.$_POST['cat'].'" ORDER BY item_id ASC';
	$result = mysql_exe_query(array($p_cat,1));
	while($resultnow = mysql_exe_fetch_array(array($result,1))){
		$option .= '<option value="'.$resultnow[0].'" selected>'.$resultnow[1].'</option>';
	}
	$content = $option;
    
	echo $content;
?>