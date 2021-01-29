<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Content-type: text/html; charset=ASCII');
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//===============================Data Equipment Class==================
	$query = 'DELETE FROM invent_item_work_order WHERE WorkOrderNo="'.$_POST['wo'].'" AND itemspare="'.$_POST['id'].'"'; echo $query;
	mysql_exe_query(array($query,1));
	
	//---- Data Spare Part Request ------//
	$i=1; $body = ''; $q_data = 'SELECT IT.item_id Item_Code, IT.item_description Item_Name, IT.Stock Quantity,ISA.request_quantity Request, IT.remark_1, CONCAT("<a href=\'\' onclick=alert(\'",WO.WorkOrderNo,"\',\'",IT.item_id,"\')>Edit</a>") Modif FROM invent_item_work_order ISA, invent_item IT, work_order WO WHERE ISA.itemspare=IT.item_id AND ISA.WorkOrderNo=WO.WorkOrderNo AND WO.WorkOrderNo="'.$_POST['wo'].'"'; 
				
	$result = mysql_exe_query(array($q_data,1));
	while($result_data_now = mysql_exe_fetch_array(array($result,1))){
		$body .= '
			<tr>
				<td>'.$i.'</td>
				<td>'.$result_data_now[0].'</td>
				<td>'.$result_data_now[1].'</td>
				<td>'.$result_data_now[3].'</td>
				<td>'.$result_data_now[2].'</td>
				<td><button class="btn btn-danger btn-rounded btn-fw" onclick="del_partreq(\''.$result_data_now[2].'\')">Delete</td>
			</tr>
			'; $i++;
	}
	
	$table = '
				<thead>
					<tr>
						<th> No </th>
						<th> Item Code </th>
						<th> Item Name </th>
						<th> Request Stock </th>
						<th> Available Stock </th>
						<th> Delete </th>
					</tr>
				</thead>
				<tbody>
					'.$body.'
				</tbody>	
		';
    
	$content = $table;
	echo $content;
?>