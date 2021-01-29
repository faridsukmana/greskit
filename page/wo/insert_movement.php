<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $item_id=$_POST['item_id'];
    $date_move=$_POST['date_topup'];
    $center_name=$_POST['center_name'];
    $wo_name=$_POST['wo_name'];
    $take_by=$_POST['take_by'];
    $number_stock=$_POST['number_stock'];
    $remark_1=$_POST['remark_1'];
    $remark_2=$_POST['remark_2'];
    $move_id=get_new_code_item(array('JVMOVET',$numrow,1));
   // $topup_id='001x';
    $state_id='SJVST181012013921';
   // $movement_id='MOVET181011093620';
    /*
    echo 'insert into invent_journal_movement values ("'.$move_id.'","'.$item_id.'",'.$center_name.',"'.$take_by.'","'.$number_stock.'",'.$state_id.',"'.$remark_1.'","'.$remark_2.'","'.$date_move.'","'.$wo_name.'")';
  */
  $query = 'insert into invent_journal_movement values ("'.$move_id.'","'.$item_id.'","'.$center_name.'","'.$take_by.'",'.$number_stock.',"'.$state_id.'","'.$remark_1.'","'.$remark_2.'","'.$date_move.'","'.$wo_name.'")';
   // $result = mysqli_query($con,$query);
    if(mysqli_query($con,$query)){
        echo 'Adding Data is Success';
    }
    else{
        echo 'Failed to Adding Data';
    }
	
?>