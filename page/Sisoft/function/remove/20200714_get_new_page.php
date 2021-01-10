<?php
	function get_new_page(){
		
		if(_ACCESS_){
			//##############DAILY CHECKLIST##################################//
			//**************ITEM CHECKLIST***********************************//
			if(isset($_REQUEST['icheck'])){
				$content = item_checklist();
			}
			
			//**************ITEM CHECKLIST***********************************//
			else if(isset($_REQUEST['lcheck'])){ 
				$content = master_checklist();
			}
			
			//**************FORM CHECKLIST***********************************//
			else if(isset($_REQUEST['formck'])){ 
				$content = form_name_checklist(); 
			}
			
			//**************CREATE CHECKLIST***********************************//
			else if(isset($_REQUEST['dailyc'])){ 
				$content = create_daily_checklist(); 
			}
			
			//*************EXPORT WORK ORDER TO EXCEL***********************//			
			else if(isset($_REQUEST['expwo'])){
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