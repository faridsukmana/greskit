<?php
	header("Origin:xxx.com");
    header("Access-Control-Allow-Origin:*");
    include("conf.php");
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }

    $state = $_POST['state'];
    $wo = $_POST['wo']; 

    //---- Get status for work order----//
    $qu = 'UPDATE work_order SET WorkStatusID="'.$state.'" WHERE WorkOrderNo="'.$wo.'"';
    mysqli_query($con,$qu); 

    $query = 'SELECT A.WorkStatusID,A.WorkOrderNo,B.WorkStatus FROM work_order A, work_status B WHERE A.WorkStatusID=B.WorkStatusID AND WorkOrderNo="'.$wo.'"';
    $result = mysqli_query($con,$query); 
	$data = mysqli_fetch_assoc($result);
    echo json_encode($data);

?>