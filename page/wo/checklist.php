<?php
	header('Origin:xxx.com');
    header('Access-Control-Allow-Origin:*');
    include('conf.php');
	
	$assetid=$_POST['assetid'];

    $con = new mysqli(host,user,pass,dbase);
	if($con -> connect_errno){
        printf("Connection error: %s\n", $con->connect_error);
    }
	
	if(empty($assetid)){
		/*$query = '
			SELECT A.id_checklist_history ID, B.form_name Form_Name, date Date FROM checklist_history A, checklist_form_name B WHERE A.id_form_checklist=B.id_form_checklist AND A.id_form_checklist NOT IN (SELECT id_form_checklist FROM pm_checklist WHERE id_form_checklist<>""	 OR id_form_checklist <> NULL GROUP BY id_form_checklist) GROUP BY A.id_checklist_history ORDER BY date DESC';*/
		$query = '
			SELECT A.id_checklist_history ID, B.form_name Form_Name, date Date FROM checklist_history A, checklist_form_name B WHERE A.id_form_checklist=B.id_form_checklist AND A.id_checklist_history NOT IN (SELECT id_checklist_history FROM work_order) GROUP BY A.id_checklist_history ORDER BY date DESC
		';
		$result = mysqli_query($con,$query); $list='';	
		while($data = mysqli_fetch_assoc($result)){
		$list .= '
                    <div class="item white mark border-orange margin-button shadow">
                        <div class="left"><a href="#" onclick="form_checklist(\''.$data['ID'].'\',\'no\')"><span class="text-small orange radius padding">Detail</span></a></div> 
                        <h2><strong>'.$data['ID'].'</strong></h2>
                        <p class="text-grey">'.$data['Date'].'</p>
                        <p class="text-orange">'.$data['Form_Name'].'</p>
                        <p class="text-orange">Daily Checklist</p>
                    </div>
            ';
		}
		
	}else{
		$content = 'Asset tidak kosong';
	}

    $content = '<div class="list padding grey-100" id="list_wo">'.$list.'</div>';
    
	echo $content;
?>