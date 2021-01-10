<?php
########################################################## KHUSUS PILIHAN MENU ##########################################################
	//===========Mendefinikan menu yang akan ditampilkan ==============
	//=============link menu, menu name, css ==========================
	function get_menu($list){
		$link_menu = $list[0]; $name_menu = $list[1]; $child_link=$list[2]; $child_menu=$list[3]; $css = $list[4]; 
		$i=0; $list_menu =''; $drop_menu=''; 
		while($i<sizeof($link_menu)){
			$list_menu .= '<li class="dropbtn"><a href="'.$link_menu[$i].'">'.$name_menu[$i].'</a>';
			if(sizeof($child_menu[$i])>1){
				$j=0;
				$list_menu .= '<ul><div class="dropdown-content">';
				while($j<sizeof($child_menu[$i])){
					$list_menu.='<li><a href="'.$child_link[$i][$j].'">'.$child_menu[$i][$j].'</a></li>';
					$j++;
				}
				$list_menu .= '</div></ul>';
			}
			$list_menu.='</li>';
			$i++;
		}
		
		$content = '<div '.$css.'><ul>'.$list_menu.'</ul></div>';
		return $content ;
	}
#########################################################################################################################################

########################################################## INPUT HTML ###################################################################
	//===========Fungsi textarea menggunakan TinyMCT =====
	//==============id, name, rows, cols, width===========
	function textarea_mct($style){
		$id = $style[0]; $name = $style[1]; $rows = $style[2]; $cols = $style[3]; $width = $style[4];
		$content = '<textarea id="'.$id.'" name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'" style="width: '.$width.'"></textarea>';
		return $content;
	}
#########################################################################################################################################


