<?php
    header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
    
    $form = $_POST['form'];
    $template_form = '';
    
    if($form=='wo'){
        //--- Asset Query ----//
        $qasset = 'SELECT AssetID, AssetNo FROM asset';
        $rasset = mysqli_query($con,$qasset); $asset;
        while($dasset = mysqli_fetch_assoc($rasset)){
            $asset .= '<option value="'.$dasset['AssetID'].'">'.$dasset['AssetNo'].'</option>';
        }
        
        //--- Requestby Query ----//
        $qreqby = 'SELECT EmployeeID, FirstName FROM employee';
        $rreqby = mysqli_query($con,$qreqby); $reqby;
        while($dreqby = mysqli_fetch_assoc($rreqby)){
            $reqby .= '<option value="'.$dreqby['EmployeeID'].'">'.$dreqby['FirstName'].'</option>';
        }
        
        //--- Work Priority Query ----//
        $qwprior = 'SELECT WorkPriorityID, WorkPriority FROM work_priority';
        $rqwprior = mysqli_query($con,$qwprior); $wprior;
        while($dqwprior = mysqli_fetch_assoc($rqwprior)){
            $wprior .= '<option value="'.$dqwprior['WorkPriorityID'].'">'.$dqwprior['WorkPriority'].'</option>';
        }
        
        //--- Work Type Query ----//
        $qwtype = 'SELECT WorkTypeID, WorkTypeDesc FROM work_type';
        $rwtype = mysqli_query($con,$qwtype); $wtype;
        while($dwtype = mysqli_fetch_assoc($rwtype)){
            $wtype .= '<option value="'.$dwtype['WorkTypeID'].'">'.$dwtype['WorkTypeDesc'].'</option>';
        }
        
        //--- Department Query ----//
        $qdept = 'SELECT DepartmentID, DepartmentDesc FROM department';
        $rdept = mysqli_query($con,$qdept); $dept;
        while($ddept = mysqli_fetch_assoc($rdept)){
            $dept .= '<option value="'.$ddept['DepartmentID'].'">'.$ddept['DepartmentDesc'].'</option>';
        }
        
        //--- Work Trade Query ----//
        $qwtrade = 'SELECT WorkTradeID, WorkTrade FROM work_trade';
        $rwtrade = mysqli_query($con,$qwtrade); $wtrade;
        while($dwtrade = mysqli_fetch_assoc($rwtrade)){
            $wtrade .= '<option value="'.$dwtrade['WorkTradeID'].'">'.$dwtrade['WorkTrade'].'</option>';
        }
        
        //--- Work Status Query ----//
        $qwstate = 'SELECT WorkStatusID, WorkStatus FROM work_status';
        $rwstate = mysqli_query($con,$qwstate); $wstate;
        while($dwstate = mysqli_fetch_assoc($rwstate)){
            $wstate .= '<option value="'.$dwstate['WorkStatusID'].'">'.$dwstate['WorkStatus'].'</option>';
        }
        
        $date_now = date('Y-m-d');
        $time = date('H:i');
        
        $template_form = '
            <div class="list">
                <div class="item">
                    <label class="text-orange">Asset No</label>
                    <div class="buttons-group full large">
                    <button class="grey-300 white text-orange-900 icon ion-qr-scanner" id="cam_asset_qr" onclick="asset_qr()"></button>
                    </div>
                    <select id="assetno">
                        '.$asset.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">Requested</label>
                    <input type="date" id="requested" value="'.$date_now.'">
                    <input type="time" id="requested_time" value="'.$time.'">
                </div>
                <div class="item">
                    <label class="text-orange">Required</label>
                    <input type="date" id="required" value="'.$date_now.'">
                    <input type="time" id="required_time" value="'.$time.'">
                </div>
                <div class="item">
                    <label class="text-orange">Plan Start</label>
                    <input type="date" id="plan_start" value="'.$date_now.'">
                    <input type="time" id="plan_start_time" value="'.$time.'">
                </div>
                <div class="item">
                    <label class="text-orange">Plan Finish</label>
                    <input type="date" id="plan_finish" value="'.$date_now.'">
                    <input type="time" id="plan_finish_time" value="'.$time.'">
                </div>
                <!--
                <div class="item">
                    <label class="text-orange">Actual Start</label>
                    <input type="date" id="actual_start">
                    <input type="time" id="actual_start_time">
                </div>
                <div class="item">
                    <label class="text-orange">Actual End</label>
                    <input type="date" id="actual_end">
                    <input type="time" id="actual_end_time">
                </div>-->
                <div class="item">
                    <label class="text-orange">Request By</label>
                    <select id="requestby">
                        '.$reqby.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">Work Priority</label>
                    <select id="wprior">
                        '.$wprior.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">Work Type</label>
                    <select id="wtype">
                        '.$wtype.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">Department</label>
                    <select id="dept">
                        '.$dept.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">MU Section</label>
                    <select id="wtrade">
                        '.$wtrade.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">Work State</label>
                    <select id="wstate">
                        '.$wstate.'  
                    </select>
                </div>
                <div class="item">
                    <label class="text-orange">Problem Description</label>
                    <input type="text" id="problem">
                </div>
                <div class="item">
                    <label class="text-orange">K3 Identification</label>
                    <input type="text" id="k3">
                </div>
                <div class="item">
                    <label class="text-orange">Cause Description</label>
                    <input type="text" id="cause">
                </div>
                <div class="item">
                    <label class="text-orange">Action Taken</label>
                    <input type="text" id="action">
                </div>
                <div class="item">
                    <label class="text-orange">Prevention Taken</label>
                    <input type="text" id="prevent">
                </div>
                <div class="item">
                    <br/><br/>
                </div>
            </div>
        ';    
        
        echo $template_form;
    }
    
    else if($form=='insertwo'){
       //-- Generate a new id untuk kategori aset --//
	   $result = mysqli_query($con,'SELECT COUNT(*) row FROM work_order');
	   $resultnow=mysqli_fetch_assoc($result); 
	   $numrow=$resultnow['row']+1; $woid=get_new_code('WO',$numrow);
       
       $requested = $_POST['requested'];
       $required = $_POST['required'];
       $plan_start = $_POST['plan_start'];
       $plan_finish = $_POST['plan_finish'];
       $assetno = $_POST['assetno'];
       $requestby = $_POST['requestby'];
       $wprior = $_POST['wprior'];
       $wtype = $_POST['wtype'];
       $dept = $_POST['dept'];
       $wtrade = $_POST['wtrade'];
       $wstate = $_POST['wstate'];
       $problem = $_POST['problem'];
       $k3 = $_POST['k3'];
       $cause = $_POST['cause'];
       $action = $_POST['action'];
       $prevent = $_POST['prevent'];
       $createdby = $_POST['createdby'];
       
       $query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,Created_By,DepartmentID,identifyK3) VALUES("'.$woid.'","'.$requested.'","'.$required.'","'.$plan_start.'","'.$plan_finish.'","EP000001","'.$requestby.'","'.$assetno.'","'.$wtype.'","'.$wprior.'","'.$wstate.'","'.$wtrade.'","FL000001","'.$problem.'","'.$cause.'","'.$action.'","'.$prevent.'","'.$createdby.'","'.$dept.'","'.$k3.'")'; 
       $result = mysqli_query($con,$query);
       if($result) echo 'Insert '.$woid.' Successed';
       else echo 'Insert '.$woid.' Failed ';
    }
    
?>