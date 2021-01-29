<?php
    header('Content-type: text/html; charset=ASCII');
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $item_id = $_POST['item_id'];
    $date_topup=$_POST['date_topup'];
    $vendor_id=$_POST['vendor_id'];
    $number_po=$_POST['number_po'];
    $price_topup=$_POST['price_topup'];
    $quantity_topup=$_POST['quantity_topup'];
    $topup_id=get_new_code_item(array('TOPUP',$numrow,1));
   // $topup_id='001x';
    $state_id='SJVST181012013921';
    $movement_id='MOVET181011093620';
    
  //  echo $topup_id.'|'.$item_id.'|'.$price_topup.'|'.$vendor_id.'|'.$number_po.'|'.$quantity_topup.'|'.$state_id.'|'.$movement_id.'|'.$date_topup;
    
    $query = 'insert into invent_topup values ("'.$topup_id.'","'.$item_id.'",'.$price_topup.',"'.$vendor_id.'","'.$number_po.'",'.$quantity_topup.',"'.$state_id.'","'.$movement_id.'","'.$date_topup.'")';
   // $result = mysqli_query($con,$query);
    if(mysqli_query($con,$query)){
        echo 'Adding Data is Success';
    }
    else{
        echo 'Failed to Adding Data';
    }
    
    /*
    if(!empty($item_id)){
        $query = 'Insert ';
        $result = mysqli_query($con,$query);
        $data = mysqli_fetch_assoc($result);
        //echo json_encode($data);
        echo $data['itemname'];
    }else{
		die(header("HTTP/1.0 404 Not Found"));
	}
	*/
	
?>