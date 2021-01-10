<?php
	function get_new_page(){
		
		if(_ACCESS_){
			//*************EXPORT WORK ORDER TO EXCEL***********************//			
			if(isset($_REQUEST['expwo'])){
				$content = export_work_order();
			}
			//*************EXPORT ASSET TO EXCEL***********************//
			else if(isset($_REQUEST['expas'])){
				$content = export_asset();
			}
			return $content;
		}		
	}
?>