<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }

    $itemid=$_POST['itemid'];

    $query = '
        SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WS.WorkStatusID Work_Status_ID
        FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC, invent_item_work_order IW
        WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WO.WorkOrderNo=IW.WorkOrderNo AND IW.itemspare="'.$itemid.'" ORDER BY Work_Order_No DESC
    ';

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

    $query = 'SELECT IT.item_id Item_ID, IT.item_description Item_Name, IB.brand_short_name Brand_Name, IC.item_category_description Category, IL.critical_level Critical_Level, IT.min Min, IT.max Max, IU.unit Unit, IT.stock Stock, IT.last_price Last_Price, IT.avg_price Avg_Price, IW.warehouse_name Warehouse, IT.qrpath, IE.id_location Location, IE.detail_location FROM invent_item IT, invent_brand IB, invent_item_categories IC, invent_critical_level IL, invent_unit IU, invent_warehouse IW, invent_location IE WHERE IT.brand_id=IB.brand_id AND IT.item_category_code=IC.item_category_code AND IT.critical_id=IL.critical_id AND IT.id_unit=IU.id_unit AND IT.warehouse_id=IW.warehouse_id AND IT.id_location=IE.id_location AND IT.item_id="'.$itemid.'"';
    
    $result = mysqli_query($con,$query); 
    $data = mysqli_fetch_assoc($result);

    $content = '
                <div class="list shadow padding radius white" id="list_wo">
                    <div class="item">
                        <h2 class="text-huge"> ID : '.$data['Item_ID'].', Name : '.$data['Item_Name'].'</h2>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-pricetags"></i> Brand Name : '.$data['Brand_Name'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-pricetags"></i> Category : '.$data['Category'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-location"></i> Location : '.$data['detail_location'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-speedometer"></i> Critical Level : '.$data['Critical_Level'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-android-cart"></i> Unit : '.$data['Unit'].' Min : '.$data['Min'].', Max : '.$data['Max'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-at"></i> Last Price : '.$data['Last_Price'].' Average Price : '.$data['Avg_Price'].', Max : '.$data['Max'].'
                        </p>
                        <p class="text-grey-500 text-small">
                            <i class="icon ion-ios-box"></i> Warehouse : '.$data['Warehouse'].'
                        </p>
                    </div>
                    '.$list.'
                </div>';

    

    echo $content;
?>