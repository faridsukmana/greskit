<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//---- Query Asset ------//
	$option=''; $comasset = 'SELECT EmployeeID, FirstName FROM employee WHERE DepartmentID="'.$_POST['department'].'" ORDER BY EmployeeID ASC';
	$result = mysql_exe_query(array($comasset,1));
	while($resultnow = mysql_exe_fetch_array(array($result,1))){
		$option .= '<option value="'.$resultnow[0].'" selected>'.$resultnow[1].'</option>';
	}
	$content = $option;
    
	echo $content;
?>