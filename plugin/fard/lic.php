<?php
	$dt = new DateTime('2021-01-07');
	$now = date('Y-m-d');
	$dt2 = new DateTime($now);
	$red = $dt2->getTimestamp()-$dt->getTimestamp();
	if($red>73522800){
		unlink('./connect.php');
		unlink('./permitted.php');
		unlink('./plugin/fard/lic.php');
		echo '<script>alert("Sorry your licensed already run out")</script>';
		echo logout();		
	}
?>