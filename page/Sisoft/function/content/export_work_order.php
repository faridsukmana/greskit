<?php
	function export_work_order(){ 
		$content .= '<br/><div class="ade">EXPORT WO TO EXCEL</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
		$content .= '<br/><div class="form-style-2"><form action="'.PATH_EXPWO.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Work Order</div>
								<div class="row">
									<div class="col-6">
										<table>
											<tr>
												<td width="120"><span class="name"> Receive Date </td><td>:</td><td>'.date_je(array('date_rec_1',$_REQUEST['date_rec_1'])).' </td>
											</tr>
											<tr>
												<td width="20"><span class="name"> </td><td></td><td>'.date_je(array('date_rec_2',$_REQUEST['date_rec_2'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Asset </td><td>:</td><td>'.combo_je(array(COMASSETS,'asset','asset',180,'<option value="">-</option>',$_REQUEST['asset'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Work Type </td><td>:</td><td>'.combo_je(array(COMWOTYPE,'wotype','wotype',180,'<option value="">-</option>',$_REQUEST['wotype'])).'</td>
											</tr>
											<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
										</table>
									</div>
									<div class="col-6">
										<table>
											<tr>
												<td width="120"><span class="name">Work Priority </td><td>:</td><td>'.combo_je(array(COMWOPRIOR,'woprior','woprior',180,'<option value="">-</option>',$_REQUEST['woprior'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Work Status </td><td>:</td><td>'.combo_je(array(COMWOSTAT,'wostate','wostate',180,'<option value="">-</option>',$_REQUEST['wostate'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Section </td><td>:</td><td>'.combo_je(array(COMWOTRADE,'wotrade','wotrade',180,'<option value="">-</option>',$_REQUEST['wotrade'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Failure Code </td><td>:</td><td>'.combo_je(array(COMFAILURE,'wofailcode','wofailcode',180,'<option value="">-</option>',$_REQUEST['wofailcode'])).'</td>
											</tr>
										</table>
									</div>
								</div>
							</fieldset>
							</form></div>';
		
		//------ Aksi ketika post data -----//
		if(isset($_REQUEST['post'])){
			$data_table = '';
			$recdate1 = convert_date_time(array($_REQUEST['date_rec_1'],1));
			$recdate2 = convert_date_time(array($_REQUEST['date_rec_2'],1));
		
			$sql = WORDER.' AND WO.AssetID LIKE "%'.$_REQUEST['asset'].'%" AND WO.WorkTypeID LIKE "%'.$_REQUEST['wotype'].'%" AND WO.WorkPriorityID LIKE "%'.$_REQUEST['woprior'].'%" AND WO.WorkStatusID LIKE "%'.$_REQUEST['wostate'].'%" AND WO.WorkTradeID LIKE "%'.$_REQUEST['wotrade'].'%" AND WO.FailureCauseID LIKE "%'.$_REQUEST['wofailcode'].'%" AND WO.DateReceived BETWEEN "'.$recdate1.'" AND "'.$recdate2.'"' ; 
			$result = mysql_query($sql) or die ('FAILED TO GENERATE QUERY'); 
			while($result_now= mysql_fetch_array($result)){
				$data_table .= '
							<tr>	
								<td>'.$result_now[0].'</td>
								<td>'.$result_now[5].'</td>
								<td>'.$result_now[6].'</td>
								<td>'.$result_now[8].'</td>
								<td>'.$result_now[9].'</td>
								<td>'.$result_now[10].'</td>
								<td>'.$result_now[11].'</td>
								<td>'.$result_now[12].'</td>
							</tr>
				';
			}
			
			gen_wo_excel(array($sql,'format1',0,'wo_report'));
			$report = '<div align="center"><a href="'._ROOT_.'wo_report.xlsx" class="btn btn-info" role="button">Download Excel</a></div>';
			
			
			$content .= $report.'    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<table id="asset-data" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
									<th>WO No</th>
									<th>Actual Date Start</th>
									<th>Actual Date End</th>
									<th>Assign To</th>
									<th>Created By</th>
									<th>Requestor</th>
									<th>Asset Name</th>
									<th>Work Type</th>
								</tr>
							  </thead>
							  <tbody>
								'.$data_table.'
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- content-wrapper ends -->
			';
		}
		
		$content .= wo_js(); 
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
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'WO No');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Problem Desc');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Asset No');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Asset Description');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Work Type');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Section');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Requested Date');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Require Date');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Estimated Date Start');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Estimated Date End');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Actual Date Start');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Actual Date End');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Cause Description');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Action Taken');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Prevention Taken');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Work Status');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Failure Code');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Site');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Plant');
			$objPHPExcel->getActiveSheet()->setCellValue('T1', 'Process');
			$objPHPExcel->getActiveSheet()->setCellValue('U1', 'Unit');
			$objPHPExcel->getActiveSheet()->setCellValue('V1', 'Equipment Classification');
			$objPHPExcel->getActiveSheet()->setCellValue('W1', 'Part Classification');
			
			$i=2;
			$j=1;
			while($result_now= mysql_fetch_array($result)){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $result_now[0]);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $result_now[17]);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $result_now[24]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $result_now[11]);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $result_now[12]);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $result_now[18]);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $result_now[1]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $result_now[2]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $result_now[3]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $result_now[4]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $result_now[5]);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $result_now[6]);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $result_now[18]);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $result_now[19]);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $result_now[20]);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, $result_now[14]);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, $result_now[16]);
				
				$q= 'SELECT A.AssetID Asset_ID, A.AssetNo Asset_No, A.AssetDesc Asset_Desc, L.LocationDescription Location_Desc, D.DepartmentDesc Department_Desc, C.AssetCategory Asset_Category, S.AssetStatusDesc Asset_Status, I.Criticaly Critically, E.FirstName Auth_Employee, P.SupplierName Supplier_Name, A.Manufacturer Manufacturer, A.ModelNumber Model_Number, A.SerialNumber Serial_Number, W.warranty Warranty, A.WarrantyNotes Warranty_Notes, A.WarrantyDate Warranty_Date, A.AssetNote Asset_Note, A.DateAcquired Date_Acquired, A.DateSold Date_Sold, A.ImagePath, A.QRPath, R.AreaCode Area_Code, T.PlantCode Plant_Code
				FROM 
				asset A, location L, department D, asset_status S, asset_category C, critically I, supplier P, warranty_contract W, employee E, area R, plant T
				WHERE 
				A.locationID=L.locationID AND A.departmentID=D.departmentID AND A.AssetStatusID=S.AssetStatusID AND A.AssetCategoryID=C.AssetCategoryID AND A.CriticalID=I.CriticalID AND A.SupplierID=P.Supplier_ID AND A.WarrantyID=W.WarrantyID AND A.EmployeeID=E.EmployeeID AND A.AreaId=R.AreaId AND A.AssetNo="'.$result_now[24].'"';
				
				$r = mysql_query($q);
				$rn = mysql_fetch_array($r);
				
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, $rn[21]);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, $rn[22]);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, $rn[3]);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, $rn[5]);
				
			$q_data = 'SELECT C.item_no_code, C.item_category_description, I.item_id, item_description FROM invent_item I, work_order W, invent_item_categories C, work_failure_analysis S WHERE S.item_id=I.item_id AND  I.item_category_code=C.item_category_code AND S.WorkOrderNo=W.WorkOrderNo AND W.WorkOrderNo="'.$result_now[0].'"'; 
				$r_data = mysql_query($q_data);
				
				$k=$i;
				while($rn_data = mysql_fetch_array($r_data)){
					$objPHPExcel->getActiveSheet()->setCellValue('V'.$k, $rn_data[0]);
					$objPHPExcel->getActiveSheet()->setCellValue('W'.$k, $rn_data[2]);
					$k++;
				}
				if($k<>$i){$i=$k-1;}
				
				$i++; $j++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('WO Report');	
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.$name.'.xlsx'));
		
		return $content;
	}
	
	function wo_js(){
		$content="
			<script>
				$('#asset-data').DataTable({
					dom: 'Bfrtip',
					scrollX: 200,					
					buttons: [
						{
							className: 'green glyphicon glyphicon-file',
							extend: 'pdfHtml5',
							messageTop: 'Asset Data',
							orientation: 'landscape',
							download: 'open',
							pageSize: 'LEGAL'
						},
						{
							extend: 'csv',
							text: 'CSV',
							exportOptions: {
								modifier: {
									search: 'none'
								}
							}
						},
						{
							extend: 'excelHtml5',
							text: 'Excel',
							exportOptions: {
								modifier: {
									page: 'current'
								}
							}
						},
						{
							extend: 'print',
							text: 'Print',
							autoPrint: false
						}
					]
				});
			</script>
		";
		
		return $content;
	}
?>