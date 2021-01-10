<?php
	function item_checklist(){
		/**----- Delete -------------------*/
			if(isset($_REQUEST['delete'])){
				$query = 'DELETE FROM checklist_item WHERE id_item_check="'.$_REQUEST['rowid'].'"';
				mysql_exe_query(array($query,1));  
			}
		
			$content = '<br/><div class="ade">ITEM CHECKLIST</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
			$content .= '<br/><div id="example1" style="width: 1030px; height: 500px; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,400,80,80]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(QICHECK.' ORDER BY id_item_check DESC');
			//-------get header pada sql----------
			$name = gen_mysql_head(QICHECK.' ORDER BY id_item_check DESC');
			//-------set header pada handson------
			$sethead = "['Item Check ID','Item Check'"._USER_EDIT_SETHEAD_._USER_DELETE_SETHEAD_."]";
			//-------set id pada handson----------
			$setid = "[{data:'Item_Check',className: 'htLeft'},{data:'Description',className: 'htLeft'}"._USER_EDIT_SETID_._USER_DELETE_SETID_."]";
			//-------get data pada sql------------
			$dt = array(QICHECK.' ORDER BY id_item_check DESC',$field,array('Edit','Delete'),array(PATH_ICHECK.EDIT,PATH_ICHECK.DELETE),array());
			if (_VIEW_) $data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			$content .= get_handson($sethandson);
			//------------Jika ada halaman tambah data-------//
			if(isset($_REQUEST['add'])){
				$content = '<br/><div class="ade">ADD DATA FOR WORK PRIORITY</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_._USER_INSERT_.'</div>';
				//----- Buat Form Isian Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ICHECK.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Priority</legend>
								<table>
									<tr><td width="150"><span class="name"> Item Check </td><td>:</td> </span></td><td>'.text_je(array('icheck','','false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				//------ Aksi ketika post menambahkan data -----//
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['icheck'])){
						//-- Read Text to new code ---//
						$myFile = _ROOT_."function/inc/icheck.txt";
						$fh = fopen($myFile, 'r');
						$code = fread($fh, 21);
						fclose($fh);
						$ncode = $code+1;
						$fh = fopen($myFile, 'w+') or die("Can't open file.");
						fwrite($fh, $ncode);
						
						//-- Generate a new id untuk kategori aset --//
						$result = mysql_exe_query(array(COUNTPRIORY,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $numrow=$resultnow[0]+1; $wpid=get_new_code('IC',$ncode); 
						//-- Insert data pada kategori aset --//
						$query = 'INSERT INTO checklist_item (id_item_check ,description) VALUES("'.$wpid.'","'.$_REQUEST['icheck'].'")'; mysql_exe_query(array($query,1));
						//-- Ambil data baru dari database --//
						$querydat = QICHECK.' WHERE id_item_check="'.$wpid.'"'; 
						$content .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Item Check ID','Item Check'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_Check',className: 'htLeft'},{data:'Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ICHECK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$content .= get_handson($sethandson);
					}else{
						$content .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
			}
			//------------Jika ada halaman edit data-------//
			if(isset($_REQUEST['edit'])){ $info='';
				if(isset($_REQUEST['post'])){
					if(!empty($_REQUEST['icheck'])){
						//-- Update data pada kategori aset --//
						$query = 'UPDATE checklist_item SET description="'.$_REQUEST['icheck'].'" WHERE id_item_check="'.$_REQUEST['rowid'].'"'; mysql_exe_query(array($query,1));  
						//-- Ambil data baru dari database --//
						$querydat = QICHECK.' WHERE id_item_check="'.$_REQUEST['rowid'].'"'; 
						$info .= '<br/><div id="example1" style="width: 1335px; height: 80px; overflow: hidden; font-size=10px;"></div>';
						$width = "[200,200,80]";
						$field = gen_mysql_id($querydat);
						$name = gen_mysql_head($querydat);
						//-------set header pada handson------
						$sethead = "['Item Check ID','Item Check'"._USER_EDIT_SETHEAD_."]";
						//-------set id pada handson----------
						$setid = "[{data:'Item_Check',className: 'htLeft'},{data:'Description',className: 'htLeft'}"._USER_EDIT_SETID_."]";
						$dt = array($querydat,$field,array('Edit'),array(PATH_ICHECK.EDIT),array());
						$data = get_data_handson_func($dt);
						$fixedcolleft=0;
						$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
						$info .= get_handson($sethandson);
					}else{
						$info .= '<div class="toptext" align="center" style="color:red">Some Field is Empty</div>';
					}
				}
				//-----Ambil nilai semua data yang terkait dengan id data------//
				$querydat = QICHECK.' WHERE id_item_check="'.$_REQUEST['rowid'].'"'; $result=mysql_exe_query(array($querydat,1)); $resultnow=mysql_exe_fetch_array(array($result,1));
				$icheck=$resultnow[1]; 
				//-----Tampilan judul pada pengeditan------
				$content = '<br/><div class="ade">EDIT DATA ITEM CHECK FOR '.$icheck.'</div>';
				$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
				//----- Buat Form Isian Edit Data Berikut-----
				$content .= '<br/><div class="form-style-1"><form action="'.PATH_ICHECK.EDIT.'&rowid='.$_REQUEST['rowid'].POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Priority</legend>
								<table>
									<tr><td width="150"><span class="name"> Item Check </td><td>:</td> </span></td><td>'.text_je(array('icheck',$icheck,'false')).'</td></tr>
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
				$content.=$info;
			}
			
			return $content;
	}
?>