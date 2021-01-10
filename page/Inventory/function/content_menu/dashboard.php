<?php
	function dashboard(){
			//**********TEXT INFO TOTAL PRICE OF LAST WITHDRAW ITEM IN THIS MONTH**********--------
			$result = mysql_exe_query(array(TOPRIMOVING,1)); $resultnow=mysql_exe_fetch_array(array($result,1));$price=$resultnow[0];
			$label_message = '<div class="alert alert-info" align="center">
							  Total Price of Last Withdraw Item In This Month : <strong>'.$price.'</strong>
							</div>';
	
			//***********HIGHLIGHT MOVEMENT THIS MONTH***********//
			$width = "[200,150,150,200,200,150,150,350,350]";
			$field = gen_mysql_id(MONTHMOVEMENT);
			$name = gen_mysql_head(MONTHMOVEMENT);
			$sethead = "['Movement Date','Jurnal Number','Movement Type','Item Name','Brand','Quantity','Remark 1','Remark 2']";
			$setid = "[{data:'Movement_Date',className: 'htLeft'},{data:'Jurnal_Number',className: 'htLeft'},{data:'Movement_Type',className: 'htLeft'},{data:'Item_Name',className: 'htLeft'},{data:'Brand',className: 'htLeft'},{data:'Quantity',className: 'htLeft'},{data:'Remark_1',className: 'htLeft'},{data:'Remark_2',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(MOVEMENT,$field,array('Edit'),array(PATH_MOVEMENT.EDIT),array(),PATH_MOVEMENT);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'monthmove');
			$monthmove= '<div id="monthmove" style="width: 775px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********HIGH JOURNAL MOVEMENT THIS MONTH***********//
			$width = "[330,150]";
			$field = gen_mysql_id(HIGHMOVEMENT);
			$name = gen_mysql_head(HIGHMOVEMENT);
			$sethead = "['Item Name','Total Price']";
			$setid = "[{data:'Item_Name',className: 'htLeft'},{data:'Total_Price',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(HIGHMOVEMENT,$field,array('Edit'),array(PATH_MOVEMENT.EDIT),array(),PATH_MOVEMENT);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'hightmove');
			$hightmove= '<div id="hightmove" style="width: 575px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********LOW LEVEL ITEM STOCK THIS MONTH***********//
			$width = "[330,95,95]";
			$field = gen_mysql_id(LOWLEVELITEM);
			$name = gen_mysql_head(LOWLEVELITEM);
			$sethead = "['Item Name','Stock','Min']";
			$setid = "[{data:'Item_Name',className: 'htLeft'},{data:'Stock',className: 'htLeft'},{data:'Min',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(LOWLEVELITEM,$field,array('Edit'),array(PATH_ITEM.EDIT),array(),PATH_ITEM);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'lowlevel');
			$lowlevelit= '<div id="lowlevel" style="width: 575px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			//***********HIGH LEVEL ITEM STOCK THIS MONTH***********//
			$width = "[330,95,95]";
			$field = gen_mysql_id(HIGHLEVELITEM);
			$name = gen_mysql_head(HIGHLEVELITEM);
			$sethead = "['Item Name','Stock','Max']";
			$setid = "[{data:'Item_Name',className: 'htLeft'},{data:'Stock',className: 'htLeft'},{data:'Max',className: 'htLeft'}]";
			//-------get data pada sql------------
			$dt = array(HIGHLEVELITEM,$field,array('Edit'),array(PATH_ITEM.EDIT),array(),PATH_ITEM);
			$data = get_data_handson_func($dt);
			//----Fungsi memanggil data handsontable melalui javascript---
			$fixedcolleft=0;
			$sethandson = array($sethead,$setid,$data,$width,$fixedcolleft,'highlevel');
			$highlevelit= '<div id="highlevel" style="width: 575px; height: 140px; overflow: hidden; font-size=10px; z-index:0;"></div>'.get_handson_id($sethandson);
			
			$content .= get_js_graph(array(ITEMTOPUP,'3d-column-interactive','Total Topup '.date('M Y').' by Item Name','Item Name','container1','500','500','typequery1','#',''));
			$content .= get_js_graph(array(ITEMJMOVE,'3d-column-interactive','Total Withdraw '.date('M Y').' by Item Name','Item Name','container2','500','500','typequery1','#',''));
			$content .= get_js_graph(array(ITEMRETUR,'3d-column-interactive','Total Return '.date('M Y').' by Item Name','Item Name','container3','500','500','typequery1','#',''));
			
			$content .= '
					<div class="row">
						<div class="col-lg-12">
							'.$label_message.'
						</div>
						<div class="col-lg-7 d-flex justify-content-center">
							<table>
							<tr><td><div class="ade">Hightlight Movement This Month</div></td></tr>
							<tr><td>'.$monthmove.'</td></tr>
							</table>
						</div>
						<div class="col-lg-5 d-flex justify-content-center">
							<table>
							<tr><td><div class="ade">High Price of Withdraw This Month</div></td></tr>
							<tr><td>'.$hightmove.'</td></tr>
							</table>
						</div>
						<div class="col-lg-6  d-flex justify-content-center">
							<table>
							<tr><td><div class="ade">Low Level Item</div></td></tr>
							<tr><td>'.$lowlevelit.'</td></tr>
							</table>
						</div>
						<div class="col-lg-6 d-flex justify-content-center">
							<table>
							<tr><td><div class="ade">High Level Item</div></td></tr>
							<tr><td>'.$highlevelit.'</td></tr>
							</table>
						</div>
						<div class="col-lg-4">
							<div id="container1"></div>
						</div>
						<div class="col-lg-4">
							<div id="container2"></div>
						</div>
						<div class="col-lg-4">
							<div id="container3"></div>
						</div>
					</div>
				';
			
		return $content;
	}
?>