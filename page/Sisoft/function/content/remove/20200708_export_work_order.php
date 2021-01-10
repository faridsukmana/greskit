<?php
	function export_work_order(){ 
		$content .= '<br/><div class="ade">EXPORT WO TO EXCEL</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
		$content .= '<br/><div class="form-style-2"><form action="'.PATH_EXPWO.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><legend>Work Order</legend>
								<table>
									<tr>
										<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.date_je(array('date_rec_1',$_REQUEST['date_rec_1'])).' </td>
										<td width="20"><span class="name"> </td><td></td><td>'.date_je(array('date_rec_2',$_REQUEST['date_rec_2'])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name">Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'<option value="">-</option>',$_REQUEST['asset'])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name">Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'<option value="">-</option>',$_REQUEST['wotype'])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name">Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'<option value="">-</option>',$_REQUEST['woprior'])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name">Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostate','wostate',180,'<option value="">-</option>',$_REQUEST['wostate'])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name">Work Trade </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'<option value="">-</option>',$_REQUEST['wotrade'])).'</td>
									</tr>
									<tr>
										<td width="120"><span class="name">Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'wofailcode','wofailcode',180,'<option value="">-</option>',$_REQUEST['wofailcode'])).'</td>
									</tr>
		
									<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
								</table>
							</fieldset>
							</form></div>';
		
		//------ Aksi ketika post data -----//
		if(isset($_REQUEST['post'])){
			$recdate1 = convert_date_time(array($_REQUEST['date_rec_1'],1));
			$recdate2 = convert_date_time(array($_REQUEST['date_rec_2'],1));
		
			$sql = WORDER.' AND WO.AssetID LIKE "%'.$_REQUEST['asset'].'%" AND WO.WorkTypeID LIKE "%'.$_REQUEST['wotype'].'%" AND WO.WorkPriorityID LIKE "%'.$_REQUEST['woprior'].'%" AND WO.WorkStatusID LIKE "%'.$_REQUEST['wostate'].'%" AND WO.WorkTradeID LIKE "%'.$_REQUEST['wotrade'].'%" AND WO.FailureCauseID LIKE "%'.$_REQUEST['wofailcode'].'%" AND WO.DateReceived BETWEEN "'.$recdate1.'" AND "'.$recdate2.'"' ;
			
			gen_wo_excel(array($sql,'format1',0,'wo_report'));
			$report = '<div align="center"><a href="'._ROOT_.'wo_report.xlsx" class="btn btn-info" role="button">Download Excel</a></div>';
		}
		
		$content .= $report;
		return $content;
	}
	
	function gen_wo_excel($data){
		$sql = $data[0];
		$page = $data[1];
		$sheet = $data[2];
		$name = $data[3];
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
		
		if(strcmp($page,'format1')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'No WO');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Receive Date');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Require Date');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Estimated Date Start');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Estimated Date End');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Actual Date Start');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Actual Date End');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Hand Over Date');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Assign To');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Created By');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Requestor');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Asset Name');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Work Type');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Work Priority');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Work Status');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Work Trade');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Failure Code');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Problem Desc');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Cause Description');
			$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Action Taken');
			$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Prevention Taken');
			
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
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $result_now[18]);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $result_now[18]);
				$i++; $j++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('WO Report');	
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.$name.'.xlsx'));
		
		return $content;
	}
?>