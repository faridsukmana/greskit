<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	$id_asset = $_POST['id_asset'];
	$first_date = $_POST['first_date'];
	$second_date = $_POST['second_date'];
	//=================================================
	$query_data = WORDER.' AND WO.WorkTypeID="WT000002" AND WO.AssetID="'.$id_asset.'" AND WO.DateReceived BETWEEN "'.$first_date.'" AND "'.$second_date.'" AND WO.Hidden="no" ORDER BY WO.WorkOrderNo DESC';
	$result_data = mysql_exe_query(array($query_data,1));
	$data_table = ''; $i =1;
	while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
		$data_table .= '
			<tr>
				<td>'.$i.'</td>
				<td>'.$result_data_now[0].'</td>
				<td>'.$result_data_now[12].'</td>
				<td>'.$result_data_now[14].'</td>
				<td>'.$result_data_now[10].'</td>
			</tr>
		';
		$i++;
	}
	
	$content = '
					<thead>
						<tr>
							<th> No </th>
							<th> WO No </th>
							<th> Work Type </th>
							<th> Work Status </th>
							<th> Requestor </th>
						</tr>
					</thead>
					<tbody>
						'.$data_table.'
					</tbody>	
	';
    
	echo $content;
?>