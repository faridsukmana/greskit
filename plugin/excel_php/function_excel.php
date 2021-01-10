<?php
require_once 'reader.php';

//===============================================Ini adalah fungsi yang digunakan untuk mengambil data ke excel dan dipindahkan ke MySQl dengan cara=========
//===============================================menampung semua variable dalam excel ke dalam array dua dimensi=============================================
///==============================================$table adalah nama tabel dalam database yang akan di drop atau delete=======================================
function parseExcel($excel_file_name_with_path,$sheet,$table)
{
	//$sql = 'DELETE FROM '.$table; 
	$k = 0; $l = 0;
	mysql_query($sql);
	
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($excel_file_name_with_path);
	
	if(strcmp($table,'pmwo_detail_object')==0){
		$colname=array('object','compname','owner','category','gi_brand','gi_type','gi_service_tag','gi_pn','gi_sn','pi_vendor','pi_purch_date','pi_waranty','pi_end_waranty','pi_waranty_state','m_type','m_no','k_brand','k_no','ms_brand','ms_type','processor','mm_mb','mm_type','hdd_type','hdd_capacity','hdd_qty','drive','ups_bat','fa_cpu','fa_monitor','ui_user','ui_level','ui_location','ui_own_section','ui_department','ui_start_date_use');

		for ($i = 7; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 2; $j <= 37; $j++) {
					if($j==12 or $j==14 or $j==37){
						$date = $data->sheets[$sheet]['cells'][$i][$j];
						$arr = explode('/',$date); 
						$tahun = $arr[2];
						$tanggal = (int)$arr[0];
						$bulan = $arr[1];
						if (checkdate($bulan, $tanggal, $tahun))
							$fus = $tahun.'-'.$bulan.'-'.$tanggal;
						else
							$fus = '-';
						$product[$i-1][$colname[$j-2]] = $data->sheets[$sheet]['cells'][$i][$j];
					}else if($j==40){
						$product[$i-1][$colname[$j-2]] = $product[$i-1]['sel_amount']+$product[$i-1]['cogs']+$product[$i-1]['tlf']+$product[$i-1]['ci']+$product[$i-1]['ddo'];
					}else{
						$product[$i-1][$colname[$j-2]]=$data->sheets[$sheet]['cells'][$i][$j];
					}
			}
			
			$sql = 'SELECT * FROM '.$table.' WHERE APMOBJECTID="'.$product[$i-1]['object'].'"' ; //echo $sql;
			$result = mysql_query($sql);
			$rows = mysql_num_rows($result);
			
			if($rows>0){
				$sql = 'DELETE FROM '.$table.' WHERE APMOBJECTID like "'.$product[$i-1]['object'].'"' ;
				$result = mysql_query($sql);
				
				$sql =  'INSERT INTO '.$table.' VALUES("","'.$product[$i-1]['object'].'","'.$product[$i-1]['compname'].'","'.$product[$i-1]['owner'].'",
					"'.$product[$i-1]['category'].'","'.$product[$i-1]['gi_brand'].'","'.$product[$i-1]['gi_type'].'","'.$product[$i-1]['gi_service_tag'].'",
					"'.$product[$i-1]['gi_pn'].'","'.$product[$i-1]['gi_sn'].'","'.$product[$i-1]['pi_vendor'].'","'.$product[$i-1]['pi_purch_date'].'",
					"'.$product[$i-1]['pi_waranty'].'","'.$product[$i-1]['pi_end_waranty'].'","'.$product[$i-1]['pi_waranty_state'].'","'.$product[$i-1]['m_type'].'",
					"'.$product[$i-1]['m_no'].'","'.$product[$i-1]['k_brand'].'","'.$product[$i-1]['k_no'].'","'.$product[$i-1]['ms_brand'].'",
					"'.$product[$i-1]['ms_type'].'","'.$product[$i-1]['processor'].'","'.$product[$i-1]['mm_mb'].'","'.$product[$i-1]['mm_type'].'",
					"'.$product[$i-1]['hdd_type'].'","'.$product[$i-1]['hdd_capacity'].'","'.$product[$i-1]['hdd_qty'].'","'.$product[$i-1]['drive'].'",
					"'.$product[$i-1]['ups_bat'].'","'.$product[$i-1]['fa_cpu'].'","'.$product[$i-1]['fa_monitor'].'","'.$product[$i-1]['ui_user'].'",
					"'.$product[$i-1]['ui_level'].'","'.$product[$i-1]['ui_location'].'","'.$product[$i-1]['ui_own_section'].'","'.$product[$i-1]['ui_department'].'",
					"'.$product[$i-1]['ui_start_date_use'].'")';
				//	echo $sql.'<br/>';
					$query = mysql_query($sql);
				//	echo $k++.' .'.$rows.'<br/>';
			}else{
				$sql =  'INSERT INTO '.$table.' VALUES("","'.$product[$i-1]['object'].'","'.$product[$i-1]['compname'].'","'.$product[$i-1]['owner'].'",
					"'.$product[$i-1]['category'].'","'.$product[$i-1]['gi_brand'].'","'.$product[$i-1]['gi_type'].'","'.$product[$i-1]['gi_service_tag'].'",
					"'.$product[$i-1]['gi_pn'].'","'.$product[$i-1]['gi_sn'].'","'.$product[$i-1]['pi_vendor'].'","'.$product[$i-1]['pi_purch_date'].'",
					"'.$product[$i-1]['pi_waranty'].'","'.$product[$i-1]['pi_end_waranty'].'","'.$product[$i-1]['pi_waranty_state'].'","'.$product[$i-1]['m_type'].'",
					"'.$product[$i-1]['m_no'].'","'.$product[$i-1]['k_brand'].'","'.$product[$i-1]['k_no'].'","'.$product[$i-1]['ms_brand'].'",
					"'.$product[$i-1]['ms_type'].'","'.$product[$i-1]['processor'].'","'.$product[$i-1]['mm_mb'].'","'.$product[$i-1]['mm_type'].'",
					"'.$product[$i-1]['hdd_type'].'","'.$product[$i-1]['hdd_capacity'].'","'.$product[$i-1]['hdd_qty'].'","'.$product[$i-1]['drive'].'",
					"'.$product[$i-1]['ups_bat'].'","'.$product[$i-1]['fa_cpu'].'","'.$product[$i-1]['fa_monitor'].'","'.$product[$i-1]['ui_user'].'",
					"'.$product[$i-1]['ui_level'].'","'.$product[$i-1]['ui_location'].'","'.$product[$i-1]['ui_own_section'].'","'.$product[$i-1]['ui_department'].'",
					"'.$product[$i-1]['ui_start_date_use'].'")';
				//	echo $sql.'<br/>';
					$query = mysql_query($sql);
				//	echo $l++.' .'.$rows.'<br/>';
			}
			
			
			if($query){
				$content = true;
			}else{
				$content = false;
			}
		}
	}else if(strcmp($table,'budget_input_excel')==0){
		$sql = 'DELETE FROM '.$table; 
		mysql_query($sql);
	
		$colname=array('coding','cogroup','exgroup','actype','cocentre','ledacc','ledfac','ledcomFe','juncur','julcur','augcur','sepcur','octcur','novcur','deccur','sumcur','remcur','jannext','febnext','marnext','aprnext','maynext','junnext','julnext','augnext','sepnext','octnext','novnext','decnext','sumnext','ledname','comp','newcoled','coled','codingcocom');
		
		for ($i = 4; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 35; $j++) {
				$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
			}
			$sql =  'INSERT INTO '.$table.' VALUES("'.$product[$i-1]['coding'].'","'.$product[$i-1]['cogroup'].'","'.$product[$i-1]['exgroup'].'",
					"'.$product[$i-1]['actype'].'","'.$product[$i-1]['cocentre'].'","'.$product[$i-1]['ledacc'].'","'.$product[$i-1]['ledfac'].'",
					"'.$product[$i-1]['ledcomFe'].'","'.$product[$i-1]['juncur'].'","'.$product[$i-1]['julcur'].'","'.$product[$i-1]['augcur'].'",
					"'.$product[$i-1]['sepcur'].'","'.$product[$i-1]['octcur'].'","'.$product[$i-1]['novcur'].'","'.$product[$i-1]['deccur'].'",
					"'.$product[$i-1]['sumcur'].'","'.$product[$i-1]['remcur'].'","'.$product[$i-1]['jannext'].'","'.$product[$i-1]['febnext'].'",
					"'.$product[$i-1]['marnext'].'","'.$product[$i-1]['aprnext'].'","'.$product[$i-1]['maynext'].'","'.$product[$i-1]['junnext'].'",
					"'.$product[$i-1]['julnext'].'","'.$product[$i-1]['augnext'].'","'.$product[$i-1]['sepnext'].'","'.$product[$i-1]['octnext'].'",
					"'.$product[$i-1]['novnext'].'","'.$product[$i-1]['decnext'].'","'.$product[$i-1]['sumnext'].'","'.$product[$i-1]['ledname'].'",
					"'.$product[$i-1]['comp'].'","'.$product[$i-1]['newcoled'].'","'.$product[$i-1]['coled'].'","'.$product[$i-1]['codingcocom'].'")';
			mysql_query($sql);	
		//	echo $sql.'<br/>';
		//	break;
		}
	}
	
	else if(strcmp($table,'budget_input_excel_core')==0){
		$sql = 'DELETE FROM '.$table; 
		mysql_query($sql);
	
		$colname=array('coding','cogroup','exgroup','actype','cocentre','ledacc','ledfac','ledcomFe','jancur','febcur','marcur','aprcur','maycur','juncur','julcur','augcur','sepcur','octcur','novcur','deccur','jannext','febnext','marnext','aprnext','maynext','junnext','julnext','augnext','sepnext','octnext','novnext','decnext');
		
		/*for ($i = 4; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 32; $j++) {
				$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
			}
			
			$sql =  'INSERT INTO '.$table.' VALUES("'.$product[$i-1]['coding'].'","'.$product[$i-1]['cogroup'].'","'.$product[$i-1]['exgroup'].'",
					"'.$product[$i-1]['actype'].'","'.$product[$i-1]['cocentre'].'","'.$product[$i-1]['ledacc'].'","'.$product[$i-1]['ledfac'].'",
					"'.$product[$i-1]['ledcomFe'].'","'.$product[$i-1]['jancur'].'","'.$product[$i-1]['febcur'].'","'.$product[$i-1]['marcur'].'",
					"'.$product[$i-1]['aprcur'].'","'.$product[$i-1]['maycur'].'","'.$product[$i-1]['juncur'].'","'.$product[$i-1]['julcur'].'","'.$product[$i-1]['augcur'].'",
					"'.$product[$i-1]['sepcur'].'","'.$product[$i-1]['octcur'].'","'.$product[$i-1]['novcur'].'","'.$product[$i-1]['deccur'].'",
					"'.$product[$i-1]['jannext'].'","'.$product[$i-1]['febnext'].'",
					"'.$product[$i-1]['marnext'].'","'.$product[$i-1]['aprnext'].'","'.$product[$i-1]['maynext'].'","'.$product[$i-1]['junnext'].'",
					"'.$product[$i-1]['julnext'].'","'.$product[$i-1]['augnext'].'","'.$product[$i-1]['sepnext'].'","'.$product[$i-1]['octnext'].'",
					"'.$product[$i-1]['novnext'].'","'.$product[$i-1]['decnext'].'")';
			mysql_query($sql);	*/
			
		for ($i = 4; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 32; $j++) {
				$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
			}
			$qjan = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=1 AND Year(TransDate)='.date('Y'); $rjan = mysql_query($qjan); $rsjan = mysql_fetch_array($rjan);
			
			$qfeb = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=2 AND Year(TransDate)='.date('Y'); $rfeb = mysql_query($qfeb); $rsfeb = mysql_fetch_array($rfeb);
			
			$qmar = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=3 AND Year(TransDate)='.date('Y'); $rmar = mysql_query($qmar); $rsmar = mysql_fetch_array($rmar);
			
			$qapr = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=4 AND Year(TransDate)='.date('Y'); $rapr = mysql_query($qapr); $rsapr = mysql_fetch_array($rapr);
			
			$qmay = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=5 AND Year(TransDate)='.date('Y'); $rmay = mysql_query($qmay); $rsmay = mysql_fetch_array($rmay);
			
			$qjun = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=6 AND Year(TransDate)='.date('Y'); $rjun = mysql_query($qjun); $rsjun = mysql_fetch_array($rjun);
			
			$qjul = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=7 AND Year(TransDate)='.date('Y'); $rjul = mysql_query($qjul); $rsjul = mysql_fetch_array($rjul);
			
			$qaug = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=8 AND Year(TransDate)='.date('Y'); $raug = mysql_query($qaug); $rsaug = mysql_fetch_array($raug);
			
			$qsep = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=9 AND Year(TransDate)='.date('Y'); $rsep = mysql_query($qsep); $rssep = mysql_fetch_array($rsep);
			
			$qoct = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=10 AND Year(TransDate)='.date('Y'); $roct = mysql_query($qoct); $rsoct = mysql_fetch_array($roct);
			
			$qnov = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=11 AND Year(TransDate)='.date('Y'); $rnov = mysql_query($qnov); $rsnov = mysql_fetch_array($rnov);
			
			$qdec = 'SELECT SUM(AmountMST) FROM budget_ledgertrans WHERE AccountNum="'.$product[$i-1]['ledacc'].'" AND Dimension2_="'.$product[$i-1]['cocentre'].'" AND Month(TransDate)=12 AND Year(TransDate)='.date('Y'); $rdec = mysql_query($qdec); $rsdec = mysql_fetch_array($rdec);
			
			$sql =  'INSERT INTO '.$table.' VALUES("'.$product[$i-1]['coding'].'","'.$product[$i-1]['cogroup'].'","'.$product[$i-1]['exgroup'].'",
					"'.$product[$i-1]['actype'].'","'.$product[$i-1]['cocentre'].'","'.$product[$i-1]['ledacc'].'","'.$product[$i-1]['ledfac'].'",
					"'.$product[$i-1]['ledcomFe'].'","'.$product[$i-1]['jancur'].'","'.$product[$i-1]['febcur'].'","'.$product[$i-1]['marcur'].'",
					"'.$product[$i-1]['aprcur'].'","'.$product[$i-1]['maycur'].'","'.$product[$i-1]['juncur'].'","'.$product[$i-1]['julcur'].'","'.$product[$i-1]['augcur'].'",
					"'.$product[$i-1]['sepcur'].'","'.$product[$i-1]['octcur'].'","'.$product[$i-1]['novcur'].'","'.$product[$i-1]['deccur'].'",
					"'.$rsjan[0].'","'.$rsfeb[0].'",
					"'.$rsmar[0].'","'.$rsapr[0].'","'.$rsmay[0].'","'.$rsjun[0].'",
					"'.$rsjul[0].'","'.$rsaug[0].'","'.$rssep[0].'","'.$rsoct[0].'",
					"'.$rsnov[0].'","'.$rsdec[0].'")';
			mysql_query($sql);	
		//	echo $sql.'<br/>';
		//	break;
		}
	}
	
	else if(strcmp($table,'purch_invoice')==0){
		$sql = 'DELETE FROM '.$table; 
		mysql_query($sql);
		
		$colname=array('Plan_PO','PO_Number','Supplier_Name','Description','Price_Unit','Qty_RF','Total','VAT','WHTAX','Total_Amount','RF_No','RF_Date','RF_Receive','Invoice_No','No_Faktur_Pajak','FP_Date','Due_Date','Complete_Date','IR_No','IR_Date','IR_No_2','IR_Date_2','Nota_Retur','Retur_Faktur_Pajak','Date_Retur_Faktur_Pajak');
		
		for ($i = 2; $i <= $data->sheets[$sheet]['numRows']; $i++) {
			for ($j = 1; $j <= 26; $j++) {
				if($j==12 or $j==13 or $j==16 or $j==17 or $j==18 or $j==20 or $j==22){
						$date = $data->sheets[$sheet]['cells'][$i][$j]; $unixTimestamp = ($date - 25569) * 86400; $date = gmdate("Y-m-d", $unixTimestamp);
						$product[$i-1][$colname[$j-1]] = $date;
				}else if($j==4){
					$product[$i-1][$colname[$j-1]]=str_replace('"',"'",$data->sheets[$sheet]['cells'][$i][$j]);
				}else{
					$product[$i-1][$colname[$j-1]]=$data->sheets[$sheet]['cells'][$i][$j];
				}
			}
			$sql = 'INSERT INTO '.$table.' VALUES ("'.$product[$i-1]['Plan_PO'].'","'.$product[$i-1]['PO_Number'].'","'.$product[$i-1]['Supplier_Name'].'","'.$product[$i-1]['Description'].'","'.$product[$i-1]['Price_Unit'].'","'.$product[$i-1]['Qty_RF'].'","'.$product[$i-1]['Total'].'","'.$product[$i-1]['VAT'].'","'.$product[$i-1]['WHTAX'].'","'.$product[$i-1]['Total_Amount'].'","'.$product[$i-1]['RF_No'].'","'.$product[$i-1]['RF_Date'].'","'.$product[$i-1]['RF_Receive'].'","'.$product[$i-1]['Invoice_No'].'","'.$product[$i-1]['No_Faktur_Pajak'].'","'.$product[$i-1]['FP_Date'].'","'.$product[$i-1]['Due_Date'].'","'.$product[$i-1]['Complete_Date'].'","'.$product[$i-1]['IR_No'].'","'.$product[$i-1]['IR_Date'].'","'.$product[$i-1]['IR_No_2'].'","'.$product[$i-1]['IR_Date_2'].'","'.$product[$i-1]['Nota_Retur'].'","'.$product[$i-1]['Retur_Faktur_Pajak'].'","'.$product[$i-1]['Date_Retur_Faktur_Pajak'].'")';
			mysql_query($sql);
		//	echo $sql;
		//	break;
		}
	}
	
//	echo $product;
	
	return $product;
}

//==========================================================================================================================================================================================

//---------------------------------------------buat fungsi untuk megetahui apakah parameter termasuk date atau bukan----------------------------------------//
	function is_date( $str )
	{
		  $stamp = strtotime( $str );
		 
		  if (!is_numeric($stamp))
		  {
			 return FALSE;
		  }
		  
		  $month = date( 'm', $stamp );
		  $day   = date( 'd', $stamp );
		  $year  = date( 'Y', $stamp );
		 
		  if (checkdate($month, $day, $year))
		  {
			 return TRUE;
		  }
		 
		  return FALSE;
	} 
	//----------------------------------------------------------------------------------------------------------------------------------------------------------//