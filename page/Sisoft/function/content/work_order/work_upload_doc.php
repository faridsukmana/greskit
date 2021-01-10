<?php
	error_reporting (E_ALL ^ E_NOTICE ^ E_DEPRECATED);
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('../../../../../connect.php');
	include('../../../../../permitted.php');
	include('../../../define.php');
	
	$upload = 1;
	if(isset($_FILES['file']['name'])){
		$ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
		$location = '../../../file/supportdoc/'.$_FILES['file']['name'];
		$temp_loc = 'file/supportdoc/'.$_FILES['file']['name'];
	}else{
		$upload = 0;
	}
	
	$validext = array('doc','pdf','jpg','png');
	
	//---- Cek extension----//
	if(!in_array($ext,$validext)){
		$upload = 0;
	}else{
		$upload = 1;
	}
	
	
	//-- Read Text to new code ---//
	$myFile = "../../inc/doc.txt";
	$fh = fopen($myFile, 'r');
	$code = fread($fh, 21);
	fclose($fh);
	$ncode = $code+1;
	$fh = fopen($myFile, 'w+') or die("Can't open file.");
	fwrite($fh, $ncode);
						
	//-- Generate a new id untuk kategori aset --//
	$docid=get_new_code('DC',$ncode); 
	
	if($upload==1){
		//--- Upload File ---------//
		if(file_exists($location)) unlink($location);
		if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
		   $query = 'INSERT INTO work_document (ID_Document, Document_Name, Link) VALUES ("'.$docid.'","'.$_POST['docname'].'","'.$temp_loc.'")';
		   mysql_exe_query(array($query,1));
		}
	}
	
	//===============================Doc List==================
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
	
	//============Generate kode baru sebagai ID pada database==========
	function get_new_code($name,$val){
		if($val<10){
			$content = $name.'00000'.$val;
		}else if($val>=10 && $val<100){
			$content = $name.'0000'.$val;
		}else if($val>=100 && $val<1000){
			$content = $name.'000'.$val;
		}else if($val>=1000 && $val<10000){
			$content = $name.'00'.$val;
		}else if($val>=10000 && $val<100000){
			$content = $name.'0'.$val;
		}else if($val>=100000 && $val<1000000){
			$content = $name.$val;
		}
		return $content;
	}
	
?>