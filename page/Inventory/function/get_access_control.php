<?php
	//=======================DEFINE ACCESS CONTROL FOR USER ========================
	//*************INSERT CONTROL ***************//
	if(_INSERT_){
		//*********Based On Page ***********//
		if(strcmp($_REQUEST['page'],'itemcat')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_ITEMCAT.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'brand')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_BRAND.ADD.'">Add</a></span>');	
		else if(strcmp($_REQUEST['page'],'item')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_ITEM.ADD.'">Add</a></span> || <span><a href="'.PATH_ITEM.UPLOAD.'">Upload</a></span>');
		else if(strcmp($_REQUEST['page'],'stock')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_STOCK.ADD.'">Add</a></span>');	
		else if(strcmp($_REQUEST['page'],'vendor')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_VENDOR.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'movetype')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_MOVETYPE.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'crlevel')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_CRLEVEL.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'wrhouse')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_WRHOUSE.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'sjvmove')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_SJVMOVE.ADD.'">Add</a></span>');	
		else if(strcmp($_REQUEST['page'],'unit')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_UNIT.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'topup')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_TOPUP.ADD.'">Add</a></span>');	
		else if(strcmp($_REQUEST['page'],'brand2')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_BRAND2.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'curr')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_CURR.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'ccenter')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_CCENTER.ADD.'">Add</a></span>');else if(strcmp($_REQUEST['page'],'jvmovement')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_JVMOVEMENT.ADD.'">Add</a></span>');	
		else if(strcmp($_REQUEST['page'],'mreturn')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_MRETURN.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'movement')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_MOVEMENT.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'location')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_LOCATION.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'site')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_SITE.ADD.'">Add</a></span>');
		else if(strcmp($_REQUEST['page'],'rp')==0) DEFINE('_USER_INSERT_',' || <span><a href="'.PATH_PLANRP.ADD.'">Add</a></span>');
	}else{
		DEFINE('_USER_INSERT_',''); 
	}
	
	//*************VIEW CONTROL ***************//
	if(_VIEW_){
		//*********Based On Page ***********//
		if(strcmp($_REQUEST['page'],'itemcat')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_ITEMCAT.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'brand')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_BRAND.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'item')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_ITEM.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'stock')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_STOCK.'">View</a></span>'); 
		else if(strcmp($_REQUEST['page'],'vendor')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_VENDOR.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'movetype')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_MOVETYPE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'crlevel')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_CRLEVEL.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'wrhouse')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_WRHOUSE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'sjvmove')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_SJVMOVE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'unit')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_UNIT.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'topup')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_TOPUP.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'brand2')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_BRAND2.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'curr')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_CURR.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'ccenter')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_CCENTER.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'jvmovement')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_JVMOVEMENT.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'mreturn')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_MRETURN.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'movement')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_MOVEMENT.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'location')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_LOCATION.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'site')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_SITE.'">View</a></span>');
		else if(strcmp($_REQUEST['page'],'rp')==0) DEFINE('_USER_VIEW_','<span><a href="'.PATH_PLANRP.'">View</a></span>');
	}else{
		DEFINE('_USER_VIEW_',''); 
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
		DEFINE("_USER_RP_SETHEAD_",",'RP Form'");
		DEFINE("_USER_RP_SETID_",",{data:'Create',renderer: 'html'}");
	}else{
		DEFINE("_USER_EDIT_SETHEAD_","");
		DEFINE("_USER_EDIT_SETID_","");
		DEFINE("_USER_RP_SETHEAD_","");
		DEFINE("_USER_RP_SETID_","");
	}
?>