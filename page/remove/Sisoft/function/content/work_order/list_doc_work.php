<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	//===============================Doc==================
	$query_data = 'SELECT ID_Document, Document_Name, Link FROM work_document ORDER BY ID_Document DESC';
	$result_data = mysql_exe_query(array($query_data,1));
	$data_list = ''; $i =1;
	while($result_data_now=mysql_exe_fetch_array(array($result_data,1))){
		$data_list .= '
				<tr>
					<td>'.$i.'</td>
					<td>'.$result_data_now[0].'</td>
					<td>'.$result_data_now[1].'</td>
					<td><a href="'._ROOT_.$result_data_now[2].'">Link</a></td>
					<td><button class="btn btn-danger btn-rounded btn-fw" onclick="del_doc(\''.$result_data_now[0].'\')">Delete</td>
				</tr>
			';
		$i++;
	}
	
	$content = '
					<thead>
						<tr>
							<th>No</th>
							<th>Document ID</th>
							<th>Document Name</th>
							<th>Link</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						'.$data_list.'
					</tbody>	
	';
    
	echo $content;
?>