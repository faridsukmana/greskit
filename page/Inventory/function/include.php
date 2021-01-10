<?php
//==================Kumpulan halaman php yang didefinisikan dalam developer=================
	require_once(_ROOT_.'function/data/get_ssql.php');
	require_once(_ROOT_.'function/get_library.php');
	require_once(_ROOT_.'function/get_js.php');
	require_once(_ROOT_.'function/get_plugin.php');
	require_once(_ROOT_.'function/get_access_control.php');
	
	//----- definisikan halaman yang akan diakses------------------//
	require_once(_ROOT_.'function/get_page.php'); //--- halaman utama yang harus dimiliki
	require_once(_ROOT_.'function/content_menu/dashboard.php');
	require_once(_ROOT_.'function/content_menu/costing_report.php');
	require_once(_ROOT_.'function/content_menu/brand.php');
	require_once(_ROOT_.'function/content_menu/categories.php');
	require_once(_ROOT_.'function/content_menu/inventory_items.php');
	require_once(_ROOT_.'function/content_menu/stock.php');
	require_once(_ROOT_.'function/content_menu/vendor.php');
	require_once(_ROOT_.'function/content_menu/movement_type.php');
	require_once(_ROOT_.'function/content_menu/critical_level.php');
	require_once(_ROOT_.'function/content_menu/warehouse.php');
	require_once(_ROOT_.'function/content_menu/state_journal_movement.php');
	require_once(_ROOT_.'function/content_menu/topup.php');
	require_once(_ROOT_.'function/content_menu/unit.php');
	require_once(_ROOT_.'function/content_menu/brand2.php');
	require_once(_ROOT_.'function/content_menu/currency.php');
	require_once(_ROOT_.'function/content_menu/cost_center.php');
	require_once(_ROOT_.'function/content_menu/journal_movement.php');
	require_once(_ROOT_.'function/content_menu/manual_return.php');
	require_once(_ROOT_.'function/content_menu/movement.php');
	require_once(_ROOT_.'function/content_menu/location.php');
	require_once(_ROOT_.'function/content_menu/site.php');
	
	//------- Fungsi reporting -----------
	require_once(_ROOT_.'function/content_menu/report/r_inventory_transaction.php');
	require_once(_ROOT_.'function/content_menu/report/r_inventory_topup.php');
	require_once(_ROOT_.'function/content_menu/report/r_inventory_journal.php');
	require_once(_ROOT_.'function/content_menu/report/r_inventory_return.php');
	
	//------- Fungsi Plan PO -------------
	require_once(_ROOT_.'function/content_menu/rp.php');
	
	require_once(_ROOT_.'function/content_menu/error_info.php');
	
?>