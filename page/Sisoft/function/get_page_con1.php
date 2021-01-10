<?php
	function get_page_con1(){
		$content = '';
		if(strcmp($_REQUEST['page'],'schedu')==0){
			if ($_SESSION['userID'] !='') {
				$field = gen_mysql_id(TIMESCHEDU);
				$dt = array(TIMESCHEDU,$field);
				$data = get_data_handson($dt);
			}elseif($_SESSION['userID'] ==''){
				$field = gen_mysql_id(TIMESCHEDUNOID);
				$dt = array(TIMESCHEDUNOID,$field);
				$data = get_data_handson($dt);
			}
			
			$datenow = date('Y-m-d'); 
			$content = "
				<script>

				  $(document).ready(function() {

					$('#calendar').fullCalendar({
					  header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay,listWeek'
					  },
					  defaultDate: '".$datenow."',
					  navLinks: true, // can click day/week names to navigate views

					  weekNumbers: true,
					  weekNumbersWithinDays: true,
					  weekNumberCalculation: 'ISO',

					  editable: true,
					  eventLimit: true, 
					  events: ".$data."
					});

				  });

				</script>
			";
			
			$content .= '<div id="calendar"></div>';
		}
		
		return $content;
	}
?>