<?php
	function form_upload(){
		$content = '<form enctype="multipart/form-data" method="POST" action="'.EUP.POST.'">
						<table class="mytable">
						<tr>
						<td width="250"><label for="file">Excel File : </label></td>
						<td width="250"><input type="file" name="excelfile" id="file"/></td>
						</tr>
						<tr>
						<td width="250"></td>
						<td width="250"><input type="submit" value="Upload" class="submit"></td>
						</tr>
						</table>
					</form>';
		$content .= '<div class="title">Manual Generate And Update Data (Automatic Generate (10.00 pm) And Automatic Update (11.00 pm))</div><br/>';
		$content .= '<form enctype="multipart/form-data" method="POST" action="'.EUP.GEN.'">
						<table class="mytable">
						<tr>
						<td width="250" style="color=red"> Please click this after upload file (Excel to MySQL): </td>
						<td width="250"><input type="submit" value="Generate Excel Data" class="submit"></td>
						</tr>
						</table>
					</form>';
		$content .= '<form enctype="multipart/form-data" method="POST" action="'.EUP.UPDATE.'">
						<table class="mytable">
						<tr>
						<td width="250" style="color=red"> Please click this to move file new generate file to Data Coal Boiler: </td>
						<td width="250"><input type="submit" value="Update" class="submit"></td>
						</tr>
						</table>
					</form>';
		return $content;
	}
	
	//============================function to upload file=============================================
	function upload_file(){
		$content = '';
		$content = "Failed"; 
		if((!empty($_FILES['excelfile'])) && ($_FILES['excelfile']['error']==0)){
			$filename = basename($_FILES['excelfile']['name']);
			$name_file = substr($filename,0,strpos($filename, '.'));
			if(strcmp($name_file,'boiler_report')==0){
				$ext = substr($filename, strpos($filename, '.')+1);
				if(($ext=='xls')&&($_FILES['excelfile']['type']=='application/vnd.ms-excel')){
					$newname = 'view/upload_excel/'.$filename;
					if((move_uploaded_file($_FILES['excelfile']['tmp_name'],$newname))){
						$content = '<div align="center" class="warning">Its done ! The file has been saved as : '.$newname.'</div>';
					}else{
						$content = '<div align="center" class="warning">Error : A problem occured during file upload. Only file format (.xls)</div>';
					}
				}else{
					$content = '<div align="center" class="warning">Only .xls are accepted to upload</div>';
				}
			}else{
				$content = '<div align="center" class="warning">Please rename and file with (boiler_report.xls)</div>';
			}		
		}else{
			$content = '<div align="center" class="warning">Error : No file upload</div>';
		}
		
	//	$content = $_FILES['excelfile']['type'];
		return $content;
	}
	
	//=============================function to generate file excel to mysql server=====================
	//=Option 1== $sheet adalah letak halaman excel ,$table berisikan nama tabel database yang akan dihapus, dan $path adalah letak dari file excel yang akan digenerate== Tapi tidak bisa untuk membaca format excel == pengambilan data diarahkan ke plugin excel_php/function_excel.php
	function generate_file($sheet,$table,$path){
		$newname = $path;
		$prod=parseExcel($newname,$sheet,$table);
		
		//print_r($prod);
		
		/*$i = 0;
		while($i<sizeof($prod)){
			$sql = 'INSERT INTO tb_coal VALUES("'.$product[$i-1]['name'].'","'.$product[$i-1]['date'].'","'.$product[$i-1]['value'].'","'.$product[$i-1]['validity'].'","'.$product[$i-1]['time_ms'].'")';
		
			$query = mysql_query($sql);
			$i++;
		}*/
		if($prod){
			$content = '<div class="warning" align="center">Generate to MySQL was successed</div>';
		}else{
			$content = '<div class="warning" align="center">Generate to MySQL was failed (May be some data not insert)</div>';
		}
		return $content;
	}
	
	//=Option 2 == Bisa membaca format excel === Pengambilan data diarahkan ke plugin PHPExcel/function_read_data.php
	function generate_file_op2($sheet,$table,$path){
		$newname = $path;
		$content = get_data($newname,$sheet,$table);;
		return $content;
	}	
	
	//==============================function move data tb_coal to tb_report_data=======================
	function update_data(){
		$sql = 'SELECT distinct(time_string) FROM tb_coal';
		$result = mysql_query($sql) or die('failed');
		while($result_now = mysql_fetch_array($result)){
			$sql = 'INSERT INTO tb_coal_report (date_time) VALUES ("'.$result_now[0].'")';
			mysql_query($sql);
		}
		
		$sql = 'SELECT var_name, time_string, var_value FROM tb_coal';
		$result = mysql_query($sql);
		while($result_now = mysql_fetch_array($result)){
			$sql = 'UPDATE tb_coal_report SET '.strtolower($result_now['var_name']).'='.$result_now['var_value'].' WHERE date_time="'.$result_now['time_string'].'"';
			$query = mysql_query($sql);
			if(!query){
				$content = '<div class="warning" align="center">Failed Update</div>';
			}else{
				$content = '<div class="warning" align="center">successed Update</div>';
			}
		}
		return $content;
	}
	
	//==============================function search ===================================================
	function search_data(){
		$date = date("m/d/Y");
		$string_date = strtotime($date);
		$yesterday = strtotime('-2 days',$string_date);
		$yesterday = date("m/d/Y",$yesterday);
		$tb = 	'<tr>
					<td width=100>Date : </td><td><input type="text" value="'.$yesterday.'" id="datepicker" name = "date" class="inputadd"> s/d <input type="text" value="'.$date.'" id="datepicker2" name = "date2" class="inputadd"></td>
				</tr>
				<tr>
					<td width=100></td><td><input type="submit" name="submit" value="Search" class="submit">
					<input type="reset" name="cancel" value="Cancel" class="submit"></td>
				</tr>';
		$content = '<form method="POST" action="'.DUP.POST.'&pg='.$_REQUEST['pg'].'" id="form"><table class="mytable">'.$tb.'</table></form>';
		return $content;
	}
	
	//==============================function show data form mysql =====================================
	function show_data($date_,$date_2,$in_ses){
		if($in_ses==0){
			$date = $date_;
			$arr = explode('/',$date); 
			$tahun = $arr[2];
			$bulan = $arr[0];
			$tanggal = $arr[1];
			$fus = $tahun.'-'.$bulan.'-'.$tanggal.' 00:00:00';
			$date = $date_2;
			$arr = explode('/',$date); 
			$tahun = $arr[2];
			$bulan = $arr[0];
			$tanggal = $arr[1];
			$fus2 = $tahun.'-'.$bulan.'-'.$tanggal.' 00:00:00';	
			$tabhead = ''; $tabbody='';
			$content = $fus.'  to  '.$fus2;
			gen_to_excel($fus,$fus2);
			$_SESSION['last_date'] = $fus;
			$_SESSION['new_date'] = $fus2;
		}else if($in_ses==1){
			$fus = $_SESSION['last_date'];
			$fus2 = $_SESSION['new_date'];
			$content = $fus.'  to  '.$fus2;
			gen_to_excel($fus,$fus2);
		}
		if(isset($_REQUEST['pg'])&&strcmp($_REQUEST['pg'],'1')==0){
			$sql = 'SELECT date_time AS Date_Time, lh_burnback AS LH_Burn_Back, lh_coalthick AS LH_Coal_Thick, id_hz AS ID_Fan_Speed, lhtotal_coal AS LH_Total_Coal, lh_stoker_speed AS LH_Stoker_Speed, rhtotal_coal AS RH_Total_Coal, flue_temp AS Flue_Temp, o2_level AS O2_Level, lhfd_hz AS LH_FD_Fan_Speed, rh_coalthick AS RH_Coal_Thick FROM tb_coal_report WHERE date_time BETWEEN "'.$fus.'" AND "'.$fus2.'" ORDER BY date_time DESC';
		
			$result = mysql_query($sql);
			
			$tabhead = '<tr><th>No</th><th>Date Time</th><th>LH Burn Back (°C)</th><th>LH Coal Thick(MM)</th><th>ID Fan Speed(HZ)</th><th>LH Total Coal(Tons)</th><th>LH Stoker Speed(HZ)</th><th>RH Total Coal(Tons)</th><th>Flue Temp(°C)</th><th>O2 Level(%)</th><th>LH FD Fan Speed(HZ)</th><th>RH Coal Thick(MM)</th></tr>';
			
			$i=1;
			$tabbody = '';
			$r1=0;$r2=0;$r3=0;$r4=0;$r5=0;$r6=0;$r7=0;$r8=0;$r9=0;$r10=0;
			while($result_now = mysql_fetch_array($result)){
				$tabbody .= '<tr><td>'.$i.'</td><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td><td>'.$result_now[6].'</td><td>'.$result_now[7].'</td><td>'.$result_now[8].'</td><td>'.$result_now[9].'</td><td>'.$result_now[10].'</td></tr>';
				$r1 = $r1 + (float)$result_now[1];
				$r2 = $r2 + (float)$result_now[2];
				$r3 = $r3 + (float)$result_now[3];
				$r4 = $r4 + (float)$result_now[4];
				$r5 = $r5 + (float)$result_now[5];
				$r6 = $r6 + (float)$result_now[6];
				$r7 = $r7 + (float)$result_now[7];
				$r8 = $r8 + (float)$result_now[8];
				$r9 = $r9 + (float)$result_now[9];
				$r10 = $r10 + (float)$result_now[10];
				$i++;
			}
			$tabhead2 = '<tr><th>Total</th><th></th><th>'.$r1.'</th><th>'.$r2.'</th><th>'.$r3.'</th><th>'.$r4.'</th><th>'.$r5.'</th><th>'.$r6.'</th><th>'.$r7.'</th><th>'.$r8.'</th><th>'.$r9.'</th><th>'.$r10.'</th></tr>';
		}
		
		
		else if(isset($_REQUEST['pg'])&&strcmp($_REQUEST['pg'],'2')==0){
			$sql = 'SELECT date_time AS Date_Time, co2_level AS CO2_Level, steam_press AS Steam_Press, rh_stoker_speed AS RH_Stoker_Speed, valve_pos AS Valve_Pos, water_flowrate AS Water_Flow_Rate, rhfd_hz AS RH_FD_Fan_Speed, water_temp AS Water_Temp, rh_burnback as RH_Burn_Back, water_level AS Water_Level, total_wtr AS Total_Water, steam_flow AS Steam_Flow  FROM tb_coal_report WHERE date_time BETWEEN "'.$fus.'" AND "'.$fus2.'" ORDER BY date_time DESC';
		
			$result = mysql_query($sql);
			
			$tabhead = '<tr><th>No</th><th>Date Time</th><th>CO2 Level(%)</th><th>Steam Pressure (BAR)</th><th>RH Stoker Speed (HZ)</th><th>Valve Position (BAR)</th><th>Water Flow Rate</th><th>RH FD Fan Speed (HZ)</th><th>Water Temp (°C)</th><th>RH Burn Back (°C)</th><th>Water Level(%)</th><th>Total Water</th><th>Steam Flow (Tons / Hour)</th></tr>';
			
			$i = 1;
			$tabbody = '';
			$r1=0;$r2=0;$r3=0;$r4=0;$r5=0;$r6=0;$r7=0;$r8=0;$r9=0;$r10=0;$r11=0;
			while($result_now = mysql_fetch_array($result)){
				$tabbody .= '<tr><td>'.$i.'</td><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td><td>'.$result_now[6].'</td><td>'.$result_now[7].'</td><td>'.$result_now[8].'</td><td>'.$result_now[9].'</td><td>'.$result_now[10].'</td></td><td>'.$result_now[11].'</td></tr>';
				$r1 = $r1 + (float)$result_now[1];
				$r2 = $r2 + (float)$result_now[2];
				$r3 = $r3 + (float)$result_now[3];
				$r4 = $r4 + (float)$result_now[4];
				$r5 = $r5 + (float)$result_now[5];
				$r6 = $r6 + (float)$result_now[6];
				$r7 = $r7 + (float)$result_now[7];
				$r8 = $r8 + (float)$result_now[8];
				$r9 = $r9 + (float)$result_now[9];
				$r10 = $r10 + (float)$result_now[10];
				$r11 = $r11 + (float)$result_now[11];
				$i++;
			}
			$tabhead2 = '<tr><th>Total</th><th></th><th>'.$r1.'</th><th>'.$r2.'</th><th>'.$r3.'</th><th>'.$r4.'</th><th>'.$r5.'</th><th>'.$r6.'</th><th>'.$r7.'</th><th>'.$r8.'</th><th>'.$r9.'</th><th>'.$r10.'</th><th>'.$r11.'</th></tr>';
		}
		
		$content .= '<table class="display" id="data"><thead>'.$tabhead.'</thead><tbody>'.$tabbody.'</tbody><tfoot>'.$tabhead2.'</tfoot></table>';
		return $content;
	}
	
	//==========================================function generate to excel===============================
	function gen_to_excel($fus,$fus2){
		$content = '';
		error_reporting(E_ALL);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("TPC INDO PLASTIC AND CHEMICALS")
							 ->setLastModifiedBy("TPC INDO PLASTIC AND CHEMICALS")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("document for Office 2007 XLSX, generated using PHP.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("TPC INDO PLASTIC AND CHEMICALS");
		
		$sql = 'SELECT date_time AS Date_Time, lh_burnback AS LH_Burn_Back, lh_coalthick AS LH_Coal_Thick, id_hz AS ID_Fan_Speed, lhtotal_coal AS LH_Total_Coal, lh_stoker_speed AS LH_Stoker_Speed, rhtotal_coal AS RH_Total_Coal, flue_temp AS Flue_Temp, o2_level AS O2_Level, lhfd_hz AS LH_FD_Fan_Speed, rh_coalthick AS RH_Coal_Thick, co2_level AS CO2_Level,steam_press AS Steam_Press, rh_stoker_speed AS RH_Stoker_Speed, valve_pos AS Valve_Pos, rhfd_hz AS RH_FD_Fan_Speed, water_temp AS Water_Temp, rh_burnback as RH_Burn_Back, water_level AS Water_Level, total_wtr AS Total_Water, steam_flow AS Steam_Flow FROM tb_coal_report WHERE date_time BETWEEN "'.$fus.'" AND "'.$fus2.'"';
		$result = mysql_query($sql) or die('gagal');
		
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DATE TIME');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'LH BURN BACK');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'LH COAL THICK');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ID FAN SPEED');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'LH TOTAL COAL');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'LH STOKER SPEED');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'RH TOTAL COAL');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'FLUE TEMP');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'O2 LEVEL');
		$objPHPExcel->getActiveSheet()->setCellValue('J1', 'LH FD FAN SPEED');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'RH COAL THICK');
		$objPHPExcel->getActiveSheet()->setCellValue('L1', 'CO2 LEVEL');
		$objPHPExcel->getActiveSheet()->setCellValue('M1', 'STEAM PRESS');
		$objPHPExcel->getActiveSheet()->setCellValue('N1', 'RH STOKER SPEED');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'VALVE POS');
		$objPHPExcel->getActiveSheet()->setCellValue('P1', 'RH FD FAN SPEED');
		$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'WATER TEMP');
		$objPHPExcel->getActiveSheet()->setCellValue('R1', 'RH BURN BACK');
		$objPHPExcel->getActiveSheet()->setCellValue('S1', 'WATER LEVEL');
		$objPHPExcel->getActiveSheet()->setCellValue('T1', 'TOTAL WATER');
		$objPHPExcel->getActiveSheet()->setCellValue('U1', 'STEAM FLOW');
		
		$i=2;
		$j=1;
		while($result_now= mysql_fetch_array($result)){
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $result_now[0]);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $result_now[1]);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $result_now[2]);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $result_now[3]);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result_now[4]);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $result_now[5]);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $result_now[6]);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[7]);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result_now[8]);
			$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $result_now[9]);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $result_now[10]);
			$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $result_now[11]);
			$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result_now[12]);
			$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $result_now[13]);
			$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $result_now[14]);
			$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $result_now[15]);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $result_now[16]);
			$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $result_now[17]);
			$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $result_now[18]);
			$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $result_now[19]);
			$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $result_now[20]);
			$i++; $j++;
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('COAL FAIRED BOILER REPORT');	
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', 'view/upload_excel/Boiler_Report_Fix.xlsx'));
		
		return $content;
	}
	
	//===========================function get_time ======================================================
	function get_time(){
		ini_set('date.timezone', 'Asia/Jakarta');
		return date('h:i a', time());
	}
?>