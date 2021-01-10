<?php
//#############################FUNGSI UTAMA DALAM GENERATE DATAGRID##################################//
	//----function sum table, coloumn u want to show--------------------------//
	// 1. berfungsi untuk memecahkah field yang dipilih pada tabel database sesuai dengan angka 0123,11.,12. sehing akan ditampung dalam array 0 1 2 3 11 12
	// 2. function ini berfungsi untuk memanggil field atau arrow yang digunakan sebagai judul kolom dari tabel sebuah website
	function get_num_tab($coloumn){
		//----------Get sum of coloum in query ---------------------------//
		$sum_tb = 0;
		for($i=0; $i<strlen($coloumn); $i++){
			if(strcmp($coloumn[$i],',')==0){
				$i++;
				$char = $coloumn[$i];
				$i++;
				while(strcmp($coloumn[$i],'.')!=0){
					$char .= $coloumn[$i];
					$i++;
				}
				$table[$sum_tb] = (int)$char; 
				$sum_tb++;
			}else{
				$table[$sum_tb] = (int)$coloumn[$i];
				$sum_tb++;
			}
		}
		//----------------------------------------------------------------//
		return $table;
	}
	
	//----fungsi untuk memilih model dari data grid------------
	function model_tab($num_mod){
		if($num_mod==0){
			$content = "halign:'center'";
		}else if($num_mod==1){
			$content = "width:400,halign:'center'";
		}else if($num_mod==2){
			$content = "width:100,editor:'textbox'";
		}else if($num_mod==3){
			$content = "width:80,align:'right',editor:{type:'numberbox',options:{precision:1}}";
		}else if($num_mod==4){
			$content = "width:80,align:'right',editor:'numberbox'";
		}
		return $content;
	}
	
	//----fungsi searching data---------------------------------
	function get_search(){
		return $content;
	}
	
	//----fungsi utama untuk proses pemanggilan data grid dan pengaturan tabel----
	//----1. Judul, 2. Query, 3. Jenis model data grid tiap tabel 012.12,.13, 4. model toolbar, 5. Lebar, 6. tinggi
	//----7. Manual thead or no
	function get_table_jeasy($title_tab,$query,$num_col,$num_toolbar,$width,$height,$mhead){ 
		$num_tab = get_num_tab($num_col);
		$result = mysql_query($query) or die("failed"); 
		
		$coloumn = mysql_num_fields($result); 
		$i = 0;
		
		//----Menentukan jenis head dari tabel -----------------
		if(strcmp($mhead,'JANUARY')==0 || strcmp($mhead,'FEBRUARY')==0 || strcmp($mhead,'MARCH')==0 || strcmp($mhead,'APRIL')==0 || strcmp($mhead,'MAY')==0 || strcmp($mhead,'JUNE')==0 || strcmp($mhead,'JULY')==0 || strcmp($mhead,'AUGUST')==0 || strcmp($mhead,'SEPTEMBER')==0 || strcmp($mhead,'OCTOBER')==0 || strcmp($mhead,'NOVEMBER')==0 || strcmp($mhead,'DECEMBER')==0 || strcmp($mhead,'OVAUGUST')==0){
			while($i<$coloumn){
				$title = str_replace('_',' ',strtoupper(mysql_field_name($result,$i)));
			//	$field = str_replace('_','',strtolower($title));
				$ar_title[$i] = strtolower(mysql_field_name($result,$i)); 
				$i++; 
			}
			$thead = get_manual_head($query,$mhead);
		}else if(strcmp($mhead,'PURCHASING')==0){ 
			while($i<$coloumn){
				$title = str_replace('_',' ',strtoupper(mysql_field_name($result,$i)));
				$ar_title[$i] = strtolower(mysql_field_name($result,$i)); 
				$i++; 
			}
			$thead = get_manual_head($query,$mhead);
		}else{
			while($i<$coloumn){
				$title = str_replace('_',' ',strtoupper(mysql_field_name($result,$i)));
			//	$field = str_replace('_','',strtolower($title));
				$ar_title[$i] = strtolower(mysql_field_name($result,$i));  
				$field = $ar_title[$i];
				if(strcmp($mhead,'SHOWRF-P')==0){ 
					$width = 'width=85';
				}
				$thead .= "<th ".$width." data-options=\"field:'".$field."',".model_tab($num_tab[$i])."\">".$title."</th>"; 
				$i++; 
			}
			$thead = "<thead><tr>".$thead."</tr></thead>"; 
		}
		
		//----Membentuk body table-------------------------------
		$body_table = "<table id=\"dg\" class=\"easyui-datagrid\" title=\"".$title_tab."\" style=\"width:".$width."px;height:".$height."px\" nowrap=\"false\" 
			data-options=\"
			rownumbers:true,
			singleSelect:true,
			pagination:false";
			
		if(strcmp($mhead,'THEME FOR USE GROUP VIEW')==0){
			$body_table .= "
			view:groupview,
            groupField:'group_name',
            groupFormatter:function(value,rows){
                return value;
             }";
		}else if(strcmp($mhead,'THDBUDGET')==0){
			$body_table .="
			sortOrder:'asc'
			";
		}
		
		$body_table .= "\" toolbar=\"#toolbar\">".$thead."</table>";
		$content .= $body_table;
		
		//-------perintah menyisipkan toolbar-----------------
		$content .= get_toolbar($num_toolbar);
		//-------perintah mengambil data pada query-----------
		$content .= get_data_temp($query,$ar_title,$coloumn);
		//$content .= get_data_json($query);
		return $content;
	}

	//---fungsi menambahkan toolbar--------
	function get_toolbar($num_toolbar){
		$num_tool = get_num_tab($num_toolbar);
		$i=0; $toolbar = '';
		while($i<sizeof($num_tool)){
			if($num_tool[$i]==0)
				$toolbar .= "<a href=\"javascript:void(0)\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-add',plain:true\" onclick=\"newit()\">Add</a>";
			else if($num_tool[$i]==1)
				$toolbar .= "<a href=\"javascript:void(0)\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-edit',plain:true\" onclick=\"editit()\">Edit</a>";
			else if($num_tool[$i]==2)
				$toolbar .= "<a href=\"javascript:void(0)\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-remove',plain:true\" onclick=\"removeit()\">Remove</a>";
			else if($num_tool[$i]==3)
				$toolbar .= "<a href=\"javascript:void(0)\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-save',plain:true\" onclick=\"accept()\">Save</a>";
			else if($num_tool[$i]==4)
				$toolbar .= "<a href=\"javascript:void(0)\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-undo',plain:true\" onclick=\"reject()\">Undo</a>";
			$i++;
		}
		
		$content = '<div id="toolbar">'.$toolbar.'</div>';
		return $content;
	}
	
	//---fungsi untuk mendapatkan data dalam bentuk json
	function get_data_json($query){
		$arr_result = array();
		$result = mysql_query($query) or die("failed");
		while($result_now=mysql_fetch_object($result)){
			array_push($arr_result,$result_now);
		}
	//	$res[$result_now] = $arr_result; 
		return json_encode($arr_result); 
	}
	
	//---fungsi untuk mendapatkan pada tabel----
	function get_data_temp($query,$ar_title,$coloumn){
		$result = mysql_query($query) or die("failed");
		$num_rows = mysql_num_rows($result);
		while($result_now=mysql_fetch_array($result)){
			$data .= '{';
		//	$i=0;
			for($i=0; $i<$coloumn; $i++){
			//while($i<$coloumn){
				if(is_numeric($result_now[$i]) && $i!=$coloumn-1){
					$data .= '"'.$ar_title[$i].'":'.$result_now[$i].',';
				}else if(!is_numeric($result_now[$i]) && ($i<$coloumn-1)){
					$data .= '"'.$ar_title[$i].'":"'.str_replace(array("\n","\r",'"'),' ',$result_now[$i]).'",';
				}else if($i==$coloumn-1){
					$data .= '"'.$ar_title[$i].'":"'.str_replace(array("\n", "\r",'"'),' ',$result_now[$i]).'"';
				}
			//	$i++;
			}
			$data .= '},';
		}
		$data .= '.'; $data = rtrim($data,',.');
		
		$content = '
		<script type="text/javascript">
			var data = 	[
				'.$data.'
			];
		</script>';
		return $content;
	}
	
	//---fungsi input di jeasyui -----------------------
	//--- Parameter yang digunakan terdiri dari query jika tipe input select menggunakan query
	//--- Input digunakan untuk memilih jenis input 
	//--- Type digunakan untuk memiliih jika tipe input select apakah menggunakan array atau query
	//--- Title digunakan untuk memberikan judul isian disamping input
	//--- Mendefinisikan lebar dari input
	//--- Isi di dalam array ($query,$input,$type,$title,$name,$width)
	function input_jeasyui($array_input){
		$query = $array_input[0];
		$input = $array_input[1];
		$type = $array_input[2];
		$title = $array_input[3];
		$name = $array_input[4];
		$width = $array_input[5]; 
		$value = $array_input[6];
		
		//--------Type Select ---------------
		if(strcmp($input,'select')==0){
			if(strcmp($type,'array')==0){
				$i = 0;
				$content = '<td>'.$title.'</td>';
				while($i<sizeof($query)){
					if(strcmp($value,$query[$i])==0){
						$option .= '<option value="'.$query[$i].'" selected="true">'.$query[$i].'</option>';
					}else{
						$option .= '<option value="'.$query[$i].'">'.$query[$i].'</option>';
					}
					
					$i++;
				}
				
				$content .= '<td><select class="easyui-combobox" name="'.$name.'" style="width:'.$width.'px">
								'.$option.'
							 </select></td>';
			}
		}
		
		//--------Type input text ------------
		else if(strcmp($input,'text')==0){
			$content = '<td>'.$title.'</td>';
			if(empty($value))
				$content .= '<td><input class="easyui-textbox" type="text" name="'.$name.'" style="width:'.$width.'px"></input></td>';
			else
				$content .= '<td><input class="easyui-textbox" type="text" name="'.$name.'" style="width:'.$width.'px" value="'.$value.'"></input></td>';
		}
		
		//--------Type input textarea ------------
		else if(strcmp($input,'textarea')==0){
			if(empty($value))
				$content .= '<textarea class="easyui-textbox" name="'.$name.'" data-options="multiline:true" style="width:'.$width.'px; height:60px"></textarea>';
			else
				$content .= '<textarea class="easyui-textbox" name="'.$name.'" data-options="multiline:true" style="width:'.$width.'px; height:60px">'.$value.'</textarea>';
		}
		
		//--------Type datetime---------------
		else if(strcmp($input,'datetime')==0){
			$content = '<td>'.$title.'</td>';
			$content .= '<td><input class="easyui-datetimebox" style="width:'.$width.'px" name="'.$name.'"></input></td>';
		}
		
		//--------Type input date-------------
		else if(strcmp($input,'date')==0){
			$content = '<td>'.$title.'</td>';
			if(!empty($value)){
				$date = explode('-',$value); 
				$tahun = $date[0];
				$tanggal = $date[2];
				$bulan = $date[1];
				if (checkdate($bulan, $tanggal, $tahun)){
					$value = $bulan.'/'.$tanggal.'/'.$tahun;
					$content .= '<td><input class="easyui-datebox" style="width:'.$width.'px" name="'.$name.'" value="'.$value.'"></input></td>';
				}else{
					$content .= '<td><input class="easyui-datebox" style="width:'.$width.'px" name="'.$name.'"></input></td>';
				}
			}else{
				$content .= '<td><input class="easyui-datebox" style="width:'.$width.'px" name="'.$name.'"></input></td>';
			}
			
		}
		
		//--------Type hidden ----------------
		else if(strcmp($input,'hidden')==0){
			$content .= '<td><input type="hidden" name="'.$name.'" value="'.$value.'"></input></td>';
		}
		
		//--------Type submit ----------------
		else if(strcmp($input,'submit')==0){
			$content .= '<td><input type="submit" name="submit" value="'.$name.'" class="easyui-linkbutton" style="width:90px;" name="'.$name.'"></input></td>';
		}
		
		//--------Type button---------------
		else if(strcmp($input,'button')==0){
			$content .= '<td><a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveData()" style="width:90px">'.$name.'</a></td>';
		}
		
		//--------Type reset ----------------
		else if(strcmp($input,'reset')==0){
			$content .= '<td><input type="reset" name="reset" value="'.$name.'" class="easyui-linkbutton" style="width:90px;"></input></td>';
		}
		
		return $content;
	}
	
	//--- fungsi untuk membuat tag form dari beberapa input-----
	//--- Page berfungsi mendefinisikan halaman untuk melakukan posting
	//--- Input berfungsi memanggil fungsi input yang terdapat dalam isi array
	//--- Isi (page,input)
	function form_concate($array_form){
		$i=0;
		$page = $array_form[0];
		$input = $array_form[1]; 
		while($i<sizeof($input)){
			$type_input = $array_form[1][$i];
			$i++; 
			if(($i%2)==0){
				$data_input .= $type_input.'<tr/>';
			}else if(($i%2)==1 && $i<>sizeof($input)){
				$data_input .= '<tr>'.$type_input;
			}else if(($i%2)==1 && $i==sizeof($input)){
				$data_input .= '<tr>'.$type_input.'</tr>';
			}
		}
		
		$content = '
				<form id="ff" action="'.$page.POST.'" method="POST" enctype="multipart/form-data">
					<table cellpadding="5">
					 '.$data_input.'
					</table>
				</form>';
		return $content; 
	}
	
	//---fungsi membuat thead manual pada tabel --------
	function get_manual_head($query,$thead){
		if(strcmp($thead,'JANUARY')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\" data-options=\"halign:'center'\">JANUARY ".date('Y')."</th>
						<th colspan=\"4\" data-options=\"halign:'center'\">JANUARY - JANUARY ".date('Y')."</th>
						<th colspan=\"4\" data-options=\"halign:'center'\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\" data-options=\"halign:'center'\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'january_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\" data-options=\"halign:'center'\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_january_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_january_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\" data-options=\"halign:'center'\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST FEB DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN FEB DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\" data-options=\"halign:'center'\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\" data-options=\"halign:'center'\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_january',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_january',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
					
				</thead>";
		}else if(strcmp($thead,'FEBRUARY')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">FEBRUARY ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - FEBRUARY ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'february_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'february_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_february_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_february_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST MAR DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN MAR DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_february',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_february',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_february',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_february',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'MARCH')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">MARCH ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - MARCH ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'march_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'march_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_march_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_march_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST APR DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN APR DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_march',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_march',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_march',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_march',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'APRIL')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">APRIL ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - APRIL ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'april_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'april_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_april_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_april_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST MAY DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN MAY DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_april',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_april',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_april',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_april',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'MAY')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">MAY ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - MAY ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'may_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'may_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_may_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_may_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST JUN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN JUN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_may',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_may',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_may',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_may',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'JUNE')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">JUNE ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - JUNE ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'june_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'june_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_june_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_june_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST JUL DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN JUL DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_june',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_june',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_june',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_june',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'JULY')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">JULY ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - JULY ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'july_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'july_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_july_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_july_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST AUG DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN AUG DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_july',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_july',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_july',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_july',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'AUGUST')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">AUGUST ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - AUGUST ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'august_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'august_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_august_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_august_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST SEP DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN SEP DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_august',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_august',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_august',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_august',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'SEPTEMBER')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">SEPTEMBER ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - SEPTEMBER ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'september_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'september_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_september_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_september_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST OCT DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN OCT DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_september',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_september',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_september',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_september',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'OCTOBER')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">OCTOBER ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - OCTOBER ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'october_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'october_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_october_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_october_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST NOV DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN NOV DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_october',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_october',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_october',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_october',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'NOVEMBER')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">NOVEMBER ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - NOVEMBER ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'november_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'november_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_november_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_november_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST DEC DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN DEC DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_november',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_november',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_november',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_november',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'DECEMBER')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">DECEMBER ".date('Y')."</th>
						<th colspan=\"4\">JANUARY - DECEMBER ".date('Y')."</th>
						<th colspan=\"4\">".date('Y')."</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"3\" data-options=\"field:'plan_2016',halign:'center'\">".(date('Y')+1)."</th>
						<th colspan=\"4\">VARIANCE</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'december_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'december_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatDetailSomeMonth' rowspan=\"2\" data-options=\"field:'january_december_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'january_december_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_sep_dec',halign:'center'\">EST DEC DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_sep_dec',halign:'center'\">PLAN DEC DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'estimated_jan_dec',halign:'center'\">EST JAN DEC</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'plan_jan_dec',halign:'center'\">PLAN JAN DEC</th>
						<th colspan=\"2\">EST VS PLAN ".date('Y')."</th>
						<th colspan=\"2\">EST VS PLAN ".(date('Y')+1)."</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_december',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_december',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_january_december',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_january_december',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_15',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_15',halign:'center'\">PERCENT</th>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'va_est_vs_plan_2016',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'pa_est_vs_plan_2016',halign:'center'\">PERCENT</th>
						
					</tr>
				</thead>";
		}else if(strcmp($thead,'PURCHASING')==0){
		$content = "
		<thead>
			<tr>
				<th colspan=6 align=\"center\"><b>Plan PO Data<b></th>
				<th colspan=9 align=\"center\"><b>PO Header Data<b></th>
				<th colspan=5 align=\"center\"><b>PO Line Data<b></th>
				<th colspan=2 align=\"center\"><b>Vendor Data<b></th>
			</tr>	
			<tr>
				<th data-options=\"field:'pr_no',halign:'center'\">NO</th>
				<th data-options=\"field:'pr_createdby',halign:'center'\">PR CREATEDBY</th>
				<th data-options=\"field:'pr_createddate',halign:'center'\">PR CREATEDDATE</th>
				<th data-options=\"field:'pr_approveddate',halign:'center'\">PR APPROVEDDATE</th>
				<th data-options=\"field:'pr_firmeddate',halign:'center'\">PR FIRMEDDATE</th>
				<th data-options=\"field:'pr_firmedby',halign:'center'\">PR FIRMEDBY</th>
				
				<th data-options=\"field:'po_no',halign:'center'\">PO NO</th>
				<th data-options=\"field:'po_date',halign:'center'\">PO DATE</th>
				<th data-options=\"field:'po_status',halign:'center'\">STATUS</th>
				<th data-options=\"field:'currencycode',halign:'center'\">CURRENCY</th>
				<th data-options=\"field:'lineamount',halign:'center'\">LINEAMOUNT</th>
				<th data-options=\"field:'totalamount',halign:'center'\">TOTALAMOUNT</th>
				<th data-options=\"field:'sumtax',halign:'center'\">SUMTAX</th>
				<th data-options=\"field:'summarkup',halign:'center'\">SUMMARKUP</th>
				<th data-options=\"field:'netamount',halign:'center'\">NETAMOUNT</th>
				
				<th data-options=\"field:'itemid',halign:'center'\">ITEMID</th>
				<th width='400' data-options=\"field:'itemtxt',halign:'center'\">ITEMTXT</th>
				<th data-options=\"field:'purchprice',halign:'center'\">PRICE</th>
				<th data-options=\"field:'purchqty',halign:'center'\">QTY</th>
				<th data-options=\"field:'purchunit',halign:'center'\">UNIT</th>
				
				<th data-options=\"field:'vend_no',halign:'center'\">NO</th>
				<th data-options=\"field:'vend_name',halign:'center'\">NAME</th>			
			</tr>
		</thead>";
		}
		
		//====================Over Budget vs Actual =============
		else if(strcmp($thead,'OVAUGUST')==0){
		$content = "<thead>
					<tr>
						<th rowspan=\"3\" data-options=\"field:'group_of_expense',halign:'center'\">GROUP OF EXPENSE</th>
						<th rowspan=\"3\" data-options=\"field:'group_code',halign:'center'\">GROUP CODE</th>
						<th rowspan=\"3\" data-options=\"field:'group_name',halign:'center'\">GROUP NAME</th>
						<th rowspan=\"3\" data-options=\"field:'code',halign:'center'\">LEDGER ACCOUNT</th>
						<th rowspan=\"3\" data-options=\"field:'account_name',halign:'center'\">ACCOUNT NAME</th>
						<th rowspan=\"3\" data-options=\"field:'cost_center',halign:'center'\">COST CENTER</th>
						<th colspan=\"4\">AUGUST 2015</th>
						<th rowspan=\"3\" data-options=\"field:'reason',halign:'center'\">REASON</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatDetailMonth' rowspan=\"2\" data-options=\"field:'august_actual_2015',halign:'center'\">ACTUAL</th>
						<th width='100' align='right' formatter='formatPrice' rowspan=\"2\" data-options=\"field:'august_plan_2015',halign:'center'\">PLAN</th>
						<th colspan=\"2\">ACTUAL VS PLAN (VARIANCE)</th>
					</tr>
					<tr>
						<th width='100' align='right' formatter='formatPrice' data-options=\"field:'variance_amount_august',halign:'center'\">AMOUNT</th>
						<th width='100' align='right' formatter='formatPercent' data-options=\"field:'variance_percent_august',halign:'center'\">PERCENT</th>					
					</tr>
				</thead>";
		}
		return $content;
	}
//##################################################################################################
?>