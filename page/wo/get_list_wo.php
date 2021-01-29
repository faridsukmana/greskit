<?php
    header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $query = 'SELECT * FROM work_order';
        $result = mysqli_query($con,$query);
    //    $data = mysqli_fetch_assoc($result);
        $temp='<option>--Choose Work Order--</option>';
        while($row=mysqli_fetch_assoc($result)){
            $temp=$temp.'<option value="'.$row['WorkOrderNo'].'">'.$row['WorkOrderNo'].'</option>';
        }
        echo $temp;
        
        
?>