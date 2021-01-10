<?php
	function costing_report(){
		//***********MOVEMENT SPARE PARTS***********//
		$width = "[300,80,100,100,200,200]";
		$field = gen_mysql_id(COSTMOVEMENT);
		$name = gen_mysql_head(COSTMOVEMENT);
		$sethead = "['Spare Parts','Qty','Price','Amount','Remarks','Asset']";
		$setid = "[{data:'Spare_Parts',className: 'htLeft'},{data:'Qty',className: 'htLeft'},{data:'Price',className: 'htLeft'},{data:'Amount',className: 'htLeft'},{data:'Remarks',className: 'htLeft'},{data:'Asset',className: 'htLeft'}]";
		//-------get data pada sql------------
		$dt = array(COSTMOVEMENT,$field,array(),array(),array(),'');
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'costmovement');
		$costmovement= '<div id="costmovement" style="width: 1100px; height: 300px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
		
		//***********COSTING REPORT***********//
		$width = "[100,500,100,100]";
		$field = gen_mysql_id(COSTREPORT);
		$name = gen_mysql_head(COSTREPORT);
		$sethead = "['WO','WO Description','Asset','Total Cost']";
		$setid = "[{data:'WorkOrderNo',className: 'htLeft'},{data:'ProblemDesc',className: 'htLeft'},{data:'AssetNo',className: 'htLeft'},{data:'Total_Cost',className: 'htLeft'}]";
		//-------get data pada sql------------
		$dt = array(COSTREPORT,$field,array(),array(),array(),'');
		$data = get_data_handson_func($dt);
		//----Fungsi memanggil data handsontable melalui javascript---
		$fixedcolleft=0;
		$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'costreport');
		$costreport= '<div id="costreport" style="width: 1100px; height: 300px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
	
		$content .= '
					<div class="row">
						<div class="col-lg-12  d-flex justify-content-center">
							<table>
							<tr><td><div class="ade">COSTING CALCULATION</div></td></tr>
							<tr><td>'.$costmovement.'</td></tr>
							</table>
						</div>
						<div class="col-lg-12 d-flex justify-content-center">
							<table>
							<tr><td><div class="ade">COSTING REPORT</div></td></tr>
							<tr><td>'.$costreport.'</td></tr>
							</table>
						</div>
					</div>
				';	
				  
		return $content;
	}
	
	
?>