########################################################## HANDSON TABLE ################################################################
	//===========Fungsi menampilkan data dalam tabel pada handsontable==
	//=============Mengeset id, header dan data dengan menggunakan fungsi ========================
	//=============Untuk menampilkan data menuju fungsi get_handson pada halaman get_js.php
	//=============NOTE : NONAKTIFKAN TinyMCT di get_js.php agar bisa menggunakan handsontable
	
	//-----------Set head in header-------
	function set_head($head){
		$i = 0;
		$content = "[";
		while($i<sizeof($head)){
			if($i<(sizeof($head)-1))
				$content .= "'".$head[$i]."',";
			else if($i==(sizeof($head)-1))
				$content .= "'".$head[$i]."']";
			$i++;
		}
		return $content;
	}
	
	//-----------Set id in header----------
	function set_id($id){
		$i = 0;
		$content = "["; 
		while($i<sizeof($id)){
			if($i<(sizeof($id)-1))
				$content .= "{data:'".$id[$i]."'},";
			else if($i==(sizeof($id)-1))
				$content .= "{data:'".$id[$i]."'}]";
			$i++;
		}
		
		return $content;
	}
	
	//-----------Get data from mysql---------
	function get_data_handson($data){
		$sql = $data[0];
		$id = $data[1];
		$total = $data[2];
		
		$result = mysql_query($sql);
		$content = "[";
		if(!empty($total)){
			$content .= $total;
		}
		
		$numrow = mysql_num_rows($result); $i=0;
		while($result_now=mysql_fetch_array($result)){
			if($i<($numrow-1)){
				$content .= "{"; $j=0;
				while($j<sizeof($id)){
					if($j<(sizeof($id)-1))
						$content .= $id[$j].":'".$result_now[$j]."',";
					else if($j==(sizeof($id)-1))	
						$content .= $id[$j].":'".$result_now[$j]."'";
					$j++;
				}
				$content .= "},";
			}
			else if($i==($numrow-1)){
				$content .= "{"; $j=0;
				while($j<sizeof($id)){
					if($j<(sizeof($id)-1))
						$content .= $id[$j].":'".$result_now[$j]."',";
					else if($j==(sizeof($id)-1))	
						$content .= $id[$j].":'".$result_now[$j]."'";
					$j++;
				}
				$content .= "}";
			}	
			$i++;
		}
		
		$content .= "]";
		return $content;
	}
	
	//-----------Get data from mysql and with function edit, add, or delete---------
	function get_data_handson_func($data){
		$sql = $data[0];
		$id = $data[1];
		//$total = $data[2];
		$func = $data[2];
		$path = $data[3];
		$link_data = $data[4];
		$home_path = $data[5];
		
		$result = mysql_query($sql);
		$content = "[";
		if(!empty($total)){
			$content .= $total;
		}
		
		$numrow = mysql_num_rows($result); $i=0;
		while($result_now=mysql_fetch_array($result)){
			if($i<($numrow-1)){
				$content .= "{"; $j=0;
				while($j<sizeof($id)){
					if($j<(sizeof($id)-1))
						if(!in_array($j,$link_data))
							$content .= $id[$j].":'".$result_now[$j]."',";
						else
							//$content .= $id[$j].":'<span class=\"datalink\"><a href=\"".$path."&rowid=".$result_now[0]."\">".$result_now[$j]."</a></span>',";
							$content .= $id[$j].":'<span class=\"datalink\"><a href=\"".$home_path."&dataid=".$result_now[0]."#popup-article\">".$result_now[$j]."</a></span>',";
					else if($j==(sizeof($id)-1)){	
						//$content .= $id[$j].":'".$result_now[$j]."',".$func.":'<span class=\"editlink\"><a href=\"".$path."&rowid=".$result_now[0]."\">".$func."</a></span>'";
						$content .= $id[$j].":'".$result_now[$j]."',";
						$k=0;
						while($k<sizeof($func)){
							if($k<sizeof($func)-1)
								$content .= $func[$k].":'<span class=\"editlink\"><a href=\"".$path[$k]."&rowid=".$result_now[0]."\">".$func[$k]."</a></span>',"; 
							else
								$content .= $func[$k].":'<span class=\"editlink\"><a href=\"".$path[$k]."&rowid=".$result_now[0]."\">".$func[$k]."</a></span>'";
							$k++;
						}
					}
					$j++;
				}
				$content .= "},";
			}
			else if($i==($numrow-1)){
				$content .= "{"; $j=0;
				while($j<sizeof($id)){
					if($j<(sizeof($id)-1))
						if(!in_array($j,$link_data))
							$content .= $id[$j].":'".$result_now[$j]."',";
						else
							$content .= $id[$j].":'<span class=\"datalink\"><a href=\"".$home_path."&dataid=".$result_now[0]."#popup-article\">".$result_now[$j]."</a></span>',";
					else if($j==(sizeof($id)-1)){	
						//$content .= $id[$j].":'".$result_now[$j]."',".$func.":'<span class=\"editlink\"><a href=\"".$path."&rowid=".$result_now[0]."\">".$func."</a></span>'";
						$content .= $id[$j].":'".$result_now[$j]."',";
						$k=0;
						while($k<sizeof($func)){
							if($k<sizeof($func)-1)
								$content .= $func[$k].":'<span class=\"editlink\"><a href=\"".$path[$k]."&rowid=".$result_now[0]."\">".$func[$k]."</a></span>',"; 
							else
								$content .= $func[$k].":'<span class=\"editlink\"><a href=\"".$path[$k]."&rowid=".$result_now[0]."\">".$func[$k]."</a></span>'";
							$k++;
						}
					}
					$j++;
				}
				$content .= "}";
			}
			
			$i++;
		}
		
		$content .= "]";
		return $content;
	}
	
	//-----------Get data from array---------
	function get_data_handson_array($data){
		$arr = $data[0];
		$id = $data[1];
		$total = $data[2];
		
		$content = "[";
		if(!empty($total)){
			$content .= $total;
		}
		
		$i=0;
		while($i<sizeof($arr)){
			if($i<(sizeof($arr)-1)){
				$content .= "{"; $j=0;
				while($j<sizeof($id)){
					if($j<(sizeof($id)-1))
						$content .= $id[$j].":'".$arr[$i][$j]."',";
					else if($j==(sizeof($id)-1))	
						$content .= $id[$j].":'".$arr[$i][$j]."'";
					$j++;
				}
				$content .= "},";
			}
			else if($i==(sizeof($arr)-1)){
				$content .= "{"; $j=0;
				while($j<sizeof($id)){
					if($j<(sizeof($id)-1))
						$content .= $id[$j].":'".$arr[$i][$j]."',";
					else if($j==(sizeof($id)-1))	
						$content .= $id[$j].":'".$arr[$i][$j]."'";
					$j++;
				}
				$content .= "}";
			}	
			$i++;
		}
		
		$content .= "]"; //echo $content;
		return $content;
	}
#########################################################################################################################################

