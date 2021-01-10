<?php
	function asset(){
		
			/*------Hanya kasus untuk hapus data---**/
			if(isset($_REQUEST['delete']) && !isset($_REQUEST['assetid'])){
				$query = 'UPDATE asset SET Hidden="yes" WHERE AssetID="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
				//-- Log Asset ----------------------//
				$now = date('Y-m-d h:m:s');
				$desc = 'Delete for Asset ID '.$_REQUEST['rowid'];
				$q_log = 'INSERT INTO log_asset (AssetID, PIC, modified_date, Description) VALUES ("'.$_REQUEST['rowid'].'","'.$_SESSION['user'].'","'.$now.'","'.$desc.'")';
				mysql_exe_query(array($q_log,1));
			}
			/*------Get Pop Up Windows---------*/
			$content = pop_up(array('assets',PATH_ASSETS));
			
			$content .= '<br/><div class="ade">ASSETS</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
		/*if(_DELETE_) $width = "[150,150,200,80,80,100,100,100,100,200,200,200,150,150,150,200,200,200,200,200,150,150,150]";
			else $width = "[150,150,200,80,100,100,100,200,200,200,150,150,150,200,200,200,200,200,150,150,150]";*/
			if(_DELETE_) $width = "[150,150,300,100,100,150,150,80,80,100,100,200,200,200,150,150,150,200,200,200,200,200,150,150,150]";
			else $width = "[150,150,300,100,100,150,150,80,100,200,200,200,150,150,150,200,200,200,200,200,150,150,150]";
			//-------get id pada sql -------------
			if ($_SESSION['userID'] !='') {
				$field = gen_mysql_id(ASSETS.' AND T.PlantID LIKE "%'.$_REQUEST['plant'].'%" AND R.AreaID LIKE "%'.$_REQUEST['area'].'%" ORDER BY A.AssetID DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(ASSETS.' AND T.PlantID LIKE "%'.$_REQUEST['plant'].'%" AND R.AreaID LIKE "%'.$_REQUEST['area'].'%" ORDER BY A.AssetID DESC');
				/*$sethead = "['Asset ID','Asset No','Asset Desc'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_._USER_HISTORY_SETHEAD_._USER_DOC_SETHEAD_.",'Area Code','Plant Code','Process Unit Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold']";
				//-------set id pada handson----------
				$setid = "[{data:'Asset_ID',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_._USER_HISTORY_SETID_._USER_DOC_SETID_.",{data:'Area_Code',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}]";*/
				// Timuraya
				$sethead = "['Asset ID','Asset No','Asset Desc','Area Code','Plant Code','Asset Category','Asset Status'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_._USER_HISTORY_SETHEAD_._USER_DOC_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Asset_ID',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'},{data:'Area_Code',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_._USER_HISTORY_SETID_._USER_DOC_SETID_."]";
				//-------get data pada sql------------
				$dt = array(ASSETS.' AND T.PlantID LIKE "%'.$_REQUEST['plant'].'%" AND R.AreaID LIKE "%'.$_REQUEST['area'].'%" ORDER BY A.AssetID DESC',$field,array('Edit','Delete','History','Attachment'),array(PATH_ASSETS.EDIT,PATH_ASSETS.DELETE,PATH_ASSETS.HISTORY,PATH_ASSETS.DOCUMENT),array(0),PATH_ASSETS);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=3;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}elseif($_SESSION['userID'] ==''){
				
				$field = gen_mysql_id(ASSETSNOID.' AND T.PlantID LIKE "%'.$_REQUEST['plant'].'%" AND R.AreaID LIKE "%'.$_REQUEST['area'].'%" ORDER BY A.AssetID DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(ASSETSNOID.' AND T.PlantID LIKE "%'.$_REQUEST['plant'].'%" AND R.AreaID LIKE "%'.$_REQUEST['area'].'%" ORDER BY A.AssetID DESC');
				/*$sethead = "['Asset ID','Asset No','Asset Desc'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_._USER_HISTORY_SETHEAD_._USER_DOC_SETHEAD_.",'Area Code','Plant Code','Process Unit Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold']";
				//-------set id pada handson----------
				$setid = "[{data:'Asset_ID',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_._USER_HISTORY_SETID_._USER_DOC_SETID_.",{data:'Area_Code',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}]";*/
				// Timuraya
				$sethead = "['Asset ID','Asset No','Asset Desc','Area Code','Plant Code','Asset Category','Asset Status'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_._USER_HISTORY_SETHEAD_._USER_DOC_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Asset_ID',renderer: 'html',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'},{data:'Area_Code',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_._USER_HISTORY_SETID_._USER_DOC_SETID_."]";
				//-------get data pada sql------------
				$dt = array(ASSETSNOID.' AND T.PlantID LIKE "%'.$_REQUEST['plant'].'%" AND R.AreaID LIKE "%'.$_REQUEST['area'].'%" ORDER BY A.AssetID DESC',$field,array('Edit','Delete','History','Attachment'),array(PATH_ASSETS.EDIT,PATH_ASSETS.DELETE,PATH_ASSETS.HISTORY,PATH_ASSETS.DOCUMENT),array(0),PATH_ASSETS);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=3;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			}
			
			//-------set header pada handson------
			
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['upload'])){
				$content = '<br/><div class="ade">UPLOAD ASSET DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSETS.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Upload Excel Asset</div>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'file/asset.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> Asset Data </td><td>:</td> </span></td><td>'.text_filebox(array('assup','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'file/';
						$target_file = $target_dir.basename($_FILES['assup']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="alert alert-danger" align="center">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['assup']['size']>500000){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 500KB)</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 || $sizeupload==0){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['assup']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="alert alert-danger" align="center"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'asset');
								$content .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['assup']['name']).' has been uploaded</div>';
							}
						}
					}catch(RuntimeException $e){
						$content = $e->getMessage();
					}
				}
			}
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR ASSETS</div>';
				$content .= '<div class="toptext" align="center"><span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.'">View</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.ADD.'">Add</a></span></div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_ASSETS.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Assets</div>
								<table>
									<tr>
										<td width="120"><span class="name"> Asset No </td><td>:</td><td>'.text_je(array('asno','','false')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Desc </td><td>:</td><td>'.text_je(array('asdes','','false')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Area Code </td><td>:</td><td>'.combo_je(array(COMBAREA,'areacode','areacode',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Plant Code </td><td>:</td><td>'.combo_je(array(COMBPLANT,'plantcode','plantcode',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Process Unit Desc </td><td>:</td><td>'.combo_je(array(COMLOCATN,'locdes','locdes',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Departement Desc </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Asset Category </td><td>:</td><td>'.combo_je(array(COMASSCAT,'ascat','ascat',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Status </td><td>:</td></td><td>'.combo_je(array(COMASSTAT,'assta','assta',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Criticality </td><td>:</td><td>'.combo_je(array(COMCRITIC,'critic','critic',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Auth. Employee </td><td>:</td><td>'.combo_je(array(COMEMPLOY,'employ','employ',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Supplier </td><td>:</td><td>'.combo_je(array(COMSUPPLY,'supply','supply',180,'','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty </td><td>:</td><td>'.combo_je(array(COMWARRAN,'warran','warran',180,'','')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Manufacturer </td><td>:</td><td>'.text_je(array('manuf','','false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Model No </td><td>:</td><td>'.text_je(array('mono','','false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Serial No </td><td>:</td><td>'.text_je(array('sn','','false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty Expired </td><td>:</td><td>'.date_je(array('wardat','')).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Warranty Notes </td><td>:</td><td>'.text_je(array('warnot','','true','style="width:100%;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Notes </td><td>:</td><td>'.text_je(array('assnot','','true','style="width:100%;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Date Acquired </td><td>:</td><td>'.date_je(array('datacq','')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Date Disposed </td><td>:</td><td>'.date_je(array('datdis','')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td><td width="20"><td><td width="120"><td>
									</tr>
									<!--<tr>
										<td width="120"><span class="name"> Parent </td><td>:</td><td colspan="4">'.combo_je(array(COMASSETS,'parent','parent',250,'<option value=""> - </option>','')).'</td>
										
									</tr>-->
		
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){ 
					if(!empty($_REQUEST['asno']) && !empty($_REQUEST['asdes']) && !empty($_REQUEST['ascat']) && !empty($_REQUEST['assta']) && !empty($_REQUEST['critic']) && !empty($_REQUEST['employ']) && !empty($_REQUEST['supply']) && !empty($_REQUEST['warran']) && !empty($_REQUEST['datacq']) && !empty($_REQUEST['areacode']) && !empty($_REQUEST['plantcode'])){
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/asset/';
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
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTASSETS,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $asid=get_new_code('AS',$numrow); 
						$wardat=convert_date(array($_REQUEST['wardat'],2)); $datacq=convert_date(array($_REQUEST['datacq'],2)); $datdis=convert_date(array($_REQUEST['datdis'],2));
						//-- Insert data pada kategori aset --//
						if(empty(basename($_FILES['image']['name']))){
						$query = 'INSERT INTO asset (AssetID,AssetNo,AssetDesc,locationID,DepartmentID,AssetCategoryID,AssetStatusID,CriticalID, EmployeeID,SupplierID,Manufacturer,ModelNumber,SerialNumber,WarrantyID,WarrantyNotes, WarrantyDate,AssetNote,DateAcquired,DateSold,ParentID,AreaID,PlantID) VALUES("'.$asid.'","'.$_REQUEST['asno'].'","'.$_REQUEST['asdes'].'","'.$_REQUEST['locdes'].'","'.$_REQUEST['depdes'].'","'.$_REQUEST['ascat'].'","'.$_REQUEST['assta'].'","'.$_REQUEST['critic'].'","'.$_REQUEST['employ'].'","'.$_REQUEST['supply'].'","'.$_REQUEST['manuf'].'","'.$_REQUEST['mono'].'","'.$_REQUEST['sn'].'","'.$_REQUEST['warran'].'","'.$_REQUEST['warnot'].'","'.$wardat.'","'.$_REQUEST['assnot'].'","'.$datacq.'","'.$datdis.'","'.$_REQUEST['parent'].'","'.$_REQUEST['areacode'].'","'.$_REQUEST['plantcode'].'")';
						}else{
						$query = 'INSERT INTO asset (AssetID,AssetNo,AssetDesc,locationID,DepartmentID,AssetCategoryID,AssetStatusID,CriticalID, EmployeeID,SupplierID,Manufacturer,ModelNumber,SerialNumber,WarrantyID,WarrantyNotes, WarrantyDate,AssetNote,DateAcquired,DateSold,ParentID,ImagePath,AreaID,PlantID) VALUES("'.$asid.'","'.$_REQUEST['asno'].'","'.$_REQUEST['asdes'].'","'.$_REQUEST['locdes'].'","'.$_REQUEST['depdes'].'","'.$_REQUEST['ascat'].'","'.$_REQUEST['assta'].'","'.$_REQUEST['critic'].'","'.$_REQUEST['employ'].'","'.$_REQUEST['supply'].'","'.$_REQUEST['manuf'].'","'.$_REQUEST['mono'].'","'.$_REQUEST['sn'].'","'.$_REQUEST['warran'].'","'.$_REQUEST['warnot'].'","'.$wardat.'","'.$_REQUEST['assnot'].'","'.$datacq.'","'.$datdis.'","'.$_REQUEST['parent'].'","'.$target_file.'","'.$_REQUEST['areacode'].'","'.$_REQUEST['plantcode'].'")';
						} mysql_exe_query(array($query,1)); 
						//-- Log Asset ----------------------//
						$now = date('Y-m-d h:m:s');
						$desc = 'Insert for Asset No '.$_REQUEST["asno"];
						$q_log = 'INSERT INTO log_asset (AssetID, PIC, modified_date, Description) VALUES ("'.$asid.'","'.$_SESSION['user'].'","'.$now.'","'.$desc.'")';
						mysql_exe_query(array($q_log,1));
						//-- Ambil data baru dari database --//
						$querydat = ASSETS.' AND AssetID="'.$asid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,150,200,200,200,200,150,150,150,200,200,200,200,200,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Asset ID','Asset No','Asset Desc','Location Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold'"._USER_EDIT_SETHEAD_."]";
						$setid = "[{data:'Asset_ID',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'},{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSETS.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=3;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson).$info;
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){ //echo $_REQUEST['datacq'];
					if(!empty($_REQUEST['asno']) && !empty($_REQUEST['asdes']) && !empty($_REQUEST['ascat']) && !empty($_REQUEST['assta']) && !empty($_REQUEST['critic']) && !empty($_REQUEST['employ']) && !empty($_REQUEST['supply']) && !empty($_REQUEST['warran']) && !empty($_REQUEST['datacq'])){
						
						//--------Post Image File------------------
						try{
							$typeupload = 1; $sizeupload = 1;
							$target_dir = _ROOT_.'file/asset/';
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
						
						
						//-- Update data pada kategori aset --//
						$wardat=convert_date(array($_REQUEST['wardat'],2)); $datacq=convert_date(array($_REQUEST['datacq'],2)); $datdis=convert_date(array($_REQUEST['datdis'],2));
						
						if(empty(basename($_FILES['image']['name']))){
						$query = 'UPDATE asset SET AssetNo="'.$_REQUEST['asno'].'", AssetDesc="'.$_REQUEST['asdes'].'", locationID="'.$_REQUEST['locdes'].'", DepartmentID="'.$_REQUEST['depdes'].'", AssetCategoryID="'.$_REQUEST['ascat'].'", AssetStatusID="'.$_REQUEST['assta'].'", CriticalID="'.$_REQUEST['critic'].'",  EmployeeID="'.$_REQUEST['employ'].'", SupplierID="'.$_REQUEST['supply'].'", Manufacturer="'.$_REQUEST['manuf'].'", ModelNumber="'.$_REQUEST['mono'].'", SerialNumber="'.$_REQUEST['sn'].'", WarrantyID="'.$_REQUEST['warran'].'", WarrantyNotes="'.$_REQUEST['warnot'].'",  WarrantyDate="'.$wardat.'", AssetNote="'.$_REQUEST['assnot'].'", DateAcquired="'.$datacq.'", DateSold="'.$datdis.'", ParentID="'.$_REQUEST['parent'].'", AreaID="'.$_REQUEST['areacode'].'", PlantID="'.$_REQUEST['plantcode'].'" WHERE AssetID="'.$_REQUEST['rowid'].'"';
						}else{
						$query = 'UPDATE asset SET AssetNo="'.$_REQUEST['asno'].'", AssetDesc="'.$_REQUEST['asdes'].'", locationID="'.$_REQUEST['locdes'].'", DepartmentID="'.$_REQUEST['depdes'].'", AssetCategoryID="'.$_REQUEST['ascat'].'", AssetStatusID="'.$_REQUEST['assta'].'", CriticalID="'.$_REQUEST['critic'].'",  EmployeeID="'.$_REQUEST['employ'].'", SupplierID="'.$_REQUEST['supply'].'", Manufacturer="'.$_REQUEST['manuf'].'", ModelNumber="'.$_REQUEST['mono'].'", SerialNumber="'.$_REQUEST['sn'].'", WarrantyID="'.$_REQUEST['warran'].'", WarrantyNotes="'.$_REQUEST['warnot'].'",  WarrantyDate="'.$wardat.'", AssetNote="'.$_REQUEST['assnot'].'", DateAcquired="'.$datacq.'", DateSold="'.$datdis.'", ParentID="'.$_REQUEST['parent'].'", ImagePath="'.$target_file.'", AreaID="'.$_REQUEST['areacode'].'", PlantID="'.$_REQUEST['plantcode'].'" WHERE AssetID="'.$_REQUEST['rowid'].'"';
						} 
						mysql_exe_query(array($query,1));
						//-- Log Asset ----------------------//
						$now = date('Y-m-d h:m:s');
						$desc = 'Modified for Asset No '.$_REQUEST["asno"];
						$q_log = 'INSERT INTO log_asset (AssetID, PIC, modified_date, Description) VALUES ("'.$_REQUEST['rowid'].'","'.$_SESSION['user'].'","'.$now.'","'.$desc.'")';
						mysql_exe_query(array($q_log,1));
						//-- Ambil data baru dari database --//
						$querydat = ASSETS.' AND AssetID="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[150,150,200,200,200,200,150,150,150,200,200,200,200,200,150,150,150,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						$sethead = "['Asset ID','Asset No','Asset Desc','Location Desc','Department Desc','Asset Category','Asset Status','Critically', 'Auth Employeee','Supplier Name','Manufacturer','Model Number','Serial Number','Warranty', 'Warranty Date','Date Acquired','Date Sold'"._USER_EDIT_SETHEAD_."]";
						$setid = "[{data:'Asset_ID',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset_Desc',className: 'htLeft'},{data:'Location_Desc',className: 'htLeft'},{data:'Department_Desc',className: 'htLeft'},{data:'Asset_Category',className: 'htLeft'},{data:'Asset_Status',className: 'htLeft'},{data:'Critically',className: 'htLeft'},{data:'Auth_Employee',className: 'htLeft'},{data:'Supplier_Name',className: 'htLeft'},{data:'Manufacturer',className: 'htLeft'},{data:'Model_Number',className: 'htLeft'},{data:'Serial_Number',className: 'htLeft'},{data:'Warranty',className: 'htLeft'},{data:'Warranty_Date',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Acquired',type: 'date',dateFormat: 'YYYY-MM-DD'},{data:'Date_Sold',type: 'date',dateFormat: 'YYYY-MM-DD'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ASSETS.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=3;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson).$addinfo;
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$asno=$resultnow[1]; $asdes=$resultnow[2]; $locdes=$resultnow[3]; $depdes=$resultnow[4]; $ascat=$resultnow[5]; $assta=$resultnow[6]; $critic=$resultnow[7]; $employ=$resultnow[8]; $supply=$resultnow[9]; $manuf=$resultnow[10]; $mono=$resultnow[11]; $sn=$resultnow[12]; $warran=$resultnow[13]; $warnot=$resultnow[14]; $wardat=convert_date(array($resultnow[15],3)); $assnot=$resultnow[16]; $datacq=convert_date(array($resultnow[17],3)); $datdis=convert_date(array($resultnow[18],3)); $parent=$resultnow[19]; $areacode=$resultnow[20]; $plantcode=$resultnow[21];
				
				//-----Tampilan judul pada pengeditan------ 
				$content = '<br/><div class="ade">EDIT DATA FOR ASSET CATEGORY FOR '.$asdes.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-2"><form action="'.PATH_ASSETS.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Assets</div>
								<table>
									<tr>
										<td width="120"><span class="name"> Asset No </td><td>:</td> </span></td><td>'.text_je(array('asno',$asno,'false')).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Desc </td><td>:</td> </span></td><td>'.text_je(array('asdes',$asdes,'false')).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Area Code </td><td>:</td> </span></td><td>'.combo_je(array(COMBAREA,'areacode','areacode',180,'',$areacode)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Plant Code </td><td>:</td> </span></td><td>'.combo_je(array(COMBPLANT,'plantcode','plantcode',180,'',$plantcode)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Process Unit Desc </td><td>:</td> </span></td><td>'.combo_je(array(COMLOCATN,'locdes','locdes',180,'',$locdes)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Departement Desc </td><td>:</td> </span></td><td>'.combo_je(array(LOCATNDEPART,'depdes','depdes',180,'',$depdes)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Asset Category </td><td>:</td> </span></td><td>'.combo_je(array(COMASSCAT,'ascat','ascat',180,'',$ascat)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Status </td><td>:</td> </span></td><td>'.combo_je(array(COMASSTAT,'assta','assta',180,'',$assta)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Criticality </td><td>:</td> </span></td><td>'.combo_je(array(COMCRITIC,'critic','critic',180,'',$critic)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Auth. Employee </td><td>:</td> </span></td><td>'.combo_je(array(COMEMPLOY,'employ','employ',180,'',$employ)). '*</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Supplier </td><td>:</td> </span></td><td>'.combo_je(array(COMSUPPLY,'supply','supply',180,'',$supply)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty </td><td>:</td> </span></td><td>'.combo_je(array(COMWARRAN,'warran','warran',180,'',$warran)).' *</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Manufacturer </td><td>:</td> </span></td><td>'.text_je(array('manuf',$manuf,'false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Model No </td><td>:</td> </span></td><td>'.text_je(array('mono',$mono,'false')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Serial No </td><td>:</td> </span></td><td>'.text_je(array('sn',$sn,'false')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Warranty Expired </td><td>:</td> </span></td><td>'.date_je(array('wardat',$wardat)).' </td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Warranty Notes </td><td>:</td> </span></td><td>'.text_je(array('warnot',$warnot,'true','style="width:100%;height:80px"')).'</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Asset Notes </td><td>:</td> </span></td><td>'.text_je(array('assnot',$assnot,'true','style="width:100%;height:80px"')).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Date Acquired </td><td>:</td> </span></td><td>'.date_je(array('datacq',$datacq)).' *</td>
										<td width="20"><td>
										<td width="120"><span class="name"> Date Disposed </td><td>:</td> </span></td><td>'.date_je(array('datdis',$datdis)).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name"> Image </td><td>:</td> </span></td><td>'.text_filebox(array('image','','false')).'</td><td width="20"><td><td width="120"><td>
									</tr>
									<!--<tr>
										<td width="120"><span class="name"> Parent </td><td>:</td><td>'.combo_je(array(COMASSETS,'parent','parent',180,'<option value=""> - </option>',$parent)).'</td>
										<td width="20"><td>
										<td width="120"></td><td></td><td><span class="editlink"><a href="'.PATH_ASSETS.CHILD.'&rowid='.$_REQUEST['rowid'].'">Get Childs or Siblings</a></span></td>
									</tr>-->
		
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['child'])){ 
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = ASSETS.' AND A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$asdes=$resultnow[2]; 
				//-----Tampilan judul pada pengeditan------ 
				$content = '<br/><div class="ade">CHILD FROM ASSETS DATA  '.$asdes.'</div>';
				$content .= '<div class="toptext" align="center"><span><a href="'.PATH_ASSETS.EDIT.'&rowid='.$_REQUEST['rowid'].'">View</a></span></div>';
				
				//----- Buat Form Tambah Child Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ASSETS.CHILD.POST.'&rowid='.$_REQUEST['rowid'].'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Add Child</div>
								<table>
									<tr><td width="150"><span class="name"> Child </td><td>:</td> </span></td><td>'.combo_je(array(COMASSETS,'child','child',250,'<option value=""> - </option>','')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
							
				//------ Aksi ketika post menambahkan pada child -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['child'])){
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTACHILD,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; 
						$chid='CH'.date('y').date('m').date('d').date('h').date('i').date('s');
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO siblings (SiblingsID,AssetID,ChildID) VALUES("'.$chid.'","'.$_REQUEST['rowid'].'","'.$_REQUEST['child'].'")'; mysql_exe_query(array($query,1));
					}else{
						$content .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
				//------ Aksi ketika menghapus data pada child -----//
				if(isset($_REQUEST['delete'])){
					$con = 'SiblingsID="'.$_REQUEST['rowid'].'"'; 
					$content = query_delete(array(PATH_ASSETS.CHILD.'&rowid='.$_REQUEST['assetid'], 'siblings', $con));	
				}
				
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,200,200,200,200,80]";
				//-------get id pada sql -------------
				$field = gen_mysql_id(ACHILD.' AND S.AssetID="'.$_REQUEST['rowid'].'"');
				//-------get header pada sql----------
				$name = gen_mysql_head(ACHILD.' AND S.AssetID="'.$_REQUEST['rowid'].'"');
				//-------set header pada handson------
				$sethead = "['Sibling ID','Asset No','Asset','Child No','Child'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Siblings_ID',className: 'htLeft'},{data:'Asset_No',className: 'htLeft'},{data:'Asset',className: 'htLeft'},{data:'Child_No',className: 'htLeft'},{data:'Child',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array(ACHILD.' AND S.AssetID="'.$_REQUEST['rowid'].'"',$field,array('Delete'),array(PATH_ASSETS.CHILD.DELETE.'&assetid='.$_REQUEST['rowid']),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
			
			//------------Jika ada halaman spare data-------//
			if(isset($_REQUEST['spare'])){
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$assetname=$resultnow[2];  
				$content = '<br/><div class="ade">'.TSPARE.' '.$assetname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//-----------------POST-------------------
				if(isset($_REQUEST['post'])){
					//-- Insert data pada kategori aset --//
					$field = array(
							'AssetID', 
							'item_id');
					$value = array(
							'"'.$_REQUEST['rowid'].'"',
							'"'.$_REQUEST['item'].'"'); 
					$query = mysql_stat_insert(array('invent_item_spare_asset',$field,$value)); 
					mysql_exe_query(array($query,1)); 
				}
				//------ Aksi ketika menghapus data pada spare -----//
				if(isset($_REQUEST['delete'])){
					$con = 'AssetID="'.$_REQUEST['assetid'].'" AND item_id="'.$_REQUEST['rowid'].'"'; 
					$content = query_delete(array(PATH_ASSETS.SPARE.'&rowid='.$_REQUEST['assetid'], 'invent_item_spare_asset', $con));	
				}
				//-----DEFINE-------------------
				DEFINE('_SPARE_ASSET_',$_REQUEST['rowid']); 
				//DEFINE('SPAREP','SELECT ISA.item_id Item_Code, AST.AssetDesc Asset_Name ,IT.item_description Item_Name, IO.quantity Quantity FROM invent_item_spare_asset ISA, invent_item IT, invent_stock IO, asset AST WHERE ISA.item_id=IT.item_id AND IT.item_id=IO.item_id AND ISA.AssetID=AST.AssetID AND AST.AssetID="'._SPARE_ASSET_.'"');
				DEFINE('SPAREP','SELECT ISA.item_id Item_Code, AST.AssetDesc Asset_Name ,IT.item_description Item_Name, IT.stock Quantity FROM invent_item_spare_asset ISA, invent_item IT, asset AST WHERE ISA.item_id=IT.item_id AND ISA.AssetID=AST.AssetID AND AST.AssetID="'._SPARE_ASSET_.'"');
				DEFINE('COMBSPAREP','SELECT item_id, item_description FROM invent_item WHERE item_id NOT IN (SELECT item_id FROM invent_item_spare_asset WHERE AssetID="'._SPARE_ASSET_.'")');  
				//-------------------------------------------------//
				
				$name_field=array('Item Name');
				$input_type=array(
							combo_je(array(COMBSPAREP,'item','item',200,'',''))
						);
				$signtofill = array('*');
				$content .= create_form(array(FASPAREP,PATH_ASSETS.SPARE.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,400,400,100,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id(SPAREP);
				//-------get header pada sql----------
				$name = gen_mysql_head(SPAREP);
				//-------set header pada handson------
				$sethead = "['Item Code','Asset Name','Item Name','Quantity'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Item_Code',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array(SPAREP,$field,array('Delete'),array(PATH_ASSETS.SPARE.DELETE.'&assetid='.$_REQUEST['rowid']),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
			
			//------------Jika ada halaman history-------//
			if(isset($_REQUEST['history'])){
				/*------Get Pop Up Windows---------*/
				$content = pop_up(array('worder',PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid']));
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$assetname=$resultnow[2];  
				$content .= '<br/><div class="ade">WORK ORDER HISTORY FOR '.$assetname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				$content .= '<div style="margin-top:5px;" st align="center">'._USER_WO_._USER_PM_._USER_RC_._USER_LOG_.'</div>';
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,200,400,400,400,400]";
				//-------get id pada sql -------------
				$field = gen_mysql_id(WORDER.' AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC');
				//-------get header pada sql----------
				$name = gen_mysql_head(WORDER.' AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC');
				//-------set header pada handson------
				$sethead = "['Work_Order_No','Asset_Name','Work_Type','Work_Status','Work_Priority','Work_Trade','Receive_Date','Required_Date','Estimated_Date_Start','Estimated_Date_End','Actual_Date_Start','Actual_Date_End','Hand_Over_Date','Assign_to','Created_By','Requestor','Failure_Code','Problem_Desc','Cause_Description','Action_Taken','Prevention_Taken']";
				//-------set id pada handson----------
				$setid = "[{data:'Work_Order_No',renderer: 'html',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Work_Type',className: 'htLeft'},{data:'Work_Status',className: 'htLeft'},{data:'Work_Priority',className: 'htLeft'},{data:'Work_Trade',className: 'htLeft'},{data:'Receive_Date',className: 'htLeft'},{data:'Required_Date',className: 'htLeft'},{data:'Estimated_Date_Start',className: 'htLeft'},{data:'Estimated_Date_End',className: 'htLeft'},{data:'Actual_Date_Start',className: 'htLeft'},{data:'Actual_Date_End',className: 'htLeft'},{data:'Hand_Over_Date',className: 'htLeft'},{data:'Assign_to',className: 'htLeft'},{data:'Created_By',className: 'htLeft'},{data:'Requestor',className: 'htLeft'},{data:'Failure_Code',className: 'htLeft'},{data:'Problem_Desc',className: 'htLeft'},{data:'Cause_Description',className: 'htLeft'},{data:'Action_Taken',className: 'htLeft'},{data:'Prevention_Taken',className: 'htLeft'}]";
				//-------get data pada sql------------
				$dt = array(WORDER.' AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC',$field,array(),array(),array(0),PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid']);
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
				
				if(ISSET($_REQUEST['type']) && $_REQUEST['type']=='wo'){
					$content = type_history_wo();
				}else if(ISSET($_REQUEST['type']) && $_REQUEST['type']=='pm'){
					$content = type_history_pm();
				}else if(ISSET($_REQUEST['type']) && $_REQUEST['type']=='rc'){
					$content = type_history_rc();
					if(ISSET($_REQUEST['date'])){
						$content = tipe_history_rc_detail();
					}
				}else if(ISSET($_REQUEST['type']) && $_REQUEST['type']=='log'){
					$content = type_history_log();
				}
				
				$content .= asset_history_js();
			}
			
			//------------Jika ada halaman docoment-------//
			if(isset($_REQUEST['doc'])){ $addinfo='';
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = EDASSETS.' WHERE A.AssetID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$assetname=$resultnow[2];  
				$content = '<br/><div class="ade">DOCUMENT ATTACHMENT FOR '.$assetname.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				if(isset($_REQUEST['post'])){
						if(!empty($_REQUEST['docname'])){
							$upload = 0;
					//--------Post Doc File------------------
							try{
								$existupload=1; $typeupload = 1; $sizeupload = 1;
								$target_dir = _ROOT_.'file/assetdoc/';
								$target_file = $target_dir.basename($_FILES['doc']['name']);
								$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); 
								$expensions= array("pdf");
								if(file_exists($target_file)){
									$addinfo .= '<div class="alert alert-danger" align="center">Sorry, File already exist</div>';
									$typeupload = 0;
								}
								
								if(in_array($filetype,$expensions)===false){
									$addinfo .= '<div class="alert alert-danger" align="center">Sorry, only PDF files are allowed</div>';
									$typeupload = 0;
								}
								
								if($_FILES['image']['size']>2000000){ 
									$addinfo .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 2MB)</div>';
									$sizeupload = 0;
								}
								
								if($existupload==0 || $typeupload==0 || $sizeupload==0){
									$addinfo .= '<div class="alert alert-danger" align="center">Sorry, You have failed upload document</div>';
								}else{
									if(!move_uploaded_file($_FILES['doc']['tmp_name'],$target_file)){
										$addinfo ='<div class="alert alert-danger" align="center"> You havent upload image. Empty Field of document</div>.';
									}else{
										$addinfo .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['doc']['name']).' has been uploaded</div>';
										$upload = 1;
									}
								}
							}catch(RuntimeException $e){
								$addinfo = '<br/>'.$e->getMessage();
							}
						
							
							//-- Generate a new id untuk kategori aset --// 
							$result = mysql_exe_query(array(COUNTQASSETDOC,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; //$docid=get_new_code('DT',$numrow); 
							$docid='DT'.date('y').date('m').date('d').date('h').date('i').date('s');
							//-- Insert data pada kategori aset --//
							$field = array(
									'AssetDocID', 
									'AssetID',
									'NameDoc',
									'DocPath',
									'PathFile');
							$value = array(
									'"'.$docid.'"',
									'"'.$_REQUEST['rowid'].'"',
									'"'.$_REQUEST['docname'].'"',
									'"<span class=\"editlink\"><a href=\"'.$target_file.'\">Download</a></span>"',
									'"'.$target_file.'"'); 
							$query = mysql_stat_insert(array('asset_document',$field,$value)); 
							if($upload==1){
								mysql_exe_query(array($query,1));
								//-- Log Asset ----------------------//
								$now = date('Y-m-d h:m:s');
								$desc = 'Upload document for Asset ID '.$_REQUEST['rowid'].', document name : '.$_REQUEST['docname'];
								$q_log = 'INSERT INTO log_asset (AssetID, PIC, modified_date, Description) VALUES ("'.$_REQUEST['rowid'].'","'.$_SESSION['user'].'","'.$now.'","'.$desc.'")';
								mysql_exe_query(array($q_log,1));
							}
						}else{
							$addinfo = '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
						}
				}
				//------ Aksi ketika menghapus data pada spare -----//
				if(isset($_REQUEST['delete'])){
					$query = 'SELECT * FROM asset_document';
					$result = mysql_exe_query(array($query,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $path = $resultnow[4];
					unlink($path);
					$con = 'AssetID="'.$_REQUEST['assetid'].'" AND AssetDocID="'.$_REQUEST['rowid'].'"'; 
					$content = query_delete(array(PATH_ASSETS.DOCUMENT.'&rowid='.$_REQUEST['assetid'], 'asset_document', $con));	
				}
				
				//----- Buat Form Isian Berikut-----
				$name_field=array('Name of Document','Attachment');
				$input_type=array(
							text_je(array('docname',$sn,'false')),
							text_filebox(array('doc','','false'))
						);
				$signtofill = array(' * ',' <span style="color:red; font-size:12;"> PDF Max (2MB)</span>');
				$content .= create_form(array(ASSETDOC,PATH_ASSETS.DOCUMENT.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill)).$addinfo;
				
				$query = QASSETDOC.' AND AD.AssetID="'.$_REQUEST['rowid'].'"';
				$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
				//-------set lebar kolom -------------
				$width = "[200,350,350,200,100]";
				//-------get id pada sql -------------
				$field = gen_mysql_id($query);
				//-------get header pada sql----------
				$name = gen_mysql_head($query);
				//-------set header pada handson------
				$sethead = "['Doc ID','Asset Name','Document Name','Download'"._USER_DELETE_SETHEAD_."]";
				//-------set id pada handson----------
				$setid = "[{data:'Doc_ID',className: 'htLeft'},{data:'Asset_Name',className: 'htLeft'},{data:'Doc_Name',className: 'htLeft'},{data:'Path',renderer:'html'}"._USER_DELETE_SETID_."]";
				//-------get data pada sql------------
				$dt = array($query,$field,array('Delete'),array(PATH_ASSETS.DOCUMENT.DELETE.'&assetid='.$_REQUEST['rowid']),array());
				$data = get_data_handson_func($dt);
				//----Fungsi memanggil data handsontable melalui javascript---
				$fixedcolleft=0;
				$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
				//--------fungsi hanya untuk meload data
				$content .= get_handson($sethandson);
			}
			
			//------------Jika ada halaman tree-------//
			if(isset($_REQUEST['tree'])){
				$content = '<br/><div class="ade">TREE ASSET DATA</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				$content .= tree_asset();
			}
			
		$content .= asset_list_js();
		return $content;
	}
	
	//=======================Popup Detail=================================
	//================Data Preventive Maintenance from asset============================//
	function pop_detail_pm(){
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['dataid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//=================================================
		$query_data = WORDER.' AND WO.WorkTypeID="WT000002" AND WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.Hidden="no" ORDER BY WO.WorkOrderNo DESC';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[12].'</td>
					<td>'.$result_data_now[14].'</td>
					<td>'.$result_data_now[10].'</td>
				</tr>
			';
			$i++;
		}
		
		$date = '
					<div>
						<div class="row">
							<div class="col-sm-9">
								  <div class="form-group row">
									<label class="col-sm-2 col-form-label">Periode</label>
									<div class="col-sm-5">
										<div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" id="pm_first_date" placeholder="dd/mm/yyyy">
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-th"></i></span>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" id="pm_second_date" placeholder="dd/mm/yyyy">
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-th"></i></span>
										</div>
									</div>
								  </div>
							</div>
						</div>
					</div>
		';
		
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Preventive Maintenance History</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							'.$date.'
							<table id="partam-popup" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> WO No </th>
								  <th> Work Type </th>
								  <th> Work Status </th>
								  <th> Requestor </th>
								</tr>
							  </thead>
							  <tbody>
								'.$data_table.'
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- content-wrapper ends -->
			';
		return $content;
	}
	
	//=======================Popup Detail=================================
	//================Data Parts============================//
	function pop_detail_part(){
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['dataid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//===============================Part List==================
		$query_data = 'SELECT AR.Qty Qty_Consume,IT.item_id Part_No, IT.item_description Description, IT.stock Stock_Available, IU.unit Unit, IL.id_location Location_Code,IL.detail_location Location FROM work_order WO, asset AE, invent_journal_movement IE, invent_item IT, invent_unit IU, invent_location IL,

		(SELECT IT.item_id Part_No, SUM(IE.number_of_stock) Qty FROM work_order WO, asset AE, 
		invent_journal_movement IE, invent_item IT WHERE AE.AssetID="'.$_REQUEST['dataid'].'" AND 
		WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" 
		AND IT.item_id=IE.item_id GROUP BY IT.item_id ASC) AR

		WHERE AE.AssetID="'.$_REQUEST['dataid'].'" AND WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IT.item_id=IE.item_id AND IU.id_unit=IT.id_unit AND IL.id_location=IT.id_location AND AR.Part_No=IT.item_id GROUP BY IT.item_id DESC';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_list = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_list .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[1].'</td>
					<td>'.$result_data_now[2].'</td>
					<td>'.$result_data_now[3].'</td>
					<td>'.$result_data_now[4].'</td>
					<td>'.$result_data_now[5].'</td>
					<td>'.$result_data_now[6].'</td>
				</tr>
			';
			$i++;
		}
		
		//===============================Part Consume==================
		$query_data = 'SELECT IE.date_jvmovement Date, IT.item_id Part_No, IT.item_description Description, IE.number_of_stock Qty, IU.unit Unit, IT.avg_price Price, (IE.number_of_stock*IT.avg_price) Cost ,WO.WorkOrderNo WO_Number FROM work_order WO, asset AE, invent_journal_movement IE, invent_item IT, invent_unit IU WHERE AE.AssetID="'.$_REQUEST['dataid'].'" AND WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IT.item_id=IE.item_id AND IU.id_unit=IT.id_unit';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[1].'</td>
					<td>'.$result_data_now[2].'</td>
					<td>'.$result_data_now[3].'</td>
					<td>'.$result_data_now[4].'</td>
					<td>'.$result_data_now[5].'</td>
					<td>'.$result_data_now[6].'</td>
					<td>'.$result_data_now[7].'</td>
				</tr>
			';
			$i++;
		}
		
		//==============================Total Consumen====================
		$total_cost = 0;
		$query_data = 'SELECT SUM(IE.number_of_stock*IT.avg_price) Total_Cost FROM work_order WO, asset AE, invent_journal_movement IE, invent_item IT, invent_unit IU WHERE AE.AssetID="'.$_REQUEST['dataid'].'" AND WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IT.item_id=IE.item_id AND IU.id_unit=IT.id_unit GROUP BY AE.AssetID';
		$result_data = mysql_exe_query(array($query_data,1));
		$result_data_now=mysql_exe_fetch_array(array($result_data,1));
		$total_cost = $result_data_now[0];
		
		$date = '
					<div>
						<div class="row">
							<div class="col-sm-9">
								  <div class="form-group row">
									<label class="col-sm-2 col-form-label">Periode</label>
									<div class="col-sm-5">
										<div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" id="part_first_date" placeholder="dd/mm/yyyy">
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-th"></i></span>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" id="part_second_date" placeholder="dd/mm/yyyy">
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-th"></i></span>
										</div>
									</div>
								  </div>
							</div>
						</div>
					</div>
		';
		
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">'.$date.'
							<h4 class="card-title">Part List</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							<table id="partap-popup" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> Qty Consume </th>
								  <th> Part No </th>
								  <th> Description </th>
								  <th> Available Stock </th>
								  <th> Unit </th>
								  <th> Location Code </th>
								  <th> Location </th>
								</tr>
							  </thead>
							  <tbody>
								'.$data_list.'
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- content-wrapper ends -->
			';
		
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Part Consume</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							<table id="part-popup" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> Date </th>
								  <th> Part No </th>
								  <th> Description </th>
								  <th> Qty </th>
								  <th> Unit </th>
								  <th> Unit Price </th>
								  <th> Cost </th>
								  <th> WO Number </th>
								</tr>
							  </thead>
							  <tbody>
								'.$data_table.'
							  </tbody>
							</table>
						  </div>
						  <div class="row">
							<div class="col-9"></div>
							<div class="col-3"><label class="badge badge-success" style="font-size:16px;">Total Cost : <span id="total_movement" class="text-danger">'.$total_cost.'</span></label></div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- content-wrapper ends -->
			';
		return $content;
	}
	
	//================Data Preventive Maintenance from asset============================//
	function pop_detail_wo(){
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['dataid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//=================================================
		$query_data = WORDER.' AND WO.WorkTypeID<>"WT000002" AND WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.Hidden="no" ORDER BY WO.WorkOrderNo DESC';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[12].'</td>
					<td>'.$result_data_now[14].'</td>
					<td>'.$result_data_now[10].'</td>
				</tr>
			';
			$i++;
		}
		
		$date = '
					<div>
						<div class="row">
							<div class="col-sm-9">
								  <div class="form-group row">
									<label class="col-sm-2 col-form-label">Periode</label>
									<div class="col-sm-5">
										<div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" id="wo_first_date" placeholder="dd/mm/yyyy">
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-th"></i></span>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="controls input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
											<input class="form-control" id="wo_second_date" placeholder="dd/mm/yyyy">
											<span class="add-on"><i class="icon-remove"></i></span>
											<span class="add-on"><i class="icon-th"></i></span>
										</div>
									</div>
								  </div>
							</div>
						</div>
					</div>
		';
		
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Work Order</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							'.$date.'
							<table id="partas-popup" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> WO No </th>
								  <th> Work Type </th>
								  <th> Work Status </th>
								  <th> Requestor </th>
								</tr>
							  </thead>
							  <tbody>
								'.$data_table.'
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- content-wrapper ends -->
			';
		return $content;
	}
	
	function pop_detail_report(){
		$query_data = 'SELECT COUNT(*) FROM work_order WO WHERE WorkTypeID<>"WT000002" AND WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.Hidden="no" GROUP BY WO.AssetID';
		$result_data = mysql_exe_query(array($query_data,1));
		$result_data_now=mysql_exe_fetch_array(array($result_data,1));
		if(mysql_exe_num_rows(array($result_data,1))>0){
			$total_wo = $result_data_now[0];
		}else{
			$total_wo = 0;
		}
		
		
		$query_data = 'SELECT COUNT(*) FROM work_order WO WHERE WorkTypeID="WT000002" AND WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.Hidden="no" GROUP BY WO.AssetID';
		$result_data = mysql_exe_query(array($query_data,1));
		$result_data_now=mysql_exe_fetch_array(array($result_data,1)); 
		if(mysql_exe_num_rows(array($result_data,1))>0){
			$total_pm = $result_data_now[0];
		}else{
			$total_pm = 0;
		}
		
		$query_data = 'SELECT COUNT(*) FROM work_order WO WHERE WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.Hidden="no" GROUP BY WO.AssetID';
		$result_data = mysql_exe_query(array($query_data,1));
		$result_data_now=mysql_exe_fetch_array(array($result_data,1));
		if(mysql_exe_num_rows(array($result_data,1))>0){
			$total_data = $result_data_now[0];
		}else{
			$total_data = 0;
		}
		
		$precent_wo = ($total_data==0) ? 0: $total_wo/$total_data*100;
		$precent_pm = ($total_data==0) ? 0: $total_pm/$total_data*100;
		
		//***********MTBF AND MTTF***************//
		$query_data = 'SELECT WorkOrderNo, ActDateStart, ActDateEnd FROM work_order WO WHERE WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.WorkStatusID="WS000020" AND WO.Hidden="no"';
		$result_data = mysql_exe_query(array($query_data,1));
		$i=0; $sum_wo = 0;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$datetime[$i]['dateStart'] = $result_data_now[1];
			$datetime[$i]['dateEnd'] = $result_data_now[2];
			$i++;
		}
		$sum_wo =$i;
		
		//****MTBF*********//
		$i=0; $hours = 0; $mtbf=0;
		while($i<sizeof($datetime)-1){
			$first = strtotime($datetime[$i]['dateEnd']);
			$second = strtotime($datetime[$i+1]['dateStart']);
			$diff = $first-$second;//echo $diff.'<br/>';
			$hours = $hours + $diff / ( 60 * 60 );
			$i++;
		}
		$mtbf = ($sum_wo==0) ? 0 : ROUND($hours/$sum_wo,2);
		
		//****MTTR*********//
		$i=0; $hours = 0; $mttr=0;
		while($i<sizeof($datetime)){
			$first = strtotime($datetime[$i]['dateStart']);
			$second = strtotime($datetime[$i]['dateEnd']);
			$diff = $second-$first; 
			$hours = $hours + $diff / ( 60 * 60 );
			$i++;
		}
		$mttr = ($sum_wo==0) ? 0 : ROUND($hours/$sum_wo,2);
		
		//***********DOWNTIME***************//
		$query_data = 'SELECT WorkOrderNo, ActDateStart, ActDateEnd FROM work_order WO WHERE WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.WorkTypeID="WT000003" AND WO.Hidden="no"';
		$result_data = mysql_exe_query(array($query_data,1));
		$i=0; $sum_wo = 0;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$datetime[$i]['dateStart'] = $result_data_now[1];
			$datetime[$i]['dateEnd'] = $result_data_now[2];
			$i++;
		}
		$sum_wo =$i;
		
		$i=0; $hours = 0; $downtime=0;
		while($i<sizeof($datetime)){
			$first = strtotime($datetime[$i]['dateStart']);
			$second = strtotime($datetime[$i]['dateEnd']);
			$diff = $second-$first; 
			$hours = $hours + $diff / ( 60 * 60 );
			$i++;
		}
		
		$downtime = ($sum_wo==0) ? 0 : ROUND($hours/$sum_wo,2);
		
		//*************COST Man Hour***************
		$query_data = '
					SELECT SUM(B.cost_hour*A.Hour_Time) Cost
					FROM 
					(SELECT AssetID, WorkOrderNo, ActDateStart, ActDateEnd, TIMESTAMPDIFF(HOUR, ActDateStart, ActDateEnd) Hour_Time  FROM work_order WO WHERE WO.AssetID="'.$_REQUEST['dataid'].'" AND WO.WorkStatusID="WS000010" AND WO.Hidden="no") A, work_order_manpower B
					WHERE A.WorkOrderNo = B.WorkOrderNo AND A.AssetID="'.$_REQUEST['dataid'].'"
		';
		$result_data = mysql_exe_query(array($query_data,1));
		$result_data_now=mysql_exe_fetch_array(array($result_data,1));
		$cost_man = (empty($result_data_now[0]))? 0 : $result_data_now[0];
		
		$content = '			
				<div class="row">
					<div class="col-md-8 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title mb-0">PM vs WO</h4>
							<div class="row">
							  <div class="col-md-4">
								<div class="d-flex align-items-center pb-2">
								  <div class="dot-indicator bg-danger mr-2"></div>
								  <p class="mb-0">Work Order</p>
								</div>
								<h4 class="font-weight-semibold">'.$total_wo.' ('.$precent_wo.'%)</h4>
								<div class="progress progress-md">
								  <div class="progress-bar bg-danger" role="progressbar" style="width: '.$precent_wo.'%" aria-valuenow="'.$precent_wo.'" aria-valuemin="0" aria-valuemax="'.$precent_wo.'"></div>
								</div>
							  </div>
							  <div class="col-md-4 mt-4 mt-md-0">
								<div class="d-flex align-items-center pb-2">
								  <div class="dot-indicator bg-success mr-2"></div>
								  <p class="mb-0">Preventive Maintenance</p>
								</div>
								<h4 class="font-weight-semibold">'.$total_pm.' ('.$precent_pm.'%)</h4>
								<div class="progress progress-md">
								  <div class="progress-bar bg-success" role="progressbar" style="width: '.$precent_pm.'%" aria-valuenow="'.$precent_pm.'" aria-valuemin="0" aria-valuemax="'.$precent_pm.'"></div>
								</div>
							  </div>
							  <div class="col-md-4 mt-4 mt-md-0">
								<div class="d-flex align-items-center pb-2">
								  <div class="dot-indicator bg-info mr-2"></div>
								  <p class="mb-0">Cost Man Hour</p>
								</div>
								<h4 class="font-weight-semibold">Rp. '.$cost_man.'</h4>
							  </div>
							</div>
						</div>
                    </div>
                  </div>
				  <div class="col-md-4 grid-margin stretch-card"></div>
				  <div class="col-md-9 grid-margin stretch-card">
					<div class="card">
					  <div class="card-body">
						  <h4 class="card-title mb-0">Statistic Downtime</h4>
						  <div class="col-lg-4 col-md-6 mt-md-0 mt-4">
							<div class="d-flex">
							  <div class="wrapper">
								<h3 class="mb-0 font-weight-semibold">'.$mtbf.' hrs</h3>
								<h5 class="mb-0 font-weight-medium text-primary">MTBF</h5>
								
							  </div>
							</div>
						  </div>
						  <div class="col-lg-4 col-md-6 mt-md-0 mt-4">
							<div class="d-flex">
							  <div class="wrapper">
								<h3 class="mb-0 font-weight-semibold">'.$mttr.' hrs</h3>
								<h5 class="mb-0 font-weight-medium text-primary">MTTR</h5>
							  </div>
							</div>
						  </div>
						  <div class="col-lg-4 col-md-6 mt-md-0 mt-4">
							<div class="d-flex">
							  <div class="wrapper">
								<h3 class="mb-0 font-weight-semibold">'.$downtime.' hrs</h3>
								<h5 class="mb-0 font-weight-medium text-primary">Downtime</h5>
							  </div>
							</div>
						  </div>
						</div>
					</div>
                  </div>
				  
				</div>
		';
		return $content;
	}
	
	//========================Tree Data==================================
	function tree_asset(){
		DEFINE('QUER_FROM',' FROM 
					asset A, location L, department D, asset_status S, asset_category C, critically I, supplier P, warranty_contract W, employee E, area R, plant T
					WHERE 
					A.locationID=L.locationID AND A.departmentID=D.departmentID AND A.AssetStatusID=S.AssetStatusID AND A.AssetCategoryID=C.AssetCategoryID AND A.CriticalID=I.CriticalID AND A.SupplierID=P.Supplier_ID AND A.WarrantyID=W.WarrantyID AND A.EmployeeID=E.EmployeeID AND A.AreaId=R.AreaId AND A.PlantId=T.PlantId AND A.Hidden="no"'
		);
		
		$list='';
		$q_area = 'SELECT R.AreaCode, R.AreaDescription'.QUER_FROM.' GROUP BY R.AreaCode, R.AreaDescription';
		$qe_area = mysql_exe_query(array($q_area,1));
		while($qef_area =mysql_exe_fetch_array(array($qe_area,1))){
			$list .= '<li>'.$qef_area[1].' - <span style="color:red;">'.$qef_area[0].'</span>'
							.'<ul>';
			
			$q_asset = 'SELECT  A.AssetID, A.AssetNo, A.AssetDesc'.QUER_FROM.' AND R.AreaCode="'.$qef_area[0].'"'; 
			$qe_asset = mysql_exe_query(array($q_asset,1));
			while($qef_asset =mysql_exe_fetch_array(array($qe_asset,1))){
				$list .= '<li><a href="'.PATH_ASSETS.EDIT.'&rowid='.$qef_asset[0].'">'.$qef_asset[2].'</a> - <span style="color:red;">'.$qef_asset[1].'</span></li>';
			}
			
			$list .= '
						</ul>
					</li>';
		}
		
		$content = '
			<div class="container" style="margin-top:30px;">
				<div class="row">
					<div class="col-md-12">
						<ul id="tree1">
								<p class="well" style="height:60px;"><strong>Tree Of Asset Function</strong>
								<!--<br /> <code>$(\'#tree1\').treed();</code>-->
								</p>
								<li>List Asset
									<ul>
										'.$list.'
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
		';
		return $content;
	}
	
	//========================Javascript==================================
	function asset_list_js(){
		$content = "
			<script>
				$(document).ready(function(){
					$('#info_detail').show();
					$('#info_pm').hide();
					$('#info_wo').hide();
					$('#info_part').hide();
					$('#info_report').hide();
				})
				
				$('#info').on('click',function(){
					$('#info_detail').show();
					$('#info_pm').hide();
					$('#info_wo').hide();
					$('#info_part').hide();
					$('#info_report').hide();
				})
				
				$('#pm').on('click',function(){
					$('#info_detail').hide();
					$('#info_pm').show();
					$('#info_wo').hide();
					$('#info_part').hide();
					$('#info_report').hide();
				})
				
				$('#wo').on('click',function(){
					$('#info_detail').hide();
					$('#info_pm').hide();
					$('#info_wo').show();
					$('#info_part').hide();
					$('#info_report').hide();
				})
				
				$('#part').on('click',function(){
					$('#info_detail').hide();
					$('#info_pm').hide();
					$('#info_wo').hide();
					$('#info_part').show();
					$('#info_report').hide();
				});
				
				$('#report').on('click',function(){
					$('#info_detail').hide();
					$('#info_pm').hide();
					$('#info_wo').hide();
					$('#info_part').hide();
					$('#info_report').show();
				});
				
				$('#part-popup').DataTable();
				
				$('#partas-popup').DataTable();
				
				$('#partap-popup').DataTable();
				
				$('#partam-popup').DataTable();
				
				$('.form_date').datetimepicker({
						language:  'fr',
						weekStart: 1,
						todayBtn:  1,
						autoclose: 1,
						todayHighlight: 1,
						startView: 2,
						minView: 2,
						forceParse: 0
				});
				
				$('#pm_second_date').on('change',function(){
					var first_date = $('#pm_first_date').val();
					var second_date = $('#pm_second_date').val();
					var id_asset = $('#asset_id').val();
					var data = {'first_date':first_date, 'second_date':second_date,'id_asset':id_asset};
					$('#partam-popup').empty();
					
					$.ajax({
						type: 'POST',
						url:'"._ROOT_."function/content/asset/pm_list.php',
						data:data,
						crossDomain:true,
						cache:false,
						/*beforeSend: function(){
							loading('Please wait...');
						},*/
						success:function(data){
							$('#partam-popup').append(data);
						}
					})
				})
				
				$('#wo_second_date').on('change',function(){
					var first_date = $('#wo_first_date').val();
					var second_date = $('#wo_second_date').val();
					var id_asset = $('#asset_id').val();
					var data = {'first_date':first_date, 'second_date':second_date,'id_asset':id_asset};
					$('#partas-popup').empty();
					
					$.ajax({
						type: 'POST',
						url:'"._ROOT_."function/content/asset/wo_list.php',
						data:data,
						crossDomain:true,
						cache:false,
						/*beforeSend: function(){
							loading('Please wait...');
						},*/
						success:function(data){
							$('#partas-popup').append(data);
						}
					})
				})
				
				$('#part_second_date').on('change',function(){
					var first_date = $('#part_first_date').val();
					var second_date = $('#part_second_date').val();
					var id_asset = $('#asset_id').val(); 
					var data = {'first_date':first_date, 'second_date':second_date,'id_asset':id_asset};
					$('#partap-popup').empty();
					$('#part-popup').empty();
					$('#total_movement').empty();
					
					$.ajax({
						type: 'POST',
						url:'"._ROOT_."function/content/asset/part_list_1.php',
						data:data,
						crossDomain:true,
						cache:false,
						/*beforeSend: function(){
							loading('Please wait...');
						},*/
						success:function(data){
							$('#partap-popup').append(data);
						}
					})
					
					$.ajax({
						type: 'POST',
						url:'"._ROOT_."function/content/asset/part_list_2.php',
						data:data,
						crossDomain:true,
						cache:false,
						/*beforeSend: function(){
							loading('Please wait...');
						},*/
						success:function(data){
							$('#part-popup').append(data);
						}
					})
					
					$.ajax({
						type: 'POST',
						url:'"._ROOT_."function/content/asset/part_list_3.php',
						data:data,
						crossDomain:true,
						cache:false,
						/*beforeSend: function(){
							loading('Please wait...');
						},*/
						success:function(data){
							$('#total_movement').append(data);
						}
					})
				})

			</script>
		";
		return $content;
	}
?>