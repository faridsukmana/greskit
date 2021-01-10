<?php
	function pmlist(){
			/*------Get Pop Up Windows---------*/
			$content = pop_up(array('pmlist',PATH_PMLIST));
			
			$content .= '<br/><div class="ade">PREVENTIVE MAINTENANCE LIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,200,200,200,80,90,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
			if ($_SESSION['userID'] !='') {
				// jika id employee tidak kosong
				//-------get id pada sql -------------
				$field = gen_mysql_id(WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------set header pada handson------
				$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status'"._USER_EDIT_SETHEAD_._USER_CHECKLIST_SETHEAD_.",'Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'}"._USER_EDIT_SETID_._USER_CHECKLIST_SETID_.",{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array(WORDER.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC',$field,array('Edit','Checklist'),array(PATH_PMLIST.EDIT,PATH_PMLIST.CHECKLIST),array(0),PATH_PMLIST);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=1;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}elseif($_SESSION['userID'] ==''){
				//jika id employee kosong
				//-------get id pada sql -------------
				$field = gen_mysql_id(WORDERNOID.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(WORDERNOID.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------set header pada handson------
				$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status'"._USER_EDIT_SETHEAD_._USER_CHECKLIST_SETHEAD_.",'Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'}"._USER_EDIT_SETID_._USER_CHECKLIST_SETID_.",{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array(WORDERNOID.' AND WO.WorkTypeID="WT000002" ORDER BY WO.WorkOrderNo DESC',$field,array('Edit','Checklist'),array(PATH_PMLIST.EDIT,PATH_PMLIST.CHECKLIST),array(0),PATH_PMLIST);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=1;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}
			
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
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
								$info .= '<div class="alert alert-danger" align="center">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$info ='<div class="alert alert-danger" align="center"> You havent upload image. Empty Field of image</div>.';
								}else{
									$info .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
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
								$addinfo .= '<div class="alert alert-danger" align="center">Sorry, You havent upload image. Empty Field of image</div>';
							}else{
								if(!move_uploaded_file($_FILES['image']['tmp_name'],$target_file)){
									$addinfo ='<div class="alert alert-danger" align="center"> You havent upload image. Empty Field of image</div>.';
								}else{
									$addinfo .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['image']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$info = '<br/>'.$e->getMessage();
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
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}else{
								$date_mod=date('Y-m-d'); 
								$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", Modified_By="'.$_SESSION['user'].'", State_modified_date="'.$date_mod.'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
							}
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
				$pmstart = convert_date_time(array($resultnow[22],2)); $pmcompleted = convert_date_time(array($resultnow[23],2)); $pmtask = $resultnow[24]; $pmname = $resultnow[25]; $department = $resultnow[26];		
				//-----Cek if work type is preventive ----//
				$querycheck = 'SELECT WorkTypeDesc FROM work_type WHERE worktypeid="'.$resultnow[13].'"'; $resqcheck = mysql_exe_query(array($querycheck,1));
				$resnowqcheck = mysql_exe_fetch_array(array($resqcheck,1)); 
				if(strcmp($resnowqcheck[0],'Preventive')==0){
					$addfield ='
								<tr>
									<td width="120"><span class="name"> PM Target Start</td><td>:</td><td>'.datetime_je(array('pmstart',$pmstart,200)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Target Completed </td><td>:</td><td>'.datetime_je(array('pmcompleted',$pmcompleted,200)).'</td>
									<td width="20"><td>
								</tr>
								<tr>
									<td width="120"><span class="name"> PM Name</td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmname','pname',180,'',$pmname)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Task </td><td>:</td><td>'.combo_je(array(COMBPMGENG,'pmtask','pmtask',180,'',$pmtask)).'</td>
									<td width="20"><td>
								</tr>
					'; 
				}else{
					$addfield ='';
				}
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
				}
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMLIST.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Preventive Maintenance</div>
								<table>
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
									<tr>
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
										<td width="120"><span class="name"> Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'failed','failed',180,$resultnow[17],'')).'</td>
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
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
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
					
					//-- Insert data pada checklist --//
					$query_c = 'SELECT id_form_checklist, id_master_checklist FROM checklist_form_master WHERE id_form_checklist="'.$idform.'"';
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
				}
				
				
				//***********CHECKLIST*********************		
				$querydat = QDAILYH.' AND id_checklist_history="'.$wpid.'"'; 
				$result = mysql_exe_query(array($querydat,1));
				$data_table = ''; $i =1;
				while($result_now=mysql_exe_fetch_array(array($result,1))){
					$data_table .= '<tr>
										<td>'.$i.'</td>
										<td>'.$result_now[1].'</td>
										<td>'.$result_now[2].'</td>
										<td width="500"><input class="form-control" type="text" name="text_'.$result_now[4].'" value="'.$result_now[3].'" /></td>
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