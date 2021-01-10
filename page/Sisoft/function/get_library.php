<?php
	function get_library(){
		$content = '
			<!--------------Jquery Ver 1.11.3 for Drop Down and Jeasyui ---------------->
			<script src="'._ROOT_.'template/startbootstrap/vendor/jquery/jquery.min.js" type="text/javascript"></script>
			
			<!--------------Jeasyui Module------------>
			<link rel="stylesheet" type="text/css" href="'._ROOT_LIB_.'library/jeasyui/theme/default/easyui.css">
			<link rel="stylesheet" type="text/css" href="'._ROOT_LIB_.'library/jeasyui/icon.css">
			<script type="text/javascript" src="'._ROOT_LIB_.'library/jeasyui/jquery.easyui.min.js"></script>
			
			<!--------------Data Table------------>
			<link rel="stylesheet" type="text/css" href="'._ROOT_LIB_.'library/datatable/datatables.min.css">
			<script type="text/javascript" src="'._ROOT_LIB_.'library/datatable/datatables.min.js"></script>
				<!-------pdf maker-------->
				<script type="text/javascript" src="'._ROOT_LIB_.'library/datatable/pdfmake-0.1.36/pdfmake.min.js"></script>
				<script type="text/javascript" src="'._ROOT_LIB_.'library/datatable/pdfmake-0.1.36/vfs_fonts.js"></script>
				
			
			<!--------------Hight Chart Module------------>
			<script type="text/javascript" src="'._ROOT_LIB_.'library/highchart/highcharts.js"></script>
			<script type="text/javascript" src="'._ROOT_LIB_.'library/highchart/highcharts-3d.js"></script><!--For 3D Coloumn--> 
			<script type="text/javascript" src="'._ROOT_LIB_.'library/highchart/modules/exporting.js"></script>
				
			<!--------------TinyMCE Module---------------->
			<!-- TinyMCE Dinonaktifkan ketika menggunakan Handsontable
			<script type="text/javascript" src="'._ROOT_LIB_.'library/tinymce/tinymce.dev.js"></script>
			<script type="text/javascript" src="'._ROOT_LIB_.'library/tinymce/plugins/table/plugin.dev.js"></script>
			<script type="text/javascript" src="'._ROOT_LIB_.'library/tinymce/plugins/paste/plugin.dev.js"></script>
			<script type="text/javascript" src="'._ROOT_LIB_.'library/tinymce/plugins/spellchecker/plugin.dev.js"></script>
			-->
			
			<!--------------Handsontable Module ------------>
			<link data-jsfiddle="common" rel="stylesheet" media="screen" href="'._ROOT_LIB_.'library/handsontable/pro/handsontable-pro.full.min.css">
		    <link data-jsfiddle="common" rel="stylesheet" media="screen" href="'._ROOT_LIB_.'library/handsontable/dist/pikaday/pikaday.css">
		    <script data-jsfiddle="common" src="'._ROOT_LIB_.'library/handsontable/dist/pikaday/pikaday.js"></script>
		    <script data-jsfiddle="common" src="'._ROOT_LIB_.'library/handsontable/dist/moment/moment.js"></script>
		    <script data-jsfiddle="common" src="'._ROOT_LIB_.'library/handsontable/dist/zeroclipboard/ZeroClipboard.js"></script>
		    <script data-jsfiddle="common" src="'._ROOT_LIB_.'library/handsontable/pro/handsontable-pro.full.min.js"></script>
			
			<!--------------Full Calender License------------>
			<link rel="stylesheet" type="text/css" href="'._ROOT_LIB_.'library/fullcalender/fullcalendar.min.css">
			<script src="'._ROOT_LIB_.'library/fullcalender/moment.min.js"></script>
			<script src="'._ROOT_LIB_.'library/fullcalender/fullcalendar.min.js"></script>
			
			<!--------------Bootstrap Datepicker------------>
			<link rel="stylesheet" href="'._ROOT_LIB_.'library/bootstrapdatepicker/css/bootstrap-datetimepicker.min.css">
			<script type="text/javascript" src="'._ROOT_LIB_.'library/bootstrapdatepicker/js/bootstrap-datetimepicker-sisoft.js"></script>
			<script type="text/javascript" src="'._ROOT_LIB_.'library/bootstrapdatepicker/locales/bootstrap-datepicker.fr.min.js"></script>
		';
		return $content;
	}
?>