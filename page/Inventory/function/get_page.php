<?php
########################################################## KHUSUS HALAMAN WEB#############################################################
	function get_page(){
				
	if(_ACCESS_){	
		//========Halaman jika terjadi logout=======
		if(isset($_REQUEST['logout'])){ 
			$content = logout();
		}
		
		//========Halaman contoh penggunaan Highchart=======
		else if(isset($_REQUEST['home'])){
			//$content = '<br/><div class="wel">WELCOME TO </div><div class="sis">IMsiF</div><div class="wel"> INVENTORY MANAGEMENT</div>';
			//$content = dashboard();
			$content = costing_report();
		}
		
		//=====================**************************CONTENT MENU INVENTORY MANAGEMENT*****************************=====================
		//=======NEW PAGE=====================
		//------ CRITICAL LEVEL--------------
		if(strcmp($_REQUEST['page'],'crlevel')==0){
			$content = critical_level();
		}
		
		//------ MOVEMENT TYPE--------------
		else if(strcmp($_REQUEST['page'],'movetype')==0){
			$content = movement_type();
		}
		
		//------ STATE JOURNAL MOVEMENT--------------
		else if(strcmp($_REQUEST['page'],'sjvmove')==0){
			$content = state_journal_movement();
		}
		
		//------ WAREHOUSE--------------
		else if(strcmp($_REQUEST['page'],'wrhouse')==0){
			$content = warehouse();
		}
		
		//------ UNIT--------------
		else if(strcmp($_REQUEST['page'],'unit')==0){
			$content = unit();
		}
		
		//------ CURRENCY--------------
		else if(strcmp($_REQUEST['page'],'curr')==0){
			$content = currency();
		}
		
		//------ COST CENTER--------------
		else if(strcmp($_REQUEST['page'],'ccenter')==0){
			$content = cost_center();
		}
		
		//------ LOCATION --------------

		else if(strcmp($_REQUEST['page'],'location')==0){
			$content = location();
		}
		
		//------ ITEM CATEGORIES --------------

		else if(strcmp($_REQUEST['page'],'brand')==0){
			$content = brand();
		}
		
		//------ ITEM CATEGORIES --------------
		else if(strcmp($_REQUEST['page'],'itemcat')==0){
			$content = categories();
		}
		
		//------ ITEMS --------------
		else if(strcmp($_REQUEST['page'],'item')==0){
			$content = inventory_items();
		}
		
		//------ ITEM STOK--------------
		else if(strcmp($_REQUEST['page'],'stock')==0){
			$content = stock();
		}
		
		//------ VENDOR--------------
		else if(strcmp($_REQUEST['page'],'vendor')==0){
			$content = vendor();
		}
		
		//------ TOPUP--------------
		else if(strcmp($_REQUEST['page'],'topup')==0){
			$content = topup();
		}
		
		//------ JOURNAL MOVEMENT--------------
		else if(strcmp($_REQUEST['page'],'jvmovement')==0){
			$content = journal_movement();
		}
		
		//------ MANUAL RETURN--------------
		else if(strcmp($_REQUEST['page'],'mreturn')==0){
			$content = manual_return();
		}
		
		//------ MOVEMENT--------------
		else if(strcmp($_REQUEST['page'],'movement')==0){
			$content = movement();
		}
		 
		//------ BRAND2--------------
		else if(strcmp($_REQUEST['page'],'brand2')==0){
			$content = brand2();
		}
		
		//------ SITE--------------
		else if(strcmp($_REQUEST['page'],'site')==0){
			$content = site();
		}
		 
		//------ RP--------------
		else if(strcmp($_REQUEST['page'],'rp')==0){
			$content = rp();
		}
		
		//======= REPORT =========
		//------ Inventory Transaction -------------
		else if(strcmp($_REQUEST['page'],'rintrans')==0){
			$content = report_itrans();
		}
		//------ Inventory Topup -------------
		else if(strcmp($_REQUEST['page'],'rintopup')==0){
			$content = report_itopup();
		}
		//------ Inventory Journal -------------
		else if(strcmp($_REQUEST['page'],'rinjourn')==0){
			$content = report_ijournal();
		}
		//------ Inventory Return -------------
		else if(strcmp($_REQUEST['page'],'rinretur')==0){
			$content = report_ireturn();
		}
		
	}else{
		$content = logout();
	}
		
		return $content;
	}
	
	//-------Fungsi untuk mendapatkan waktu terakhir mengenerate data AR -------
	function get_gendatetime(){
		$query = 'SELECT gen_datetime FROM ar_gendatetime';
		$result = mysql_query($query);
		$result_now = mysql_fetch_array($result);
		$content = '<div class="title" align="right"><i>Last Update Data : '.$result_now[0].'</i></div>';
		return $content;
	}
	
	//------Fungsi generate data ke excel -------------------------------------
	function gen_data_excel($data){
		$sql = $data[0];
		$page = $data[1];
		$content = ''; 
		$result = mysql_query($sql) or die ('FAILED TO EXPORT EXCEL'); 
		error_reporting(E_ALL);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("TPC INDO PLASTIC AND CHEMICALS")
							 ->setLastModifiedBy("TPC INDO PLASTIC AND CHEMICALS")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("document for Office 2007 XLSX, generated using PHP.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("TPC INDO PLASTIC AND CHEMICALS");
		
		if(strcmp($page,'summarydes')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINATION');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CUST ACC');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'CUSTOMER');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CURR');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'CREDIT TERM');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'COFACE');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'INTERNAL CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'OVER IN CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'TOTAL CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'OVER CREDIT LIMIT');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'TOTAL AR');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'CURRENT');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'DAYS 1 TO 7');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'DAYS 8 TO 15');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'DAYS 16 TO 30');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'DAYS 31 TO 60');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'DAYS 61 TO 90');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'DAYS 90 TO 120');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'DAYS 121 TO 150');
			$objPHPExcel->getActiveSheet()->setCellValue('T1', 'DAYS OVER 150');
			
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
				$i++; $j++;
			}
		}else if(strcmp($page,'summary')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'CUST ACC');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CUSTOMER');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'AR INCL VAT USD EQ');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'CURRENT');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'DAYS 1 TO 7');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'DAYS 8 TO 15');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'DAYS 16 TO 30');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'DAYS 31 TO 60');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'DAYS 61 TO 90');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'DAYS 90 TO 120');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'DAYS 121 TO 150');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'DAYS OVER 150');
			
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
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result_now[11]);
				$i++; $j++;
			}
		}else if(strcmp($page,'detail')==0 || strcmp($page,'detailidr')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'MARKET');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'CUST ACC');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'CUSTOMER');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'INV DATE');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'DUE DATE');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'TAX FX');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'INVOICE NO');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'CURR');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'AR INCL VAT');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'AR EXCL VAT');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'VAT USD');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'VAT IDR EQUIVALENT');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'DAYS OVERDUE');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'NO OF DAYS');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'AR INCL VAT USD EQ');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'CURRENT');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'DAYS 1 TO 7');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'DAYS 8 TO 15');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'DAYS 16 TO 30');
			$objPHPExcel->getActiveSheet()->setCellValue('T1', 'DAYS 31 TO 60');
			$objPHPExcel->getActiveSheet()->setCellValue('U1', 'DAYS 61 TO 90');
			$objPHPExcel->getActiveSheet()->setCellValue('V1', 'DAYS 90 TO 120');
			$objPHPExcel->getActiveSheet()->setCellValue('W1', 'DAYS 121 TO 150');
			$objPHPExcel->getActiveSheet()->setCellValue('X1', 'DAYS OVER 150');
			
			
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
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, $result_now[21]);
				$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, $result_now[22]);
				$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, $result_now[23]);
				$i++; $j++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('AR REPORT');	
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.'Ar_Report.xlsx'));
		
		return $content;
	}
	
	function pop_up($definepage){ $content = '';
		if(strcmp($definepage,'assets')==0 && isset($_REQUEST['dataid'])){
		$query = ASSETS.' AND  A.AssetID="'.$_REQUEST['dataid'].'"'; $result=mysql_query($query); $result_now=mysql_fetch_array($result);
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$result_now[2].'</h1>
				
				<img src="'.$result_now[19].'" class="popup__media popup__media_right" alt="Image of Asset">
				<table class="text-popup">
				<tr height="30"><td>Asset Number</td><td> : </td><td>'.$result_now[0].'</td></tr>
				<tr height="30"><td>Location </td><td> : </td><td>'.$result_now[3].'</td>
				<tr height="30"><td>Department </td><td> : </td><td>'.$result_now[4].'</td>
				<tr height="30"><td>Asset Category </td><td> : </td><td>'.$result_now[5].'</td>
				<tr height="30"><td>Asset Status <td> : </td><td>'.$result_now[6].'</td>
				<tr height="30"><td>Criticaly </td><td> : </td><td>'.$result_now[7].'</td>
				<tr height="30"><td>Supplier Name </td><td> : </td><td>'.$result_now[9].'</td>
				<tr height="30"><td>Manufacturer </td><td> : </td><td>'.$result_now[10].'</td>
				<tr height="30"><td>Model Number </td><td> : </td><td>'.$result_now[11].'</td>
				<tr height="30"><td>Serial Number </td><td> : </td><td>'.$result_now[12].'</td>
				<tr height="30"><td>Warranty </td><td>: </td><td>'.$result_now[13].'</td>
				<tr height="30"><td>Warranty Date </td><td> : </td><td>'.$result_now[15].'</td>
				<tr height="30"><td>Warranty Acquired </td><td> : </td><td>'.$result_now[17].'</td>
				<tr height="30"><td>Warranty Note </td><td> : </td><td>'.$result_now[14].'</td>
				<tr height="30"><td>Asset Note </td><td> : </td><td>'.$result_now[16].'</td>
				</table>
				
				
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		}
		
		else if(strcmp($definepage,'worder')==0 && isset($_REQUEST['dataid'])){
		$query = WORDER.' AND  WO.WorkOrderNo="'.$_REQUEST['dataid'].'"'; $result=mysql_query($query); $result_now=mysql_fetch_array($result);
		$content = '	
			<div id="popup-article" class="popup">
			  <div class="popup__block">
				<h1 class="popup__title">'.$result_now[0].'</h1>
				<img src="'.$result_now[21].'" class="popup__media popup__media_right" alt="Image of Asset">
				<table class="text-popup">
				<tr height="30"><td>Asset Name </td><td> : </td><td>'.$result_now[11].'</td>
				<tr height="30"><td>WO State </td><td> : </td><td>'.$result_now[14].'</td>
				<tr height="30"><td>WO Priority </td><td> : </td><td>'.$result_now[10].'</td>
				<tr height="30"><td>WO Type </td><td> : </td><td>'.$result_now[13].'</td>
				<tr height="30"><td>WO Trade </td><td> : </td><td>'.$result_now[15].'</td>
				<tr height="30"><td>Created By </td><td> : </td><td>'.$result_now[9].'</td>
				<tr height="30"><td>Requestor </td><td> : </td><td>'.$result_now[10].'</td>
				<tr height="30"><td>Assign To </td><td> : </td><td>'.$result_now[8].'</td>
				<tr height="30"><td>Receive Date </td><td> : </td><td>'.$result_now[1].'</td>
				<tr height="30"><td>Require Date </td><td> : </td><td>'.$result_now[2].'</td>
				<tr height="30"><td>Estimate Date Start</td><td> : </td><td>'.$result_now[3].'</td>
				<tr height="30"><td>Estimate Date End</td><td> : </td><td>'.$result_now[4].'</td>
				<tr height="30"><td>Actual Date Start</td><td> : </td><td>'.$result_now[5].'</td>
				<tr height="30"><td>Actual Date Start</td><td> : </td><td>'.$result_now[6].'</td>
				<tr height="30"><td>Handover Date Start</td><td> : </td><td>'.$result_now[7].'</td>
				<tr height="30"><td>Failure Code </td><td> : </td><td>'.$result_now[16].'</td>
				<tr height="30"><td>Problem Desc </td><td> : </td><td>'.$result_now[17].'</td>
				<tr height="30"><td>Cause Desc </td><td> : </td><td>'.$result_now[18].'</td>
				<tr height="30"><td>Solution </td><td> : </td><td>'.$result_now[19].'</td>
				<tr height="30"><td>Prevention </td><td> : </td><td>'.$result_now[20].'</td>
				</table>
				
				
				<a href="#" class="popup__close">close</a>
			  </div>
			</div>
			';
		}
		return $content;
	}
	
	//################## fungsi datepicker tanggal menggunakan dateicker bootstrap#############//
	function js_topup(){
		$content .= "
				<script type='text/javascript'>
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
				</script>
		";
		return $content;
	}
#########################################################################################################################################	
?>