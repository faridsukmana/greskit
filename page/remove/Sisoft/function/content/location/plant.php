<?php
    function plant(){
         /**----- Delete -------------------*/
		if(isset($_REQUEST['delete'])){
			$query = 'DELETE FROM plant WHERE PlantId="'.$_REQUEST['rowid'].'"';
			mysql_exe_query(array($query,1));  
		}
        
        $content = '<br/><div class="ade">PLANT</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
		$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
		//-------set lebar kolom -------------
		$width = "[110,110,400,80,80]";
		//-------get id pada sql -------------
		$field = gen_mysql_id(PLANT.' ORDER BY PlantId DESC');
		//-------get header pada sql----------
		$name = gen_mysql_head(PLANT.' ORDER BY PlantId DESC');
		//-------set header pada handson------
		$sethead = "['Plant ID','Plant Code','Plant Description'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
		//-------set id pada handson----------
		$setid = "[{data:'Plant_ID',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Plant_Description',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
		//-------get data pada sql------------
		$dt = array(PLANT.' ORDER BY PlantId DESC',$field,array('Edit','Delete'),array(PATH_PLANT.EDIT,PATH_PLANT.DELETE),array());
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=2;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
		//--------fungsi hanya untuk meload data
		if (_VIEW_) $content .= get_handson($sethandson);
		if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR PLANT</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Tambah Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_PLANT.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Area</div>
								<table>
									<tr><td width="150"><span class="name"> Plant Code </td><td>:</td> </span></td><td>'.text_je(array('plantcode','','false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Plant Desc. </td><td>:</td> </span></td><td>'.text_je(array('plantdes','','false')).' *</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['plantcode']) && !empty($_REQUEST['plantdes'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/plant.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$areaid=get_new_code('PL',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO plant (PlantId,PlantCode,PlantDescription) VALUES("'.$areaid.'","'.$_REQUEST['plantcode'].'","'.$_REQUEST['plantdes'].'")'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = PLANT.' AND PlantId="'.$areaid.'"';
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[110,110,400,80,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
                		$sethead = "['Plant ID','Plant Code','Plant Description'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
                		//-------set id pada handson----------
                		$setid = "[{data:'Plant_ID',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Plant_Description',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_PLANT.EDIT,PATH_PLANT.DELETE),array());
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
					if(!empty($_REQUEST['plantcode']) && !empty($_REQUEST['plantdes'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE plant SET PlantCode="'.$_REQUEST['plantcode'].'", PlantDescription="'.$_REQUEST['plantdes'].'" WHERE PlantId="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1)); 
						//-- Ambil data baru dari database --//
						$querydat = PLANT.' AND PlantId="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[110,110,400,80,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Plant ID','Plant Code','Plant Description'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Plant_ID',className: 'htLeft'},{data:'Plant_Code',className: 'htLeft'},{data:'Plant_Description',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
						$dt = array($querydat,$field,array('Edit','Delete'),array(PATH_PLANT.EDIT,PATH_PLANT.DELETE),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="alert alert-danger" align="center">Some Field is Empty</div>';
					}
				}
		    //-----Ambil nilai semua data yang terkait dengan id data------//
			$querydat = PLANT.' AND PlantID="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
			$areacode=$resultnow[1]; $areades=$resultnow[2];  
			//-----Tampilan judul pada pengeditan------
			$content = '<br/><div class="ade">EDIT DATA FOR PLANT FOR '.$areacode.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			//----- Buat Form Isian Edit Data Berikut-----
			$content .= '<br/><div class="form-style-1"><form action="'.PATH_PLANT.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Location</div>
								<table>
									<tr><td width="150"><span class="name"> Plant Code </td><td>:</td> </span></td><td>'.text_je(array('plantcode',$areacode,'false')).' *</td></tr>
									<tr><td width="150"><span class="name"> Plant Desc. </td><td>:</td> </span></td><td>'.text_je(array('plantdes',$areades,'false')).' *</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
		}
        return $content;
    }
?>