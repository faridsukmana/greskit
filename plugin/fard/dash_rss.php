<?php
function recomended_solution(){
	$value = get_rating_rule();
	return $value;
}

function get_rating_rule(){
	$default_tab = '0';
	$sql = 'SELECT Problem as Problem FROM pmwo_rule_probsolve GROUP BY problem';
	$value = query(RSS, $sql,$default_tab,1,1,1,'DRSS','','','');
	return $value;
}
?>