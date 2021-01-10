<?php
	function choose_pmgen(){
		$content = '<br/><div class="ade">Generate Preventive Maintenance</div>';
		$content .= '<form action="'.PATH_PMGENE.'" method="post" enctype="multipart/form-data">';
		$content .= '<div align="center" style="margin:4 1 1 1;">
						<input type="hidden" name="set" value="manual" />
		                <input class="form-submit" type="submit" style="width:270px;" value="Manual">
		             </div>';
	    $content .= '</form>'; 
		
		$content .= '<form action="'.PATH_PMGENE.'" method="post" enctype="multipart/form-data">';
		$content .= '<div align="center" style="margin:4 1 1 1;">
						<input type="hidden" name="set" value="automatic" />
						'.date_je(array('end_date'.$i,$_REQUEST['end_date'])).'
		                <input class="form-submit" type="submit" value="Automatic">
		             </div>';
	    $content .= '</form>'; 
		return $content;
	}
	
	function pmgen(){
		//***********Pilih Jadwal PM*********************		
		$query = 'SELECT B.CheckListName, A.PMName, A.TargetStartDate, A.NextDate, A.PM_ID FROM pm_schedule A, pm_checklist B WHERE A.ChecklistNo=B.ChecklistNo AND A.PMState="Enable" AND A.Hidden="no"'; 
		$thead = '<thead><tr><th scope="col"><b>No</b></th><th scope="col"><b>Task Name</b></th><th scope="col"><b>Schedule Name</b></th><th scope="col"><b>Range Date</b></th><th scope="col"><b></b></th><th scope="col"><b>Select</b></th></tr></thead>';
		$result = mysql_exe_query(array($query,1));
		$i =0; $temp_i=0; 
		
		//========= Jika Otomatis ==================================
		if($_REQUEST['set']=='automatic'){
			while($result_now=mysql_exe_fetch_array(array($result,1))){
				$temp_i = $i+1;
				$start = convert_date(array($result_now[2],3));
				$checklist .= '<tr><td>'.$temp_i.'</td><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td width="200">'.date_je(array('start_'.$i,$start)).'<td width="200">'.date_je(array('next_'.$i,$_REQUEST['end_date'])).'</td><td><input type="checkbox" name="sched_'.$i.'" value="v" checked /><input type="hidden" name="pmname_'.$i.'" value="'.$result_now[4].'" /></tr>';
				$i++;
			}
		}
		
		//========= Jika Manual ==================================
		else{
			while($result_now=mysql_exe_fetch_array(array($result,1))){
				$temp_i = $i+1;
				$start = convert_date(array($result_now[2],3));
				$next = date ("Y-m-d", strtotime ($result_now[3] .'-1 days'));
				$next = convert_date(array($next,3));
				$checklist .= '<tr><td>'.$temp_i.'</td><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td width="200">'.date_je(array('start_'.$i,$start)).'<td width="200">'.date_je(array('next_'.$i,$next)).'</td><td><input type="checkbox" name="sched_'.$i.'" value="v" /><input type="hidden" name="pmname_'.$i.'" value="'.$result_now[4].'" /></tr>';
				$i++;
			}
		}
		
		$table_checklist = '<div class="col-sm-12">'.$table_checklist.'<table id="pmgen" class="table table-bordered" style="font-size: 12px">'.$thead.'<tbody>'.$checklist.'</tbody></table></div>';
		
		//********Form Show More Planning***************
		//$content = '<br/><div class="ade">Generate Preventive Maintenance</div>';
		$content = '<form action="'.PATH_PMGENE.GEN.POST.'" method="post" enctype="multipart/form-data">';
		$content .= '<div align="center" style="margin:4 1 1 1;">
		                <input type="hidden" name="totalpm" value="'.$i.'">
		                <input class="form-submit" type="submit" style="width:270px;" value="Show More Planning PM Schedule">
		             </div>'.$table_checklist;
	    $content .= '</form>'; 
	    
	    //---------------------Update pmschedule and create a new WO-------------------------
		if(isset($_REQUEST['wo'])){
		    if(!empty($_REQUEST['moddate'])){
			    $mod_date = str_replace('+-*','"',$_REQUEST['moddate']); 
			    $moddate = explode(";", $mod_date);
			    $i=0; //echo sizeof($moddate);
			    while($i<sizeof($moddate)-1){
			        //echo $moddate[$i].'<br/>';
			        mysql_exe_query(array($moddate[$i],1));
			        $i++;
			    }
		    }
		    
		    if(!empty($_REQUEST['inquery'])){
			    $inquery .= str_replace('+-*','"',$_REQUEST['inquery']); //echo $inquery.'<br/>';
			    mysql_exe_query(array($inquery,1));
		    }
		    
		    if(!empty($_REQUEST['part'])){
			    $part .= str_replace('+-*','"',$_REQUEST['part']); //echo $part.'<br/>';
			    mysql_exe_query(array($part,1));
		    }
			
			//$content = '<br/><div class="ade">Generate Preventive Maintenance</div>';
			$content = '<div class="alert alert-success" align="center">Already Create Work Order for PM '.$_REQUEST['pmid'].'</div>';
		}
	    
	    //***********Jika post dilakukan*****************
	    if(isset($_REQUEST['gen'])){
			if(isset($_REQUEST['post'])){ 
			    $i=0; $k=0; $totalpm = $_REQUEST['totalpm']; $content = ''; $value=''; $part=''; $mod_date=''; $data = array();
                //-- Get last id WO Number--//
				$result = mysql_exe_query(array(COUNTWORDER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1;
			    while($k<$totalpm){
			        //echo $_REQUEST['start_'.$k].' '.$_REQUEST['next_'.$k].' '.$_REQUEST['sched_'.$k].' '.$_REQUEST['pmname_'.$k].'<br/>';
			        if(!empty($_REQUEST['sched_'.$k])){
			        //************************************PLAN Schedule PM************************************************
					$query = 'SELECT P.FreqUnits, P.Frequency, P.PeriodDays, P.TargetStartDate, P.PM_ID, P.PMGenType, P.AssetID, P.LocationID, P.PMWOTrade, P.ChecklistNo, M.CheckListName, P.WorkTypeId FROM pm_schedule P, pm_checklist M WHERE P.ChecklistNo=M.CheckListNo AND P.PM_ID="'.$_REQUEST['pmname_'.$k].'"';
					$result = mysql_exe_query(array($query,1)); $result_now = mysql_exe_fetch_array(array($result,1));
					$fun = $result_now[0]; $freq = $result_now[1]; $Pdays = $result_now[2]; $TstartDate = $result_now[3]; $PMName = $result_now[4];
					$PMGenType = $result_now[5]; $asset = $result_now[6]; $location = $result_now[7]; $wotrade = $result_now[8]; $pmtask = $result_now[9]; $problem = $result_now[10]; $wotype = $result_now[11]; //echo $wotype;
					if(strcmp($fun,'Days')==0) $freq=$freq*1; else if(strcmp($fun,'Weeks')==0) $freq=$freq*7; else if(strcmp($fun,'Months')==0) $freq=$freq*28; else if(strcmp($fun,'Years')==0) $freq=$freq*365; 
					//$TstartDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days')); 
					
					//=====Get date from posting and define all variable ===========
					$start = convert_date(array($_REQUEST['start_'.$k],2)); $end = convert_date(array($_REQUEST['next_'.$k],2)); $pmid=$_REQUEST['pmname_'.$k]; //echo $start.' '.$end.' '.$_REQUEST['pmname_'.$k].'<br/>';
					if($TstartDate>=$start || $TstartDate<=$end){
						if(strcmp($PMGenType,'Schedule')==0){
							if(!empty($asset)){
								$queryasset = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND AssetID="'.$asset.'" AND AssetStatusID="AK000001"'; $asres = mysql_exe_query(array($queryasset,1)); $asres_now = mysql_exe_fetch_array(array($asres,1));
								//------Hanya untuk mengecek asset yang diquery tidak bernilai 0 atau status aktif--
								$rows = mysql_exe_num_rows(array($asres,1)); 
								//---------------------------------------------------------------------------------
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days'));
								while($TstartDate<=$end && $rows>0){
									$data[$i][0]=$PMName; $data[$i][1]=$asres_now[1]; $data[$i][2]=$asres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
									$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$asres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
									//$content.= $PMName.' -- '.$asres_now[1].' -- '.$asres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
									
									//=========== Dapatkan spare part berdasarkan PM Task ========================
									$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
									$result_spare = mysql_exe_query(array($query_spare,1));
									while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
									    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
									}
									
									$TstartDate = $TnextDate;
									$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
									$i++;
								}
								$mod_date .= 'UPDATE pm_schedule SET TargetStartDate="'.$TstartDate.'", TargetCompDate="'.$TcompDate.'", NextDate="'.$TnextDate.'" WHERE PM_ID="'.$pmid.'";';
							}else if(!empty($location)){
								$querylocation = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND L.LocationID="'.$location.'" AND AssetStatusID="AK000001"'; $locres = mysql_exe_query(array($querylocation,1)); 
								$dateStart = $TstartDate;
								while($locres_now = mysql_exe_fetch_array(array($locres,1))){
									$TstartDate = $dateStart;
									$TcompDate = date ("Y-m-d", strtotime ($dateStart .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($dateStart .'+'.$freq.' days'));
									while($TstartDate<=$end){
										$data[$i][0]=$PMName; $data[$i][1]=$locres_now[1]; $data[$i][2]=$locres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
										$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$locres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
										//$content.= $PMName.' -- '.$locres_now[1].' -- '.$locres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
										
										//=========== Dapatkan spare part berdasarkan PM Task ========================
    									$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
    									$result_spare = mysql_exe_query(array($query_spare,1));
    									while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
    									    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
    									}
									
									
										$TstartDate = $TnextDate;
										$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
										$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
										$i++;
									}	
								}	
								$mod_date .= 'UPDATE pm_schedule SET TargetStartDate="'.$TstartDate.'", TargetCompDate="'.$TcompDate.'", NextDate="'.$TnextDate.'" WHERE PM_ID="'.$pmid.'";';
							}
							
						}else if(strcmp($PMGenType,'Actual')==0){
							if(!empty($asset)){
								$queryasset = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND AssetID="'.$asset.'" AND AssetStatusID="AK000001"'; $asres = mysql_exe_query(array($queryasset,1)); $asres_now = mysql_exe_fetch_array(array($asres,1));
								//------Hanya untuk mengecek asset yang diquery tidak bernilai 0 atau status aktif--
								$rows = mysql_exe_num_rows(array($asres,1)); 
								//----------------------------------------------------------------------------------
								if($rows>0){
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days'));
								$data[$i][0]=$PMName; $data[$i][1]=$asres_now[1]; $data[$i][2]=$asres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
								$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$asres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
								//=========== Dapatkan spare part berdasarkan PM Task ========================
    							$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
    							$result_spare = mysql_exe_query(array($query_spare,1));
    							while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
    							    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
    							}
								
								//----Define for nedt date pm -------------
								$TstartDate = $TnextDate;
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
								}
								//$content.= $PMName.' -- '.$asres_now[1].' -- '.$asres_now[3].' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
								$mod_date .= 'UPDATE pm_schedule SET TargetStartDate="'.$TstartDate.'", TargetCompDate="'.$TcompDate.'", NextDate="'.$TnextDate.'" WHERE PM_ID="'.$pmid.'";';
							}else if(!empty($location)){
								$querylocation = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND L.LocationID="'.$location.'" AND AssetStatusID="AK000001"'; $locres = mysql_exe_query(array($querylocation,1)); 
								$dateStart = $TstartDate;
								while($locres_now = mysql_exe_fetch_array(array($locres,1))){
									$TstartDate = $dateStart;
									$TcompDate = date ("Y-m-d", strtotime ($dateStart .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($dateStart .'+'.$freq.' days'));
									$data[$i][0]=$PMName; $data[$i][1]=$locres_now[1]; $data[$i][2]=$locres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate;
									$data[$i][6]=get_new_code('WO',$numrow++);
									$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$locres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
									
									//=========== Dapatkan spare part berdasarkan PM Task ========================
        							$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
        							$result_spare = mysql_exe_query(array($query_spare,1));
        							while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
        							    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
        							}
									
									//----Define for nedt date pm -------------
									$TstartDate = $TnextDate;
									$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
									//$content.= $PMName.' -- '.$locres_now[1].' -- '.$locres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
									$i++;
								}
								$mod_date .= 'UPDATE pm_schedule SET TargetStartDate="'.$TstartDate.'", TargetCompDate="'.$TcompDate.'", NextDate="'.$TnextDate.'" WHERE PM_ID="'.$pmid.'";';
							}
						}
						
					}
			       
			    }
			     //***************************************************************************************************
			    $k++;
			    }
			    //print_r($data);
			    
			    if(!empty($value)){
			        $inquery =  substr('INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,PMID,PMTaskID,PMTarStartDate,PMTarCompDate,Created_By) VALUES '.$value,0,-1); 
				    $inquery = str_replace('"','+-*',$inquery); 
			    }else{
			        $inquery = '';
			    }
			    
			    if(!empty($part)){
				    $part = substr('INSERT INTO invent_item_work_order (WorkOrderNo,itemspare) VALUES '.$part,0,-1);
				    $part = str_replace('"','+-*',$part);
			    }else{
			        $part = '';
			    }
			    
			    if(!empty($mod_date)){
				    $mod_date = str_replace('"','+-*',$mod_date);
			    }else{
			        $mod_date = '';
			    }
				
				/*echo $inquery.'<br/>';
				echo $part.'<br/>';
				echo $mod_date.'<br/>';*/
						
			    //--------------------- Add form for generate WO from PO ------------------/
				if(_USER_INSERT_){
				    //$content = '<br/><div class="ade">Generate Preventive Maintenance</div>';
					$content = '
						<form style="margin:4 1 1 1;" action="'.PATH_PMGENE.WO.'" method="post" enctype="multipart/form-data">
						<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="inquery" value="'.$inquery.'" /></div>
						<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="val_que" value="'.$value.'" /></div>
						<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="part" value="'.$part.'" /></div>
						<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="moddate" value="'.$mod_date.'" /></div>
						<div align="center" style="margin:4 1 1 1;"><input class="form-submit" type="submit" value="Generate Work Order" /></div>
						</form>
					';
				}
				
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,400,150,150,150,150]";
				//-------get id pada sql -------------
				$field = array('pmname','asset','location','startdate','compdate','nextdate');
				//-------get header pada sql----------
				//$name = gen_mysql_head(POSITI.' ORDER BY PositionID DESC');
				//-------set header pada handson------
				$sethead = "['PM Name','Asset','Location','Start Date','Complete Date','Next Date']";
				//-------set id pada handson----------
				$setid = "[{data:'pmname',className: 'htLeft'},{data:'asset',className: 'htLeft'},{data:'location',className: 'htLeft'},{data:'startdate',className: 'htLeft'},{data:'compdate',className: 'htLeft'},{data:'nextdate',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array($data,$field,'','');
				$data = get_data_handson_array($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
	    }
	    
	    $content .= script_gen();
		return $content;
	}
	
	function script_gen(){
	    $content = '
	                <script>
	                    $("#pmgen").DataTable({
                            "scrollY":        "400px",
                            "scrollCollapse": true,
                            "paging":         false
                        });
	                </script>
	    ';
	    return $content;
	}
	
	function pmgen_temp(){
		$content = '<br/><div class="ade">Preventive Maintenance Generation</div>';
			$content .= '<form action="'.PATH_PMGENE.GEN.POST.'" method="post" enctype="multipart/form-data">';
			$content .= '<br/><div align="center"><span class="name"> PM Name : </span>'.combo_je(array(COMBPMGENE,'pmgene','pmgene',180,'',$_REQUEST['pmgene'])).'</div>
						<div align="center" style="margin:4 1 2 1;">'.date_je(array('start',$_REQUEST['start'])).' - '.date_je(array('end',$_REQUEST['end'])).'</div>
						<div align="center" style="margin:4 1 1 1;"><input class="form-submit" type="submit" value="Show More Planning PM Schedule"></div>';
			$content .= '</form>'; 
			
			//---------------------Update pmschedule and create a new WO-------------------------
			if(isset($_REQUEST['wo']) && !empty($_REQUEST['val_que'])){
				$query = 'UPDATE pm_schedule SET TargetStartDate="'.$_REQUEST['startdate'].'", TargetCompDate="'.$_REQUEST['compdate'].'", NextDate="'.$_REQUEST['nextdate'].'" WHERE PM_ID="'.$_REQUEST['pmid'].'"';
				mysql_exe_query(array($query,1));
				$inquery .= str_replace('+-*','"',$_REQUEST['inquery']); 
				mysql_exe_query(array($inquery,1));
				$part .= str_replace('+-*','"',$_REQUEST['part']); 
				mysql_exe_query(array($part,1));
				//echo $query.'<br/>'.$inquery;
				$content .= '<div class="alert alert-success" align="center">Already Create Work Order for PM '.$_REQUEST['pmid'].'</div>';
			}
			
			if(isset($_REQUEST['gen'])){
				if(isset($_REQUEST['post'])){ 
					$query = 'SELECT P.FreqUnits, P.Frequency, P.PeriodDays, P.TargetStartDate, P.PM_ID, P.PMGenType, P.AssetID, P.LocationID, P.PMWOTrade, P.ChecklistNo, M.CheckListName, P.WorkTypeId FROM pm_schedule P, pm_checklist M WHERE P.ChecklistNo=M.CheckListNo AND P.PM_ID="'.$_REQUEST['pmgene'].'"';
					$result = mysql_exe_query(array($query,1)); $result_now = mysql_exe_fetch_array(array($result,1));
					$fun = $result_now[0]; $freq = $result_now[1]; $Pdays = $result_now[2]; $TstartDate = $result_now[3]; $PMName = $result_now[4];
					$PMGenType = $result_now[5]; $asset = $result_now[6]; $location = $result_now[7]; $wotrade = $result_now[8]; $pmtask = $result_now[9]; $problem = $result_now[10]; $wotype = $result_now[11]; //echo $wotype;
					if(strcmp($fun,'Days')==0) $freq=$freq*1; else if(strcmp($fun,'Weeks')==0) $freq=$freq*7; else if(strcmp($fun,'Months')==0) $freq=$freq*28; else if(strcmp($fun,'Years')==0) $freq=$freq*365; 
					//$TstartDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days')); 
					
					//=====Get date from posting and define all variable ===========
					$start = convert_date(array($_REQUEST['start'],2)); $end = convert_date(array($_REQUEST['end'],2)); $data = array(); $value='';
					if($TstartDate<$start || $TstartDate>$end){
						$content .= '<div class="alert alert-danger" align="center">Target Start Date of '.$PMName.' Out Of This Date Range</div>';
						if($TstartDate<$start){
							$content .= '<div class="alert alert-danger" align="center">Target Start Date less than Input of Start Date</div>';
						}else if($TstartDate>$end){
							$content .= '<div class="alert alert-danger" align="center">Target Start Date more than Input of End Date</div>';
						}
					}else{
						//-- Get last id --//
						$result = mysql_exe_query(array(COUNTWORDER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1;
						if(strcmp($PMGenType,'Schedule')==0){
							if(!empty($asset)){
								$queryasset = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND AssetID="'.$asset.'" AND AssetStatusID="AK000001"'; $asres = mysql_exe_query(array($queryasset,1)); $asres_now = mysql_exe_fetch_array(array($asres,1));
								//------Hanya untuk mengecek asset yang diquery tidak bernilai 0 atau status aktif--
								$rows = mysql_exe_num_rows(array($asres,1)); 
								//---------------------------------------------------------------------------------
								$i=0; $part;
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days'));
								while($TstartDate<=$end && $rows>0){
									$data[$i][0]=$PMName; $data[$i][1]=$asres_now[1]; $data[$i][2]=$asres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
									$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$asres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
									//$content.= $PMName.' -- '.$asres_now[1].' -- '.$asres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
									
									//=========== Dapatkan spare part berdasarkan PM Task ========================
									$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
									$result_spare = mysql_exe_query(array($query_spare,1));
									while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
									    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
									}
									
									$TstartDate = $TnextDate;
									$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
									$i++;
								}
							}else if(!empty($location)){
								$querylocation = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND L.LocationID="'.$location.'" AND AssetStatusID="AK000001"'; $locres = mysql_exe_query(array($querylocation,1)); 
								$i=0;
								$dateStart = $TstartDate;
								while($locres_now = mysql_exe_fetch_array(array($locres,1))){
									$TstartDate = $dateStart;
									$TcompDate = date ("Y-m-d", strtotime ($dateStart .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($dateStart .'+'.$freq.' days'));
									while($TstartDate<=$end){
										$data[$i][0]=$PMName; $data[$i][1]=$locres_now[1]; $data[$i][2]=$locres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
										$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$locres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
										//$content.= $PMName.' -- '.$locres_now[1].' -- '.$locres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
										
										//=========== Dapatkan spare part berdasarkan PM Task ========================
    									$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
    									$result_spare = mysql_exe_query(array($query_spare,1));
    									while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
    									    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
    									}
									
									
										$TstartDate = $TnextDate;
										$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
										$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
										$i++;
									}	
								}	
							}
							
						}else if(strcmp($PMGenType,'Actual')==0){
							if(!empty($asset)){
								$queryasset = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND AssetID="'.$asset.'" AND AssetStatusID="AK000001"'; $asres = mysql_exe_query(array($queryasset,1)); $asres_now = mysql_exe_fetch_array(array($asres,1));
								$i=0;
								//------Hanya untuk mengecek asset yang diquery tidak bernilai 0 atau status aktif--
								$rows = mysql_exe_num_rows(array($asres,1)); 
								//----------------------------------------------------------------------------------
								if($rows>0){
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$freq.' days'));
								$data[$i][0]=$PMName; $data[$i][1]=$asres_now[1]; $data[$i][2]=$asres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate; $data[$i][6]=get_new_code('WO',$numrow++);
								$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$asres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
								//=========== Dapatkan spare part berdasarkan PM Task ========================
    							$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
    							$result_spare = mysql_exe_query(array($query_spare,1));
    							while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
    							    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
    							}
								
								//----Define for nedt date pm -------------
								$TstartDate = $TnextDate;
								$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
								$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
								}
								//$content.= $PMName.' -- '.$asres_now[1].' -- '.$asres_now[3].' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
							}else if(!empty($location)){
								$querylocation = 'SELECT A.AssetID, A.AssetDesc, L.LocationID, L.LocationDescription FROM asset A, location L WHERE A.locationID=L.LocationID AND L.LocationID="'.$location.'" AND AssetStatusID="AK000001"'; $locres = mysql_exe_query(array($querylocation,1)); 
								$i=0;
								$dateStart = $TstartDate;
								while($locres_now = mysql_exe_fetch_array(array($locres,1))){
									$TstartDate = $dateStart;
									$TcompDate = date ("Y-m-d", strtotime ($dateStart .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($dateStart .'+'.$freq.' days'));
									$data[$i][0]=$PMName; $data[$i][1]=$locres_now[1]; $data[$i][2]=$locres_now[3]; $data[$i][3]=$TstartDate; $data[$i][4]=$TcompDate; $data[$i][5]=$TnextDate;
									$data[$i][6]=get_new_code('WO',$numrow++);
									$value .= '("'.$data[$i][6].'","'.date("Y-m-d").'","'.$TcompDate.'","'.$TstartDate.'","'.$TcompDate.'","","EP000001","EP000001","EP000001","'.$locres_now[0].'","'.$wotype.'","WP000001","WS000001","'.$wotrade.'","FL000001","'.$problem.'","'.$PMName.'","'.$pmtask.'","'.$TstartDate.'","'.$TcompDate.'","'.$_SESSION['user'].'"),';
									
									//=========== Dapatkan spare part berdasarkan PM Task ========================
        							$query_spare = 'SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$pmtask.'"';
        							$result_spare = mysql_exe_query(array($query_spare,1));
        							while($resultnow_spare=mysql_exe_fetch_array(array($result_spare,1))){
        							    $part .= '("'.$data[$i][6].'","'.$resultnow_spare[0].'"),';
        							}
									
									//----Define for nedt date pm -------------
									$TstartDate = $TnextDate;
									$TcompDate = date ("Y-m-d", strtotime ($TstartDate .'+'.$Pdays.' days'));
									$TnextDate = date ("Y-m-d", strtotime ($TnextDate .'+'.$freq.' days'));
									//$content.= $PMName.' -- '.$locres_now[1].' -- '.$locres_now[3].' -- '.' -- '.$TstartDate.' -- '.$TcompDate.' -- '.$TnextDate.'<br/>';
									$i++;
								}
							}
						}
						//print_r($data);
						$inquery =  substr('INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,PMID,PMTaskID,PMTarStartDate,PMTarCompDate,Created_By) VALUES '.$value,0,-1); 
						$inquery = str_replace('"','+-*',$inquery); 
						$part = substr('INSERT INTO invent_item_work_order (WorkOrderNo,itemspare) VALUES '.$part,0,-1);
						$part = str_replace('"','+-*',$part); 
						//echo $part;
						
						//--------------------- Add form for generate WO from PO ------------------/
						if(_USER_INSERT_){
						$content .= '
							<form style="margin:4 1 1 1;" action="'.PATH_PMGENE.WO.'" method="post" enctype="multipart/form-data">
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="inquery" value="'.$inquery.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="val_que" value="'.$value.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="part" value="'.$part.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="pmid" value="'.$PMName.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="startdate" value="'.$TstartDate.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="compdate" value="'.$TcompDate.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input type="hidden" name="nextdate" value="'.$TnextDate.'" /></div>
							<div align="center" style="margin:4 1 1 1;"><input class="form-submit" type="submit" value="Generate Work Order" /></div>
							</form>
						';
						}
						$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
						//-------set lebar kolom -------------
						$width = "[200,400,150,150,150,150]";
						//-------get id pada sql -------------
						$field = array('pmname','asset','location','startdate','compdate','nextdate');
						//-------get header pada sql----------
						//$name = gen_mysql_head(POSITI.' ORDER BY PositionID DESC');
						//-------set header pada handson------
						$sethead = "['PM Name','Asset','Location','Start Date','Complete Date','Next Date']";
						//-------set id pada handson----------
						$setid = "[{data:'pmname',className: 'htLeft'},{data:'asset',className: 'htLeft'},{data:'location',className: 'htLeft'},{data:'startdate',className: 'htLeft'},{data:'compdate',className: 'htLeft'},{data:'nextdate',className: 'htLeft'}]";
						//-------get data pada sql------------
						$dt = array($data,$field,'','');
						$data = get_data_handson_array($dt);
						//----Fungsi memanggil data handsontable melalui javascript---
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						//--------fungsi hanya untuk meload data
						$content .= get_handson($sethandson);
					}
				}
			}
		return $content;
	}
?>