<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    header('Content-type: text/html; charset=ASCII');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }

    $movementid=$_POST['movementid'];

    $query = 'SELECT *  FROM invent_journal_movement a,invent_state_journal_movement b, invent_item c, cost_center d WHERE a.state=b.state_journal_movement_id and a.item_id=c.item_id and d.id_cost_center=a.id_cost_center and a.jvmovement_id="'.$movementid.'"';
    
    $result = mysqli_query($con,$query); 
    $data = mysqli_fetch_assoc($result);

    $content = '
                <div class="list shadow padding radius white" id="list_wo">
                    <div class="item">
                        <h2 class="text-huge">'.$data['item_description'].'</h2>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Cost Center : '.$data['cost_center'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Number of Stock : '.$data['number_of_stock'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Remark 1 : '.$data['remark1'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Remark 2 : '.$data['remark 2'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Date Journal Movement : '.$data['date_jvmovement'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Workorder Movement : '.$data['WorkOrderNo'].'
                        </p>
                </div>';

    

    echo $content;
?>