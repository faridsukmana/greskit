<?php
	require_once 'reader.php';
//	require_once('../connect.php');
/*	$filename='../view/upload_excel/TPC INDO Audit Report 2011.xls';
	
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($filename);*/
	
	//==tahun 2010===
//	$dt = get_item_data($data,1,8,18);
//	$name = compare_dB_Name($dt);
//	insert_data_MCU($name, $dt);	
	
	/*$spt_item = separate_item($dt);
	print_r ($spt_item);
	print_r (get_item_data($data));
	$total_GA = get_total_cost_amount($spt_item, $dt, 'ST');
	$total_PPE = get_total_cost_amount($spt_item, $dt, 'SF');
	$total_SP = cek_numeric($spt_item, $dt);
	echo '<br/>ST : '.$total_ST.'<br/>';
	echo '<br/>SF : '.$total_SF.'<br/>';
	echo '<br/>.. :'.$total.'<br/>';*/
	
	//===============insert data untuk tabel MCU===========================================================================================================
	function insert_data_MCU($name, $dt, $data){
		for ($i=0; $i<count($name); $i++){
			if(!empty($name[$i][1])){
				$Date = $data->sheets[1]['cells'][3][2];
				//echo $dt[0][$i].' , '.$name[$i][0].'. '.$name[$i][1].' , '.$dt[13][$i].' , '.$dt[2][$i].'<br/>';
				$sql = 'INSERT INTO tb_mcu VALUES ("","'.$dt[0][$i].'","'.$name[$i][0].'","'.$dt[13][$i].'","'.$dt[2][$i].'","'.$dt[3][$i].'","'.$dt[4][$i].'","'.$dt[5][$i].'","'.$dt[6][$i].'","'.$dt[7][$i].'","'.$dt[8][$i].'","'.$dt[9][$i].'","'.$dt[10][$i].'","'.$dt[11][$i].'","'.$dt[12][$i].'","'.$dt[14][$i].'","'.$dt[15][$i].'","'.$dt[16][$i].'","'.$dt[17][$i].'","'.$dt[18][$i].'","'.$Date.'","")';
				mysql_query($sql) or die('gagal');
			}else{
				
			}
		}
	}
	
	//================mencocokkan nama pada database yang terdapat pada ===================================================================================
	function compare_dB_Name($dt){
		$row_c = count($dt[1]);
		for($i=0; $i<$row_c; $i++){
			$name = $dt[1][$i];
			$name = substr($name,-6,-1);
			$sql = 'SELECT EMP_ID, EMP_NAME	FROM tb_employee WHERE EMP_NAME LIKE "%'.$name.'%"';
			$result = mysql_query($sql);
			$result_now = mysql_fetch_array($result);
			$row = mysql_num_rows($result);
			
			if ($row!=0){
				$nm[$i][0] = $result_now['EMP_ID'];
				$nm[$i][1] = $result_now['EMP_NAME'];
			}else{
				$sql = 'SELECT EMP_ID FROM tb_employee WHERE EMP_ID=(SELECT MAX(EMP_ID) FROM tb_employee)';
				$result = mysql_query($sql);
				$result_now = mysql_fetch_array($result);
				$row = $result_now['EMP_ID'] + 1;
				$nm[$i][0] = $row;
				$nm[$i][1] = '';
				$sql = 'INSERT tb_employee (EMP_ID, EMP_NAME) VALUES ("'.$nm[$i][0].'","'.$nm[$i][1].'")';
				//mysql_query($sql);
			}
		}
		//	$sql = 'SELECT EMP_ID, EMP_NAME	FROM tb_employee WHERE EMP_NAME LIKE "%'.$nama.'%"';
		return $nm;
	}
	
	//================mengambil NO_Lab, code ,Nama, Hematologi, Urine, HBs Ag, Liver,  Lemak, Ginjal, Glukosa, Pb, Hg, Cu, ECG, Spirometri, Audiogram, Foto, Fisik================================================================
	function get_item_data($data,$no_sheet,$top,$bottom){
		$jum_baris = $data->sheets[$no_sheet]['numRows'];
		$jum_kolom = $data->sheets[$no_sheet]['numCols'];
		
		for ($i=$top; $i<=$jum_baris-$bottom; $i++){
			//=================================== GET No Lab ==========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][2]))
				$sheet[0][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][2]; 
			else
				$sheet[0][$i-$top] = '-';
			//=================================== GET Nama ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][3])){
				$sheet[1][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][3];
				$sheet[1][$i-$top] = substr($sheet[1][$i-$top],0,-2); 
			}else
				$sheet[1][$i-$top] = '-';
			//=================================== GET Code =====================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][4]))
				$sheet[13][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][4];
			else
				$sheet[13][$i-$top] = '-';
			//=================================== GET Hematologi =====================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][7]))
				$sheet[2][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][7];
			else
				$sheet[2][$i-$top] = '-';
			//=================================== GET Urine lengkap ==================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][8]))
				$sheet[3][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][8];
			else
				$sheet[3][$i-$top] = '-';
			//=================================== GET HBs AG =========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][9]))
				$sheet[4][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][9];
			else
				$sheet[4][$i-$top] = '-';
			//=================================== GET Fungsi Liver ===================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][10]))
				$sheet[5][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][10];
			else
				$sheet[5][$i-$top] = '-';
			//=================================== GET  Profil Lemak ==================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][11]))
				$sheet[6][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][11];
			else
				$sheet[6][$i-$top] = '-';
			//=================================== GET Fungsi Ginjal ==================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][12]))
				$sheet[7][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][12];
			else
				$sheet[7][$i-$top] = '-';
			//=================================== GET Glukosa Darah ==================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][13]))
				$sheet[8][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][13];
			else
				$sheet[8][$i-$top] = '-';
			//=================================== GET HBs Pb =========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][14]))
				$sheet[9][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][14];
			else
				$sheet[9][$i-$top] = '-';
			//=================================== GET Hg ============================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][15]))
				$sheet[10][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][15];
			else
				$sheet[10][$i-$top] = '-';
			//=================================== GET Cu ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][16]))
				$sheet[11][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][16];
			else
				$sheet[11][$i-$top] = '-';
			//=================================== GET ECG ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][17]))
				$sheet[12][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][17];
			else
				$sheet[12][$i-$top] = '-';
			//=================================== GET Spirometri ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][18]))
				$sheet[14][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][18];
			else
				$sheet[14][$i-$top] = '-';
			//=================================== GET Audiogram ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][19]))
				$sheet[15][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][19];
			else
				$sheet[15][$i-$top] = '-';
			//=================================== GET Foto ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][20]))
				$sheet[16][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][20];
			else
				$sheet[16][$i-$top] = '-';
			//=================================== GET Fisik ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][21]))
				$sheet[17][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][21];
			else
				$sheet[17][$i-$top] = '-';
			//=================================== GET Saran ===========================================//
			if(isset($data->sheets[$no_sheet]['cells'][$i][22]))
				$sheet[18][$i-$top] = $data->sheets[$no_sheet]['cells'][$i][22];
			else
				$sheet[18][$i-$top] = '-';
		}
		
		return $sheet;
	}
	
	//================mengambil NO_Lab, Nama, Hematologi, Urine, HBs Ag, Liver,  Lemak, Ginjal, Glukosa, Pb, Hg, Cu, ECG, Spirometri, Audiogram, Foto, Fisik pada tahun 2011 Sheet0================================================================
	function get_item_data_2($data){
		$jum_baris = $data->sheets[0]['numRows'];
		$jum_kolom = $data->sheets[0]['numCols'];
		
		for ($i=6; $i<=$jum_baris-8; $i++){
			//=================================== GET No Lab ==========================================//
			if(isset($data->sheets[0]['cells'][$i][2])) 
				$sheet[0][$i-6] = $data->sheets[0]['cells'][$i][2]; 
			else
				$sheet[0][$i-6] = '-';
			//=================================== GET Nama ===========================================//
			if(isset($data->sheets[0]['cells'][$i][3]))
				$sheet[1][$i-6] = $data->sheets[0]['cells'][$i][3];
			else
				$sheet[1][$i-6] = '-';
			//=================================== GET Hematologi =====================================//
			if(isset($data->sheets[0]['cells'][$i][5]))
				$sheet[2][$i-6] = $data->sheets[0]['cells'][$i][5];
			else
				$sheet[2][$i-6] = '-';
			//=================================== GET Urine lengkap ==================================//
			if(isset($data->sheets[0]['cells'][$i][6]))
				$sheet[3][$i-6] = $data->sheets[0]['cells'][$i][6];
			else
				$sheet[3][$i-6] = '-';
			//=================================== GET HBs AG =========================================//
			if(isset($data->sheets[0]['cells'][$i][7]))
				$sheet[4][$i-6] = $data->sheets[0]['cells'][$i][7];
			else
				$sheet[4][$i-6] = '-';
			//=================================== GET Fungsi Liver ===================================//
			if(isset($data->sheets[0]['cells'][$i][8]))
				$sheet[5][$i-6] = $data->sheets[0]['cells'][$i][8];
			else
				$sheet[5][$i-6] = '-';
			//=================================== GET  Profil Lemak ==================================//
			if(isset($data->sheets[0]['cells'][$i][9]))
				$sheet[6][$i-6] = $data->sheets[0]['cells'][$i][9];
			else
				$sheet[6][$i-6] = '-';
			//=================================== GET Fungsi Ginjal ==================================//
			if(isset($data->sheets[0]['cells'][$i][10]))
				$sheet[7][$i-6] = $data->sheets[0]['cells'][$i][10];
			else
				$sheet[7][$i-6] = '-';
			//=================================== GET Glukosa Darah ==================================//
			if(isset($data->sheets[0]['cells'][$i][11]))
				$sheet[8][$i-6] = $data->sheets[0]['cells'][$i][11];
			else
				$sheet[8][$i-6] = '-';
			//=================================== GET HBs Pb =========================================//
			if(isset($data->sheets[0]['cells'][$i][12]))
				$sheet[9][$i-6] = $data->sheets[0]['cells'][$i][12];
			else
				$sheet[9][$i-6] = '-';
			//=================================== GET Hg ============================================//
			if(isset($data->sheets[0]['cells'][$i][13]))
				$sheet[10][$i-6] = $data->sheets[0]['cells'][$i][13];
			else
				$sheet[10][$i-6] = '-';
			//=================================== GET Cu ===========================================//
			if(isset($data->sheets[0]['cells'][$i][14]))
				$sheet[11][$i-6] = $data->sheets[0]['cells'][$i][14];
			else
				$sheet[11][$i-6] = '-';
			//=================================== GET Cu ===========================================//
			if(isset($data->sheets[0]['cells'][$i][14]))
				$sheet[12][$i-6] = $data->sheets[0]['cells'][$i][14];
			else
				$sheet[12][$i-6] = '-';
		}
		
		return $sheet;
	}
	
?>