########################################################## JEASYUI TABLE ################################################################
	//===========Fungsi menampilkan data dalam tabel Jeasyui==
	//=============field, width, text, dan halaman json ========================
	//=============url pada table digunakan untuk melakukan loading halaman yang terletak pada folde function/data
	function table_jeasyui($setdata){
		$field = $setdata[0];
		$width = $setdata[1];
		$text = $setdata[2];
		$pjson = $setdata[3];
		$i = 0; $thead = '';
		while($i<sizeof($field)){
			$thead .= '<th field="'.$field[$i].'" width="'.$width[$i].'">'.$text[$i].'</th>';
			$i++;
		}
		
		$content = '<div id="f_content">
					<table id="tt" class="easyui-datagrid" title="Column Group" style="width:950px;height:530px"
							url="'._ROOT_.'function/data/'.$pjson.'"
							rownumbers="true"
							iconCls="icon-save"
							pagination="true">
						<thead>
							<tr>
								'.$thead.'
							</tr>
						</thead>
					</table>	
					</div>';
		return $content;
	}
	
	//=============Funsgi mendapatkan coloumn name untuk digunakan sebagai title pada tabel jeasyuijeasyui/handsontable==
	function gen_mysql_head($sql){
		$head = array(); $i=0;
		$result = mysql_query($sql) or die('Sorry Generate Title in Jeasyui Table Failed');
		$num_field = mysql_num_fields($result);
		while($i<$num_field){
			$head[$i] = str_replace('_',' ',mysql_field_name($result,$i));
			$i++;
		}
		
		$content = $head;
		return $content;
	}
	
	//=============Fungsi mendapatkan coloumn name untuk digunakan sebagai id pada tabel jeasyui/handsontable==
	function gen_mysql_id($sql){
		$id = array(); $i=0;
		$result = mysql_query($sql) or die('Sorry Generate Head in Jeasyui Table Failed');
		$num_field = mysql_num_fields($result);
		while($i<$num_field){
			$id[$i] = mysql_field_name($result,$i);
			$i++;
		}
		
		$content = $id;
		return $content;
	}
	
	//===========Fungsi input data file==============================================
	function text_filebox($data){
		$name = $data[0];
		$value = $data[1];
		$multiline = $data[2];
		$style = $data[3];
		$id = $data[4];
		$event = $data[5];
		$content = '<input type="text" class="easyui-filebox" name="'.$name.'" value="'.$value.'" class="'.$id.'" '.$style.' />';
		return $content;
	}
	
	//===========Fungsi input text-area data==============================================
	function text_je($data){
		$name = $data[0];
		$value = $data[1];
		$multiline = $data[2];
		$style = $data[3];
		$id = $data[4];
		$event = $data[5];
		$disabled = $data[6];
		$content = '<input type="text" class="easyui-textbox" name="'.$name.'" value="'.$value.'" multiline="'.$multiline.'" id="'.$id.'" '.$style.' '.$disabled.' />';
		return $content;
	}
	
	//===========Fungsi input text password data==============================================
	function text_pass($data){
		$name = $data[0];
		$value = $data[1];
		$multiline = $data[2];
		$style = $data[3];
		$id = $data[4];
		$event = $data[5];
		$disabled = $data[6];
		$content = '<input type="password" class="easyui-textbox" name="'.$name.'" value="'.$value.'" multiline="'.$multiline.'" id="'.$id.'" '.$style.' '.$disabled.' />';
		return $content;
	}
	
	//===========Fungsi input text date==============================================
	function date_je($data){
		$name = $data[0];
		$value = $data[1];
		//$content = '<input id="dateasyui" type="text" class="easyui-datebox" name="'.$name.'" value='.$value.'>';
		$content = '<input id="'.$name.'" type="text" class="easyui-datebox" name="'.$name.'" value='.$value.' />';
		return $content;
	}
	
	function datetime_je($data){
		$name = $data[0];
		$value = $data[1];
		$width = $data[0];
		$content = '<input class="easyui-datetimebox" name="'.$name.'" data-options="required:true,showSeconds:false" value="'.$value.'" style="width:'.$width.'" />';
		
		//<input class="easyui-datetimebox" name="birthday" data-options="required:true,showSeconds:false" value="3/4/2010 2:3" style="width:150px">
		return $content;
	}
	
	//============Fungsi megembalikan data dalam bentuk combobox ===============
	//----------With query-----------------
	function combo_je($data){
		$query = $data[0];
		$id = $data[1];
		$name = $data[2];
		$width = $data[3];
		$null_name = $data[4];
		$value = $data[5];
		$option = $null_name;
		$result = mysql_query($query);
		while($result_now=mysql_fetch_array($result)){
			if(strcmp($result_now[0],$value)==0)
				$option .= '<option value="'.$result_now[0].'" selected>'.$result_now[1].'</option>';
			else
				$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
		}
		$content = '<select id="'.$id.'" class="easyui-combobox" name="'.$name.'" style="width:'.$width.';">'.$option.'</select>';
		return $content;
	}
	
	//-----------With array -------------------
	function combo_je_arr($data){ $i=0;
		$arr = $data[0];
		$id = $data[1];
		$name = $data[2];
		$width = $data[3];
		$null_name = $data[4];
		$value = $data[5];
		$option = $null_name;
		
		while($i<sizeof($arr)){
			if(strcmp($arr[$i],$value)==0)
				$option .= '<option value="'.$arr[$i].'" selected>'.$arr[$i].'</option>';
			else
				$option .= '<option value="'.$arr[$i].'">'.$arr[$i].'</option>';
			$i++;
		}
		$content = '<select id="'.$id.'" class="easyui-combobox" name="'.$name.'" style="width:'.$width.';">'.$option.'</select>';
		return $content;
	}
	
	//============Fungsi submit di jesyui =======================================
	function submit_je($data){
		$input_type = $data[0];
		$id = $data[1];
		$method = $data[2];
		$model = $data[3];
		$input = '';
		if(strcmp($model,'default')==0){
			$i = 0;
			while($i<sizeof($input_type)){
				$input .= $input_type[$i];
				$i++;
			}
		}
		$content = '<form id="'.$id.'" method="'.$method.'">'.$input.'</form>';
		$content .= '<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Submit</a>';
		return $content;
	}
	
	//============Generate kode baru sebagai ID pada database==========
	function get_new_code($data){
		$name = $data[0];
		$val = $data[1];
		$type = $data[2];
		
		if($type==1){
			$content = $name.date('y').date('m').date('d').date('h').date('i').date('s');
		}else if($type==2){
			if($val<10){
			$content = $name.'00000'.$val;
			}else if($val>=10 && $val<100){
				$content = $name.'0000'.$val;
			}else if($val>=100 && $val<1000){
				$content = $name.'000'.$val;
			}else if($val>=1000 && $val<10000){
				$content = $name.'00'.$val;
			}else if($val>=10000 && $val<100000){
				$content = $name.'0'.$val;
			}else if($val>=100000 && $val<1000000){
				$content = $name.$val;
			}
		}		
		return $content;
	}
	
	//-------------------------------fungsi conversi tanggal-------------------------------------------------------------------------------------------//
	//-------------------------------data asli untuk code dibawah ini adalah mm/dd/yyyy , paramater yang digunakan adalah tanggal itu sendiri----------//
	function convert_date($data){
		$date=$data[0];
		$choose=$data[1];
		if(!empty($date)){
			$date = $date;
			if($choose==1){
				$arr = explode('/',$date); 
				$tahun = $arr[2];
				$bulan = $arr[0];
				$tanggal = $arr[1];
				$fus = $tahun.'-'.$bulan.'-'.$tanggal.' 00:00:00';
			}else if($choose==2){
				$arr = explode('/',$date); 
				$tahun = $arr[2];
				$bulan = $arr[0];
				$tanggal = $arr[1];
				$fus = $tahun.'-'.$bulan.'-'.$tanggal;
			}else if($choose==3){
				$arr = explode('-',$date); 
				$tahun = $arr[0];
				$bulan = $arr[1];
				$tanggal = $arr[2];
				if($tahun!='0000' && $bulan!='00' && $tanggal!='00')
					$fus = $bulan.'/'.$tanggal.'/'.$tahun;
				else
					$fus = '';
			}
		}else{
			$fus = '';
		}
		return $fus;
	}
	
	function convert_date_time($data){
		$date=$data[0];
		$choose=$data[1];
		if(!empty($date)){
			if($choose==1){
				$arr = explode('/',$date);
				$bulan = $arr[0];
				$tanggal = $arr[1];
				$thn_time = explode(' ',$arr[2]);
				$tahun = $thn_time[0];
				$hour_minute = explode(':',$thn_time[1]);
				$jam = $hour_minute[0];
				$minute = $hour_minute[1];
				$fus = $tahun.'-'.$bulan.'-'.$tanggal.' '.$jam.':'.$minute.':00';
			}else if($choose==2){
				if($date!=='0000-00-00 00:00:00'){
					$arr = explode('-',$date);
					$tahun = $arr[0];
					$bulan = $arr[1];
					$thn_time = explode(' ',$arr[2]);
					$tanggal = $thn_time[0];
					$hour_minute = explode(':',$thn_time[1]);
					$jam = $hour_minute[0];
					$minute = $hour_minute[1];
					$fus = $bulan.'/'.$tanggal.'/'.$tahun.' '.$jam.':'.$minute;
				}else{
					$fus = '';
				}
			}
		}else{
			$fus='';
		}
		return $fus;
	}
	
	//====================Function for create form================
	function create_form($data){
		$title = $data[0]; //title of form using fieldset of legend
		$page = $data[1]; //page for posting
		$type = $data[2]; //type of form to create
		$name_field = $data[3]; //name of field
		$input_type = $data[4]; //type of input
		$signtofill = $data[5];  
		if($type==1){
			$i=0;
			while($i<sizeof($name_field)){
				$row_field .= '<tr><td width="150"><span class="name"> '.$name_field[$i].' </td><td>:</td> </span></td><td>'.$input_type[$i].$signtofill[$i].'</td></tr>';
				$i++;
			}
		
			$content .= '<br/><div class="form-style-1"><form action="'.$page.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">'.$title.'</div>
								<table>
									'.$row_field.'
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
		}
		return $content;
	}
#########################################################################################################################################
?>