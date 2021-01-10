<?php
	function get_new_page(){
		
		if(_ACCESS_){
			//------ FAILURE CODE ----------------
			if(strcmp($_REQUEST['page'],'assets')==0){
				$content = asset();
			}
			
			//##############DAILY CHECKLIST##################################//
			//**************ITEM CHECKLIST***********************************//
			else if(isset($_REQUEST['icheck'])){
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
			
			//##############PREVENTIVE MAINTENANCE##################################//
			//****************MENU PM Task List **********************//
			else if(strcmp($_REQUEST['page'],'pmchek')==0){
				$content = pm_tasklist();
			}
			//****************MENU Daftar PM **********************//
			else if(strcmp($_REQUEST['page'],'pmlist')==0){
				$content = pmlist();
			}
			//****************MENU Generate PM **********************//
			else if(strcmp($_REQUEST['page'],'pmgene')==0){
				$content = choose_pmgen();
				$content .= pmgen();
				
			}
			//****************MENU PM Schedule **********************//
			else if(strcmp($_REQUEST['page'],'pmsche')==0){
				$content = pmsche();
			}
			
			//##############PREVENTIVE MAINTENANCE##################################//
			
			
			//##############LOCATION##################################//
			//****************MENU Area **********************//
			else if(strcmp($_REQUEST['page'],'area')==0){
				$content = area();
			}
			//****************MENU Area **********************//
			else if(strcmp($_REQUEST['page'],'plant')==0){
				$content = plant();
			}
			//##############LOCATION##################################//
			
			
			//****************MENU PM Work Order **********************//
			else if(strcmp($_REQUEST['page'],'worder')==0){
				$content = worder();
			}
			
			return $content;
		}		
	}
?>