<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
	
	$asset = '';
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
		if($stage=="WS000001"){
			$cond = 'AND WO.WorkStatusID="WS000001"';
		}else if($stage=="WS000022"){
			$cond = 'AND (WO.WorkStatusID="WS000010" OR WO.WorkStatusID="WS000012" OR WO.WorkStatusID="WS000013" OR WO.WorkStatusID="WS000014" OR WO.WorkStatusID="WS000019" OR WO.WorkStatusID="WS000022")';
		}else if($stage=="WS000020"){
			$cond = 'AND (WO.WorkStatusID="WS000020" OR WO.WorkStatusID="WS000021")';
		}else{
			$cond = '';
		}
		$query = '
			SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID, AssetNo
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WT.WorkTypeID<>"WT000002" '.$cond.' ORDER BY Work_Order_No DESC
		'; //echo $query;
	}
	
	if($bolasset){
		if($wo=='wo'){
			$query = '
			SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID, AssetNo
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WT.WorkTypeID<>"WT000002" AND WO.AssetID LIKE "%'.$assetid.'%" ORDER BY Work_Order_No DESC
			';
		}
		else if($wo=='pm'){
			$query = '
			SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID, AssetNo
			FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
			WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WT.WorkTypeID="WT000002" AND WO.AssetID LIKE "%'.$assetid.'%" ORDER BY Work_Order_No DESC
			';
			
			if(!empty($assetid)){
    			$qasset = 'SELECT A.AssetID Asset_ID, A.AssetNo Asset_No, A.AssetDesc Asset_Desc, L.LocationDescription Location_Desc, D.DepartmentDesc Department_Desc, C.AssetCategory Asset_Category, S.AssetStatusDesc Asset_Status, I.Criticaly Critically, E.FirstName Auth_Employee, P.SupplierName Supplier_Name, A.Manufacturer Manufacturer, A.ModelNumber Model_Number, A.SerialNumber Serial_Number, W.warranty Warranty, A.WarrantyNotes Warranty_Notes, A.WarrantyDate Warranty_Date, A.AssetNote Asset_Note, A.DateAcquired Date_Acquired, A.DateSold Date_Sold, A.ImagePath, A.QRPath
    	                    FROM 
    	                    asset A, location L, department D, asset_status S, asset_category C, critically I, supplier P, warranty_contract W, employee E
                        	WHERE 
                        	A.locationID=L.locationID AND A.departmentID=D.departmentID AND A.AssetStatusID=S.AssetStatusID AND A.AssetCategoryID=C.AssetCategoryID AND A.CriticalID=I.CriticalID AND A.SupplierID=P.Supplier_ID AND A.WarrantyID=W.WarrantyID AND A.EmployeeID=E.EmployeeID AND A.Hidden="no" AND A.AssetID="'.$assetid.'"';
    			
    			$rasset = mysqli_query($con,$qasset);
    			$dasset = mysqli_fetch_assoc($rasset);
    			
    			$asset = '
                        <div class="item white mark border-deep-purple margin-button shadow">
                            <p class="text-grey" >'.$dasset['Asset_No'].'</p>
                            <p class="text-grey" >Desc : '.$dasset['Asset_Desc'].'</p>
                            <p class="text-grey" >Location :'.$dasset['Location_Desc'].'</p>
                            <p class="text-grey" >Dept :'.$dasset['Department_Desc'].'</p>
                            <p class="text-grey" >Manufacturer : '.$dasset['Manufacturer'].'</p>
                            <p class="text-grey" >Status : '.$dasset['Asset_Status'].'</p>
                        </div>
                ';
			}
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
                        <p class="text-green">'.$data['AssetNo'].'</p>
                        <p class="text-green">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
        else if($data['Work_Status_ID']=='WS000022'){
            $list .= '
                    <div class="item white mark border-blue margin-button shadow">
                        <div class="right"><a href="#" onclick="update_state_wo(\''.$data['Work_Order_No'].'\')"><span class="text-small blue radius padding">'.$data['Work_Status'].'</span></a></div> 
                        <h2><strong>'.$data['Work_Order_No'].'</strong></h2>
                        <p class="text-grey">'.$data['Work_Trade'].'</p>
                        <p class="text-blue">'.$data['AssetNo'].'</p>
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
                        <p class="text-purple">'.$data['AssetNo'].'</p>
                        <p class="text-purple">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
        else if($data['Work_Status_ID']=='WS000019'){
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
                        <p class="text-red">'.$data['AssetNo'].'</p>
                        <p class="text-red">'.$data['Work_Type'].'</p>
                    </div>
            ';
        }
    }

    $content = '<div class="list padding grey-100" id="list_wo">'.$asset.$list.'</div>';
    
	echo $content;
?>