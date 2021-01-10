<?php
	//================Data Work Order from asset============================//
	function type_history_wo(){
		$content = pop_up(array('worder',PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo'));
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['rowid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//=================================================
		$query_data = WORDER.' AND WO.WorkTypeID<>"WT000002" AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td><a href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo&dataid='.$result_data_now[0].'#popup-article">'.$result_data_now[0].'</a></td>
					<td>'.$result_data_now[14].'</td>
					<td>'.$result_data_now[16].'</td>
					<td>'.$result_data_now[10].'</td>
			';
			$i++;
		}
		
		
		$content .= '<div class="toptext" align="center">'._USER_VIEW_HISTORY.'</div>';
				$content .= '<div style="margin-top:5px;" st align="center">'._USER_WO_._USER_PM_._USER_RC_.'</div>';
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Work Order History</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							<table id="asset-his" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> WO No </th>
								  <th> Work Type </th>
								  <th> Work Status </th>
								  <th> Assign To </th>
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
		return $content;
	}
	
	//================Data Preventive Maintenance from asset============================//
	function type_history_pm(){
		$content = pop_up(array('worder',PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo'));
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['rowid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//=================================================
		$query_data = WORDER.' AND WO.WorkTypeID="WT000002" AND WO.AssetID="'.$_REQUEST['rowid'].'" ORDER BY WO.WorkOrderNo DESC';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td><a href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo&dataid='.$result_data_now[0].'#popup-article">'.$result_data_now[0].'</a></td>
					<td>'.$result_data_now[14].'</td>
					<td>'.$result_data_now[16].'</td>
					<td>'.$result_data_now[10].'</td>
				</tr>
			';
			$i++;
		}
		
		
		$content .= '<div class="toptext" align="center">'._USER_VIEW_HISTORY.'</div>';
				$content .= '<div style="margin-top:5px;" st align="center">'._USER_WO_._USER_PM_._USER_RC_.'</div>';
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Preventive Maintenance History</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							<table id="asset-his" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> WO No </th>
								  <th> Work Type </th>
								  <th> Work Status </th>
								  <th> Assign To </th>
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
		return $content;
	}
	
	//================Data Routine Checklist from asset============================//
	function type_history_rc(){
		$content = pop_up(array('worder',PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo'));
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['rowid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//=================================================
		$query_data = 'SELECT A.id_checklist_history ID, B.form_name Form_Name, A.date Date, C.AssetID FROM checklist_history A, checklist_form_name B, checklist_master C WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=C.id_master_checklist AND C.AssetID="'.$_REQUEST['rowid'].'" GROUP BY A.date';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[2].'</td>
					<td><a href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=rc&date='.$result_data_now[2].'"><label class="badge badge-danger">Detail</label></a></td>
				</tr>
			';
			$i++;
		}
		
		
		$content .= '<div class="toptext" align="center">'._USER_VIEW_HISTORY.'</div>';
				$content .= '<div style="margin-top:5px;" st align="center">'._USER_WO_._USER_PM_._USER_RC_.'</div>';
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Routine Checklist History</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b></code> </p>
							<table id="asset-his" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> Date </th>
								  <th> Detail </th>
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
		return $content;
	}
	
	function tipe_history_rc_detail(){
		$content = pop_up(array('worder',PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo'));
		$query = 'SELECT AssetID, AssetNo, AssetDesc FROM asset WHERE AssetID="'.$_REQUEST['rowid'].'"';
		$result = mysql_exe_query(array($query,1));
		$result_now=mysql_exe_fetch_array(array($result,1));
		$asset_no = $result_now[1];
		$name_asset = $result_now[2];
		
		//=================================================
		$query_data = 'SELECT A.id_checklist_history ID, B.form_name Form_Name, A.date Date, C.AssetID, I.description, A.description FROM checklist_history A, checklist_form_name B, checklist_master C,checklist_item I WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=C.id_master_checklist AND I.id_item_check=C.id_item_check AND C.AssetID="'.$_REQUEST['rowid'].'" AND A.date="'.$_REQUEST['date'].'" ORDER BY B.form_name, I.description ASC';
		$result_data = mysql_exe_query(array($query_data,1));
		$data_table = ''; $i =1;
		while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
			$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[1].'</td>
					<td>'.$result_data_now[4].'</td>
					<td>'.$result_data_now[5].'</td>
				</tr>
			';
			$i++;
		}
		
		
		$content .= '<div class="toptext" align="center">
					<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=rc">Back</a></span>
					</div>';
		$content .= '    
				  <div class="content-wrapper">
					<div class="row">
					  <div class="col-lg-12 grid-margin stretch-card">
						<div class="card">
						  <div class="card-body">
							<h4 class="card-title">Detail Routine Checklist</h4>
							<p class="card-description"> Detail Asset <code>code :<b>'.$asset_no.'</b>, name : <b>'.$name_asset.'</b>, date : <b>'.$_REQUEST['date'].'</b></code> </p>
							<table id="asset-his" class="table table-bordered" style="width:100%">
							  <thead>
								<tr>
								  <th> No </th>
								  <th> Form Name </th>
								  <th> Item Check </th>
								  <th> Result </th>
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
		return $content;
	}
	
	function asset_history_js(){
		$content="
			<script>
				$('#asset-his').DataTable({
					dom: 'Bfrtip',
					//scrollX: 200,					
					buttons: [
						{
							className: 'green glyphicon glyphicon-file',
							extend: 'pdfHtml5',
							messageTop: ''
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