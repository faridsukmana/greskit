<?php
require_once 'reader.php';

//===============================================Ini adalah fungsi yang digunakan untuk mengambil data ke excel dan dipindahkan ke MySQl dengan cara=========
//===============================================menampung semua variable dalam excel ke dalam array dua dimensi=============================================
///==============================================$table adalah nama tabel dalam database yang akan di drop atau delete=======================================
function parseExcel($excel_file_name_with_path,$sheet,$table)
{
	//$sql = 'DELETE FROM '.$table; 
	$k = 0; $l = 0;
	mysql_query($sql);
	
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);
	
	if(strcmp($table,'employee')==0){
		$colname=array('EmployeeNo', 'FirstName', 'LastName', 'Position','DepartmentID', 'WorkPhone', 'HandPhone', 'Address', 'OfficeLocation');
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 37; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			}
			
			$sql = 'SELECT * FROM employee WHERE EmployeeNo="'.$product[$i-1]['EmployeeNo'].'"';
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				/*$sql = 'SELECT COUNT(*) FROM Employee'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $empid=get_new_code('EP',$numrow);
				$sql = 'DELETE FROM employee WHERE EmployeeNo="'.$product[$i-1]['EmployeeNo'].'"'; 
				$result = mysql_query($sql);*/
				$sql = 'SELECT EmployeeID FROM employee WHERE EmployeeNo="'.$product[$i-1]['EmployeeNo'].'"';  
				$result = mysql_query($sql); $resultnow=mysql_fetch_array($result); $empid=$resultnow[0];
				
				$sql = 'UPDATE Employee SET EmployeeNo="'.$product[$i-1]['EmployeeNo'].'", FirstName="'.$product[$i-1]['FirstName'].'", LastName="'.$product[$i-1]['LastName'].'", Positions="'.$product[$i-1]['Position'].'",DepartmentID="'.$product[$i-1]['DepartmentID'].'", WorkPhone="'.$product[$i-1]['WorkPhone'].'", HandPhone="'.$product[$i-1]['HandPhone'].'", Address="'.$product[$i-1]['Address'].'", OfficeLocation ="'.$product[$i-1]['Location'].'" WHERE EmployeeID="'.$empid.'"'; //echo $sql.'<br/>';
				mysql_query($sql);
			}else{
				//-- Read Text to new code ---//
				$myFile = _ROOT_."function/inc/employ.txt";
				$fh = fopen($myFile, 'r');
				$code = fread($fh, 21);
				fclose($fh);
				$ncode = $code+1;
				$fh = fopen($myFile, 'w+') or die("Can't open file.");
				fwrite($fh, $ncode);
				
				$sql = 'SELECT COUNT(*) FROM Employee'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $empid=get_new_code('EP',$ncode); 
				
				$sql = 'INSERT INTO Employee (EmployeeID, EmployeeNo, FirstName, LastName, Positions, DepartmentID, WorkPhone, HandPhone, Address, OfficeLocation) VALUES ("'.$empid.'","'.$product[$i-1]['EmployeeNo'].'","'.$product[$i-1]['FirstName'].'","'.$product[$i-1]['LastName'].'","'.$product[$i-1]['Position'].'","'.$product[$i-1]['DepartmentID'].'","'.$product[$i-1]['WorkPhone'].'","'.$product[$i-1]['HandPhone'].'","'.$product[$i-1]['Address'].'","'.$product[$i-1]['Location'].'")'; //echo $sql.'<br/>';break;
				mysql_query($sql);
			}
		}
	}
	
	else if(strcmp($table,'worder')==0){
		$colname=array('WorkOrderNo','RequestorID','AssetID','ProblemDesc','DateReceived','EstDateStart','EstDateEnd','ActDateStart','ActDateEnd','DateRequired','DateHandOver','ActionTaken','FailureCauseID','AssignID','CreatedID','WorkTypeID','CauseDescription','PreventionTaken','PMTaskID','PMID','WorkStatusID','WorkPriorityID','WorkTradeID','WOCost','PMTarStartDate','PMTarCompDate','AcceptBy','WOLaborCost','WODICost','WOPartCost','EstDuration','StepofWork','TotalExpense','DepartmentID'
		);
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 41	; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			} //echo $product[$i-1]['DepartmentID'].'<br/>';
			
			$sql = 'SELECT * FROM work_order WHERE WorkOrderNo="'.$product[$i-1]['WorkOrderNo'].'"'; //echo $sql.'<br/>';
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				/*$sql = 'SELECT COUNT(*) FROM Employee'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $empid=get_new_code('EP',$numrow);
				$sql = 'DELETE FROM employee WHERE EmployeeNo="'.$product[$i-1]['EmployeeNo'].'"'; 
				$result = mysql_query($sql);*/
				$sql = 'SELECT WorkOrderNo FROM work_order WHERE WorkOrderNo="'.$product[$i-1]['WorkOrderNo'].'"';
				$result = mysql_query($sql); $resultnow=mysql_fetch_array($result); $woid=$resultnow[0];
				
				if(isset($product[$i-1]['DateReceived'])){$rec = ($product[$i-1]['DateReceived'] - 25569) * 86400; $date_rec = gmdate("Y-m-d h:m:s", $rec);}
				else{$date_rec = $product[$i-1]['DateReceived'];}
				if(isset($product[$i-1]['EstDateStart'])){$est = ($product[$i-1]['EstDateStart'] - 25569) * 86400; $date_est = gmdate("Y-m-d h:m:s", $est);}
				else{$date_est = $product[$i-1]['EstDateStart'];}
				if(isset($product[$i-1]['EstDateEnd'])){$ede = ($product[$i-1]['EstDateEnd'] - 25569) * 86400; $date_ede = gmdate("Y-m-d h:m:s", $ede);}
				else{$date_ede = $product[$i-1]['EstDateEnd'];}
				if(isset($product[$i-1]['ActDateStart'])){$ads = ($product[$i-1]['ActDateStart'] - 25569) * 86400; $date_ads = gmdate("Y-m-d h:m:s", $ads);}
				else{$date_ads = $product[$i-1]['ActDateStart'];}
				if(isset($product[$i-1]['ActDateEnd'])){$ade = ($product[$i-1]['ActDateEnd'] - 25569) * 86400; $date_ade = gmdate("Y-m-d h:m:s", $ade);}
				else{$date_ade = $product[$i-1]['ActDateEnd'];}
				if(isset($product[$i-1]['DateRequired'])){$dre = ($product[$i-1]['DateRequired'] - 25569) * 86400; $date_dre = gmdate("Y-m-d h:m:s", $dre);}
				else{$date_dre = $product[$i-1]['DateRequired'];}
				if(isset($product[$i-1]['DateHandOver'])){$dho = ($product[$i-1]['DateHandOver'] - 25569) * 86400; $date_dho = gmdate("Y-m-d h:m:s", $dho);}
				else{$date_dho = $product[$i-1]['DateHandOver'];}
				if(isset($product[$i-1]['PMTarStartDate'])){$pms = ($product[$i-1]['PMTarStartDate'] - 25569) * 86400; $date_pms = gmdate("Y-m-d h:m:s", $pms);}
				else{$date_pms = $product[$i-1]['PMTarStartDate'];}
				if(isset($product[$i-1]['PMTarCompDate'])){$pcd = ($product[$i-1]['PMTarCompDate'] - 25569) * 86400; $date_pcd = gmdate("Y-m-d h:m:s", $pcd);}
				else{$date_pms = $product[$i-1]['PMTarCompDate'];}
				
				/*
				$rec = ($product[$i-1]['DateReceived'] - 25569) * 86400; $date_rec = gmdate("Y-m-d h:m:s", $rec);
				$est = ($product[$i-1]['EstDateStart'] - 25569) * 86400; $date_est = gmdate("Y-m-d h:m:s", $est);
				$ede = ($product[$i-1]['EstDateEnd'] - 25569) * 86400; $date_ede = gmdate("Y-m-d h:m:s", $ede);
				$ads = ($product[$i-1]['ActDateStart'] - 25569) * 86400; $date_ads = gmdate("Y-m-d h:m:s", $ads);
				$ade = ($product[$i-1]['ActDateEnd'] - 25569) * 86400; $date_ade = gmdate("Y-m-d h:m:s", $ade);
				$dre = ($product[$i-1]['DateRequired'] - 25569) * 86400; $date_dre = gmdate("Y-m-d h:m:s", $dre);
				$dho = ($product[$i-1]['DateHandOver'] - 25569) * 86400; $date_dho = gmdate("Y-m-d h:m:s", $dho);
				$pms = ($product[$i-1]['PMTarStartDate'] - 25569) * 86400; $date_pms = gmdate("Y-m-d h:m:s", $pms);
				$pcd = ($product[$i-1]['PMTarCompDate'] - 25569) * 86400; $date_pcd = gmdate("Y-m-d h:m:s", $pcd);*/
				
				$sql = 'UPDATE work_order SET  RequestorID="'.$product[$i-1]['RequestorID'].'", AssetID="'.$product[$i-1]['AssetID'].'", ProblemDesc="'.$product[$i-1]['ProblemDesc'].'",DateReceived="'.$date_rec.'", EstDateStart="'.$date_est.'", EstDateEnd="'.$date_ede.'", ActDateStart="'.$date_ads.'", ActDateEnd ="'.$date_ade.'", DateRequired ="'.$date_dre.'", DateHandOver ="'.$date_dho.'", ActionTaken ="'.$product[$i-1]['ActionTaken'].'", FailureCauseID ="'.$product[$i-1]['FailureCauseID'].'", AssignID ="'.$product[$i-1]['AssignID'].'", CreatedID ="'.$product[$i-1]['CreatedID'].'", WorkTypeID ="'.$product[$i-1]['WorkTypeID'].'", CauseDescription ="'.$product[$i-1]['CauseDescription'].'", PreventionTaken ="'.$product[$i-1]['PreventionTaken'].'", PMTaskID ="'.$product[$i-1]['PMTaskID'].'", PMID ="'.$product[$i-1]['PMID'].'", WorkStatusID ="'.$product[$i-1]['WorkStatusID'].'", WorkPriorityID ="'.$product[$i-1]['WorkPriorityID'].'", WOCost ="'.$product[$i-1]['WOCost'].'", PMTarStartDate ="'.$date_pms.'", PMTarCompDate ="'.$date_pcd.'", AcceptBy ="'.$product[$i-1]['AcceptBy'].'", WOLaborCost ="'.$product[$i-1]['WOLaborCost'].'", WODICost ="'.$product[$i-1]['WODICost'].'", WOPartCost ="'.$product[$i-1]['WOPartCost'].'", EstDuration ="'.$product[$i-1]['EstDuration'].'", StepofWork ="'.$product[$i-1]['StepofWork'].'", TotalExpense ="'.$product[$i-1]['TotalExpense'].'", DepartmentID ="'.$product[$i-1]['DepartmentID'].'" WHERE WorkOrderNo="'.$woid.'"'; 
				mysql_query($sql);
			}else{
				$sql = 'SELECT COUNT(*) FROM work_order'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $woid=get_new_code('WO',$numrow); 
				
				if(isset($product[$i-1]['DateReceived'])){$rec = ($product[$i-1]['DateReceived'] - 25569) * 86400; $date_rec = gmdate("Y-m-d h:m:s", $rec);}
				else{$date_rec = $product[$i-1]['DateReceived'];}
				if(isset($product[$i-1]['EstDateStart'])){$est = ($product[$i-1]['EstDateStart'] - 25569) * 86400; $date_est = gmdate("Y-m-d h:m:s", $est);}
				else{$date_est = $product[$i-1]['EstDateStart'];}
				if(isset($product[$i-1]['EstDateEnd'])){$ede = ($product[$i-1]['EstDateEnd'] - 25569) * 86400; $date_ede = gmdate("Y-m-d h:m:s", $ede);}
				else{$date_ede = $product[$i-1]['EstDateEnd'];}
				if(isset($product[$i-1]['ActDateStart'])){$ads = ($product[$i-1]['ActDateStart'] - 25569) * 86400; $date_ads = gmdate("Y-m-d h:m:s", $ads);}
				else{$date_ads = $product[$i-1]['ActDateStart'];}
				if(isset($product[$i-1]['ActDateEnd'])){$ade = ($product[$i-1]['ActDateEnd'] - 25569) * 86400; $date_ade = gmdate("Y-m-d h:m:s", $ade);}
				else{$date_ade = $product[$i-1]['ActDateEnd'];}
				if(isset($product[$i-1]['DateRequired'])){$dre = ($product[$i-1]['DateRequired'] - 25569) * 86400; $date_dre = gmdate("Y-m-d h:m:s", $dre);}
				else{$date_dre = $product[$i-1]['DateRequired'];}
				if(isset($product[$i-1]['DateHandOver'])){$dho = ($product[$i-1]['DateHandOver'] - 25569) * 86400; $date_dho = gmdate("Y-m-d h:m:s", $dho);}
				else{$date_dho = $product[$i-1]['DateHandOver'];}
				if(isset($product[$i-1]['PMTarStartDate'])){$pms = ($product[$i-1]['PMTarStartDate'] - 25569) * 86400; $date_pms = gmdate("Y-m-d h:m:s", $pms);}
				else{$date_pms = $product[$i-1]['PMTarStartDate'];}
				if(isset($product[$i-1]['PMTarCompDate'])){$pcd = ($product[$i-1]['PMTarCompDate'] - 25569) * 86400; $date_pcd = gmdate("Y-m-d h:m:s", $pcd);}
				else{$date_pms = $product[$i-1]['PMTarCompDate'];}
				
				/*$rec = ($product[$i-1]['DateReceived'] - 25569) * 86400; $date_rec = gmdate("Y-m-d h:m:s", $rec);
				$est = ($product[$i-1]['EstDateStart'] - 25569) * 86400; $date_est = gmdate("Y-m-d h:m:s", $est);
				$ede = ($product[$i-1]['EstDateEnd'] - 25569) * 86400; $date_ede = gmdate("Y-m-d h:m:s", $ede);
				$ads = ($product[$i-1]['ActDateStart'] - 25569) * 86400; $date_ads = gmdate("Y-m-d h:m:s", $ads);
				$ade = ($product[$i-1]['ActDateEnd'] - 25569) * 86400; $date_ade = gmdate("Y-m-d h:m:s", $ade);
				$dre = ($product[$i-1]['DateRequired'] - 25569) * 86400; $date_dre = gmdate("Y-m-d h:m:s", $dre);
				$dho = ($product[$i-1]['DateHandOver'] - 25569) * 86400; $date_dho = gmdate("Y-m-d h:m:s", $dho);
				$pms = ($product[$i-1]['PMTarStartDate'] - 25569) * 86400; $date_pms = gmdate("Y-m-d h:m:s", $pms);
				$pcd = ($product[$i-1]['PMTarCompDate'] - 25569) * 86400; $date_pcd = gmdate("Y-m-d h:m:s", $pcd);*/
				
				$sql = 'INSERT INTO work_order (WorkOrderNo,RequestorID,AssetID,ProblemDesc,DateReceived,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateRequired,DateHandOver,ActionTaken,FailureCauseID,AssignID,CreatedID,	WorkTypeID,CauseDescription,PreventionTaken,PMTaskID,PMID,WorkStatusID,WorkPriorityID,WorkTradeID,WOCost,PMTarStartDate,PMTarCompDate,AcceptBy,WOLaborCost,WODICost,WOPartCost,EstDuration,StepofWork,TotalExpense,DepartmentID
				) VALUES ("'.$product[$i-1]['WorkOrderNo'].'","'.$product[$i-1]['RequestorID'].'","'.$product[$i-1]['AssetID'].'","'.$product[$i-1]['ProblemDesc'].'","'.$date_rec.'","'.$date_est.'","'.$date_ede.'","'.$date_ads.'","'.$date_ade.'","'.$date_dre.'","'.$date_dho.'","'.$product[$i-1]['ActionTaken'].'","'.$product[$i-1]['FailureCauseID'].'","'.$product[$i-1]['AssignID'].'","'.$product[$i-1]['CreatedID'].'","'.$product[$i-1]['WorkTypeID'].'","'.$product[$i-1]['CauseDescription'].'","'.$product[$i-1]['PreventionTaken'].'","'.$product[$i-1]['PMTaskID'].'","'.$product[$i-1]['PMID'].'","'.$product[$i-1]['WorkStatusID'].'","'.$product[$i-1]['WorkPriorityID'].'","'.$product[$i-1]['WorkTradeID'].'","'.$product[$i-1]['WOCost'].'","'.$date_pms.'","'.$date_pcd.'","'.$product[$i-1]['AcceptBy'].'","'.$product[$i-1]['WOLaborCost'].'","'.$product[$i-1]['WODICost'].'","'.$product[$i-1]['WOPartCost'].'","'.$product[$i-1]['EstDuration'].'","'.$product[$i-1]['StepofWork'].'","'.$product[$i-1]['TotalExpense'].'","'.$product[$i-1]['DepartmentID'].'")'; //echo $sql.'<br/>';break;
				mysql_query($sql); 
			}
		}
	}
	
	else if(strcmp($table,'asscat')==0){
		$colname=array('AssetCatCode', 'AssetCategory');
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 5; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			}
			
			$sql = 'SELECT * FROM asset_category WHERE AssetCatCode="'.$product[$i-1]['AssetCatCode'].'"'; 
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				/*$sql = 'SELECT COUNT(*) FROM Employee'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $empid=get_new_code('EP',$numrow);
				$sql = 'DELETE FROM employee WHERE EmployeeNo="'.$product[$i-1]['EmployeeNo'].'"'; 
				$result = mysql_query($sql);*/
				$sql = 'SELECT AssetCategoryID FROM asset_category WHERE AssetCatCode="'.$product[$i-1]['AssetCatCode'].'"';  
				$result = mysql_query($sql); $resultnow=mysql_fetch_array($result); $assid=$resultnow[0];
				
				$sql = 'UPDATE asset_category SET AssetCatCode="'.$product[$i-1]['AssetCatCode'].'", AssetCategory="'.$product[$i-1]['AssetCategory'].'" WHERE AssetCategoryID="'.$assid.'"'; //echo $sql.'<br/>';
				mysql_query($sql);
			}else{
				//-- Read Text to new code ---//
				$myFile = _ROOT_."function/inc/asscat.txt";
				$fh = fopen($myFile, 'r');
				$code = fread($fh, 21);
				fclose($fh);
				$ncode = $code+1;
				$fh = fopen($myFile, 'w+') or die("Can't open file.");
				fwrite($fh, $ncode);
				
				$sql = 'SELECT COUNT(*) FROM asset_category'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $assid=get_new_code('AT',$ncode); 
				
				$sql = 'INSERT INTO asset_category (AssetCategoryID, AssetCatCode, AssetCategory) VALUES ("'.$assid.'","'.$product[$i-1]['AssetCatCode'].'","'.$product[$i-1]['AssetCategory'].'")'; //echo $sql.'<br/>';break;
				mysql_query($sql);
			}
		}
	}
	
	else if(strcmp($table,'pmsche')==0){
		$colname=array('PM_ID','PMName','AssetID','LocationID','PMGenType','ChecklistNo','PeriodDays','PMState','WorkTypeId','FreqUnits','Frequency','InitiateDate','TargetStartDate','PMWOTrade');
		
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 16; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			}
			
			$sql = 'SELECT * FROM pm_schedule WHERE PM_ID="'.$product[$i-1]['PM_ID'].'"'; //echo $sql.'<br/>';
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				$per_days = $product[$i-1]['PeriodDays'];
				$freq_unit = $product[$i-1]['FreqUnits'];
				$freq = $product[$i-1]['Frequency']; $longdays;
				if($freq_unit=='Days'){
					$longdays=$freq*1;
				}else if($freq_unit=='Weeks'){
					$longdays=$freq*7;
				}else if($freq_unit=='Months'){
					$longdays=$freq*28;
				}else if($freq_unit=='Years'){
					$longdays=$freq*365;
				}
				
				if(isset($product[$i-1]['InitiateDate'])){
					$int = ($product[$i-1]['InitiateDate'] - 25569) * 86400; $date_int = gmdate("Y-m-d h:m:s", $int);
					$date_int = date('Y-m-d', strtotime($date_int));
				}
				
				if(isset($product[$i-1]['TargetStartDate'])){
					$tar = ($product[$i-1]['TargetStartDate'] - 25569) * 86400; $date_tar = gmdate("Y-m-d h:m:s", $int);
					$date_tar = date('Y-m-d', strtotime($date_tar));
					$date_comp = date('Y-m-d', strtotime($date_tar. ' + '.$per_days.' days'));
					$date_next = date('Y-m-d', strtotime($date_tar. ' + '.$longdays.' days'));
				}
				
				$sql = 'UPDATE pm_schedule SET PMName="'.$product[$i-1]['PMName'].'", AssetID="'.$product[$i-1]['AssetID'].'", LocationID="'.$product[$i-1]['LocationID'].'" ,PMGenType="'.$product[$i-1]['PMGenType'].'", ChecklistNo="'.$product[$i-1]['ChecklistNo'].'", PeriodDays="'.$product[$i-1]['PeriodDays'].'", PMState="'.$product[$i-1]['PMState'].'",WorkTypeId="'.$product[$i-1]['WorkTypeId'].'", FreqUnits="'.$product[$i-1]['FreqUnits'].'", Frequency="'.$product[$i-1]['Frequency'].'", InitiateDate="'.$date_int.'", TargetStartDate="'.$date_tar.'",TargetCompDate="'.$date_comp.'", NextDate="'.$date_next.'", PMWOTrade="'.$product[$i-1]['PMWOTrade'].'" WHERE PM_ID="'.$product[$i-1]['PM_ID'].'"'; 
				mysql_query($sql); 
				//echo $sql.'<br/>';break;
				//echo $date_int.' '.$date_comp.' '.$date_next; break;
			}else{
				$per_days = $product[$i-1]['PeriodDays'];
				$freq_unit = $product[$i-1]['FreqUnits'];
				$freq = $product[$i-1]['Frequency']; $longdays;
				if($freq_unit=='Days'){
					$longdays=$freq*1;
				}else if($freq_unit=='Weeks'){
					$longdays=$freq*7;
				}else if($freq_unit=='Months'){
					$longdays=$freq*28;
				}else if($freq_unit=='Years'){
					$longdays=$freq*365;
				}
				
				if(isset($product[$i-1]['InitiateDate'])){
					$int = ($product[$i-1]['InitiateDate'] - 25569) * 86400; $date_int = gmdate("Y-m-d h:m:s", $int);
					$date_int = date('Y-m-d', strtotime($date_int));
				}
				
				if(isset($product[$i-1]['TargetStartDate'])){
					$tar = ($product[$i-1]['TargetStartDate'] - 25569) * 86400; $date_tar = gmdate("Y-m-d h:m:s", $int);
					$date_tar = date('Y-m-d', strtotime($date_tar));
					$date_comp = date('Y-m-d', strtotime($date_tar. ' + '.$per_days.' days'));
					$date_next = date('Y-m-d', strtotime($date_tar. ' + '.$longdays.' days'));
				}
				
				$sql = 'INSERT INTO pm_schedule (PM_ID,PMName,AssetID,LocationID,PMGenType,ChecklistNo,PeriodDays,PMState,WorkTypeId,FreqUnits,Frequency,InitiateDate,TargetStartDate,TargetCompDate,NextDate,PMWOTrade) VALUES ("'.$product[$i-1]['PM_ID'].'","'.$product[$i-1]['PMName'].'","'.$product[$i-1]['AssetID'].'","'.$product[$i-1]['LocationID'].'","'.$product[$i-1]['PMGenType'].'","'.$product[$i-1]['ChecklistNo'].'","'.$product[$i-1]['PeriodDays'].'","'.$product[$i-1]['PMState'].'","'.$product[$i-1]['WorkTypeId'].'","'.$product[$i-1]['FreqUnits'].'","'.$product[$i-1]['Frequency'].'","'.$date_int.'","'.$date_tar.'","'.$date_comp.'","'.$date_next.'","'.$product[$i-1]['PMWOTrade'].'")'; 
				mysql_query($sql); //echo $sql.'<br/>';break;
				//echo $date_int.' '.$date_comp.' '.$date_next; break;
			}
		}
	}
	
	else if(strcmp($table,'pmtask')==0){
		$colname=array('CheckListNo', 'CheckListName', 'Task', 'id_form_checklist');
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 6; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			}
			
			$sql = 'SELECT * FROM pm_checklist WHERE CheckListNo="'.$product[$i-1]['CheckListNo'].'"'; 
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				$sql = 'SELECT CheckListNo FROM pm_checklist WHERE CheckListNo="'.$product[$i-1]['CheckListNo'].'"'; 
				$result = mysql_query($sql); $resultnow=mysql_fetch_array($result); $pmtaskid=$resultnow[0];
				
				$sql = 'UPDATE pm_checklist SET CheckListName="'.$product[$i-1]['CheckListName'].'", Task="'.$product[$i-1]['Task'].'", id_form_checklist="'.$product[$i-1]['id_form_checklist'].'" WHERE CheckListNo="'.$pmtaskid.'"'; //echo $sql.'<br/>';
				mysql_query($sql);
			}else{
				//-- Increament data ---//
				//$sql = 'SELECT COUNT(*) FROM pm_checklist'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $pmtaskid=get_new_code('PM',$numrow); 
				
				$sql = 'INSERT INTO pm_checklist (CheckListNo, CheckListName, Task, id_form_checklist) VALUES ("'.$product[$i-1]['CheckListNo'].'","'.$product[$i-1]['CheckListName'].'","'.$product[$i-1]['Task'].'","'.$product[$i-1]['id_form_checklist'].'")'; //echo $sql.'<br/>';break;
				mysql_query($sql);
			}
		}
	}
	
	else if(strcmp($table,'asset')==0){// echo $data->sheets[$sheet]['numRows'];
		$colname=array('AssetNo','AssetDesc','locationID','DepartmentID','AssetCategoryID','AssetStatusID','CriticalID','EmployeeID','SupplierID','Manufacturer','ModelNumber','SerialNumber','WarrantyID','WarrantyNotes','WarrantyDate','AssetNote','DateAcquired','DateSold','ParentID','AreaID','PlantID');
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 37; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			}
			
			$sql = 'SELECT * FROM asset WHERE AssetNo="'.$product[$i-1]['AssetNo'].'"';
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				$sql = 'SELECT AssetID FROM asset WHERE AssetNo="'.$product[$i-1]['AssetNo'].'"';  
				$result = mysql_query($sql); $resultnow=mysql_fetch_array($result); $assid=$resultnow[0];
				
				if(isset($product[$i-1]['WarrantyDate'])){$war = ($product[$i-1]['WarrantyDate'] - 25569) * 86400; $date_war = gmdate("Y-m-d h:m:s", $war);}
				else{$date_war = $product[$i-1]['WarrantyDate'];}
				if(isset($product[$i-1]['DateAcquired'])){$ac = ($product[$i-1]['DateAcquired'] - 25569) * 86400; $date_ac = gmdate("Y-m-d h:m:s", $ac);}
				else{$date_ac = $product[$i-1]['DateAcquired'];}
				if(isset($product[$i-1]['DateSold'])){$sold = ($product[$i-1]['DateSold'] - 25569) * 86400; $date_sold = gmdate("Y-m-d h:m:s", $sold);}
				else{$date_sold = $product[$i-1]['DateSold'];}
				
				/*$war = ($product[$i-1]['WarrantyDate'] - 25569) * 86400; $date_war = gmdate("Y-m-d h:m:s", $war);
				$ac = ($product[$i-1]['DateAcquired'] - 25569) * 86400; $date_ac = gmdate("Y-m-d h:m:s", $ac);
				$sold = ($product[$i-1]['DateSold'] - 25569) * 86400; $date_sold = gmdate("Y-m-d h:m:s", $sold);*/
				
				$sql = 'UPDATE asset SET AssetNo="'.$product[$i-1]['AssetNo'].'", AssetDesc="'.$product[$i-1]['AssetDesc'].'", locationID="'.$product[$i-1]['locationID'].'", DepartmentID="'.$product[$i-1]['DepartmentID'].'", AssetCategoryID="'.$product[$i-1]['AssetCategoryID'].'", AssetStatusID="'.$product[$i-1]['AssetStatusID'].'", CriticalID="'.$product[$i-1]['CriticalID'].'",  EmployeeID="'.$product[$i-1]['EmployeeID'].'", SupplierID="'.$product[$i-1]['SupplierID'].'", Manufacturer="'.$product[$i-1]['Manufacturer'].'", ModelNumber="'.$product[$i-1]['ModelNumber'].'", SerialNumber="'.$product[$i-1]['SerialNumber'].'", WarrantyID="'.$product[$i-1]['WarrantyID'].'", WarrantyNotes="'.$product[$i-1]['WarrantyNotes'].'",  WarrantyDate="'.$date_war.'", AssetNote="'.$product[$i-1]['AssetNote'].'", DateAcquired="'.$date_ac.'", DateSold="'.$date_sold.'", ParentID="'.$product[$i-1]['ParentID'].'", AreaID="'.$product[$i-1]['AreaID'].'", PlantID="'.$product[$i-1]['PlantID'].'" WHERE AssetID="'.$assid.'"';  //echo $sql.'<br/>';
				mysql_query($sql);
			}else{
				$sql = 'SELECT COUNT(*) FROM asset'; $result=mysql_query($sql); $resultnow=mysql_fetch_array($result); $numrow=$resultnow[0]+1; $assid=get_new_code('AS',$numrow); 
				
				if(isset($product[$i-1]['WarrantyDate'])){$war = ($product[$i-1]['WarrantyDate'] - 25569) * 86400; $date_war = gmdate("Y-m-d h:m:s", $war);}
				else{$date_war = $product[$i-1]['WarrantyDate'];}
				if(isset($product[$i-1]['DateAcquired'])){$ac = ($product[$i-1]['DateAcquired'] - 25569) * 86400; $date_ac = gmdate("Y-m-d h:m:s", $ac);}
				else{$date_ac = $product[$i-1]['DateAcquired'];}
				if(isset($product[$i-1]['DateSold'])){$sold = ($product[$i-1]['DateSold'] - 25569) * 86400; $date_sold = gmdate("Y-m-d h:m:s", $sold);}
				else{$date_sold = $product[$i-1]['DateSold'];}
				
				/*$war = ($product[$i-1]['WarrantyDate'] - 25569) * 86400; $date_war = gmdate("Y-m-d h:m:s", $war);
				$ac = ($product[$i-1]['DateAcquired'] - 25569) * 86400; $date_ac = gmdate("Y-m-d h:m:s", $ac);
				$sold = ($product[$i-1]['DateSold'] - 25569) * 86400; $date_sold = gmdate("Y-m-d h:m:s", $sold);*/
				
				$sql = 'INSERT INTO asset (AssetID,AssetNo,AssetDesc,locationID,DepartmentID,AssetCategoryID,AssetStatusID,CriticalID, EmployeeID,SupplierID,Manufacturer,ModelNumber,SerialNumber,WarrantyID,WarrantyNotes, WarrantyDate,AssetNote,DateAcquired,DateSold,ParentID,AreaID,PlantID) VALUES("'.$assid.'","'.$product[$i-1]['AssetNo'].'","'.$product[$i-1]['AssetDesc'].'","'.$product[$i-1]['locationID'].'","'.$product[$i-1]['DepartmentID'].'","'.$product[$i-1]['AssetCategoryID'].'","'.$product[$i-1]['AssetStatusID'].'","'.$product[$i-1]['CriticalID'].'","'.$product[$i-1]['EmployeeID'].'","'.$product[$i-1]['SupplierID'].'","'.$product[$i-1]['Manufacturer'].'","'.$product[$i-1]['ModelNumber'].'","'.$product[$i-1]['SerialNumber'].'","'.$product[$i-1]['WarrantyID'].'","'.$product[$i-1]['WarrantyNotes'].'","'.$date_war.'","'.$product[$i-1]['AssetNote'].'","'.$date_ac.'","'.$date_sold.'","'.$product[$i-1]['ParentID'].'","'.$product[$i-1]['AreaID'].'","'.$product[$i-1]['PlantID'].'")';//echo $sql.'<br/>';break;
				mysql_query($sql);
			}
		}
	}
	
	else if(strcmp($table,'item')==0){// echo $data->sheets[$sheet]['numRows'];
		$colname=array('item_id','brand_id','item_category_code','item_description','critical_id','min','max','id_unit', 'warehouse_id','currency_id','id_location','remark_1','remark_2','remark_3','remark_4','remark_5');
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 18; $j++) {
				$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j]; 
			}
			
			$sql = 'SELECT * FROM invent_item WHERE item_id="'.$product[$i-1]['item_id'].'"';
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				$sql = 'SELECT * FROM invent_item WHERE item_id="'.$product[$i-1]['item_id'].'"';
				$result = mysql_query($sql); $resultnow=mysql_fetch_array($result); $item_id=$resultnow[0];
				
				$sql = 'UPDATE invent_item SET brand_id="'.$product[$i-1]['brand_id'].'",item_category_code="'.$product[$i-1]['item_category_code'].'",item_description="'.$product[$i-1]['item_description'].'",critical_id="'.$product[$i-1]['critical_id'].'",min="'.$product[$i-1]['min'].'",max="'.$product[$i-1]['max'].'",id_unit="'.$product[$i-1]['id_unit'].'",warehouse_id="'.$product[$i-1]['warehouse_id'].'",currency_id="'.$product[$i-1]['currency_id'].'",id_location="'.$product[$i-1]['id_location'].'",remark_1="'.$product[$i-1]['remark_1'].'",remark_2="'.$product[$i-1]['remark_2'].'",remark_3="'.$product[$i-1]['remark_3'].'",remark_4="'.$product[$i-1]['remark_4'].'",remark_5="'.$product[$i-1]['remark_5'].'" WHERE item_id="'.$item_id.'"';  //echo $sql.'<br/>';
				mysql_query($sql);
			}else{
				$sql = 'INSERT INTO invent_item (item_id,brand_id,item_category_code,item_description,critical_id,min,max,id_unit, warehouse_id,currency_id,id_location,remark_1,remark_2,remark_3,remark_4,remark_5) VALUES("'.$product[$i-1]['item_id'].'","'.$product[$i-1]['brand_id'].'","'.$product[$i-1]['item_category_code'].'","'.$product[$i-1]['item_description'].'","'.$product[$i-1]['critical_id'].'","'.$product[$i-1]['min'].'","'.$product[$i-1]['max'].'","'.$product[$i-1]['id_unit'].'","'.$product[$i-1]['warehouse_id'].'","'.$product[$i-1]['currency_id'].'","'.$product[$i-1]['id_location'].'","'.$product[$i-1]['remark_1'].'","'.$product[$i-1]['remark_2'].'","'.$product[$i-1]['remark_3'].'","'.$product[$i-1]['remark_4'].'","'.$product[$i-1]['remark_5'].'")';
				mysql_query($sql); 
			}
		}
	}
	
	else if(strcmp($table,'pmwo_detail_object')==0){
		$colname=array('object','compname','owner','category','gi_brand','gi_type','gi_service_tag','gi_pn','gi_sn','pi_vendor','pi_purch_date','pi_waranty','pi_end_waranty','pi_waranty_state','m_type','m_no','k_brand','k_no','ms_brand','ms_type','processor','mm_mb','mm_type','hdd_type','hdd_capacity','hdd_qty','drive','ups_bat','fa_cpu','fa_monitor','ui_user','ui_level','ui_location','ui_own_section','ui_department','ui_start_date_use');

		for ($i = 7; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 37; $j++) {
					if($j==12 or $j==14 or $j==37){
						$date = $data->sheets[$sheet]['cells'][$i][$j];
						$arr = explode('/',$date); 
						$tahun = $arr[2];
						$tanggal = (int)$arr[0];
						$bulan = $arr[1];
						if (checkdate($bulan, $tanggal, $tahun))
							$fus = $tahun.'-'.$bulan.'-'.$tanggal;
						else
							$fus = '-';
						$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j];
					}else if($j==40){
						$product[$i-1][$colname[$j-2]] = $product[$i-1]['sel_amount']+$product[$i-1]['cogs']+$product[$i-1]['tlf']+$product[$i-1]['ci']+$product[$i-1]['ddo'];
					}else{
						$product[$i-1][$colname[$j-2]]=$data->sheets[$sheet]['cells'][$i][$j];
					}
			}
			
			$sql = 'SELECT * FROM '.$table.' WHERE APMOBJECTID="'.$product[$i-1]['object'].'"' ; //echo $sql;
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				$sql = 'DELETE FROM '.$table.' WHERE APMOBJECTID like "'.$product[$i-1]['object'].'"' ;
				$result = mysql_query($sql);
				
				$sql =  'INSERT INTO '.$table.' VALUES("","'.$product[$i-1]['object'].'","'.$product[$i-1]['compname'].'","'.$product[$i-1]['owner'].'",
					"'.$product[$i-1]['category'].'","'.$product[$i-1]['gi_brand'].'","'.$product[$i-1]['gi_type'].'","'.$product[$i-1]['gi_service_tag'].'",
					"'.$product[$i-1]['gi_pn'].'","'.$product[$i-1]['gi_sn'].'","'.$product[$i-1]['pi_vendor'].'","'.$product[$i-1]['pi_purch_date'].'",
					"'.$product[$i-1]['pi_waranty'].'","'.$product[$i-1]['pi_end_waranty'].'","'.$product[$i-1]['pi_waranty_state'].'","'.$product[$i-1]['m_type'].'",
					"'.$product[$i-1]['m_no'].'","'.$product[$i-1]['k_brand'].'","'.$product[$i-1]['k_no'].'","'.$product[$i-1]['ms_brand'].'",
					"'.$product[$i-1]['ms_type'].'","'.$product[$i-1]['processor'].'","'.$product[$i-1]['mm_mb'].'","'.$product[$i-1]['mm_type'].'",
					"'.$product[$i-1]['hdd_type'].'","'.$product[$i-1]['hdd_capacity'].'","'.$product[$i-1]['hdd_qty'].'","'.$product[$i-1]['drive'].'",
					"'.$product[$i-1]['ups_bat'].'","'.$product[$i-1]['fa_cpu'].'","'.$product[$i-1]['fa_monitor'].'","'.$product[$i-1]['ui_user'].'",
					"'.$product[$i-1]['ui_level'].'","'.$product[$i-1]['ui_location'].'","'.$product[$i-1]['ui_own_section'].'","'.$product[$i-1]['ui_department'].'",
					"'.$product[$i-1]['ui_start_date_use'].'")';
				//	echo $sql.'<br/>';
					$query = mysql_query($sql);
				//	echo $k++.' .'.$rows.'<br/>';
			}else{
				$sql =  'INSERT INTO '.$table.' VALUES("","'.$product[$i-1]['object'].'","'.$product[$i-1]['compname'].'","'.$product[$i-1]['owner'].'",
					"'.$product[$i-1]['category'].'","'.$product[$i-1]['gi_brand'].'","'.$product[$i-1]['gi_type'].'","'.$product[$i-1]['gi_service_tag'].'",
					"'.$product[$i-1]['gi_pn'].'","'.$product[$i-1]['gi_sn'].'","'.$product[$i-1]['pi_vendor'].'","'.$product[$i-1]['pi_purch_date'].'",
					"'.$product[$i-1]['pi_waranty'].'","'.$product[$i-1]['pi_end_waranty'].'","'.$product[$i-1]['pi_waranty_state'].'","'.$product[$i-1]['m_type'].'",
					"'.$product[$i-1]['m_no'].'","'.$product[$i-1]['k_brand'].'","'.$product[$i-1]['k_no'].'","'.$product[$i-1]['ms_brand'].'",
					"'.$product[$i-1]['ms_type'].'","'.$product[$i-1]['processor'].'","'.$product[$i-1]['mm_mb'].'","'.$product[$i-1]['mm_type'].'",
					"'.$product[$i-1]['hdd_type'].'","'.$product[$i-1]['hdd_capacity'].'","'.$product[$i-1]['hdd_qty'].'","'.$product[$i-1]['drive'].'",
					"'.$product[$i-1]['ups_bat'].'","'.$product[$i-1]['fa_cpu'].'","'.$product[$i-1]['fa_monitor'].'","'.$product[$i-1]['ui_user'].'",
					"'.$product[$i-1]['ui_level'].'","'.$product[$i-1]['ui_location'].'","'.$product[$i-1]['ui_own_section'].'","'.$product[$i-1]['ui_department'].'",
					"'.$product[$i-1]['ui_start_date_use'].'")';
				//	echo $sql.'<br/>';
					$query = mysql_query($sql);
				//	echo $l++.' .'.$rows.'<br/>';
			}
			
			
			if($query){
				$content = true;
			}else{
				$content = false;
			}
		}
	}else if(strcmp($table,'budget_input_excel')==0){
		$sql = 'DELETE FROM '.$table; 
		mysql_query($sql);
	
		$colname=array('coding','cogroup','exgroup','actype','cocentre','ledacc','ledfac','ledcomFe','juncur','julcur','augcur','sepcur','octcur','novcur','deccur','sumcur','remcur','jannext','febnext','marnext','aprnext','maynext','junnext','julnext','augnext','sepnext','octnext','novnext','decnext','sumnext','ledname','comp','newcoled','coled','codingcocom');
		
		for ($i = 4; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 35; $j++) {
				$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
			}
			$sql =  'INSERT INTO '.$table.' VALUES("'.$product[$i-1]['coding'].'","'.$product[$i-1]['cogroup'].'","'.$product[$i-1]['exgroup'].'",
					"'.$product[$i-1]['actype'].'","'.$product[$i-1]['cocentre'].'","'.$product[$i-1]['ledacc'].'","'.$product[$i-1]['ledfac'].'",
					"'.$product[$i-1]['ledcomFe'].'","'.$product[$i-1]['juncur'].'","'.$product[$i-1]['julcur'].'","'.$product[$i-1]['augcur'].'",
					"'.$product[$i-1]['sepcur'].'","'.$product[$i-1]['octcur'].'","'.$product[$i-1]['novcur'].'","'.$product[$i-1]['deccur'].'",
					"'.$product[$i-1]['sumcur'].'","'.$product[$i-1]['remcur'].'","'.$product[$i-1]['jannext'].'","'.$product[$i-1]['febnext'].'",
					"'.$product[$i-1]['marnext'].'","'.$product[$i-1]['aprnext'].'","'.$product[$i-1]['maynext'].'","'.$product[$i-1]['junnext'].'",
					"'.$product[$i-1]['julnext'].'","'.$product[$i-1]['augnext'].'","'.$product[$i-1]['sepnext'].'","'.$product[$i-1]['octnext'].'",
					"'.$product[$i-1]['novnext'].'","'.$product[$i-1]['decnext'].'","'.$product[$i-1]['sumnext'].'","'.$product[$i-1]['ledname'].'",
					"'.$product[$i-1]['comp'].'","'.$product[$i-1]['newcoled'].'","'.$product[$i-1]['coled'].'","'.$product[$i-1]['codingcocom'].'")';
			mysql_query($sql);	
		//	echo $sql.'<br/>';
		//	break;
		}
	}
	
	else if(strcmp($table,'budget_input_excel_core')==0){
		$sql = 'DELETE FROM '.$table; 
		mysql_query($sql);
	
		$colname=array('coding','cogroup','exgroup','actype','cocentre','ledacc','ledfac','ledcomFe','jancur','febcur','marcur','aprcur','maycur','juncur','julcur','augcur','sepcur','octcur','novcur','deccur','jannext','febnext','marnext','aprnext','maynext','junnext','julnext','augnext','sepnext','octnext','novnext','decnext');
		
		/*for ($i = 4; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 32; $j++) {
				$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
			}
			
			$sql =  'INSERT INTO '.$table.' VALUES("'.$product[$i-1]['coding'].'","'.$product[$i-1]['cogroup'].'","'.$product[$i-1]['exgroup'].'",
					"'.$product[$i-1]['actype'].'","'.$product[$i-1]['cocentre'].'","'.$product[$i-1]['ledacc'].'","'.$product[$i-1]['ledfac'].'",
					"'.$product[$i-1]['ledcomFe'].'","'.$product[$i-1]['jancur'].'","'.$product[$i-1]['febcur'].'","'.$product[$i-1]['marcur'].'",
					"'.$product[$i-1]['aprcur'].'","'.$product[$i-1]['maycur'].'","'.$product[$i-1]['juncur'].'","'.$product[$i-1]['julcur'].'","'.$product[$i-1]['augcur'].'",
					"'.$product[$i-1]['sepcur'].'","'.$product[$i-1]['octcur'].'","'.$product[$i-1]['novcur'].'","'.$product[$i-1]['deccur'].'",
					"'.$product[$i-1]['jannext'].'","'.$product[$i-1]['febnext'].'",
					"'.$product[$i-1]['marnext'].'","'.$product[$i-1]['aprnext'].'","'.$product[$i-1]['maynext'].'","'.$product[$i-1]['junnext'].'",
					"'.$product[$i-1]['julnext'].'","'.$product[$i-1]['augnext'].'","'.$product[$i-1]['sepnext'].'","'.$product[$i-1]['octnext'].'",
					"'.$product[$i-1]['novnext'].'","'.$product[$i-1]['decnext'].'")';
			mysql_query($sql);	*/
			
		for ($i = 4; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 32; $j++) {
				$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
			}
			$qjan = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=1 AND Year(TransDate)='.date('Y'); $rjan = mysql_query($qjan); $rsjan = mysql_fetch_array($rjan);
			
			$qfeb = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=2 AND Year(TransDate)='.date('Y'); $rfeb = mysql_query($qfeb); $rsfeb = mysql_fetch_array($rfeb);
			
			$qmar = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=3 AND Year(TransDate)='.date('Y'); $rmar = mysql_query($qmar); $rsmar = mysql_fetch_array($rmar);
			
			$qapr = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=4 AND Year(TransDate)='.date('Y'); $rapr = mysql_query($qapr); $rsapr = mysql_fetch_array($rapr);
			
			$qmay = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=5 AND Year(TransDate)='.date('Y'); $rmay = mysql_query($qmay); $rsmay = mysql_fetch_array($rmay);
			
			$qjun = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=6 AND Year(TransDate)='.date('Y'); $rjun = mysql_query($qjun); $rsjun = mysql_fetch_array($rjun);
			
			$qjul = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=7 AND Year(TransDate)='.date('Y'); $rjul = mysql_query($qjul); $rsjul = mysql_fetch_array($rjul);
			
			$qaug = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=8 AND Year(TransDate)='.date('Y'); $raug = mysql_query($qaug); $rsaug = mysql_fetch_array($raug);
			
			$qsep = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=9 AND Year(TransDate)='.date('Y'); $rsep = mysql_query($qsep); $rssep = mysql_fetch_array($rsep);
			
			$qoct = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=10 AND Year(TransDate)='.date('Y'); $roct = mysql_query($qoct); $rsoct = mysql_fetch_array($roct);
			
			$qnov = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=11 AND Year(TransDate)='.date('Y'); $rnov = mysql_query($qnov); $rsnov = mysql_fetch_array($rnov);
			
			$qdec = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=12 AND Year(TransDate)='.date('Y'); $rdec = mysql_query($qdec); $rsdec = mysql_fetch_array($rdec);
			
			$sql =  'INSERT INTO '.$table.' VALUES("'.$product[$i-1]['coding'].'","'.$product[$i-1]['cogroup'].'","'.$product[$i-1]['exgroup'].'",
					"'.$product[$i-1]['actype'].'","'.$product[$i-1]['cocentre'].'","'.$product[$i-1]['ledacc'].'","'.$product[$i-1]['ledfac'].'",
					"'.$product[$i-1]['ledcomFe'].'","'.$product[$i-1]['jancur'].'","'.$product[$i-1]['febcur'].'","'.$product[$i-1]['marcur'].'",
					"'.$product[$i-1]['aprcur'].'","'.$product[$i-1]['maycur'].'","'.$product[$i-1]['juncur'].'","'.$product[$i-1]['julcur'].'","'.$product[$i-1]['augcur'].'",
					"'.$product[$i-1]['sepcur'].'","'.$product[$i-1]['octcur'].'","'.$product[$i-1]['novcur'].'","'.$product[$i-1]['deccur'].'",
					"'.$rsjan[0].'","'.$rsfeb[0].'",
					"'.$rsmar[0].'","'.$rsapr[0].'","'.$rsmay[0].'","'.$rsjun[0].'",
					"'.$rsjul[0].'","'.$rsaug[0].'","'.$rssep[0].'","'.$rsoct[0].'",
					"'.$rsnov[0].'","'.$rsdec[0].'")';
			mysql_query($sql);	
		//	echo $sql.'<br/>';
		//	break;
		}
	}
	
	else if(strcmp($table,'purch_invoice')==0){
		$sql = 'DELETE FROM '.$table; 
		mysql_query($sql);
		
		$colname=array('Plan_PO','PO_Number','Supplier_Name','Description','Price_Unit','Qty_RF','Total','VAT','WHTAX','Total_Amount','RF_No','RF_Date','RF_Receive','Invoice_No','No_Faktur_Pajak','FP_Date','Due_Date','Complete_Date','IR_No','IR_Date','IR_No_2','IR_Date_2','Nota_Retur','Retur_Faktur_Pajak','Date_Retur_Faktur_Pajak');
		
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 26; $j++) {
				if($j==12 or $j==13 or $j==16 or $j==17 or $j==18 or $j==20 or $j==22){
						$date = $data->sheets[$sheet]['cells'][$i][$j]; $unixTimestamp = ($date - 25569) * 86400; $date = gmdate("Y-m-d", $unixTimestamp);
						$product[$i-1][$colname[$j-1]] = $date;
				}else if($j==4){
					$product[$i-1][$colname[$j-1]]=str_replace('"',"'",$data->sheets[$sheet]['cells'][$i][$j]);
				}else{
					$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
				}
			}
			$sql = 'INSERT INTO '.$table.' VALUES ("'.$product[$i-1]['Plan_PO'].'","'.$product[$i-1]['PO_Number'].'","'.$product[$i-1]['Supplier_Name'].'","'.$product[$i-1]['Description'].'","'.$product[$i-1]['Price_Unit'].'","'.$product[$i-1]['Qty_RF'].'","'.$product[$i-1]['Total'].'","'.$product[$i-1]['VAT'].'","'.$product[$i-1]['WHTAX'].'","'.$product[$i-1]['Total_Amount'].'","'.$product[$i-1]['RF_No'].'","'.$product[$i-1]['RF_Date'].'","'.$product[$i-1]['RF_Receive'].'","'.$product[$i-1]['Invoice_No'].'","'.$product[$i-1]['No_Faktur_Pajak'].'","'.$product[$i-1]['FP_Date'].'","'.$product[$i-1]['Due_Date'].'","'.$product[$i-1]['Complete_Date'].'","'.$product[$i-1]['IR_No'].'","'.$product[$i-1]['IR_Date'].'","'.$product[$i-1]['IR_No_2'].'","'.$product[$i-1]['IR_Date_2'].'","'.$product[$i-1]['Nota_Retur'].'","'.$product[$i-1]['Retur_Faktur_Pajak'].'","'.$product[$i-1]['Date_Retur_Faktur_Pajak'].'")';
			mysql_query($sql);
		//	echo $sql;
		//	break;
		}
	}
	
//	echo $product;
	
	return $product;
}

//==========================================================================================================================================================================================

//---------------------------------------------buat fungsi untuk megetahui apakah parameter termasuk date atau bukan----------------------------------------//
	function is_date( $str )
	{
		  $stamp = strtotime( $str );
		 
		  if (!is_numeric($stamp))
		  {
			 return FALSE;
		  }
		  
		  $month = date( 'm', $stamp );
		  $day   = date( 'd', $stamp );
		  $year  = date( 'Y', $stamp );
		 
		  if (checkdate($month, $day, $year))
		  {
			 return TRUE;
		  }
		 
		  return FALSE;
	} 
	//----------------------------------------------------------------------------------------------------------------------------------------------------------//