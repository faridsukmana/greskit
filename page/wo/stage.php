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
	
	//-----------Detail WO-----------------------
	$query = '
        SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, CONCAT(AE.AssetNo," ",AE.AssetDesc) Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID
        FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
        WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WO.WorkOrderNo="'.$wo.'" ORDER BY Work_Order_No DESC
    ';
    
    $result = mysqli_query($con,$query); 
    $data = mysqli_fetch_assoc($result);

    $det_wo = '
                <div class="list shadow padding radius white" id="list_wo">
                    <div class="item">
                        <h2 class="text-huge"> Asset : '.$data['Asset_Name'].', WO : '.$data['Work_Order_No'].'</h2>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Status : '.$data['Work_Status'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Priority : '.$data['Work_Priority'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Type : '.$data['Work_Type'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Cost Centre : '.$data['Work_Trade'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Receive Date : '.$data['Receive_Date'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Estimated Date Start : '.$data['Estimated_Date_Start'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Estimated Date End : '.$data['Estimated_Date_End'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Required Date : '.$data['Required_Date'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Actual Date Start : '.$data['Actual_Date_Start'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Actual Date End : '.$data['Actual_Date_End'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Hand Over Date : '.$data['Hand_Over_Date'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Assign to : '.$data['Assign_to'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Created_By : '.$data['Created_By'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Requestor : '.$data['Requestor'].'
                        </p>
						<p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Failure_Code : '.$data['Failure_Code'].'
                        </p>
                    </div>
					<div class="item">
						<h2>Problem Description</h2>
						<p class="text-grey-500">'.$data['Problem_Desc'].'</p>
					</div>
					<div class="item">
						<h2>Cause Description</h2>
						<p class="text-grey-500">'.$data['Cause_Description'].'</p>
					</div>
					<div class="item">
						<h2>Action Taken</h2>
						<p class="text-grey-500">'.$data['Action_Taken'].'</p>
					</div>
					<div class="item">
						<h2>Prevention Taken</h2>
						<p class="text-grey-500">'.$data['Prevention_Taken'].'</p>
					</div>
                </div><br/><br/><br/><br/><br/><br/>';
				
	
	//*************----Combobox-------------------****************
	$user = $_POST['user']; 
	$quser = 'SELECT id_group FROM tb_permit WHERE user_p="'.$user.'" AND application="Service and Maintenance"';
	$ruser = mysqli_query($con,$quser); 
	$nuser = mysqli_fetch_assoc($ruser);
	$idgroup = $nuser['id_group']; 
	
	if($idgroup=='GROUP181120033150'){
	    DEFINE('COMWOSTAT','SELECT WorkStatusID, WorkStatus FROM work_status');
	}else if($idgroup=='GROUP181120025602'){
		if(isset($wo)){
			DEFINE('COMWOSTAT','
			SELECT WorkStatusID, WorkStatus FROM work_status WHERE WorkStatusID IN (SELECT WorkStatusID FROM work_order WHERE WorkOrderNo="'.$wo.'")
			UNION
			SELECT WorkStatusID, WorkStatus FROM work_status WHERE WorkStatusID="WS000001" OR WorkStatusID="WS000022" OR WorkStatusID="WS000021"');
		}else{
			DEFINE('COMWOSTAT','SELECT WorkStatusID, WorkStatus FROM work_status WHERE WorkStatusID="WS000001" OR WorkStatusID="WS000022" OR WorkStatusID="WS000021"');
		}
	}else{
		if(isset($wo)){
			DEFINE('COMWOSTAT','
			SELECT WorkStatusID, WorkStatus FROM work_status WHERE WorkStatusID IN (SELECT WorkStatusID FROM work_order WHERE WorkOrderNo="'.$wo.'")
			UNION
			SELECT WorkStatusID, WorkStatus FROM work_status where id_group ="'.$idgroup.'" OR id_group =""');
		}else{
			DEFINE('COMWOSTAT','SELECT WorkStatusID, WorkStatus FROM work_status where id_group ="'.$idgroup.'" OR id_group =""');
		}
	}
	
    //---- Get status for work order----//
    $qu = 'SELECT WorkStatusID FROM work_order WHERE WorkOrderNo="'.$wo.'"';
    $res = mysqli_query($con,$qu); 
    $dat = mysqli_fetch_assoc($res);
    $wo_stage = $dat['WorkStatusID'];

    //---- Get all status stage in workstatus table---//
    //$query = 'SELECT WorkStatusID, WorkStatus FROM work_status';
	$query = COMWOSTAT;
    $result = mysqli_query($con,$query); $content_table = '';
    while($data = mysqli_fetch_assoc($result)){
        if($data['WorkStatusID']==$wo_stage)
            $content_table .= '<option class="full" value="'.$data['WorkStatusID'].'" selected>'.$data['WorkStatus'].'</option>'; 
        else
            $content_table .= '<option class="full" value="'.$data['WorkStatusID'].'">'.$data['WorkStatus'].'</option>'; 
    }

    $content = '
        <div id="combo_up">
		<div class="row vertical-align-center">
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
		'.$det_wo.'
		</div>
    ';

    echo $content;

?>