<?php
	require_once('../../../../connect.php');
	
	if (isset($_POST['data']) && $_POST['data']) {
		$query = 'DELETE FROM ar_fxrate';
		mysql_query($query);
		for ($r = 0, $rlen = count($_POST['data']); $r < $rlen-1; $r++) {
			$query2 = 'INSERT INTO ar_fxrate (FX_Date,Currency,TAX,BI) VALUES ("'.$_POST['data'][$r][0].'","'.$_POST['data'][$r][1].'","'.$_POST['data'][$r][2].'","'.$_POST['data'][$r][3].'")';
			mysql_query($query2);
		}
	}
	
	$out = array(
		'result' => 'ok'
	);
	echo json_encode($out);
?>