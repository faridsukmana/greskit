<?php
	function movement(){
		$content .= '<br/><div class="ade">'.TMOVEMENT.'</div>';
			$content .= '<div class="toptext" align="center">'._USER_VIEW_.'</div>';
			$content .= '<br/><div id="example1" style="width: 100%; height: 89%; overflow: hidden; font-size=10px;"></div>';
			//-------set lebar kolom -------------
			$width = "[200,150,150,200,200,150,150,350,350]";
			//-------get id pada sql -------------
			$field = gen_mysql_id(MOVEMENT);
			//-------get header pada sql----------
			$name = gen_mysql_head(MOVEMENT);
			//-------set header pada handson------
			$sethead = "['ID','Movement Date','Jurnal Number','Item Name','Brand','Movement Type','Quantity','Remark 1','Remark 2']";
			//-------set id pada handson----------
			$setid = "[{data:'ID',className: 'htLeft'},{data:'Movement_Date',className: 'htLeft'},{data:'Jurnal_Number',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand',className: 'htLeft'},{data:'Transaction_Type',className: 'htLeft'},{data:'Quantity',className: 'htLeft'},{data:'Remark_1',className: 'htLeft'},{data:'Remark_2',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(MOVEMENT,$field,array('Edit'),array(PATH_MOVEMENT.EDIT),array(),PATH_MOVEMENT);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft);
			//--------fungsi hanya untuk meload data
			if (_VIEW_) $content .= get_handson($sethandson);
		return $content;
	}
?>