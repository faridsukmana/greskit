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
	//==============================Total Consumen====================
	$total_cost = 0;
	$query_data = 'SELECT SUM(IE.number_of_stock*IT.avg_price) Total_Cost FROM work_order WO, asset AE, invent_journal_movement IE, invent_item IT, invent_unit IU WHERE AE.AssetID="'.$id_asset.'" AND WO.AssetID=AE.AssetID AND IE.WorkOrderNo=WO.WorkOrderNo AND IE.state="SJVST181120050127" AND IT.item_id=IE.item_id AND IU.id_unit=IT.id_unit AND IE.date_jvmovement BETWEEN "'.$first_date.'" AND "'.$second_date.'" GROUP BY AE.AssetID';
	$result_data = mysql_exe_query(array($query_data,1));
	$result_data_now=mysql_exe_fetch_array(array($result_data,1));
	$total_cost = $result_data_now[0];
	
	$content = $total_cost;
    
	echo $content;
?>