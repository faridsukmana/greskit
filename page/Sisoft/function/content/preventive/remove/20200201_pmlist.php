<?php
	function pmlist(){
			/*------Get Pop Up Windows---------*/
			$content = pop_up(array('pmlist',PATH_PMLIST));
			
			$content .= '<br/><div class="ade">PREVENTIVE MAINTENANCE LIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[150,200,500,400,250,150,200,200,200,200,200,200,200,80,80]";
			if ($_SESSION['userID'] !='') {
			    if(isset($_REQUEST['dashpm'])){
			        $pmquery =  WORDER.' AND WO.WorkTypeID="WT000002" AND WO.WorkStatusID NOT IN (SELECT WorkStatusID FROM work_status WHERE WorkStatusID="WS000020" OR WorkStatusID="WS000021") ORDER BY WO.WorkOrderNo DESC';
			    }else{
			        $pmquery = WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC';
			    } 
				// jika id employee tidak kosong
				//-------get id pada sql -------------
				$field = gen_mysql_id($pmquery);
				//-------get header pada sql----------
				$name = gen_mysql_head($pmquery);
				
				//-------set header pada handson------
				//==========Timuraya================
				$sethead = "['Work_Order_No','Asset_No','Asset_Name','Problem Description','Work_Type','Section','Requested_Date','Required_Date','Plan_Date_Start','Plan_Date_End','Actual_Date_Start','Actual_Date_End','Work_Status'"._USER_EDIT_SETHEAD_._USER_CHECKLIST_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Work_Status',renderer: 'html',className: 'htLeft'}"._USER_EDIT_SETID_._USER_CHECKLIST_SETID_."]";
				//-------get data pada sql------------
				$dt = array($pmquery,$field,array('Edit','Checklist'),array(PATH_PMLIST.EDIT,PATH_PMLIST.CHECKLIST),array(0),PATH_PMLIST);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=1;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}elseif($_SESSION['userID'] ==''){
			    if(isset($_REQUEST['dashpm'])){
			        $pmquery =  WORDER.' AND WO.WorkTypeID="WT000002" AND WO.WorkStatusID NOT IN (SELECT WorkStatusID FROM work_status WHERE WorkStatusID="WS000020" OR WorkStatusID="WS000021") ORDER BY WO.WorkOrderNo DESC';
			    }else{
			        $pmquery = WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC';
			    }
				//jika id employee kosong
				//-------get id pada sql -------------
				$field = gen_mysql_id($pmquery);
				//-------get header pada sql----------
				$name = gen_mysql_head($pmquery);
				
				//-------set header pada handson------
			//==========Timuraya================
				$sethead = "['Work_Order_No','Asset_No','Asset_Name','Problem Description','Work_Type','Section','Requested_Date','Required_Date','Plan_Date_Start','Plan_Date_End','Actual_Date_Start','Actual_Date_End','Work_Status'"._USER_EDIT_SETHEAD_._USER_CHECKLIST_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Work_Status',renderer: 'html',className: 'htLeft'}"._USER_EDIT_SETID_._USER_CHECKLIST_SETID_."]";
				//-------get data pada sql------------
				$dt = array($pmquery,$field,array('Edit','Checklist'),array(PATH_PMLIST.EDIT,PATH_PMLIST.CHECKLIST),array(0),PATH_PMLIST);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=1;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}
			
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
			    /*	$query = 'SELECT id_group,group_name FROM tb_user_group where id_group="'.$_SESSION['groupID'].'"';
    
                $result = mysql_exe_query(array($query,1));
                $result_data=mysql_exe_fetch_array(array($result,1));
                
                $group_name= $result_data[1];
				if ($group_name == 'Administrator') {
				$tes = '<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTATALL,'wostat','wostat',180,'','')).'</td>';
				}else{
				   $tes = '<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'','')).'</td>'; 
				}*/
				$recdat = date('m/d/Y H:i'); //echo convert_date_time(array($recdat,1));
				$content = '<br/><div class="ade">ADD DATA FOR PREVENTIVE MAINTENANCE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMLIST.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Order</div>
								<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.datetime_je(array('recdate',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Require Date </td><td>:</td><td>'.datetime_je(array('reqdate',$recdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Estimated Date Start</td><td>:</td><td>'.datetime_je(array('eststart',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Estimated Date End </td><td>:</td><td>'.datetime_je(array('estend',$recdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Actual Date Start</td><td>:</td><td>'.datetime_je(array('actstart','',200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Actual Date End </td><td>:</td><td>'.datetime_je(array('actend','',200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Hand Over Date </td><td>:</td><td>'.datetime_je(array('hanover','',200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Accepted By </td><td>:</td><td>'.text_je(array('accept','','false')).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Assign to </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'assign','assign',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Requestor </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'request','request',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'>','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Problem Desc </td><td>:</td><td>'.text_je(array('prodesc','','true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Cause Desc </td><td>:</td><td>'.text_je(array('cause','','true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Action Taken </td><td>:</td><td>'.text_je(array('action','','true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Prevention Taken </td><td>:</td><td>'.text_je(array('prevent','','true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['recdate']) && !empty($_REQUEST['reqdate']) && !empty($_REQUEST['eststart']) && !empty($_REQUEST['estend'])){
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTWORDER,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $woid=get_new_code('WO',$numrow); 
						//-- Insert data pada kategori aset --//
						$recdate = convert_date_time(array($_REQUEST['recdate'],1)); $reqdate = convert_date_time(array($_REQUEST['reqdate'],1));
						$eststart = convert_date_time(array($_REQUEST['eststart'],1)); $estend = convert_date_time(array($_REQUEST['estend'],1));
						$actstart = convert_date_time(array($_REQUEST['actstart'],1)); $actend = convert_date_time(array($_REQUEST['actend'],1));
						$hanover = convert_date_time(array($_REQUEST['hanover'],1));
						
						//--------Post Image File------------------
						if(!empty($_FILES['image']['name'])){
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/workorder/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$info .= '<div class="alert alert-danger" align="center">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>2000000){ 
								$info .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 2MB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$info .= '<div class="alert alert-danger" align="center">Sorry, You havent upload image. Failed to upload</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$info ='<div class="alert alert-danger" align="center"> You havent upload image. Failed to upload</div>.';
								}else{
									$info .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						}
						
						if(empty(basename($_FILES['image']['name']))){
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,Created_By) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$_REQUEST['assign'].'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$_SESSION['user'].'")'; 
						}else{
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,ImagePath,Created_By) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$_REQUEST['assign'].'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$target_file.'","'.$_SESSION['user'].'")';
						} //echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = WORDER.' AND WorkOrderNo="'.$woid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMLIST.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson).$info;
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}if(isset($_REQUEST['edit'])){ $info='';
				//------------Jika ada halaman edit data-------//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['recdate']) && !empty($_REQUEST['reqdate']) && !empty($_REQUEST['eststart']) && !empty($_REQUEST['estend'])){
						//-- Update data pada kategori aset --//
						$recdate = convert_date_time(array($_REQUEST['recdate'],1)); $reqdate = convert_date_time(array($_REQUEST['reqdate'],1));
						$eststart = convert_date_time(array($_REQUEST['eststart'],1)); $estend = convert_date_time(array($_REQUEST['estend'],1));
						$actstart = convert_date_time(array($_REQUEST['actstart'],1)); $actend = convert_date_time(array($_REQUEST['actend'],1));
						$hanover = convert_date_time(array($_REQUEST['hanover'],1));
						
						//--------Post Image File------------------
						if(!empty($_FILES['image']['name'])){
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/workorder/';
							$target_file = $target_dir.basename($_FILES['image']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
							$expensions= array("jpeg","jpg");
							if(in_array($filetype,$expensions)===false){
								$addinfo .= '<div class="alert alert-danger" align="center">Sorry, only JPG or JPEG files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['image']['size']>2000000){ 
								$addinfo .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 2MB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$addinfo .= '<div class="alert alert-danger" align="center">Sorry, You havent upload image. Failed to upload</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$addinfo ='<div class="alert alert-danger" align="center"> You havent upload image. Failed to upload</div>.';
								}else{
									$addinfo .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
						}
						}
						
						//---Jika assign id yang update bukan manager maka---/
						if(empty($_REQUEST['assign']))
							$assign = '';
						else
							$assign = ',  AssignID="'.$_REQUEST['assign'].'"';
						
						if(empty(basename($_FILES['image']['name']))){
							$qstate = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['rowid'].'"';
							$restate=mysql_exe_query(array($qstate,1)); $rnstate=mysql_exe_fetch_array(array($restate,1)); $wostate = $rnstate['15'];
							if($wostate==$_REQUEST['wostat']){
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", DepartmentID="'.$_REQUEST['department'].'", identifyK3="'.$_REQUEST['ktiga'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}else{
								$date_mod=date('Y-m-d'); 
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", State_modified_date="'.$date_mod.'", DepartmentID="'.$_REQUEST['department'].'", identifyK3="'.$_REQUEST['ktiga'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}
						}else{
							$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", ImagePath="'.$target_file.'", DepartmentID="'.$_REQUEST['department'].'", identifyK3="'.$_REQUEST['ktiga'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
						}
						mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = WORDER.' AND WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMLIST.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson).$addinfo;
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDWORDER.' WHERE WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$wonum=$resultnow[0]; $recdat = convert_date_time(array($resultnow[1],2)); $reqdat = convert_date_time(array($resultnow[2],2));
				$eststart = convert_date_time(array($resultnow[3],2)); $estend = convert_date_time(array($resultnow[4],2)); $actstart = convert_date_time(array($resultnow[5],2)); $actend = convert_date_time(array($resultnow[6],2)); $hanover = convert_date_time(array($resultnow[7],2));
				$pmstart = convert_date_time(array($resultnow[22],2)); $pmcompleted = convert_date_time(array($resultnow[23],2)); $pmtask = $resultnow[24]; $pmname = $resultnow[25]; $department = $resultnow[26];	$k3=$resultnow[27]; 	
				//-----Cek if work type is preventive ----//
				$querycheck = 'SELECT WorkTypeDesc FROM work_type WHERE worktypeid="'.$resultnow[13].'"'; $resqcheck = mysql_exe_query(array($querycheck,1));
				$resnowqcheck = mysql_exe_fetch_array(array($resqcheck,1)); 
				if(strcmp($resnowqcheck[0],'Preventive')==0){
					$addfield ='<div class="w-100"></div>
								<div class="col">
									<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
									  <span class="name">Target Str : </span>'.datetime_je(array('pmstart',$pmstart,200)).'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
									  <span class="name">Target Fin: </span>'.datetime_je(array('pmcompleted',$pmcompleted,200)).'
									</div>
								</div>
								<div class="w-100"></div>
								<div class="col">
									<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
									  <span class="name">Preventive Maintenance Name : </span>'.combo_je(array(COMPMTASKL,'pmname','pname','80%','',$pmname)).'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
									  <span class="name">Preventive Maintenance Task : </span>'.combo_je(array(COMBPMGENG,'pmtask','pmtask','80%','',$pmtask)).'
									</div>
								</div>
					'; 
				}else{
					$addfield ='';
				}
					//*********************Menggunakan fungsi create form******************//
				
				
					//*********************Menggunakan fungsi create form******************//
				//2.&&&&---Form ke 2. Buat Form Step Of Work--&&&&
                //-----Eksekusi jika insert dilakukan--------
               if(isset($_REQUEST['stepwork'])){
					//-- Insert data pada kategori aset --//
					$field = array(
							'WorkOrderNo', 
							'ID_Document');
					$value = array(
							'"'.$_REQUEST['rowid'].'"',
							'"'.$_REQUEST['doc_data'].'"'); 
					$query = mysql_stat_insert(array('work_document_relation',$field,$value)); 
					mysql_exe_query(array($query,1)); 
				}
				
				if(isset($_REQUEST['delstepwork']) && isset($_REQUEST['delete'])){
					$con = 'WorkOrderNo="'.$_REQUEST['wo'].'" AND ID_Document="'.$_REQUEST['rowid'].'"'; 
					$sparepart = query_delete(array(PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['wo'], 'work_document_relation', $con));	
				}
				
				$query_doc = 'SELECT ID_Document, Document_Name FROM work_document WHERE ID_Document NOT IN (SELECT ID_Document FROM work_document_relation WHERE WorkOrderNo="'.$_REQUEST['rowid'].'") ORDER BY Document_Name ASC';
				$name_field=array('Step of Work');
				$input_type=array(
							combo_je(array($query_doc,'doc_data','doc_data',180,'',''))
						);
						
			
				$signtofill = array('');
				$stepwork = '<div title="Step of Work" style="padding:10px">
								<div class="row"><div class="col">
									<button id="cl_step" class="btn btn-fw btn-outline-primary btn-sm float-right" href="#" role="button"><i class="fa fa-plus fa-fw"></i>Create New</button>
									<a id="cl_back" class="btn btn-fw btn-outline-primary btn-sm float-right" href="'.PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].'" role="button"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
								</div></div>
								<div id="step">'.
									create_form(array(TSTEPWORK,PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].STEPWORK,1,$name_field,$input_type,$signtofill)).
								'</div>
								<div id="doc">
									<br/><div class="form-style-1">
									<fieldset><div class="card-header text-center">Document Step of Work</div>
										<table>
											<tr><td width="150"><span class="name"> Document Name </td><td>:</td></span></td><td>'.text_je(array('docname','','false','','docname')).'</td></tr>
											<tr><td width="150"><span class="name"> Upload Document </td><td>:</td></span></td><td><input type="file" id="doc_upload" name="doc_file" /></td></tr>
											<tr><td></td><td></td><td><input id="sb_doc" class="form-submit" type="submit" value="Submit"></td></tr>
										</table>
									</fieldset>
									</div>
									<div>
									<table id="doc_work" class="table table-bordered" style="width:100%">
									</table>
									</div>
									<div id="sb_success" class="alert alert-success" role="alert">Success Upload</div>
									<div id="sb_failed" class="alert alert-danger" role="alert">Failed Input</div>
								</div>
							'.step_work();
				
				$querystep = 'SELECT W.ID_Document, W.Document_Name, W.Link FROM work_document W , work_document_relation R WHERE W.ID_Document=R.ID_Document AND R.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				//-------set lebar kolom -------------
				$width = "[100,300,100,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id($querystep);
				//-------get header pada sql----------
				$name = gen_mysql_head($querystep);
				//-------set header pada handson------
				$sethead = "['Document ID','Document Name','Link'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'ID_Document',className: 'htLeft'},{data:'Document_Name',className: 'htLeft'},{data:'Link',renderer:'html'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($querystep,$field,array('Delete'),array(PATH_PMLIST.EDIT.'&wo='.$_REQUEST['rowid'].'&delstepwork=ok&delete=ok'),array());
				$data = get_data_handson_func($dt);
				//-------Encode ke HTML versi handsontable-----------------// 
				$data=str_replace("',Delete:","\">Download</a></span>',Delete:",$data);
				$data=str_replace("Link:'","Link:'<span class=\"editlink\"><a href=\"page/Sisoft/",$data);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'step_work');
				//--------fungsi hanya untuk meload data
				$stepwork.= '
							<div id="step_work" style="width: 780px; height: 280px; overflow: hidden; font-size=10px;"></div>'.get_handson_id($sethandson).'</div>';
				
				//3.&&&&&&&&--Form ke 3. Buat Form Spare Part--&&&&
				//---- Data Spare Part Request ------//
				$i=1; $body = ''; $q_data = QSPAREPART2.' AND WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				
				$result = mysql_exe_query(array($q_data,1));
				while($result_data_now = mysql_exe_fetch_array(array($result,1))){
					$body .= '
						<tr>
						<td>'.$i.'</td>
						<td>'.$result_data_now[0].'</td>
						<td>'.$result_data_now[1].'</td>
						<td>'.$result_data_now[3].'</td>
						<td>'.$result_data_now[2].'</td>
						<td><button class="btn btn-danger btn-rounded btn-fw" onclick="del_partreq(\''.$_REQUEST['rowid'].'\',\''.$result_data_now[0].'\')">Delete</td>
					</tr>
					'; $i++;
				}
				
				$table = '
				<table id="part_request" class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th> No </th>
							<th> Item Code </th>
							<th> Item Name </th>
							<th> Request Stock </th>
							<th> Available Stock </th>
							<th> Delete </th>
						</tr>
					</thead>
					<tbody>
						'.$body.'
					</tbody>	
				</table>
				';
	
				//---- Query Equipment Classification ------//
				$option=''; $q_cat = 'SELECT item_category_code, CONCAT(item_no_code," - ",item_category_description) FROM invent_item_categories ORDER BY item_no_code ASC';
				$result = mysql_exe_query(array($q_cat,1));
				while($result_now = mysql_exe_fetch_array(array($result,1))){
					$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
				}
				$eq_class = '<select class="form-control" id="eq_class_part">'.$option.'</select>';
				
				//---- Query Part Classification ------//
				$sp_class = '<select class="form-control" id="sp_class_part" name="spare"></select>';
				
				DEFINE('COMBSPAREWO','SELECT item_id, item_description FROM invent_item WHERE item_id NOT IN (SELECT itemspare FROM invent_item_work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'")');  
				
				$form_spare = '
							<div class="row">
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  Spare Part Class : '.$eq_class.'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-secondary" role="alert">
									  Spare part : '.$sp_class.'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  Request Quantity : <input type="text" class="form-control" id="requestqty" name="request" placeholder="Request Quantity"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col"></div>
								<div class="col">
									<input type="hidden" id="wo_partreq" value="'.$_REQUEST['rowid'].'" />
									<button type="button" id="add_partreq" class="btn btn-primary btn-block">Add Data</button>
									<div id="load_partreq" class="alert alert-warning" role="alert" style="margin-top:5px;">Loading ... </div>
								</div>
								<div class="col"></div>
							</div>
							<div style="margin-top:10px;">'.$table.'</div>';
				$sparepart .= '<div title="Spare Part" style="padding:10px">'.$form_spare.spare_part().'</div>';
				
				//4.&&&&&&&&--Form ke 4. Buat Form Man Power--&&&&
				if(isset($_REQUEST['power']) && isset($_REQUEST['costman']) && is_numeric($_REQUEST['costman'])){
					$actstart = convert_date_time(array($_REQUEST['start_d'],1)); 
                    $actend = convert_date_time(array($_REQUEST['finish_d'],1));
                    //-- Insert data pada kategori aset --//
                    $field = array(
                            'WorkOrderNo', 
                            'EmployeeID',
                            'cost_hour',
                            'start_date',
                            'finish_date');
                    $value = array(
                            '"'.$_REQUEST['rowid'].'"',
                            '"'.$_REQUEST['mpow'].'"',
                            '"'.$_REQUEST['costman'].'"',
                            '"'.$actstart.'"',
                            '"'.$actend.'"',); 
                    $query = mysql_stat_insert(array('work_order_manpower',$field,$value)); 
                    mysql_exe_query(array($query,1)); 
                }
                if(isset($_REQUEST['delmanpow']) && isset($_REQUEST['delete'])){
                    $con = 'WorkOrderNo="'.$_REQUEST['wo'].'" AND EmployeeID="'.$_REQUEST['rowid'].'"'; 
                    $manpower = query_delete(array(PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['wo'], 'work_order_manpower', $con));   
                }
                DEFINE('COMBMANPOW','SELECT EmployeeID, FirstName FROM employee WHERE EmployeeID NOT IN (SELECT EmployeeID FROM work_order_manpower WHERE WorkOrderNo="'.$_REQUEST['rowid'].'")');  
                
                       
                $name_field=array('Employee Name *', 'Cost/Hour *','Start Date','Finish Date');
                $input_type=array(
                            combo_je(array(COMBMANPOW,'mpow','mpow',180,'','')),
                            text_je(array('costman','','false')),
                            datetime_je(array('start_d','',200)),
                            datetime_je(array('finish_d','',200))
                        );
				$signtofill = array('');
				$manpower .= '<div title="Man Power" style="padding:10px">'.create_form(array(TMANPOWER,PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].MANPOW,1,$name_field,$input_type,$signtofill));
				
				$queryspare = QMANPOWER.' AND WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
                //-------set lebar kolom -------------
                $width = "[150,150,220,100,100,100,100]";
                //-------get id pada sql -------------
                $field = gen_mysql_id($queryspare);
                //-------get header pada sql----------
                $name = gen_mysql_head($queryspare);
                //-------set header pada handson------
                $sethead = "['ID','No ID','Name','Cost/Hour','Start Date','Finish Date'"._USER_DELETE_SETHEAD_."]";
                //-------set id pada handson----------
                $setid = "[{data:'ID',className: 'htLeft'},{data:'No_ID',className: 'htLeft'},{data:'Name',className: 'htLeft'},{data:'Cost',className: 'htLeft'},{data:'start',className: 'htLeft'},{data:'finish',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($queryspare,$field,array('Delete'),array(PATH_PMLIST.EDIT.'&wo='.$_REQUEST['rowid'].DELMANPOW),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'manpower');
				//--------fungsi hanya untuk meload data
				$manpower.= '
							<div id="manpower" style="width: 780px; height: 280px; overflow: hidden; font-size=10px;"></div>'.get_handson_id($sethandson).'</div>';
				//5.&&&&&&&&--Form ke 5. Buat Form Total Expense--&&&&
				if(isset($_REQUEST['expense'])){
					$field = array(
							'TotalExpense');
					$value = array(
							'"'.$_REQUEST['totalexp'].'"'); 
					$query = mysql_stat_update(array('work_order',$field,$value,'WorkOrderNo="'.$_REQUEST['rowid'].'"')); 
					mysql_exe_query(array($query,1)); 
				}
				$queryexp = 'SELECT TotalExpense FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				$resexp = mysql_exe_query(array($queryexp,1)); $resnowexp = mysql_exe_fetch_array(array($resexp,1)); 
				$name_field=array('Total Expense');
				$input_type=array(
							text_je(array('totalexp',$resnowexp[0],'false'))
						);
				$signtofill = array('<span style="color:red; font-size:12;"> Number</span>');
				$totalexp = '<div title="Total Expense" style="padding:10px">'.create_form(array(TMANPOWER,PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].TEXP,1,$name_field,$input_type,$signtofill)).'</div>';
				
				//6.&&&&&&&&--Form ke 6. Failure Analysis--&&&&
				$queryexp = 'SELECT AssetID FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				$resexp = mysql_exe_query(array($queryexp,1)); $resnowexp = mysql_exe_fetch_array(array($resexp,1)); 
				$qserv= ASSETS.' AND A.AssetID="'.$resnowexp[0].'"';
				$rqserv = mysql_exe_query(array($qserv,1)); $resqserv = mysql_exe_fetch_array(array($rqserv,1));
				
				//---- Query Equipment Classification ------//
				$option=''; $q_cat = 'SELECT item_category_code, CONCAT(item_no_code," - ",item_category_description) FROM invent_item_categories ORDER BY item_no_code ASC';
				$result = mysql_exe_query(array($q_cat,1));
				while($result_now = mysql_exe_fetch_array(array($result,1))){
					$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
				}
				$eq_class = '<select class="form-control" id="eq_class">'.$option.'</select>';
				
				//---- Query Part Classification ------//
				$sp_class = '<select class="form-control" id="sp_class"></select>';
				
				//---- Query Failure Code ------//
				$query_code = 'SELECT FailureCauseID FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
				$result = mysql_exe_query(array($query_code,1));
				$result_now = mysql_exe_fetch_array(array($result,1)); 
				$code = $result_now[0]; 
				
				$option=''; $q_flcode = 'SELECT FailureCauseID, CONCAT(FailureCauseCode," - ",FailureCauseDesc) FROM failure_cause';
				$result = mysql_exe_query(array($q_flcode,1));
				while($result_now = mysql_exe_fetch_array(array($result,1))){
					if($result_now[0]==$code)
						$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
					else
						$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
				}
				$eq_flcode = '<select class="form-control" id="eq_flcode">'.$option.'</select>';
				
				//---- Data Equipment Classification ------//
				$i=1; $body = ''; $q_data = 'SELECT C.item_no_code, C.item_category_description, I.item_id, item_description FROM invent_item I, work_order W, invent_item_categories C, work_failure_analysis S WHERE S.item_id=I.item_id AND  I.item_category_code=C.item_category_code AND S.WorkOrderNo=W.WorkOrderNo AND W.WorkOrderNo="'.$_REQUEST['rowid'].'"';
				$result = mysql_exe_query(array($q_data,1));
				while($result_data_now = mysql_exe_fetch_array(array($result,1))){
					$body .= '
						<tr>
						<td>'.$i.'</td>
						<td>'.$result_data_now[0].'</td>
						<td>'.$result_data_now[1].'</td>
						<td>'.$result_data_now[2].'</td>
						<td>'.$result_data_now[3].'</td>
						<td><button class="btn btn-danger btn-rounded btn-fw" onclick="del_eqclass(\''.$result_data_now[2].'\')">Delete</td>
					</tr>
					'; $i++;
				}
				
				$table = '
				<table id="fail_analisys" class="table table-bordered" style="width:100%">
					<thead>
						<tr>
							<th> No </th>
							<th> Item Class Code </th>
							<th> Item Class Description </th>
							<th> Item Code </th>
							<th> Item Descriptions </th>
							<th> Delete </th>
						</tr>
					</thead>
					<tbody>
						'.$body.'
					</tbody>	
				</table>
				';
				
				$data_svc = '
							<input type="hidden" id="temp_wo" value="'.$_REQUEST['rowid'].'" />
							<div class="row">
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  Failure Code : '.$eq_flcode.'
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  SITE : '.$resqserv[21].'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-secondary" role="alert">
									  PLANT : '.$resqserv[22].'
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="alert alert-secondary" role="alert">
									  PROCESS : '.$resqserv[3].'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  UNIT : '.$resqserv[5].'
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="alert alert-primary" role="alert">
									  Item Class : '.$eq_class.'
									</div>
								</div>
								<div class="col">
									<div class="alert alert-secondary" role="alert">
									  Item : '.$sp_class.'
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col"></div>
								<div class="col">
									<button type="button" id="add_class" class="btn btn-primary btn-block">Add Data</button>
								</div>
								<div class="col"></div>
							</div>
							<div style="margin-top:10px;">'.$table.'</div>';
				
				$servicereq = '<div title="Failure Analysis" style="padding:10px">'.$data_svc.'</div>'.failure_analysis();
				
				
				
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA PREVENTIVE MAINTENANCE FOR '.$wonum.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Jika status sebagai manager ---------------//
				if(_VIEW_ && _DELETE_ && _EDIT_ && _INSERT_){
					$addassignto = '
					<td width="120"><span class="name"> Assign to </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'assign','assign',180,'',$resultnow[9])).'</td>
						<td width="20"><td>
						<td width="120"></td>
					</tr>
					';
					
				}else{
					$addassignto = '';
				}//----- Buat Form Isian Edit Data Berikut-----
				//---- Query Plant ------//
				$get_plantid = 'SELECT PlantID FROM asset WHERE AssetID="'.$resultnow[12].'"';
				$r_plantid = mysql_exe_query(array($get_plantid,1));
				$rn_plantid = mysql_exe_fetch_array(array($r_plantid,1));
				$plantid = $rn_plantid[0];
				
				$option=''; $plant = 'SELECT PlantId, PlantCode FROM plant ORDER BY PlantCode';
				$result = mysql_exe_query(array($plant,1));
				while($result_now = mysql_exe_fetch_array(array($result,1))){
					if($result_now[0]==$plantid){
						$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
					}else{
						$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
					}
				}
				$plant_slc = '<select class="form-control" id="plant">'.$option.'</select>';
				
				//---- Query Asset ------//
				$option=''; $comasset = COMASSETSNO; $desc = '';
				$result = mysql_exe_query(array($comasset,1));
				while($result_now = mysql_exe_fetch_array(array($result,1))){
					if($result_now[0]==$resultnow[12]){
						$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
						$desc = $result_now[1];
					}else{
						$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
					}
					
				}
				$comasset_slc = '<select class="form-control" id="asset" name="asset">'.$option.'</select>';
				
				//---- Query Asset Desc------//
				$option=''; $comasset = COMASSETSDESC;
				$result = mysql_exe_query(array($comasset,1));
				while($result_now = mysql_exe_fetch_array(array($result,1))){
					if($result_now[0]==$resultnow[12]){
						$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
						$desc = $result_now[1];
					}else{
						$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
					}
				}
				$comasset_desc = '<select class="form-control" id="assdesc" name="asset_desc">'.$option.'</select>';
				
				//--- Get Current Status -----//
				$q_stat = 'SELECT WorkStatusID, WorkStatus FROM work_status WHERE WorkStatusID="'.$resultnow[15].'"';
				$r_stat = mysql_exe_query(array($q_stat,1));
				$rn_stat = mysql_exe_fetch_array(array($r_stat,1));
				$statusid_res = $rn_stat[0]; 
				$status_res = $rn_stat[1];
				//--- Jika grup adalah administrator dan status adalah close maka atau grup level 1 dan level 0 dan status adalah---
				if(($_SESSION['groupID']!="GROUP181120033150" AND $statusid_res=="WS000020") OR (($_SESSION['groupID']=="GROUP201103104941" OR $_SESSION['groupID']=="GROUP181120025602") AND ($statusid_res=="WS000010" OR $statusid_res=="WS000012" OR $statusid_res=="WS000013" OR $statusid_res=="WS000014" OR $statusid_res=="WS000019"))){
					$submit = '';
				}else{
					$submit = '<input class="form-submit" type="submit" value="Submit">';
				}
				
				$content .= '<div class="easyui-tabs" style="width:800px;height:500px;margin:auto">
							<div title="PM" style="padding:10px">
							<br/><div class="form-style-2"><form action="'.PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">PM LIST</div>
								<div class="row">
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Requested : </span>'.datetime_je(array('recdate',$recdat,180)).'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Required. : </span>'.datetime_je(array('reqdate',$recdat,180)).'
										</div>
									</div>
									'.$addfield.'
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Plant : </span>'.$plant_slc.'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Asset : </span>'.$comasset_slc .'
										</div>
									</div>
									<!--<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Asset Desc: </span>'.$comasset_desc .'
										</div>
									</div>-->
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name" id="asset_desc">Asset Description : '.$desc.'</span>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Problem Description : </span>'.text_je(array('prodesc',$resultnow[18],'true','style="width:100%;height:40px"')).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Requested By : </span>'.combo_je(array(COMEMPLOY,'request','request','80%','',$resultnow[11])).'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Work Priority : </span>'.combo_je(array(COMWOPRIOR,'woprior','woprior','80%','',$resultnow[14])).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Work Type : </span>'.combo_je(array(COMWOTYPE,'wotype','wotype','80%','',$resultnow[13])).'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-primary" role="alert" style="margin-bottom:0px;">
										  <span class="name">Department : </span>'.combo_je(array(LOCATNDEPART,'department','department','80%','',$resultnow[26])).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-danger" role="alert" style="margin-bottom:0px;">
										  <span class="name">MU Section : </span>'.combo_je(array(COMWOTRADE,'wotrade','wotrade','80%','',$resultnow[16])).'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-success" role="alert" style="margin-bottom:0px;">
											<div class="row">
												<div class="col">
													<span class="name">Current Status : </span>'.text_je(array('cur',$status_res,'false','style="width:80%;height:22px" disabled')).'
												</div>
												<div class="col">
													<span class="name">Update Status : </span>'.combo_je(array(COMWOSTAT,'wostat','wostat','80%','',$resultnow[15])).'
												</div>
											</div>
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-danger" role="alert" style="margin-bottom:0px;">
										  <span class="name">Plan Start : </span>'.datetime_je(array('eststart',$eststart,200)).'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-danger" role="alert" style="margin-bottom:0px;">
										  <span class="name">Plan Finish : </span>'.datetime_je(array('estend',$estend,200)).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-warning" role="alert" style="margin-bottom:0px;">
										  <span class="name">Act. Start : </span>'.datetime_je(array('actstart',$actstart,200)).'
										</div>
									</div>
									<div class="col">
										<div class="alert alert-warning" role="alert" style="margin-bottom:0px;">
										  <span class="name">Act. Finish : </span>'.datetime_je(array('actend',$actend,200)).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-warning" role="alert" style="margin-bottom:0px;">
										  <span class="name">K3 Identification : </span>'.text_je(array('ktiga',$k3,'true','style="width:100%;height:40px"')).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-warning" role="alert" style="margin-bottom:0px;">
										  <span class="name">Cause Description : </span>'.text_je(array('cause',$resultnow[19],'true','style="width:100%;height:40px"')).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-warning" role="alert" style="margin-bottom:0px;">
										  <span class="name">Action Taken : </span>'.text_je(array('action',$resultnow[20],'true','style="width:100%;height:40px"')).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-warning" role="alert" style="margin-bottom:0px;">
										  <span class="name">Prevention Taken : </span>'.text_je(array('prevent',$resultnow[21],'true','style="width:100%;height:40px"')).'
										</div>
									</div>
									<div class="w-100"></div>
									<div class="col">
										<div class="alert alert-danger" role="alert" >
										  <span class="name">Image : </span>'.text_filebox(array('image','','false')).'
										</div>
									</div>
									<div class="col">
										<div class="badge badge-primary">User/Prod</div></h1>
										<div class="badge badge-danger">Planner/Adm</div></h1>
										<div class="badge badge-warning">MU SPV/GL</div></h1>
									</div>
								</div>
								<!--<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.datetime_je(array('recdate',$recdat,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Require Date </td><td>:</td><td>'.datetime_je(array('reqdate',$reqdat,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Estimated Date Start</td><td>:</td><td>'.datetime_je(array('eststart',$eststart,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Estimated Date End </td><td>:</td><td>'.datetime_je(array('estend',$estend,200)).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Actual Date Start</td><td>:</td><td>'.datetime_je(array('actstart',$actstart,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Actual Date End </td><td>:</td><td>'.datetime_je(array('actend',$actend,200)).'</td>
										<td width="20"><td>
									</tr>
									'.$addfield.'
									<tr>
										<td width="120"><span class="name"> Hand Over Date </td><td>:</td><td>'.datetime_je(array('hanover',$hanover,200)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Accepted By </td><td>:</td><td>'.text_je(array('accept',$resultnow[8],'false')).'</td>
										<td width="20"><td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Department </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'department','department',180,'',$resultnow[26])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'',$resultnow[10])).'</td>
									</tr>
									'.$addassignto.'
									<tr>
										<td width="120"><span class="name"> Requestor </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'request','request',180,'',$resultnow[11])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'',$resultnow[12])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'',$resultnow[13])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'',$resultnow[14])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'',$resultnow[15])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Order Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'',$resultnow[16])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,'',$resultnow[17])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Problem Desc </td><td>:</td><td>'.text_je(array('prodesc',$resultnow[18],'true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Cause Desc </td><td>:</td><td>'.text_je(array('cause',$resultnow[19],'true','style="width:200px;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Action Taken </td><td>:</td><td>'.text_je(array('action',$resultnow[20],'true','style="width:200px;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Prevention Taken </td><td>:</td><td>'.text_je(array('prevent',$resultnow[21],'true','style="width:200px;height:80px"')).'</td>
									</tr>
								</table>-->
								<table>
									<tr><td></td><td></td><td>'.$submit.'</td></tr>
								</table>
							</fieldset>
							</form></div></div>
				'.$stepwork.$sparepart.$manpower/*.$totalexp*/.$servicereq.'
							</div>'.add_wo();
				$content.=$info;
			}
			
			if(ISSET($_REQUEST['checklist'])){
				//***** POSTING PROCESSS WHEN EDITING FORM *****//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['idhis'])){
						//-- Insert checklist in form --------//
						$q_check = 'SELECT id_master_checklist FROM checklist_history WHERE id_checklist_history="'.$_REQUEST['idhis'].'"';
						$r_check = mysql_exe_query(array($q_check,1));
						while($rn_check=mysql_exe_fetch_array(array($r_check,1))){ 
							if(!empty($_REQUEST['text_'.$rn_check[0]])){
								$q_update = 'UPDATE checklist_history SET description="'.$_REQUEST['text_'.$rn_check[0]].'" WHERE id_checklist_history="'.$_REQUEST['idhis'].'" AND id_master_checklist="'.$rn_check[0].'"'; //echo $q_update.'<br/>';
								mysql_exe_query(array($q_update,1));
							}
						}
						$info .= '<div class="alert alert-success" align="center" role="alert">Update Successed</div>';
					}else{
						$info .= '<div class="alert alert-danger" align="center" role="alert">Update Failed, some field is empty</div>';
					}
				}
				
				$query = 'SELECT A.PMTaskID, B.ChecklistName, B.Task, B.id_form_checklist, C.form_name, A.id_checklist_history FROM work_order A, pm_checklist B , checklist_form_name C WHERE A.PMTaskID=B.CheckListNo AND B.id_form_checklist=C.id_form_checklist AND A.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				$result = mysql_exe_query(array($query,1));
				$result_now = mysql_exe_fetch_array(array($result,1));
				$taskname = $result_now[1];
				$tasklist = $result_now[2];
				$idform = $result_now[3];
				$form_name = $result_now[4];
				$id_history = $result_now[5];
				
				//**** Insert data to history *****//
				$date_now = date('Y-m-d'); 
						
				if(empty($id_history)){
					//-- Read Text to new code ---//
					$myFile = _ROOT_."function/inc/hcheck.txt";
					$fh = fopen($myFile, 'r');
					$code = fread($fh, 21);
					fclose($fh);
					$ncode = $code+1;
					$fh = fopen($myFile, 'w+') or die("Can't open file.");
					fwrite($fh, $ncode);
					//-- Generate a new id untuk checklist --//
					$wpid=get_new_code('HC',$ncode); 
					$query = 'UPDATE work_order SET id_checklist_history="'.$wpid.'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
					mysql_exe_query(array($query,1));
					
					//-- Get Asset -----
					$q_asset = 'SELECT AssetID FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
					$r_asset = mysql_exe_query(array($q_asset,1));
					$r_now_asset=mysql_exe_fetch_array(array($r_asset,1));
					$asset_id = $r_now_asset[0];
					
					//-- Insert data pada checklist --//
					//--- Berdasarkan master form tanpa asset--
					//$query_c = 'SELECT id_form_checklist, id_master_checklist FROM checklist_form_master WHERE id_form_checklist="'.$idform.'"';
					//--- Berdasarkan master form dan asset--
					$query_c = 'SELECT A.id_form_checklist, A.id_master_checklist FROM checklist_form_master A, checklist_master B WHERE A.id_master_checklist=B.id_master_checklist AND id_form_checklist="'.$idform.'" AND B.AssetID="'.$asset_id.'"';
					
					$result_c = mysql_exe_query(array($query_c,1));
					while($result_now_c=mysql_exe_fetch_array(array($result_c,1))){
						$query = 'INSERT INTO checklist_history (id_checklist_history ,date, id_form_checklist, id_master_checklist) VALUES("'.$wpid.'","'.$date_now.'","'.$result_now_c[0].'","'.$result_now_c[1].'")'; 
						mysql_exe_query(array($query,1));
					}
				}else{
					$wpid=$id_history; 
					$query = 'SELECT date FROM checklist_history WHERE id_checklist_history="'.$wpid.'"';
					$result = mysql_exe_query(array($query,1));
					$result_now = mysql_exe_fetch_array(array($result,1));
					$date_now = $result_now[0];
					
					//-- Get Asset -----
					$q_asset = 'SELECT AssetID FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
					$r_asset = mysql_exe_query(array($q_asset,1));
					$r_now_asset=mysql_exe_fetch_array(array($r_asset,1));
					$asset_id = $r_now_asset[0]; 
					
					//--- Berdasarkan master form dan asset--
					$query_c = 'SELECT A.id_form_checklist, A.id_master_checklist FROM checklist_form_master A, checklist_master B WHERE A.id_master_checklist=B.id_master_checklist AND id_form_checklist="'.$idform.'" AND B.AssetID="'.$asset_id.'"';
					
					$result_c = mysql_exe_query(array($query_c,1));
					while($result_now_c=mysql_exe_fetch_array(array($result_c,1))){
						$q_check = 'SELECT COUNT(*) FROM checklist_history WHERE id_form_checklist="'.$result_now_c[0].'" AND id_master_checklist="'.$result_now_c[1].'"';
						$r_check = mysql_exe_query(array($q_check,1));
						$rn_check=mysql_exe_fetch_array(array($r_check,1));
						if($rn_check[0]==0){
							$query = 'INSERT INTO checklist_history (id_checklist_history ,date, id_form_checklist, id_master_checklist) VALUES("'.$wpid.'","'.$date_now.'","'.$result_now_c[0].'","'.$result_now_c[1].'")'; 
							mysql_exe_query(array($query,1));
						}
					}
				}
				
				
				//***********CHECKLIST*********************		
				$querydat = QDAILYH.' AND id_checklist_history="'.$wpid.'"'; 
				$result = mysql_exe_query(array($querydat,1));
				$data_table = ''; $i =1;
				while($result_now=mysql_exe_fetch_array(array($result,1))){
					if(isset($result_now[3])){
						$def = $result_now[3];
					}else{
						$def = $result_now[5];
					}
					$data_table .= '<tr>
										<td>'.$i.'</td>
										<td>'.$result_now[1].'</td>
										<td>'.$result_now[2].'</td>
										<td width="500"><input class="form-control" type="text" name="text_'.$result_now[4].'" value="'.$def.'" /></td>
									</tr>';
					$i++;
				}
				
				
				$content = '<div class="toptext" align="center">
					<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMLIST.'">Back</a></span>
					</div>';
				$content .= '    
						  <div class="content-wrapper">
							<div class="row">
							  <div class="col-lg-12 grid-margin stretch-card">
								<div class="card">
								  <div class="card-body">
									<div class="alert alert-primary" role="alert"><b>PM Name : '.$taskname.'</b><br>'.$tasklist.'</div>'.$info.'
									<p class="card-description"><code>Form Name : <b>'.$form_name.'</b>, WO Noumber :<b>'.$_REQUEST['rowid'].'</b>, date : <b>'.$date_now.'</b></code> </p>
									
									<form action="'.PATH_PMLIST.CHECKLIST.'&rowid='.$_REQUEST['rowid'].'&idhis='.$wpid.POST.'" method="post" enctype="multipart/form-data">
										<input class="btn btn-primary btn-fw" type="submit" value="Save">
										<table id="checklist" class="table table-bordered" style="width:100%">
										  <thead>
											<tr>
											  <th> No </th>
											  <th> Asset </th>
											  <th> Item </th>
											  <th> Result </th>
											</tr>
										  </thead>
										  <tbody>
											'.$data_table.'
										  </tbody>
										</table>
									</form>
								  </div>
								</div>
							  </div>
							</div>
						  </div>
						  <!-- content-wrapper ends -->
					';
			}
		
		$content .= pmlist_js();
		return $content;
	}
	
	function pmlist_js(){
		$content="
			<script>
				$('#checklist').DataTable({
					dom: 'Bfrtip',
					paging: false,
					//scrollX: 200,					
					buttons: [
						{
							className: 'green glyphicon glyphicon-file',
							extend: 'pdfHtml5',
							messageTop: ''
						},
						{
							extend: 'csv',
							text: 'CSV',
							exportOptions: {
								modifier: {
									search: 'none'
								}
							}
						},
						{
							extend: 'excelHtml5',
							text: 'Excel',
							exportOptions: {
								modifier: {
									page: 'current'
								}
							}
						},
						{
							extend: 'print',
							text: 'Print',
							autoPrint: false
						}
					]
				});
			</script>
		";
		
		return $content;
	}
	
?>