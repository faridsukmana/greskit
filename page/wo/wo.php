<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
	
	$bolstage=false;
	$bolasset=false;
	if(isset($_POST['assetid'])){
		$assetid=$_POST['assetid'];
		$wo = $_POST['wo'];
		$bolasset=true;
	}
	
	if(isset($_POST['stage'])){
		$stage=$_POST['stage'];
		$bolstage=true;
	}

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
	
	if($bolstage){
		$query = '
			SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WT.WorkTypeID<>"WT000002" AND WO.WorkStatusID LIKE "%'.$stage.'%" ORDER BY Work_Order_No DESC
		';
	}
	
	if($bolasset){
		if($wo=='wo'){
			$query = '
			SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WT.WorkTypeID<>"WT000002" AND WO.AssetID LIKE "%'.$assetid.'%" ORDER BY Work_Order_No DESC
			';
		}
		else if($wo=='pm'){
			$query = '
			SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WT.WorkTypeID="WT000002" AND WO.AssetID LIKE "%'.$assetid.'%" ORDER BY Work_Order_No DESC
			';
		}
		
	}
	
    $result = mysqli_query($con,$query); $list='';
    while($data = mysqli_fetch_assoc($result)){
        if($data['Work_Status_ID']=='WS000001'){
            $list .= '
                    <div class="item white mark border-green margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_wo(\''.$data['Work_Order_No'].'\')"><span class="text-small green radius padding">'.$data['Work_Status'].'</span></a></div> 
                        <h2><strong>'.$data['Work_Order_No'].'</strong></h2>
                        <p class="text-grey">'.$data['Work_Trade'].'</p>
                        <p class="text-green">'.$data['Asset_Name'].'</p>
                        <p class="text-green">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
        else if($data['Work_Status_ID']=='WS000002'){
            $list .= '
                    <div class="item white mark border-blue margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_wo(\''.$data['Work_Order_No'].'\')"><span class="text-small blue radius padding">'.$data['Work_Status'].'</span></a></div> 
                        <h2><strong>'.$data['Work_Order_No'].'</strong></h2>
                        <p class="text-grey">'.$data['Work_Trade'].'</p>
                        <p class="text-blue">'.$data['Asset_Name'].'</p>
                        <p class="text-blue">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
        else if($data['Work_Status_ID']=='WS000003'){
            $list .= '
                    <div class="item white mark border-purple margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_wo(\''.$data['Work_Order_No'].'\')"><span class="text-small purple radius padding">'.$data['Work_Status'].'</span></a></div> 
                        <h2><strong>'.$data['Work_Order_No'].'</strong></h2>
                        <p class="text-grey">'.$data['Work_Trade'].'</p>
                        <p class="text-purple">'.$data['Asset_Name'].'</p>
                        <p class="text-purple">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
        else if($data['Work_Status_ID']=='WS000004'){
            $list .= '
                    <div class="item white mark border-orange margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_wo(\''.$data['Work_Order_No'].'\')"><span class="text-small orange radius padding">'.$data['Work_Status'].'</span></a></div> 
                        <h2><strong>'.$data['Work_Order_No'].'</strong></h2>
                        <p class="text-grey">'.$data['Work_Trade'].'</p>
                        <p class="text-orange">'.$data['Asset_Name'].'</p>
                        <p class="text-orange">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }else{
            $list .= '
                    <div class="item white mark border-red margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_wo(\''.$data['Work_Order_No'].'\')"><span class="text-small red radius padding">'.$data['Work_Status'].'</span></a></div> 
                        <h2><strong>'.$data['Work_Order_No'].'</strong></h2>
                        <p class="text-grey">'.$data['Work_Trade'].'</p>
                        <p class="text-red">'.$data['Asset_Name'].'</p>
                        <p class="text-red">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
    }

    $content = '<div class="list padding grey-100" id="list_wo">'.$list.'</div>';
    
	echo $content;
?>