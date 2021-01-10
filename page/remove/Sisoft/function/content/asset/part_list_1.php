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
	$query_data = 'SELECT AR.Qty Qty_Consume,IT.item_id Part_No, IT.item_description Description, IT.stock Stock_Available, IU.unit Unit, IL.id_location Location_Code,IL.detail_location Location FROM work_order WO, asset AE, invent_journal_movement IE, invent_item IT, invent_unit IU, invent_location IL,

	(SELECT IT.item_id Part_No, SUM(IE.number_of_stock) Qty FROM work_order WO, asset AE, 
	invent_journal_movement IE, invent_item IT WHERE AE.AssetID="'.$id_asset.'" AND 
	WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IE.date_jvmovement BETWEEN "'.$first_date.'" AND "'.$second_date.'" AND IT.item_id=IE.item_id GROUP BY IT.item_id ASC) AR

	WHERE AE.AssetID="'.$id_asset.'" AND WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IT.item_id=IE.item_id AND IU.id_unit=IT.id_unit AND IL.id_location=IT.id_location AND AR.Part_No=IT.item_id AND IE.date_jvmovement BETWEEN "'.$first_date.'" AND "'.$second_date.'" GROUP BY IT.item_id DESC';
	$result_data = mysql_exe_query(array($query_data,1));
	$data_list = ''; $i =1;
	while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
		$data_list .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[1].'</td>
					<td>'.$result_data_now[2].'</td>
					<td>'.$result_data_now[3].'</td>
					<td>'.$result_data_now[4].'</td>
					<td>'.$result_data_now[5].'</td>
					<td>'.$result_data_now[6].'</td>
				</tr>
			';
		$i++;
	}
	
	$content = '
					<thead>
						<tr>
							<th> No </th>
							<th> Qty Consume </th>
							<th> Part No </th>
							<th> Description </th>
							<th> Available Stock </th>
							<th> Unit </th>
							<th> Location Code </th>
							<th> Location </th>
						</tr>
					</thead>
					<tbody>
						'.$data_list.'
					</tbody>	
	';
    
	echo $content;
?>