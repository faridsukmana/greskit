<?php
	function pmsche(){
		/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'UPDATE pm_schedule SET Hidden="yes" WHERE PM_ID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
			
			$content = '<br/><div class="ade">Preventive Maintenance SCHEDULE</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			if(_DELETE_) $width = "[200,200,400,200,200,200,200,150,150,150,150,150,80,80]";
			else $width = "[200,200,400,200,200,200,200,150,150,150,150,150,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(PMSCHE.' ORDER BY PM_ID DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(PMSCHE.' ORDER BY PM_ID DESC');
			//-------set header pada handson------
			$sethead = "['PM ID','PM Name','PM Task','Asset','Plant Code','Section','PM State','Frequency Unit','Initiate Date','Target Start Date','Target Comp_Date','Next Date'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'PM_ID',className: 'htLeft'},{data:'PM_Name',className: 'htLeft'},{data:'PM_Task',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'PM_State',className: 'htLeft'},{data:'Frequency_Unit',className: 'htLeft'},{data:'Initiate_Date',className: 'htLeft'},{data:'Target_Start_Date',className: 'htLeft'},{data:'Target_Comp_Date',className: 'htLeft'},{data:'Next_Date',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(PMSCHE.' ORDER BY PM_ID DESC',$field,array('Edit','Delete'),array(PATH_PMSCHE.EDIT,PATH_PMSCHE.DELETE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR Preventive Maintenance SCHEDULE SCHEDULE</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Cek form pm yang digunakan berdasarkan asset atau location untuk mendefinisikan query berdasarkan kondisi tersebut ------//
				if(strcmp($_REQUEST['pmby'],'Asset')==0){
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
				}else if(strcmp($_REQUEST['pmby'],'Location')==0){
					$qpmby = COMLOCATN;
					$tpmby = 'Location';
				}else if(strcmp($_REQUEST['pmby'],'Plant Code')==0){
					$qpmby = COMBPLANT;
					$tpmby = 'Plant Code';
				}else{
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
				}
				
				//----- Get Value for field work type for preventive  ----------
				$query = 'SELECT WorkTypeDesc FROM work_type WHERE WorkTypeDesc="Preventive Maintenance"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1));
				//----- Buat Form Isian Berikut-----
				$indate = date('m/d/Y');
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMSCHE.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">PM Schedule</div>
								<table>
									<tr>
										<td width="120"><span class="name"> PM By </span></td><td>:</td><td>'.combo_je_arr(array(array('Asset','Plant Code'),'pmby','pmby',180,'',$_REQUEST['pmby'])).combobox_onselect(array(PATH_PMSCHE.ADD,'pmby',1)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> '.$tpmby.' </span></td><td>:</td><td>'.combo_je(array($qpmby,'pmbytype','pmbytype',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Generation Type </span></td><td>:</td><td>'.combo_je_arr(array(array('Schedule','Actual'),'pmgen','pmgen',180,'',$_REQUEST['dest'])).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Section </span></td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </span></td><td>:</td><td>'.text_je(array('wotype',$result_now[0],'false','','','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Name </span></td><td>:</td><td>'.text_je(array('pmname','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Task </span></td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmtask','pmtask',180,'','')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Status </span></td><td>:</td><td>'.combo_je_arr(array(array('Enable','Disable'),'pmstat','pmstat',180,'','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Frequency Unit </span></td><td>:</td><td>'.combo_je_arr(array(array('Days','Weeks','Months','Years'),'frequ','frequ',180,'','')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'frequ')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Frequency </span></td><td>:</td><td>'.text_je(array('freq','0','false','','freq')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'freq')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Days </span></td><td>:</td><td>'.text_je(array('days','0','false','','days','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Periode Days </span></td><td>:</td><td>'.text_je(array('wpdays','0','false','','wpdays')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'wpdays')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Initiate Date </span></td><td>:</td><td>'.date_je(array('indate',$indate)).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'indate')).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Target Start Date </span></td><td>:</td><td>'.date_je(array('tarsdate','')).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Target Completed Date </span></td><td>:</td><td>'.date_je(array('tarcdate','')).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Next Start Date </span></td><td>:</td><td>'.date_je(array('nextdate','')).' </td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['pmname']) && !empty($_REQUEST['pmbytype'])){//convert_date(array($_REQUEST['wardat'],2));
						$indate = convert_date(array($_REQUEST['indate'],2)); $tarsdate = convert_date(array($_REQUEST['tarsdate'],2));
						$tarcdate = convert_date(array($_REQUEST['tarcdate'],2)); $nextdate = convert_date(array($_REQUEST['nextdate'],2));
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTPMSCHE,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $shid=get_new_code('SH',$numrow); 
						//-- Insert data pada kategori aset --//
						//----- Get Value for field work type id for preventive  ----------
						$query = 'SELECT WorkTypeID FROM work_type WHERE WorkTypeDesc="Preventive Maintenance"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1));
						if(strcmp($_REQUEST['pmby'],'Asset')==0){
						$query = 'INSERT INTO pm_schedule (PM_ID,AssetID,PMGenType,PMWOTrade,WorkTypeId,PMName,ChecklistNo,PMState,FreqUnits,Frequency,PeriodDays,InitiateDate,TargetStartDate,TargetCompDate,NextDate) VALUES("'.$shid.'","'.$_REQUEST['pmbytype'].'","'.$_REQUEST['pmgen'].'","'.$_REQUEST['wotrade'].'","'.$result_now[0].'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmtask'].'","'.$_REQUEST['pmstat'].'","'.$_REQUEST['frequ'].'","'.$_REQUEST['freq'].'","'.$_REQUEST['wpdays'].'","'.$indate.'","'.$tarsdate.'","'.$tarcdate.'","'.$nextdate.'")'; 
						}
						else if(strcmp($_REQUEST['pmby'],'Location')==0){
						$query = 'INSERT INTO pm_schedule (PM_ID,LocationID,PMGenType,PMWOTrade,WorkTypeId,PMName,ChecklistNo,PMState,FreqUnits,Frequency,PeriodDays,InitiateDate,TargetStartDate,TargetCompDate,NextDate) VALUES("'.$shid.'","'.$_REQUEST['pmbytype'].'","'.$_REQUEST['pmgen'].'","'.$_REQUEST['wotrade'].'","'.$result_now[0].'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmtask'].'","'.$_REQUEST['pmstat'].'","'.$_REQUEST['frequ'].'","'.$_REQUEST['freq'].'","'.$_REQUEST['wpdays'].'","'.$indate.'","'.$tarsdate.'","'.$tarcdate.'","'.$nextdate.'")'; 
						}
						else if(strcmp($_REQUEST['pmby'],'Plant Code')==0){
						$query = 'INSERT INTO pm_schedule (PM_ID,LocationID,PMGenType,PMWOTrade,WorkTypeId,PMName,ChecklistNo,PMState,FreqUnits,Frequency,PeriodDays,InitiateDate,TargetStartDate,TargetCompDate,NextDate) VALUES("'.$shid.'","'.$_REQUEST['pmbytype'].'","'.$_REQUEST['pmgen'].'","'.$_REQUEST['wotrade'].'","'.$result_now[0].'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmtask'].'","'.$_REQUEST['pmstat'].'","'.$_REQUEST['frequ'].'","'.$_REQUEST['freq'].'","'.$_REQUEST['wpdays'].'","'.$indate.'","'.$tarsdate.'","'.$tarcdate.'","'.$nextdate.'")'; 
						}
						//echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = PMSCHE.' AND PM_ID="'.$shid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,200,200,200,200,150,150,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['PM ID','PM Name','PM Task','Asset','Plant Code','Work Trade','PM State','Frequency Unit','Initiate Date','Target Start Date','Target Comp_Date','Next Date'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'PM_ID',className: 'htLeft'},{data:'PM_Name',className: 'htLeft'},{data:'PM_Task',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'PM_State',className: 'htLeft'},{data:'Frequency_Unit',className: 'htLeft'},{data:'Initiate_Date',className: 'htLeft'},{data:'Target_Start_Date',className: 'htLeft'},{data:'Target_Comp_Date',className: 'htLeft'},{data:'Next_Date',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMSCHE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['pmname'])){
						$indate = convert_date(array($_REQUEST['indate'],2)); $tarsdate = convert_date(array($_REQUEST['tarsdate'],2));
						$tarcdate = convert_date(array($_REQUEST['tarcdate'],2)); $nextdate = convert_date(array($_REQUEST['nextdate'],2));
						$query_locas = 'SELECT assetid, locationid FROM pm_schedule WHERE PM_ID="'.$_REQUEST['rowid'].'"'; 
						$result = mysql_exe_query(array($query_locas,1)); $result_now=mysql_exe_fetch_array(array($result,1)); $asset=$result_now[0]; $location=$result_now[1];
						
						//----- Get Value for field work type id for preventive  ----------
						$query = 'SELECT WorkTypeID FROM work_type WHERE WorkTypeDesc="Preventive Maintenance"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1)); $worktype=$result_now[0];
						//-- Update data pada kategori aset --//
						if(!empty($asset)){
						$query = 'UPDATE pm_schedule SET AssetID="'.$_REQUEST['pmbytype'].'", PMGenType="'.$_REQUEST['pmgen'].'", PMWOTrade="'.$_REQUEST['wotrade'].'", WorkTypeId="'.$worktype.'", PMName="'.$_REQUEST['pmname'].'", ChecklistNo="'.$_REQUEST['pmtask'].'", PMState="'.$_REQUEST['pmstat'].'", FreqUnits="'.$_REQUEST['frequ'].'",Frequency="'.$_REQUEST['freq'].'", PeriodDays="'.$_REQUEST['wpdays'].'", InitiateDate="'.$indate.'", TargetStartDate="'.$tarsdate.'", TargetCompDate="'.$tarcdate.'",NextDate="'.$nextdate.'" WHERE PM_ID="'.$_REQUEST['rowid'].'"'; 
						}else if(!empty($location)){
						$query = 'UPDATE pm_schedule SET LocationID="'.$_REQUEST['pmbytype'].'", PMGenType="'.$_REQUEST['pmgen'].'", PMWOTrade="'.$_REQUEST['wotrade'].'", WorkTypeId="'.$worktype.'", PMName="'.$_REQUEST['pmname'].'", ChecklistNo="'.$_REQUEST['pmtask'].'", PMState="'.$_REQUEST['pmstat'].'", FreqUnits="'.$_REQUEST['frequ'].'",Frequency="'.$_REQUEST['freq'].'", PeriodDays="'.$_REQUEST['wpdays'].'", InitiateDate="'.$indate.'", TargetStartDate="'.$tarsdate.'", TargetCompDate="'.$tarcdate.'",NextDate="'.$nextdate.'" WHERE PM_ID="'.$_REQUEST['rowid'].'"';
						}
						//echo $query;
						mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = PMSCHE.' AND PM_ID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,400,200,200,200,200,150,150,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['PM ID','PM Name','PM Task','Asset','Plant Code','Work Trade','PM State','Frequency Unit','Initiate Date','Target Start Date','Target Comp_Date','Next Date'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'PM_ID',className: 'htLeft'},{data:'PM_Name',className: 'htLeft'},{data:'PM_Task',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'PM_State',className: 'htLeft'},{data:'Frequency_Unit',className: 'htLeft'},{data:'Initiate_Date',className: 'htLeft'},{data:'Target_Start_Date',className: 'htLeft'},{data:'Target_Comp_Date',className: 'htLeft'},{data:'Next_Date',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_PMSCHE.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDPMSCHE.' WHERE PM_ID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $result_now=mysql_exe_fetch_array(array($result,1));
				$assetid = $result_now[0]; $locationid = $result_now[1]; $worktrade = $result_now[2]; $pmname = $result_now[3]; $pmtask = $result_now[4]; $pmstate = $result_now[5]; $frequnit = $result_now[6]; $frequency = $result_now[11]; $perioddays = $result_now[12]; 
				$worktype = $result_now[13]; $pmgentype = $result_now[14];
				$indate = convert_date(array($result_now[7],3)); $tarsdate = convert_date(array($result_now[8],3));
				$tarcdate = convert_date(array($result_now[9],3)); $nextdate = convert_date(array($result_now[10],3));
				$days = 0;
				if(strcmp($frequnit,'Days')==0) $days=$frequency*1; else if(strcmp($frequnit,'Weeks')==0) $days=$frequency*7;
				else if(strcmp($frequnit,'Months')==0) $days=$frequency*28; else if(strcmp($frequnit,'Years')==0) $days=$frequency*365;
				
				//----- Get Value for field work type for preventive  ----------
				$query = 'SELECT WorkTypeDesc FROM work_type WHERE WorkTypeID="'.$worktype.'"'; $result=mysql_exe_query(array($query,1)); $result_now=mysql_exe_fetch_array(array($result,1)); $worktype = $result_now[0];
				
				//----- Cek form pm yang digunakan berdasarkan asset atau location untuk mendefinisikan query berdasarkan kondisi tersebut ------//
				if(!empty($assetid)){
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
					$idpmby = $assetid;
				}else if(!empty($locationid_old)){
					$qpmby = COMLOCATN;
					$tpmby = 'Location';
					$idpmby = $locationid;
				}else if(!empty($locationid)){
					$qpmby = COMBPLANT;
					$tpmby = 'Plant Code';
					$idpmby = $locationid;
				}else{
					$qpmby = COMASSETS;
					$tpmby = 'Asset';
				}
				
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA PM SCHEDULE FOR '.$pmname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_PMSCHE.EDIT.POST.'&rowid='.$_REQUEST['rowid'].'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">PM Schedule</div>
								<table>
									<tr>
										<td width="120"><span class="name"> '.$tpmby.' </span></td><td>:</td><td>'.combo_je(array($qpmby,'pmbytype','pmbytype',180,'',$idpmby)).'</td>
										<td width="20"><td>
										<td width="120"></td><td></td><td></td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Generation Type </span></td><td>:</td><td>'.combo_je_arr(array(array('Schedule','Actual'),'pmgen','pmgen',180,'',$pmgentype)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Section </span></td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'',$worktrade)).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Work Type </span></td><td>:</td><td>'.text_je(array('wotype',$worktype,'false','','','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Name </span></td><td>:</td><td>'.text_je(array('pmname',$pmname,'false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> PM Task </span></td><td>:</td><td>'.combo_je(array(COMPMTASKL,'pmtask','pmtask',180,'',$pmtask)).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> PM Status </span></td><td>:</td><td>'.combo_je_arr(array(array('Enable','Disable'),'pmstat','pmstat',180,'',$pmstate)).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Frequency Unit </span></td><td>:</td><td>'.combo_je_arr(array(array('Days','Weeks','Months','Years'),'frequ','frequ',180,'',$frequnit)).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'frequ')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Frequency </span></td><td>:</td><td>'.text_je(array('freq',$frequency,'false','','freq')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'freq')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Days </span></td><td>:</td><td>'.text_je(array('days',$days,'false','','days','','disabled')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Work Periode Days </span></td><td>:</td><td>'.text_je(array('wpdays',$perioddays,'false','','wpdays')).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'wpdays')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Initiate Date </span></td><td>:</td><td>'.date_je(array('indate',$indate)).box_onchange(array(PATH_PMSCHE.ADD.'&pmby='.$_REQUEST['pmby'],'indate')).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Target Start Date </span></td><td>:</td><td>'.date_je(array('tarsdate',$tarsdate)).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Target Completed Date </span></td><td>:</td><td>'.date_je(array('tarcdate',$tarcdate)).' </td>
										<td width="20"><td>
										<td width="120"><span class="name"> Next Start Date </span></td><td>:</td><td>'.date_je(array('nextdate',$nextdate)).' </td>
									</tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
			
			//------------Halaman upload templater-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD PM SCHEDULE DATA USING EXCEL</div>';
					$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
					//----- Buat Form Isian Edit Data Berikut-----
					$content .= '<br/><div class="form-style-1"><form action="'.PATH_PMSCHE.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
								<fieldset><div class="card-header text-center">Upload Excel PM Schedule</div>
									<table>
										<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'file/pmsche.xls">Download Excel Format</a></span></td></tr>
										<tr><td width="150"><span class="name"> PM Schedule </td><td>:</td> </span></td><td>'.text_filebox(array('pmsche','','false')).'</td></tr>
										<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
									</table>
								</fieldset>
								</form></div>';
								
					//------ Aksi ketika post upload data -----//
					if(isset($_REQUEST['post'])){
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/';
							$target_file = $target_dir.basename($_FILES['pmsche']['name']);
							$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							if($filetype!='xls'){
								$content .= '<div class="alert alert-danger" align="center">Sorry, only XLS files are allowed</div>';
								$typeupload = 0;
							}
							
							if($_FILES['pmsche']['size']>500000){
								$content .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 500KB)</div>';
								$sizeupload = 0;
							}
							
							if($typeupload==0 || $sizeupload==0){
								$content .= '<div class="alert alert-danger" align="center">Sorry, your file not uploaded</div>';
							}else{
								if(!move_uploaded_file($_FILES['pmsche']['tmp_name'],$target_file)){
									throw new RuntimeException('<div class="alert alert-danger" align="center"> Failed to move uploaded file. Your file still open</div>.');
								}else{
									parseExcel($target_file,0,'pmsche');
									$content .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['pmsche']['name']).' has been uploaded</div>';
								}
							}
						}catch(RuntimeException $e){
							$content = $e->getMessage();
						}
					}
			}

		return $content;
	}
?>