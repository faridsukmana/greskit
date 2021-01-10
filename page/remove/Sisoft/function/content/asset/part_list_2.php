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
	//===============================Part List==================
	//===============================Part Consume==================
	$query_data = 'SELECT IE.date_jvmovement Date, IT.item_id Part_No, IT.item_description Description, IE.number_of_stock Qty, IU.unit Unit, IT.avg_price Price, (IE.number_of_stock*IT.avg_price) Cost ,WO.WorkOrderNo WO_Number FROM work_order WO, asset AE, invent_journal_movement IE, invent_item IT, invent_unit IU WHERE AE.AssetID="'.$id_asset.'" AND WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IT.item_id=IE.item_id AND IU.id_unit=IT.id_unit AND IE.date_jvmovement BETWEEN "'.$first_date.'" AND "'.$second_date.'"';
	
	$result_data = mysql_exe_query(array($query_data,1));
	$data_table = ''; $i =1;
	while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
		$data_table .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[1].'</td>
					<td>'.$result_data_now[2].'</td>
					<td>'.$result_data_now[3].'</td>
					<td>'.$result_data_now[4].'</td>
					<td>'.$result_data_now[5].'</td>
					<td>'.$result_data_now[6].'</td>
					<td>'.$result_data_now[7].'</td>
				</tr>
			';
		$i++;
	}
	
	$content = '
					<thead>
						<tr>
							<th> No </th>
							<th> Date </th>
							<th> Part No </th>
							<th> Description </th>
							<th> Qty </th>
							<th> Unit </th>
							<th> Unit Price </th>
							<th> Cost </th>
							<th> WO Number </th>
						</tr>
					</thead>
					<tbody>
						'.$data_table.'
					</tbody>	
	';
    
	echo $content;
?>