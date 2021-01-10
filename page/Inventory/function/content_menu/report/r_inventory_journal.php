<?php
	function report_ijournal(){
		$content .= '<br/><div class="ade">'.TRINJOURN.'</div>';
		//----- Buat Form Isian Berikut-----
		$name_field=array('Date Journal Movement from','To','Brand','Item','State','Cost Center','Warehouse');
		$input_type=array(
						date_je(array('from','')),
						date_je(array('to','')),
						combo_je(array(COMBRAND,'brand','brand',350,'<option value="">-</option>','')),
						combo_je(array(COMBITEM,'item','item',350,'<option value="">-</option>','')),
						combo_je(array(COMBSTATE,'state','state',350,'<option value="">-</option>','')),
						combo_je(array(COMBCCENTER,'ccenter','ccenter',350,'<option value="">-</option>','')),
						combo_je(array(COMBWRHOUSE,'warehouse','warehouse',350,'<option value="">-</option>',''))
					);
		$signtofill = array('','','','','');
		$content .= create_form(array('',PATH_RINJOURN.GEN,1,$name_field,$input_type,$signtofill)).js_topup();
		if(isset($_REQUEST['gen'])){
			if(!empty($_REQUEST['from']) && !empty($_REQUEST['to'])){
				$query = JVMOVEMENT.' AND J.date_jvmovement BETWEEN "'.$_REQUEST['from'].'" AND "'.$_REQUEST['to'].'" AND B.brand_id LIKE "%'.$_REQUEST['brand'].'%" AND I.item_id LIKE "%'.$_REQUEST['item'].'%" AND J.state LIKE "%'.$_REQUEST['state'].'%" AND J.id_cost_center LIKE "%'.$_REQUEST['ccenter'].'%" AND I.warehouse_id LIKE "%'.$_REQUEST['warehouse'].'%" ORDER BY J.date_jvmovement DESC';
			}
			else{
				$query = JVMOVEMENT.' AND B.brand_id LIKE "%'.$_REQUEST['brand'].'%" AND I.item_id LIKE "%'.$_REQUEST['item'].'%" AND J.state LIKE "%'.$_REQUEST['state'].'%" AND J.id_cost_center LIKE "%'.$_REQUEST['ccenter'].'%" AND I.warehouse_id LIKE "%'.$_REQUEST['warehouse'].'%" ORDER BY J.date_jvmovement DESC';
			}
			
			$info = excel_ijournal(array($query,'Inventory Journal','0'));
		}
		return $info.$content;
	}
	
	function excel_ijournal($data){
		$sql = $data[0];
		$name = $data[1];
		$sheet = $data[2];
		$content = ''; 
		$result = mysql_query($sql) or die ('FAILED TO EXPORT EXCEL'); 
		error_reporting(E_ALL);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("GRESKIT-CMMS")
							 ->setLastModifiedBy("GRESKIT-CMMS")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("document for Office 2007 XLSX, generated using PHP.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("GRESKIT-CMMS");
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray(array('font' => array('size' => 13,'bold' => true,'color' => array('rgb' => 'f3092a')),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Date');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Item Name');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Brand');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Cost Center');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Warehouse');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'State');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Number of Stock');
			
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
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[8]);
			$i++; $j++;
		}
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		
		
		$objPHPExcel->getActiveSheet()->setTitle($name);	
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.'file/report/'.$name.'.xlsx'));
		
		$content= success_info(array('Excel already available. <a href="'._ROOT_.'file/report/'.$name.'.xlsx'.'">Download this file</a>'));
		return $content;
	}
?>