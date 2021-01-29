<?php
    header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $query = 'SELECT vendor_id,vendor_name FROM invent_vendor';
        $result = mysqli_query($con,$query);
    //    $data = mysqli_fetch_assoc($result);
        $temp='<option>--Choose Vendor--</option>';
        while($row=mysqli_fetch_assoc($result)){
            $temp=$temp.'<option value="'.$row['vendor_id'].'">'.$row['vendor_name'].'</option>';
        }
        echo $temp;
        
        
?>