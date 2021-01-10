<?php
	//=======================DEFINE ACCESS CONTROL FOR USER ========================
	//*************INSERT CONTROL ***************//
	if(_INSERT_){
		//*********Based On Page ***********//
		if(strcmp($_REQUEST['page'],'asscat')==0) DEFINE('_USER_INSERT_',' <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSCAT.ADD.'">Add</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSCAT.UPLOAD.'">Upload</a></span>');	
		else if(strcmp($_REQUEST['page'],'assets')==0){
			DEFINE('_USER_INSERT_',' <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.ADD.'">Add</a></span>  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.UPLOAD.'">Upload</a></span>');	
			DEFINE("_USER_SPARE_SETHEAD_",",'Spare Part'");
			DEFINE("_USER_SPARE_SETID_",",{data:'View',renderer: 'html'}");
			DEFINE("_USER_DOC_SETHEAD_",",'Document'");
			DEFINE("_USER_DOC_SETID_",",{data:'Attachment',renderer: 'html'}");
		}
		else if(strcmp($_REQUEST['page'],'falcod')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_FALCOD.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'employ')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_EMPLOY.ADD.'">Add</a></span>  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_EMPLOY.UPLOAD.'">Upload</a></span>');	
		else if(strcmp($_REQUEST['page'],'depart')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_DEPART.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'locatn')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_LOCATN.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'supply')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_SUPPLY.ADD.'">Add</a></span>');	
		else if(strcmp($_REQUEST['page'],'priory')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PRIORY.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'wstate')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WSTATE.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'wrtype')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WRTYPE.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'warran')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WARRAN.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'asstat')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSTAT.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'wtrade')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WTRADE.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'critic')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_CRITIC.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'positi')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_POSITI.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'worder')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WORDER.ADD.'">Add</a></span>  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WORDER.UPLOAD.'">Upload</a></span>');
		else if(strcmp($_REQUEST['page'],'pmchek')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMCHEK.ADD.'">Add</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMCHEK.UPLOAD.'">Upload</a></span>');
		else if(strcmp($_REQUEST['page'],'pmsche')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMSCHE.ADD.'">Add</a></span> <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMSCHE.UPLOAD.'">Upload</a></span>');
		else if(strcmp($_REQUEST['page'],'pmlist')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMLIST.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'icheck')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ICHECK.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'lcheck')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_LCHECK.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'formck')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_FORMCK.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'dailyc')==0) DEFINE('_USER_INSERT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_DAILYC.ADD.'">Add</a></span>');
	}else{
		DEFINE('_USER_INSERT_',''); 
		DEFINE("_USER_SPARE_SETHEAD_","");
		DEFINE("_USER_SPARE_SETID_","");
	}
	
	//*************VIEW CONTROL ***************//
	if(_VIEW_){
		//*********Based On Page ***********//
		if(strcmp($_REQUEST['page'],'asscat')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSCAT.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'assets')==0){ 
			DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.'">View</a></span>'); 
			DEFINE('_USER_VIEW_HISTORY','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'">All History</a></span>'); 
			DEFINE('_USER_WO_','<span><a class="btn btn-outline-success btn-rounded btn-fw" href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=wo">Work Order</a></span>'); 
			DEFINE('_USER_PM_','<span><a class="btn btn-outline-success  btn-rounded btn-fw" href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=pm">Preventive Maintenance</a></span>'); 
			DEFINE('_USER_RC_','<span><a class="btn btn-outline-success  btn-rounded btn-fw" href="'.PATH_ASSETS.HISTORY.'&rowid='.$_REQUEST['rowid'].'&type=rc">Routine Checklist</a></span>'); 
			DEFINE("_USER_HISTORY_SETHEAD_",",'Work Order'");
			DEFINE("_USER_HISTORY_SETID_",",{data:'History',renderer: 'html'}");
			DEFINE("_USER_DOC_SETHEAD_","");
			DEFINE("_USER_DOC_SETID_","");
		}
		else if(strcmp($_REQUEST['page'],'falcod')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_FALCOD.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'employ')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_EMPLOY.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'depart')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_DEPART.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'locatn')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_LOCATN.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'supply')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_SUPPLY.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'priory')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PRIORY.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'wstate')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WSTATE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'wrtype')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WRTYPE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'warran')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WARRAN.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'wtrade')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WTRADE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'asstat')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ASSTAT.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'critic')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_CRITIC.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'positi')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_POSITI.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'expwo')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_EXPWO.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'expas')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_EXPAS.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'worder')==0) {
			DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WORDER.'">View</a></span>');
			DEFINE('_USER_PRINT_','  <span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_WORDER.TPRINT.'&wo='.$_REQUEST['rowid'].'&blankpage=ok" rel="noopener noreferrer" target="_blank">Print</a></span>');
		}
		else if(strcmp($_REQUEST['page'],'pmchek')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMCHEK.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'pmsche')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMSCHE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'pmlist')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_PMLIST.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'icheck')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_ICHECK.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'lcheck')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_LCHECK.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'formck')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_FORMCK.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'dailyc')==0) DEFINE('_USER_VIEW_','<span><a class="btn btn-outline-primary btn-rounded btn-fw" href="'.PATH_DAILYC.'">View</a></span>');
	}else{
		DEFINE('_USER_VIEW_',''); 
		DEFINE("_USER_HISTORY_SETHEAD_","");
		DEFINE("_USER_HISTORY_SETID_","");
	}
	
	//*************DELETE CONTROL ***************//
	if(_DELETE_){ 
		DEFINE("_USER_DELETE_SETHEAD_",",'Remove'");
		DEFINE("_USER_DELETE_SETID_",",{data:'Delete',renderer: 'html'}");
	}else{
		DEFINE("_USER_DELETE_SETHEAD_","");
		DEFINE("_USER_DELETE_SETID_",""); 
	}
	
	//*************EDIT CONTROL ***************//
	if(_EDIT_){
		DEFINE("_USER_EDIT_SETHEAD_",",'Modified'");
		DEFINE("_USER_EDIT_SETID_",",{data:'Edit',renderer: 'html'}");
		
		DEFINE("_USER_CHECKLIST_SETHEAD_",",'Checklist'");
		DEFINE("_USER_CHECKLIST_SETID_",",{data:'Checklist',renderer: 'html'}");
		
		DEFINE("_USER_SPAREPART_SETHEAD_",",'Spare Part'");
		DEFINE("_USER_SPAREPART_SETID_",",{data:'List',renderer: 'html'}");
	}else{
		DEFINE("_USER_EDIT_SETHEAD_","");
		DEFINE("_USER_EDIT_SETID_",""); 
	}
	
	//*************DETAIL CONTROL ***************//
	if(_DETAIL_){
		DEFINE("_USER_DETAIL_SETHEAD_",",'Detail'");
		DEFINE("_USER_DETAIL_SETID_",",{data:'Detail',renderer: 'html'}");
	}else{
		DEFINE("_USER_DETAIL_SETHEAD_","");
		DEFINE("_USER_DETAIL_SETID_",""); 
	}
	
?>