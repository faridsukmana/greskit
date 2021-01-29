<?php
    header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    header('Content-type: text/html; charset=ASCII');
    include('conf.php');
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $query = 'SELECT *  FROM invent_topup a,invent_state_journal_movement b, invent_item c WHERE a.state_journal_movement_id=b.state_journal_movement_id and a.item_id=c.item_id';
        $result = mysqli_query($con,$query);
        $temp='';
        while($row=mysqli_fetch_assoc($result)){
            if($row['state_journal_movement']=='Send'){
                $temp=$temp.' <div class="item white mark border-red margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_topup(\''.$row['id_topup'].'\')"><span class="text-small red radius padding">'.$row['state_journal_movement'].'</span></a></div>
                        <p class="text-red">'.$row['item_id'].'</p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Item Name : '.$row['item_description'].'
                        </p>
                        	<p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Quantity : '.$row['qty'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Date Top Up : '.$row['date_topup'].'
                        </p>
                        </div>';    
            }
            else if ($row['state_journal_movement']=='Approved'){
                $temp=$temp.' <div class="item white mark border-green margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_topup(\''.$row['id_topup'].'\')"><span class="text-small green radius padding">'.$row['state_journal_movement'].'</span></a></div>
                        <p class="text-green">'.$row['item_id'].'</p>
                         <p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Item Name : '.$row['item_description'].'
                        </p>
                        	<p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Quantity : '.$row['qty'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Date Top Up : '.$row['date_topup'].'
                        </p>
                        </div>';  
            }
            else{
                $temp=$temp.' <div class="item white mark border-yellow margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_topup(\''.$row['id_topup'].'\')"><span class="text-small yellow radius padding">'.$row['state_journal_movement'].'</span></a></div>
                        <p class="text-yellow">'.$row['item_id'].'</p>
                         <p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Item Name : '.$row['item_description'].'
                        </p>
                        	<p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Quantity : '.$row['qty'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-arrow-right-b"></i> Date Top Up : '.$row['date_topup'].'
                        </p>
                        </div>';  
            }
            
        }
        echo '<div class="list padding grey-100" id="list_state">'.$temp.'</br></br></br></div>';
        
        
?>