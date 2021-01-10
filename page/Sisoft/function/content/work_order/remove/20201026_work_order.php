<?php
	function worder(){
			/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'UPDATE work_order SET Hidden="yes" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			/*------Get Pop Up Windows---------*/
			$content = pop_up(array('worder',PATH_WORDER));
			
			$content .= '<br/><div class="ade">WORK ORDER</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			if(_DELETE_) $width = "[200,200,110,110,80,80,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
			else $width = "[200,200,110,110,80,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
			if ($_SESSION['userID'] !='') {
				//-------get id pada sql -------------
				$field = gen_mysql_id(WORDER.' AND WO.WorkTypeID<>"WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(WORDER.' AND WO.WorkTypeID<>"WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------set header pada handson------
				$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',renderer: 'html',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array(WORDER.' AND WO.WorkTypeID<>"WT000002" ORDER BY WO.WorkOrderNo DESC',$field,array('Edit','Delete'),array(PATH_WORDER.EDIT,PATH_WORDER.DELETE),array(0),PATH_WORDER);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=1;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}elseif($_SESSION['userID'] ==''){
				//-------get id pada sql -------------
				$field = gen_mysql_id(WORDERNOID.' AND WO.WorkTypeID<>"WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(WORDERNOID.' AND WO.WorkTypeID<>"WT000002" ORDER BY WO.WorkOrderNo DESC');
				//-------set header pada handson------
				$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_.",'Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',renderer: 'html',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_.",{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array(WORDERNOID.' AND WO.WorkTypeID<>"WT000002" ORDER BY WO.WorkOrderNo DESC',$field,array('Edit','Delete'),array(PATH_WORDER.EDIT,PATH_WORDER.DELETE),array(0),PATH_WORDER);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=1;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}
			
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman upload excel-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD WO DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_WORDER.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Upload Excel Employee</div>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'/file/worder.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> Excel WO </td><td>:</td> </span></td><td>'.text_filebox(array('worder','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'/file/';
						$target_file = $target_dir.basename($_FILES['worder']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="alert alert-danger" align="center">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['worder']['size']>50000){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your files is too large</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 && $sizeupload==0){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['worder']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="alert alert-danger" align="center"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'worder');
								$content .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['worder']['name']).' has been uploaded</div>';
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$recdat = date('m/d/Y H:i'); //echo convert_date_time(array($recdat,1));
				$content = '<br/><div class="ade">ADD DATA FOR WORK ORDER</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				
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
				
				/*$query = 'SELECT id_group,group_name FROM tb_user_group where id_group="'.$_SESSION['groupID'].'"';
    
                $result = mysql_exe_query(array($query,1));
                $result_data=mysql_exe_fetch_array(array($result,1));
                
                $group_name= $result_data[1];
				if ($group_name == 'Administrator') {
				$tes = '<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTATALL,'wostat','wostat',180,'','')).'</td>';
				}else{
				   $tes = '<td width="120"><span class="name"> Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostat','wostat',180,'','')).'</td>'; 
				}*/
										
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_WORDER.ADD.POST.'" method="post" enctype="multipart/form-data">
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
										<td width="120"><span class="name"> Department </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'department','department',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Created by </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'create','create',180,'','')).'</td>
									</tr>
									<tr>
									'.$addassignto.'
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
							
							if($_FILES['image']['size']>500000){ 
								$info .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 500KB)</div>';
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

						//---Jika assign id yang update bukan manager maka---/
						if(empty($_REQUEST['assign']))
							$assign = 'EP000001';
						else
							$assign = $_REQUEST['assign'];
						
						if(empty(basename($_FILES['image']['name']))){
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,Created_By,DepartmentID) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$assign.'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$_SESSION['user'].'","'.$_REQUEST['department'].'")'; 
						}else{
						$query = 'INSERT INTO work_order (WorkOrderNo,DateReceived,DateRequired,EstDateStart,EstDateEnd,ActDateStart,ActDateEnd,DateHandOver,AcceptBy,AssignID,CreatedID,RequestorID,AssetID,WorkTypeID,WorkPriorityID,WorkStatusID,WorkTradeID,FailureCauseID,ProblemDesc,CauseDescription,ActionTaken,PreventionTaken,ImagePath,Created_By,DepartmentID) VALUES("'.$woid.'","'.$recdate.'","'.$reqdate.'","'.$eststart.'","'.$estend.'","'.$actstart.'","'.$actend.'","'.$hanover.'","'.$_REQUEST['accept'].'","'.$assign.'","'.$_REQUEST['create'].'","'.$_REQUEST['request'].'","'.$_REQUEST['asset'].'","'.$_REQUEST['wotype'].'","'.$_REQUEST['woprior'].'","'.$_REQUEST['wostat'].'","'.$_REQUEST['wotrade'].'","'.$_REQUEST['failed'].'","'.$_REQUEST['prodesc'].'","'.$_REQUEST['cause'].'","'.$_REQUEST['action'].'","'.$_REQUEST['prevent'].'","'.$target_file.'","'.$_REQUEST['department'].'")';
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
						$dt = array($querydat,$field,array('Edit'),array(PATH_WORDER.EDIT),array());
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
							
							if($_FILES['image']['size']>500000){ 
								$addinfo .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 500KB)</div>';
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
							
						}else{
							$query = 'UPDATE work_order SET DateReceived="'.$recdate.'", DateRequired="'.$reqdate.'", EstDateStart="'.$eststart.'", EstDateEnd="'.$estend.'", ActDateStart="'.$actstart.'", ActDateEnd="'.$actend.'", DateHandOver="'.$hanover.'", AcceptBy="'.$_REQUEST['accept'].'"'.$assign.', CreatedID="'.$_REQUEST['create'].'", RequestorID="'.$_REQUEST['request'].'", AssetID="'.$_REQUEST['asset'].'", WorkTypeID="'.$_REQUEST['wotype'].'", WorkPriorityID="'.$_REQUEST['woprior'].'", WorkStatusID="'.$_REQUEST['wostat'].'", WorkTradeID="'.$_REQUEST['wotrade'].'", FailureCauseID="'.$_REQUEST['failed'].'", ProblemDesc="'.$_REQUEST['prodesc'].'", CauseDescription="'.$_REQUEST['cause'].'", ActionTaken="'.$_REQUEST['action'].'", PreventionTaken="'.$_REQUEST['prevent'].'", ImagePath="'.$target_file.'", DepartmentID="'.$_REQUEST['department'].'" WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"';
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
						$dt = array($querydat,$field,array('Edit'),array(PATH_WORDER.EDIT),array());
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
				$pmstart = convert_date_time(array($resultnow[22],2)); $pmcompleted = convert_date_time(array($resultnow[23],2)); $pmtask = $resultnow[24]; $pmname = $resultnow[25]; $department=$resultnow[26];		
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
									<td width="120"><span class="name"> PM Name</td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmname','pname',180,'',$pmtask)).'</td>
									<td width="20"><td>
									<td width="120"><span class="name"> PM Task </td><td>:</td><td>'.combo_je(array(COMBPMGENG,'pmtask','pmtask',180,'',$pmname)).'</td>
									<td width="20"><td>
								</tr>
					'; 
				}else{
					$addfield ='';
				}
				
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
					$sparepart = query_delete(array(PATH_WORDER.EDIT.'&rowid='.$_REQUEST['wo'], 'work_document_relation', $con));	
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
									<a id="cl_back" class="btn btn-fw btn-outline-primary btn-sm float-right" href="'.PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].'" role="button"><i class="fa fa-arrow-left fa-fw"></i>Back</a>
								</div></div>
								<div id="step">'.
									create_form(array(TSTEPWORK,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].STEPWORK,1,$name_field,$input_type,$signtofill)).
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
				$dt = array($querystep,$field,array('Delete'),array(PATH_WORDER.EDIT.'&wo='.$_REQUEST['rowid'].'&delstepwork=ok&delete=ok'),array());
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
				if(isset($_REQUEST['spare'])){
					//-- Insert data pada kategori aset --//
					$field = array(
							'WorkOrderNo', 
							'itemspare',
							'request_quantity');
					$value = array(
							'"'.$_REQUEST['rowid'].'"',
							'"'.$_REQUEST['spare'].'"',
							'"'.$_REQUEST['request'].'"'); 
					$query = mysql_stat_insert(array('invent_item_work_order',$field,$value)); 
					mysql_exe_query(array($query,1)); 
				}
				if(isset($_REQUEST['delspare']) && isset($_REQUEST['delete'])){
					$con = 'WorkOrderNo="'.$_REQUEST['wo'].'" AND itemspare="'.$_REQUEST['rowid'].'"'; 
					$sparepart = query_delete(array(PATH_WORDER.EDIT.'&rowid='.$_REQUEST['wo'], 'invent_item_work_order', $con));	
				}
	
				DEFINE('COMBSPAREWO','SELECT item_id, item_description FROM invent_item WHERE item_id NOT IN (SELECT itemspare FROM invent_item_work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'")');  
				$name_field=array('Spare Part','Request Quantity');
				$input_type=array(
							combo_je(array(COMBSPAREWO,'spare','spare',180,'','')),
							text_je(array('request','','false','','request'))
						);
				$signtofill = array('');
				$sparepart .= '<div title="Spare Part" style="padding:10px">'.create_form(array(TSPAREPART,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].PSPARE,1,$name_field,$input_type,$signtofill));
				
				 $queryspare = QSPAREPART2.' AND WO.WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
                //-------set lebar kolom -------------
                $width = "[200,400,200,100,100]";
                //-------get id pada sql -------------
                $field = gen_mysql_id($queryspare);
                //-------get header pada sql----------
                $name = gen_mysql_head($queryspare);
                //-------set header pada handson------
                $sethead = "['Item Code','Item Name','Request Quantity','Quantity'"._USER_DELETE_SETHEAD_."]";
                //-------set id pada handson----------
                $setid = "[{data:'Item_Code',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Request',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($queryspare,$field,array('Delete'),array(PATH_WORDER.EDIT.'&wo='.$_REQUEST['rowid'].DELPSPARE),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'sparepart');
				//--------fungsi hanya untuk meload data
				$sparepart.= '
							<div id="sparepart" style="width: 780px; height: 280px; overflow: hidden; font-size=10px;"></div>'.get_handson_id($sethandson).'</div>';
				
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
                    $manpower = query_delete(array(PATH_WORDER.EDIT.'&rowid='.$_REQUEST['wo'], 'work_order_manpower', $con));   
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
				$manpower .= '<div title="Man Power" style="padding:10px">'.create_form(array(TMANPOWER,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].MANPOW,1,$name_field,$input_type,$signtofill));
				
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
				$dt = array($queryspare,$field,array('Delete'),array(PATH_WORDER.EDIT.'&wo='.$_REQUEST['rowid'].DELMANPOW),array());
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
				$totalexp = '<div title="Total Expense" style="padding:10px">'.create_form(array(TMANPOWER,PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].TEXP,1,$name_field,$input_type,$signtofill)).'</div>';
				
				//6.&&&&&&&&--Form ke 6. Failure Analysis--&&&&
				$queryexp = 'SELECT AssetID FROM work_order WHERE WorkOrderNo="'.$_REQUEST['rowid'].'"'; 
				$resexp = mysql_exe_query(array($queryexp,1)); $resnowexp = mysql_exe_fetch_array(array($resexp,1)); 
				$qserv= ASSETS.' AND A.AssetID="'.$resnowexp[0].'"';
				$rqserv = mysql_exe_query(array($qserv,1)); $resqserv = mysql_exe_fetch_array(array($rqserv,1));
				$data_svc = '
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
				';
				$servicereq = '<div title="Failure Analysis" style="padding:10px">'.$data_svc.'</div>';
				
				//-----INDUK FORM----------------------------
				//-----Form ke 1. Buat Form Work Order-----
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA WORK ORDER FOR '.$wonum.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_PRINT_.'</div>';
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
				$content .= '<div class="easyui-tabs" style="width:800px;height:500px;margin:auto">
							<div title="Work Order" style="padding:10px">
							<br/><div class="form-style-2"><form action="'.PATH_WORDER.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Order</div>
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
							</form></div></div>
							'.$stepwork.$sparepart.$manpower/*.$totalexp*/.$servicereq.'
							</div>';
				$content.=$info;
			}if(isset($_REQUEST['print'])){
				$content = get_print(array('workderdoc',$_REQUEST['wo']));
			}
		
		return $content;
	}
	function step_work(){
		$content = "<script>
						$('#doc').hide();
						$('#cl_back').hide();
						$('#sb_success').hide();
						$('#sb_failed').hide();
						$('#doc_work').hide();
						
						$('#cl_step').on('click',function(){
							$('#cl_step').hide();
							$('#cl_back').show();
							$('#step').hide();
							$('#doc').show();
							$('#sb_success').hide();
							$('#sb_failed').hide();
							$('#step_work').hide();
							$('#doc_work').show();
							
							$.ajax({
								type: 'POST',
								url:'"._ROOT_."function/content/work_order/list_doc_work.php',
								data:data,
								crossDomain:true,
								cache:false,
								success:function(data){
									$('#doc_work').append(data);
								}
							})
						})
						
						/*$('#cl_back').on('click',function(){
							$('#cl_step').show();
							$('#cl_back').hide();
							$('#step').show();
							$('#doc').hide();
							$('#sb_success').hide();
							$('#sb_failed').hide();
							$('#dock_work').hide();
							$('#step_work').show();
							$('#doc_work').empty();
						})*/
						
						$('#sb_doc').on('click',function(){
							var docname = $('#docname').val();
							var fd = new FormData();
							var files = $('#doc_upload')[0].files[0];
							fd.append('file',files); 
							fd.append('docname',docname);
							$('#doc_work').empty();
							
							$.ajax({
								type: 'POST',
								url:'"._ROOT_."function/content/work_order/work_upload_doc.php',
								data:fd,
								contentType: false,
								processData: false,
								success:function(data){
									$('#docname').val('');
									$('#doc_upload').val('');
									$('#doc_work').append(data);
								}
							})
							
						})
						
						function del_doc(id){
							$('#doc_work').empty();
							$.ajax({
								type: 'POST',
								url:'"._ROOT_."function/content/work_order/work_delete_doc.php',
								data:{'id':id},
								crossDomain:true,
								cache:false,
								success:function(data){
									$('#doc_work').append(data);
								}
							})
						}
					</script>
		";
		return $content;
	}
?>