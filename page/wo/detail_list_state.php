<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    header('Content-type: text/html; charset=ASCII');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }

    $topupid=$_POST['topupid'];

    $query = 'SELECT *  FROM invent_topup a,invent_state_journal_movement b, invent_item c WHERE a.state_journal_movement_id=b.state_journal_movement_id and a.item_id=c.item_id and a.id_topup="'.$topupid.'"';
    
    $result = mysqli_query($con,$query); 
    $data = mysqli_fetch_assoc($result);

    $content = '
                <div class="list shadow padding radius white" id="list_wo">
                    <div class="item">
                        <h2 class="text-huge">'.$data['item_description'].'</h2>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Price : '.$data['price'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Vendor Id : '.$data['vendor_id'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> PO Number : '.$data['po_number'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Quantity : '.$data['qty'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Date Top Up : '.$data['date_topup'].'
                        </p>
                </div>';

    

    echo $content;
?>