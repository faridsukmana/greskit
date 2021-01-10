<?php
    $query = 'SELECT A.FirstName, EmployeeID,A.DepartmentID FROM employee A, tb_user B WHERE A.EmployeeID=B.id_employee AND B.username="'.$_SESSION['user'].'"
    '; 
    $result = mysql_exe_query(array($query,1));
    $result_data=mysql_exe_fetch_array(array($result,1));

    $_SESSION['section']= $result_data[2];
    $_SESSION['userID']= $result_data[1];
    
    $query = 'SELECT id_group FROM tb_permit WHERE user_p="'.$_SESSION['user'].'" AND application="'.$_SESSION['app'].'"';
    
    $result = mysql_exe_query(array($query,1));
    $result_data=mysql_exe_fetch_array(array($result,1));
    
    $_SESSION['groupID']= $result_data[0];
	
	if($_SESSION['groupID']=="GROUP181120033150"){
		$_SESSION['section']= '';
	}else{
		$_SESSION['section']= $_SESSION['section'];
	}
    
    
    
   
?>