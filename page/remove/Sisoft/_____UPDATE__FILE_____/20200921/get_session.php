<?php
    $query = 'SELECT A.FirstName, EmployeeID,A.DepartmentID FROM employee A, tb_user B WHERE A.EmployeeID=B.id_employee 
    ';
    $result = mysql_exe_query(array($query,1));
    $result_data=mysql_exe_fetch_array(array($result,1));

    $_SESSION['section']= $result_data[2];
    $_SESSION['userID']= $result_data[1];
    
?>