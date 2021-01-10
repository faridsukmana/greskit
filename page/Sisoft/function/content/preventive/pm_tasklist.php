<?php
	function pm_tasklist(){
		$content = '<br/><div class="ade">PM TASK LIST</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
		$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom -------------
		$width = "[200,300,800,200,80,90]";
		//-------get id pada sql -------------
		$field = gen_mysql_id(PMCHEK_DETAIL);
		//-------get header pada sql----------
		$name = gen_mysql_head(PMCHEK_DETAIL);
		//-------set header pada handson------
		$sethead = "['Check List No','Check List Name','Task','Form Name'"._USER_EDIT_SETHEAD_._USER_SPAREPART_SETHEAD_."]";
		//-------set id pada handson----------
		$setid = "[{data:'Check_List_No',className: 'htLeft'},{data:'Check_List_Name',className: 'htLeft'},{data:'Task',className: 'htLeft',renderer: 'html'},{data:'Form_Name',className: 'htLeft'}"._USER_EDIT_SETID_._USER_SPAREPART_SETID_."]";
		//-------get data pada sql------------
		$dt = array(PMCHEK_DETAIL,$field,array('Edit','List'),array(PATH_PMCHEK.EDIT,PATH_PMCHEK.SPARE),array());
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=2;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		if (_VIEW_) $content .= get_handson($sethandson);
		if(isset($_REQUEST['add'])){
			$content = '<br/><div class="ade">ADD DATA FOR PM TASK LIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			//----- Buat Form Isian Berikut-----
			$content .= '<br/><div class="form-style-1"><form action="'.PATH_PMCHEK.ADD.POST.'" method="post" enctype="multipart/form-data">
						<fieldset><div class="card-header text-center">PM Task List</div>
							<table>
								<tr><td width="150"><span class="name"> PM Task Name </td><td>:</td> </span></td><td>'.text_je(array('pmname','','false')).'</td></tr>
								<tr><td width="150"><span class="name"> PM Check List </td><td>:</td> </span></td><td>'.text_je(array('pmlist','','true','style="width:150%;height:80px"')).'</td></tr>
								<tr><td width="150"><span class="name"> PM Form </td><td>:</td> </span></td><td>'.combo_je(array(COMBFORMCK,'form','form',220,'<option value="">-</option>','')).'</td></tr>
								<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
							</table>
						</fieldset>
						</form></div>';
			//------ Aksi ketika post menambahkan data -----//
			if(isset($_REQUEST['post'])){
				if(!empty($_REQUEST['pmname']) && !empty($_REQUEST['pmlist'])){
					//-- Generate a new id untuk kategori aset --//
					$result = mysql_exe_query(array(COUNTPMCHEK,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $pmid=get_new_code('PM',$numrow); 
					//-- Insert data pada kategori aset --//
					$query = 'INSERT INTO pm_checklist (CheckListNo ,CheckListName, Task, id_form_checklist) VALUES("'.$pmid.'","'.$_REQUEST['pmname'].'","'.$_REQUEST['pmlist'].'","'.$_REQUEST['form'].'")'; mysql_exe_query(array($query,1));
					//-- Ambil data baru dari database --//
					$querydat = PMCHEK.' WHERE CheckListNo="'.$pmid.'"'; 
					$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
					$width = "[200,300,800,80]";
					$field = gen_mysql_id($querydat);
					$name = gen_mysql_head($querydat);
					//-------set header pada handson------
					$sethead = "['Check List No','Check List Name','Task'"._USER_EDIT_SETHEAD_."]";
					//-------set id pada handson----------
					$setid = "[{data:'Check_List_No',className: 'htLeft'},{data:'Check_List_Name',className: 'htLeft'},{data:'Task',className: 'htLeft',renderer: 'html'}"._USER_EDIT_SETID_."]";
					$dt = array($querydat,$field,array('Edit'),array(PATH_CHEK.EDIT),array());
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
				if(!empty($_REQUEST['pmname']) && !empty($_REQUEST['pmlist'])){
					//-- Update data pada kategori aset --//
					$query = 'UPDATE pm_checklist SET CheckListName="'.$_REQUEST['pmname'].'", Task="'.$_REQUEST['pmlist'].'", id_form_checklist="'.$_REQUEST['form'].'" WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
					//-- Ambil data baru dari database --//
					$querydat = PMCHEK.' WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; 
					$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
					$width = "[200,300,800,80]";
					$field = gen_mysql_id($querydat);
					$name = gen_mysql_head($querydat);
					//-------set header pada handson------
					$sethead = "['Check List No','Check List Name','Task'"._USER_EDIT_SETHEAD_."]";
					//-------set id pada handson----------
					$setid = "[{data:'Check_List_No',className: 'htLeft'},{data:'Check_List_Name',className: 'htLeft'},{data:'Task',className: 'htLeft',renderer: 'html'}"._USER_EDIT_SETID_."]";
					$dt = array($querydat,$field,array('Edit'),array(PATH_PMCHEK.EDIT),array());
					$data = get_data_handson_func($dt);
					$fixedcolleft=0;
					$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
					$info .= get_handson($sethandson);
				}else{
					$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
				}
			}
			//-----Ambil nilai semua data yang terkait dengan id data------//
			$querydat = PMCHEK.' WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
			$pmname=$resultnow[1]; $pmlist=$resultnow[2]; $form=$resultnow[3];
			//-----Tampilan judul pada pengeditan------
			$content = '<br/><div class="ade">EDIT DATA PM TASK LIST FOR '.$pmname.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			//----- Buat Form Isian Edit Data Berikut-----
			$content .= '<br/><div class="form-style-1"><form action="'.PATH_PMCHEK.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
						<fieldset><div class="card-header text-center">PM Task List</div>
							<table>
								<tr><td width="150"><span class="name"> PM Task Name </td><td>:</td> </span></td><td>'.text_je(array('pmname',$pmname,'false')).'</td></tr>
								<tr><td width="150"><span class="name"> PM Check List </td><td>:</td> </span></td><td>'.text_je(array('pmlist',$pmlist,'true','style="width:150%;height:80px"')).'</td></tr>
								<tr><td width="150"><span class="name"> PM Form </td><td>:</td> </span></td><td>'.combo_je(array(COMBFORMCK,'form','form',220,'<option value="">-</option>',$form)).'</td></tr>
								<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
							</table>
						</fieldset>
						</form></div>';
			$content.=$info;
		}
		
		//------------Jika ada halaman menambah daftar spare part pada PM Tasklist-------//
		if(isset($_REQUEST['spare'])){
		    //======Dilakukan posting======//
			if(isset($_REQUEST['post'])){
			    //-- Insert data pada kategori aset --//
				$field = array(
						'CheckListNo', 
						'item_id');
				$value = array(
						'"'.$_REQUEST['rowid'].'"',
						'"'.$_REQUEST['spare'].'"'); 
				$query = mysql_stat_insert(array('pm_invent_checklist',$field,$value)); 
				mysql_exe_query(array($query,1)); 
			}
			
			if(isset($_REQUEST['delspare']) && isset($_REQUEST['delete'])){
				$con = 'CheckListNo="'.$_REQUEST['pm'].'" AND item_id="'.$_REQUEST['rowid'].'"'; 
				$sparepart = query_delete(array(PATH_PMCHEK.SPARE.'&rowid='.$_REQUEST['pm'], 'pm_invent_checklist', $con));	
			}
		    
		    //-----Tampilan judul pada spare part------
		    //-----Ambil nilai semua data yang terkait dengan id data------//
			$querydat = PMCHEK.' WHERE CheckListNo="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
			$pmname=$resultnow[1]; $pmlist=$resultnow[2]; $form=$resultnow[3];
			//-----Tampilan judul pada pengeditan------
			$content = '<br/><div class="ade">SPARE PART, PM TASK LIST FOR '.$pmname.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			//----- Buat Form Isian Edit Data Berikut-----
			DEFINE('COMBSPAREWO','SELECT item_id, item_description FROM invent_item WHERE item_id NOT IN (SELECT item_id FROM pm_invent_checklist WHERE CheckListNo="'.$_REQUEST['rowid'].'")');  
			$name_field=array('Spare Part');
			$input_type=array(
					combo_je(array(COMBSPAREWO,'spare','spare',180,'',''))
			);
			$signtofill = array('');
			$sparepart .= '<div title="Spare Part" style="padding:10px">'.create_form(array(TSPAREPART,PATH_PMCHEK.SPARE.'&rowid='.$_REQUEST['rowid'].POST,1,$name_field,$input_type,$signtofill));
			$content .= $sparepart;
			
			//=====Tampilkan data ========//
			$queryspare = QSPAREPART3.' AND PM.CheckListNo="'.$_REQUEST['rowid'].'"'; 
		    //-------set lebar kolom -------------
			$width = "[200,400,100,100]";
			//-------get id pada sql -------------
			$field = gen_mysql_id($queryspare);
			//-------get header pada sql----------
			$name = gen_mysql_head($queryspare);
			//-------set header pada handson------
			$sethead = "['Item Code','Item Name','Quantity'"._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Item_Code',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Quantity',className: 'htLeft'}"._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array($queryspare,$field,array('Delete'),array(PATH_PMCHEK.SPARE.'&pm='.$_REQUEST['rowid'].DELPSPARE),array());
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'sparepart');
			//--------fungsi hanya untuk meload data
			$content.= '
						<div id="sparepart" style="width: 1030px; height: 280px; overflow: hidden; font-size=10px;"></div>'.get_handson_id($sethandson).'</div>';
		}
		
		//------------Halaman upload templater-------//
		if(isset($_REQUEST['upload'])){
			$content = '<br/><div class="ade">UPLOAD PM TASK LIST DATA USING EXCEL</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_PMCHEK.UPLOAD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Upload Excel PM Task</div>
								<table>
									<tr><td width="150" colspan="3"><span class="editlink"><a href="'._ROOT_.'file/pmtask.xls">Download Excel Format</a></span></td></tr>
									<tr><td width="150"><span class="name"> PM Task List </td><td>:</td> </span></td><td>'.text_filebox(array('pmtask','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
							
				//------ Aksi ketika post upload data -----//
				if(isset($_REQUEST['post'])){
					try{
						$typeupload = 1; $sizeupload = 1;
						$target_dir = _ROOT_.'file/';
						$target_file = $target_dir.basename($_FILES['pmtask']['name']);
						$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
						if($filetype!='xls'){
							$content .= '<div class="alert alert-danger" align="center">Sorry, only XLS files are allowed</div>';
							$typeupload = 0;
						}
						
						if($_FILES['pmtask']['size']>500000){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your files is too large (Max 500KB)</div>';
							$sizeupload = 0;
						}
						
						if($typeupload==0 || $sizeupload==0){
							$content .= '<div class="alert alert-danger" align="center">Sorry, your file not uploaded</div>';
						}else{
							if(!move_uploaded_file($_FILES['pmtask']['tmp_name'],$target_file)){
								throw new RuntimeException('<div class="alert alert-danger" align="center"> Failed to move uploaded file. Your file still open</div>.');
							}else{
								parseExcel($target_file,0,'pmtask');
								$content .= '<div class="alert alert-success" align="center"> The File '.basename($_FILES['pmtask']['name']).' has been uploaded</div>';
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