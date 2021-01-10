<?php
	function export_asset(){
		$content .= '<br/><div class="ade">EXPORT ASSET TO EXCEL</div>';
		$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
		$content .= '<br/><div class="form-style-2"><form action="'.PATH_EXPAS.ADD.POST.'" method="post" enctype="multipart/form-data">
							<fieldset><div class="card-header text-center">Asset</div>
								<div class="row">
									<div class="col-6">
										<table>
											<tr>
												<td width="120"><span class="name">Asset Category </td><td>:</td><td>'.combo_je(array(COMASSCAT,'ascat','ascat',180,'<option value="">-</option>',$_REQUEST['ascat'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Plant Code </td><td>:</td><td>'.combo_je(array(PLANT,'asset','asset',180,'<option value="">-</option>',$_REQUEST['asset'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Department </td><td>:</td><td>'.combo_je(array(LOCATNDEPART,'dept','dept',180,'<option value="">-</option>',$_REQUEST['dept'])).'</td>
											</tr>
											<tr><td></td><td></td><td><input class="form-submit" type="submit" value="Submit"></td></tr>
										</table>
									</div>
									<div class="col-6">
										<table>
											<tr>
												<td width="120"><span class="name">Asset Status </td><td>:</td><td>'.combo_je(array(COMASSTAT,'asstat','asstat',180,'<option value="">-</option>',$_REQUEST['asstat'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Critically </td><td>:</td><td>'.combo_je(array(COMCRITIC,'critic','critic',180,'<option value="">-</option>',$_REQUEST['critic'])).'</td>
											</tr>
											<tr>
												<td width="120"><span class="name">Supplier Name </td><td>:</td><td>'.combo_je(array(COMSUPPLY,'suppname','suppname',180,'<option value="">-</option>',$_REQUEST['suppname'])).'</td>
											</tr>
										</table>
									</div>
								</div>
							</fieldset>
							</form></div>';
		//------ Aksi ketika post data -----//
		if(isset($_REQUEST['post'])){
			$data_table = '';
			$sql = ASSETS. ' AND A.AssetCategoryID LIKE "%'.$_REQUEST['ascat'].'%" AND T.PlantId LIKE "%'.$_REQUEST['asset'].'%" AND D.DepartmentID LIKE "%'.$_REQUEST['dept'].'%" AND S.AssetStatusID LIKE "%'.$_REQUEST['asstat'].'%" AND I.CriticalID LIKE "%'.$_REQUEST['critic'].'%" AND P.Supplier_ID LIKE "%'.$_REQUEST['suppname'].'%"'; 
			$result = mysql_query($sql) or die ('FAILED TO GENERATE QUERY'); 
			while($result_now= mysql_fetch_array($result)){
				$data_table .= '
							<tr>	
								<td>'.$result_now[0].'</td>
								<td>'.$result_now[1].'</td>
								<td>'.$result_now[2].'</td>
								<td>'.$result_now[3].'</td>
								<td>'.$result_now[4].'</td>
								<td>'.$result_now[5].'</td>
								<td>'.$result_now[6].'</td>
								<td>'.$result_now[7].'</td>
							</tr>
				';
			}
			
			//=========GENERATER EXCEL=============================
			gen_asset_excel(array($sql,'format1',0,'asset_report'));
			$report = '<div align="center"><a href="'._ROOT_.'asset_report.xlsx" class="btn btn-info" role="button">Download Excel</a></div>';
			
			$content .= $report.'    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<table id="asset-data" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
									<th> Asset ID </th>
									<th> No Asset </th>
									<th>Asset Description</th>
									<th>Location Description</th>
									<th>Department Description</th>
									<th>Category Asset</th>
									<th>Status Asset</th>
									<th>Critically</th>
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
			
			//gen_asset_excel(array($sql,'format1',0,'asset_report'));
			//$report = '<div align="center"><a href="'._ROOT_.'asset_report.xlsx" class="btn btn-info" role="button">Download Excel</a></div>';
		}
		
		//$content .= $report;
		$content .= asset_js(); 
		return $content;
	}
	
	function gen_asset_excel($data){
		$sql = $data[0];
		$page = $data[1];
		$sheet = $data[2];
		$name = $data[3];
		$content = ''; 
		$result = mysql_query($sql) or die ('FAILED TO EXPORT EXCEL'); 
		error_reporting(E_ALL);
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("GRESKIT")
							 ->setLastModifiedBy("GRESKIT")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("document for Office 2007 XLSX, generated using PHP.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("GRESKIT");
		
		if(strcmp($page,'format1')==0){
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Asset ID');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'No Asset');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Asset Description');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Location Description');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Department Description');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Category Asset');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Status Asset');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Critically');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Auth. Employee');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Supplier Name');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Manufacture');
			$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Model Number');
			$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Serial Number');
			$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Warranty');
			$objPHPExcel->getActiveSheet()->setCellValue('O1', 'Warranty Notes');
			$objPHPExcel->getActiveSheet()->setCellValue('P1', 'Warranty Date');
			$objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Asset Note');
			$objPHPExcel->getActiveSheet()->setCellValue('R1', 'Acquired Date');
			$objPHPExcel->getActiveSheet()->setCellValue('S1', 'Sold Date');
			
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
				$i++; $j++;
			}
		}
		
		$objPHPExcel->getActiveSheet()->setTitle('Asset Report');	
		$objPHPExcel->setActiveSheetIndex($sheet);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save(str_replace('', '.xlsx', _ROOT_.$name.'.xlsx'));
		
		return $content;
	}
	
	function asset_js(){
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