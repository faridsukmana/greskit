<?php
    header('Content-type: text/html; charset=ASCII');
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $itemid = $_POST['item'];
    //echo $itemid;
    
    
    if(!empty($itemid)){
        $query = 'SELECT item_description itemname FROM invent_item WHERE item_id='.'"'.$itemid.'"';
        $result = mysqli_query($con,$query);
        $data = mysqli_fetch_assoc($result);
        //echo json_encode($data);
        echo $data['itemname'];
    }else{
		die(header("HTTP/1.0 404 Not Found"));
	}
	
	
?>