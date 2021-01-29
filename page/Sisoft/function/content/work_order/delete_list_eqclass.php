<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Content-type: text/html; charset=ASCII');
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//===============================Data Equipment Class==================
	$query = 'DELETE FROM work_failure_analysis WHERE WorkOrderNo="'.$_POST['wo'].'" AND item_id="'.$_POST['item'].'"';
	mysql_exe_query(array($query,1));
	
	$i=1; $body = ''; $q_data = 'SELECT C.item_no_code, C.item_category_description, I.item_id, item_description FROM invent_item I, work_order W, invent_item_categories C, work_failure_analysis S WHERE S.item_id=I.item_id AND  I.item_category_code=C.item_category_code AND S.WorkOrderNo=W.WorkOrderNo AND W.WorkOrderNo="'.$_POST['wo'].'"'; 
				$result = mysql_exe_query(array($q_data,1));
				while($result_data_now = mysql_exe_fetch_array(array($result,1))){
					$body = '
						<tr>
						<td>'.$i.'</td>
						<td>'.$result_data_now[0].'</td>
						<td>'.$result_data_now[1].'</td>
						<td>'.$result_data_now[2].'</td>
						<td>'.$result_data_now[3].'</td>
						<td><button class="btn btn-danger btn-rounded btn-fw" onclick="del_eqclass(\''.$result_data_now[2].'\')">Delete</td>
					</tr>
					'; $i++;
				}
				
				$table = '
					<thead>
						<tr>
							<th> No </th>
							<th> Equipment Class Code </th>
							<th> Equipment Class Description </th>
							<th> Spare Part Code </th>
							<th> Spare Part Descriptions </th>
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