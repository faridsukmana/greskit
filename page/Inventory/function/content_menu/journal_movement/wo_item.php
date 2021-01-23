<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Content-type: text/html; charset=ASCII');
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
	
	include('../../../../../connect.php');
	
	$wo = $_POST['wo'];
	$query = 'SELECT A.item_id, A.item_description, B.request_quantity FROM invent_item A, invent_item_work_order B WHERE A.item_id=B.itemspare AND B.WorkOrderNo="'.$wo.'" AND B.itemspare NOT IN (SELECT item_id FROM invent_journal_movement WHERE WorkOrderNo="'.$wo.'")'; 
	$result = mysql_exe_query(array($query,1)); $i=1; 
	while($result_now=mysql_exe_fetch_array(array($result,1))){
		$body .= '
						<tr>
						<td>'.$i.'</td>
						<td>'.$result_now['item_id'].'</td>
						<td>
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="'.$result_now['item_id'].'" name="check_'.$result_now['item_id'].'">
							  <label class="custom-control-label" for="'.$result_now['item_id'].'">'.$result_now['item_description'].'</label>
							</div>
						</td>
						<td>'.$result_now['request_quantity'].'</td>
						<td>
							<input type="text" class="form-control" name="text_'.$result_now['item_id'].'">
						</td>
						</tr>';
		$i++;
	}
	
	$content = '<thead>
					<tr>
						<th> No </th>
						<th> Item Code </th>
						<th> Item Name </th>
						<th> Request Qty </th>
						<th> Remark </th>
					</tr>
				</thead>
				<tbody>
					'.$body.'
				</tbody>';
	
	echo $content;
?>