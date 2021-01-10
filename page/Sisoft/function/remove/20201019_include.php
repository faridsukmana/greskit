<?php
//==================Kumpulan halaman php yang didefinisikan dalam developer=================
	require_once(_ROOT_.'function/data/get_ssql.php');
	require_once(_ROOT_.'function/get_library.php');
	require_once(_ROOT_.'function/get_js.php');
	require_once(_ROOT_.'function/get_plugin.php');
	require_once(_ROOT_.'function/get_page.php');
	require_once(_ROOT_.'function/get_page_con1.php');
	//***********support get_page.php ************************//
	require_once(_ROOT_.'function/content/asset/asset.php'); //===================suppport asset ====//
	require_once(_ROOT_.'function/content/asset/asset_history.php'); //===================suppport asset history ====//
	require_once(_ROOT_.'function/content/preventive/pm_tasklist.php'); //===================pm task list ====//
	require_once(_ROOT_.'function/content/preventive/pmlist.php'); //===================pm list ====//
	require_once(_ROOT_.'function/content/preventive/pmgen.php'); //===================pm generate ====//
	require_once(_ROOT_.'function/content/preventive/pmsche.php'); //===================pm schedule ====//
	require_once(_ROOT_.'function/content/work_order/work_order.php'); //===================work order ====//
	//***********content ************************//
	require_once(_ROOT_.'function/get_new_page.php');
	require_once(_ROOT_.'function/content/checklist/item_checklist.php');
	require_once(_ROOT_.'function/content/checklist/master_checklist.php');
	require_once(_ROOT_.'function/content/checklist/form_name_checklist.php');
	require_once(_ROOT_.'function/content/checklist/daily_check.php');
	require_once(_ROOT_.'function/content/export_work_order.php');
	require_once(_ROOT_.'function/content/export_asset.php');
	
	require_once(_ROOT_.'function/get_access_control.php');
	
?>