<?php
	header("Origin:xxx.com");
    header("Access-Control-Allow-Origin:*");
    include("conf.php");
    
    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }

    $wo = '';
    $wo = $_POST['wo']; 
	$user = $_POST['user']; 
    //---- Get status for work order----//
    $qu = 'SELECT WorkStatusID FROM work_order WHERE WorkOrderNo="'.$wo.'"';
    $res = mysqli_query($con,$qu); 
    $dat = mysqli_fetch_assoc($res);
    $wo_stage = $dat['WorkStatusID'];

    //---- Get all status stage in workstatus table---//
    $query = 'SELECT WorkStatusID, WorkStatus FROM work_status';
    $result = mysqli_query($con,$query); $content_table = '';
    while($data = mysqli_fetch_assoc($result)){
        if($data['WorkStatusID']==$wo_stage)
            $content_table .= '<option class="full" value="'.$data['WorkStatusID'].'" selected>'.$data['WorkStatus'].'</option>'; 
        else
            $content_table .= '<option class="full" value="'.$data['WorkStatusID'].'">'.$data['WorkStatus'].'</option>'; 
    }

    $content = '
        <div class="row vertical-align-center" id="combo_up">
            <div class="col">
                <div class="list">
                    <div class="item">
                        <select id="comb_state">
                            '.$content_table.'
                        </select>
                    </div>
                </div>
                <a href="#" onclick="update_stage(\''.$wo.'\');" class="a_button orange full"><i class="icon ion-edit"></i>Update</a>
            </div>
        </div>
    ';

    echo $content;

?>