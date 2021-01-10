<?php
	function report_itrans(){
		$content .= '<br/><div class="ade">'.TRINTRANS.'</div>';
		//----- Buat Form Isian Berikut-----
		$name_field=array('Date Transcation from','To','Type Transcation','Brand','Item');
		$input_type=array(
						date_je(array('from','')),
						date_je(array('to','')),
						combo_je(array(COMBMOVETYPE,'movetype','movetype',350,'<option value="">-</option>','')),
						combo_je(array(COMBRAND,'brand','brand',350,'<option value="">-</option>','')),
						combo_je(array(COMBITEM,'item','item',350,'<option value="">-</option>',''))
					);
		$signtofill = array('','','','','');
		$content .= create_form(array('',PATH_RINTRANS.GEN,1,$name_field,$input_type,$signtofill)).js_topup();
		if(isset($_REQUEST['gen'])){
			if(!empty($_REQUEST['from']) && !empty($_REQUEST['to'])){
				$query = MOVEMENT.' AND M.movement_date BETWEEN "'.$_REQUEST['from'].'" AND "'.$_REQUEST['to'].'" AND M.type LIKE "%'.$_REQUEST['movetype'].'%" AND B.brand_id LIKE "%'.$_REQUEST['brand'].'%" AND I.item_id LIKE "%'.$_REQUEST['item'].'%" ORDER BY M.movement_date DESC';
			}
			else{
				$query = MOVEMENT.' AND M.type LIKE "%'.$_REQUEST['movetype'].'%" AND B.brand_id LIKE "%'.$_REQUEST['brand'].'%" AND I.item_id LIKE "%'.$_REQUEST['item'].'%" ORDER BY M.movement_date DESC';
			}
			
			$info= excel_itrans(array($query,'Inventory Transaction','0'));
		}
		return $info.$content;
	}
	
	function excel_itrans($data){
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
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray(array('font' => array('size' => 13,'bold' => true,'color' => array('rgb' => 'f3092a')),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)));
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Movement Date');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Journal Number');
		$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Item Name');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Brand');
		$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Movement Type');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Quantity');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Remark 1');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Remark 2');
			
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
			//$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[7]);
			//$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$i,$result_now[7], PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[7]);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result_now[8]);
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
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		
		
		$objPHPExcel->getActiveSheet()->setTitle($name);	
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.'file/report/'.$name.'.xlsx'));
		
		$content= success_info(array('Excel already available. <a href="'._ROOT_.'file/report/'.$name.'.xlsx'.'">Download this file</a>'));
		return $content;
	}
	
	function fpdf_itrans(){
		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Hello World!');
		$pdf->Output();
	}
?>