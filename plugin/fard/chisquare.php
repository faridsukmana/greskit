<?php
	function remove_duplicat_item($item){
		$i = 0; $k = 0; $sum_item = sizeof($item);
		while($i<$sum_item){
			$j = 0; $pos = false; 
			while($j<$sum_item){
				if(strcmp($item[$i],$item[$j])==0 && $j<>$i && $num[$item[$i]]>0){
					$pos = true; $num[$item[$i]]++;
				}
				$j++;
			}
			$num[$item[$i]]++;
			
			if(!$pos){
				$new_pos_item[$k] = $item[$i]; $k++;
			}
			
			$i++;
		}
		
		return $new_pos_item;
	}
	
	function get_item($sql){
		$i = 0; $j = 0; //$sum_sql = sizeof($sql); 
	//	while($i<$sum_sql){	
	//	echo $sql;
		$result = mysql_query($sql); 												
		while($result_now = mysql_fetch_array($result)){
			$item[$j] = $result_now[0]; 								//mendapatkan item dari rule
			$j++;
		}
			
		$i++;
	//	}
		
		/*$item[7] = 'Invalid IP address';
		$item[8] = "Message 'Establish Connection'";
		$item[9] = 'Invalid IP address';
		$item[10] = "Message 'Establish Connection'";
		$item[11] = "Can't start microsoft axapta has more users are running the system";*/
		
		$item = remove_duplicat_item($item);
		
		$i=0;
	/*	while($i<sizeof($item)){
			echo $item[$i].'<br/>'; $i++;
		}*/
		
		return $item;
	}
	
	function get_sql($num1, $num2, $problem, $item, $item2){
		if($num1==0 && $num2 ==1){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" and root_cause_1="'.$item.'" and root_cause_2 = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==0 && $num2 ==2){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" and root_cause_1="'.$item.'" and root_cause_3 = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==1 && $num2 ==2){
			$sql = 'SELECT COUNT(root_cause_2) FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" and root_cause_2="'.$item.'" and root_cause_3 = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==0 && $num2 ==3){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO  WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_1="'.$item.'" AND  DATE_FORMAT(PAPS.Date_Start, "%W") = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==0 && $num2 ==4){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO  WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_1="'.$item.'" AND  DATE_FORMAT(PAPS.Date_Finish, "%W") = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==1 && $num2 ==3){
			$sql = 'SELECT COUNT(root_cause_2) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO  WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_2="'.$item.'" AND  DATE_FORMAT(PAPS.Date_Start, "%W") = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==1 && $num2 ==4){
			$sql = 'SELECT COUNT(root_cause_2) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO  WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_2="'.$item.'" AND  DATE_FORMAT(PAPS.Date_Finish, "%W") = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==2 && $num2 ==3){
			$sql = 'SELECT COUNT(root_cause_3) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO  WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_2="'.$item.'" AND  DATE_FORMAT(PAPS.Date_Start, "%W") = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==2 && $num2 ==4){
			$sql = 'SELECT COUNT(root_cause_3) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO  WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_2="'.$item.'" AND  DATE_FORMAT(PAPS.Date_Finish, "%W") = "'.$item2.'" GROUP BY root_cause_1';
		}else if($num1==0 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_1="'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==1 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_2="'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==2 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_3="'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==3 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and DATE_FORMAT(PAPS.Date_Start, "%W") = "'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==4 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and DATE_FORMAT(PAPS.Date_Finish, "%W") = "'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==6 && $num2 ==7){
			$sql = 'SELECT SUM(R.O) FROM (SELECT COUNT(root_cause_1) AS O FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" and root_cause_1="'.$item.'" and root_cause_2 = "'.$item2.'" GROUP BY root_cause_1 UNION SELECT COUNT(root_cause_1) AS O FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" and root_cause_1="'.$item.'" and root_cause_3 = "'.$item2.'" GROUP BY root_cause_1 UNION SELECT COUNT(root_cause_1) AS O FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" and root_cause_2="'.$item.'" and root_cause_3 = "'.$item2.'" GROUP BY root_cause_1) AS R';
		}
		return $sql;
	}

	function contingency_table($sql,$sql2,$num1,$num2,$problem){ 
		$H0 = true;// echo $sql.'<br>'.$sql2.'<br/>'; 
		$item = get_item($sql);
		$item2 = get_item($sql2); $total_row = 0; $total_col = 0;
		
		$table = '<table class="display" id="data">';
		$i=0;
		$j=0;
		$h=0;
		
		while($j<sizeof($item2)){
			$sum_col[$j] = 0;
			$j++;
		}
			
		while($i<sizeof($item)){
			
			if($i==0){
				$k=0; $table .= '<thead><th></th>';
				while($k<sizeof($item2)){
					$table .= '<th>'.$item2[$k].'</th>';
					$k++;
				}
				$table .= '</thead><tbody>';
			}
			
			$table .= '<tr><td>'.$item[$i].'</td>';
			
			$sum_row[$i] = 0; 
			$j=0;
			
			while($j<sizeof($item2)){
				$query = get_sql($num1, $num2, $problem, $item[$i], $item2[$j]); 
				$result = mysql_query($query);
				$result_now = mysql_fetch_array($result);
				if(empty($result_now[0])){
					$con = 0;
				}else{
					$con = $result_now[0];
				}
				$item_con[$i][$j] = $con; 
				$table .= '<td>'.$item_con[$i][$j].'</td>';
				$sum_row[$i] = $sum_row[$i]+$item_con[$i][$j];
				$sum_col[$j] = $sum_col[$j]+$item_con[$i][$j];
				
			//	echo $item[$i].' - '.$item2[$j].' = '.$item_con[$i][$j].'<br/>';
				$j++;
			}
			$table .= '<td>'.$sum_row[$i].'</td>';
			$table .= '</tr>';
			$total_row = $total_row + $sum_row[$i];
			
			$i++;
		}
		
				$j=0; $table .= '</tbody><tfoot><tr><td></td>';
				while($j<sizeof($item2)){
					$total_col = $total_col + $sum_col[$j];
					$table .= '<td>'.$sum_col[$j].'</td>';
					if($j==sizeof($item2)-1){
						if($total_row == $total_col)
							$table .= '<td>'.$total_row.'</td>';
						else
							$table .= '<td>ERROR</td>';
					}
					$j++;
				}
				$table .= '</tr></tfoot>';
		
		$table .= '</table>';
		 
		
	//	$table .= '<br/>Chi-Square value is <b><u>'.$chi_square.'</u></b><br/>';
		$df = (sizeof($item)-1)*(sizeof($item2)-1);
	//	$table .= '<br/>DF value is '.(sizeof($item)-1).' x '.(sizeof($item2)-1).' = <b><u>'.$df.'</b></u><br/>';
	//	echo $table;
		
		$fh = fungsi_harapan($item, $item2, $item_con, $sum_row, $sum_col, $total_row);
		$chi_square = Chi_square_count($item, $item2, $item_con, $fh);
		
		$query = 'SELECT P_Value, DF, Value FROM pmwo_chisquare_table WHERE CAST(P_Value AS DECIMAL)=CAST(0.05 AS DECIMAL) AND DF="'.$df.'"';  
		$result = mysql_query($query);
		$result_now = mysql_fetch_array($result);
		$chi_square_tab = $result_now['Value'];
		
		$query = 'SELECT Var_Value FROM pmwo_var_asrule WHERE Var_Category = "Chi-Square" AND Var_Name = "P-Value"';
		$result = mysql_query($query);
		$result_now = mysql_fetch_array($result);
		$table .= 'Value of Chi-Square Table for P_Value("'.$result_now['Var_Value'].'") is = <b><u>'.$chi_square_tab.'</u></b><br/>';
		
		if($chi_square>$chi_square_tab){
			$H0 = false;
			$table .= 'Two variable has correlation (H1 accepted)<br/>';
			$SH0 = $chi_square.'>'.$chi_square_tab.' = Two variable has correlation (H1 accepted)';
		}else{
			$H0 = true;
			$table .= 'Two varible doesnt have correlation (H0 accepted)<br/>';
			$SH0 = $chi_square.'<'.$chi_square_tab.' = Two varible doesnt have correlation (H0 accepted)';
		}
		return $H0;
	}
	
	function fungsi_harapan($item, $item2, $item_con, $sum_row, $sum_col, $total){
		$i=0; 
		while($i<sizeof($item)){
			$j=0;
			while($j<sizeof($item2)){
				if($total<>0)
					$fh[$i][$j] = ($sum_row[$i]/$total)*$sum_col[$j];
				else
					$fh[$i][$j] = 0;
			//	echo 'Frekuensi harapan : baris-'.$i.' kolom-'.$j.' = ('.$sum_row[$i].'/'.$total.')x'.$sum_col[$j].' = '.$fh[$i][$j].'<br/>';
				$j++;
			}
			$i++;
		}
		
		return $fh;
	}
	
	function Chi_square_count($item, $item2, $f0, $fh){
		$i=0; $chi_square = 0; $val_chi = '';
		while($i<sizeof($item)){
			$j=0;
			while($j<sizeof($item2)){
				if($fh[$i][$j]<>0)	
					$fh_f0 = pow(($f0[$i][$j]-$fh[$i][$j]),2)/$fh[$i][$j];
				else
					$fh_f0 = 0;
			//	echo '('.$f0[$i][$j].' - '.$fh[$i][$j].')^2 / '.$fh[$i][$j].' = '.$fh_f0.'<br/>';
				$chi_square = $chi_square + $fh_f0;
				$val_chi = $val_chi.$fh_f0.' + ';
				$j++;
			}
			$i++;
		}
		$val_chi = $val_chi.' = '.$chi_square.'<br/>';
	//	echo $val_chi;
		return $chi_square;
	}
	
	function chisquare_correlation($problem,$v1,$v2){
		$default_tab = '0123'; 
		$sql[0] = 'SELECT root_cause_1 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1';
		$sql[1] = 'SELECT root_cause_2 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_2';
		$sql[2] = 'SELECT root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_3';
	//	$sql[3] = 'SELECT DATE_FORMAT(Date_Start, "%W") FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" GROUP BY DATE_FORMAT(Date_Start, "%W")';
		$sql[3] = 'SELECT DATE_FORMAT(P.Date_Start, "%W") FROM pmwo_ax_problem_solving P, pmwo_rule_probsolve Q WHERE P.problem = "'.$problem.'" AND P.root_cause_1 = Q.root_cause_1 AND P.root_cause_2 = Q.root_cause_2 AND P.root_cause_3 = Q.root_cause_3 GROUP BY DATE_FORMAT(P.Date_Start, "%W")';
	//	$sql[4] = 'SELECT DATE_FORMAT(Date_Finish, "%W") FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" GROUP BY DATE_FORMAT(Date_Finish, "%W")';
		$sql[4] = 'SELECT DATE_FORMAT(P.Date_Finish, "%W") FROM pmwo_ax_problem_solving P, pmwo_rule_probsolve Q WHERE P.problem = "'.$problem.'" AND P.root_cause_1 = Q.root_cause_1 AND P.root_cause_2 = Q.root_cause_2 AND P.root_cause_3 = Q.root_cause_3 GROUP BY DATE_FORMAT(P.Date_Finish, "%W")'; 
		$sql[5] = 'SELECT DIMENSION2_ FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" GROUP BY DIMENSION2_';
		
		//---------Root Cause------------//
		$sql[7] = 'SELECT R.Root_Cause FROM (SELECT root_cause_3 AS Root_Cause FROM pmwo_rule_probsolve WHERE root_cause_3<>"-" AND problem = "'.$problem.'" GROUP BY root_cause_3 UNION SELECT root_cause_2 AS Root_Cause FROM pmwo_rule_probsolve WHERE root_cause_3="-" AND problem = "'.$problem.'" GROUP BY root_cause_2) AS R GROUP BY R.Root_Cause'; 
		
		//-------Symptom---------------//
		$sql[6] = 'SELECT R.Symptom FROM (SELECT root_cause_2 AS Symptom FROM pmwo_rule_probsolve WHERE root_cause_3<>"-" AND problem = "'.$problem.'" GROUP BY root_cause_2 UNION SELECT root_cause_1 AS Symptom FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1) AS R GROUP BY R.Symptom';
		
		$H0 = contingency_table($sql[$v1],$sql[$v2],$v1,$v2,$problem);
		
		if(!$H0){
			$query = query_result($problem, $v1, $v2); $fill = $query;
		}else{
			$fill = '<div class="title">Tidak ada korelasi antara variabel, solusi tidak ada yang disarankan</div>';
		}
		return $fill;
	}
	//-----temporary not used-----------------//
	
	function query_result($problem, $num1, $num2){
		if($num1==6 && $num2 ==7){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 1</th><th>Root Cause 2</th><th>Root Cause 3</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
			//	$sql = 'SELECT problem, root_cause_1, root_cause_2, solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" and root_cause_2 = "'.$result0_now[1].'" GROUP BY root_cause_1, root_cause_2, solution';
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" and root_cause_2 = "'.$result0_now[1].'" and root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, solution'; 
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[0].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
			
		}else if($num1==0 && $num2 ==2){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 1</th><th>Root Cause 3</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_3, solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" and root_cause_3 = "'.$result0_now[1].'" GROUP BY root_cause_1, root_cause_3, solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==1 && $num2 ==2){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 2</th><th>Root Cause 3</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_2, root_cause_3, solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_2 = "'.$result0_now[0].'" and root_cause_3 = "'.$result0_now[1].'" GROUP BY root_cause_2, root_cause_3, solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==0 && $num2 ==3){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 1</th><th>Date Start</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Start, "%W"), solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" AND root_cause_2 = "'.$result0_now[1].'" AND root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Start, "%W"), solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==0 && $num2 ==4){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 1</th><th>Date Finish</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Finish, "%W"), solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" AND root_cause_2 = "'.$result0_now[1].'" AND root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Finish, "%W"), solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==1 && $num2 ==3){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 2</th><th>Date Start</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Start, "%W"), solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" AND root_cause_2 = "'.$result0_now[1].'" AND root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Start, "%W"), solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[2].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==1 && $num2 ==4){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 2</th><th>Date Finish</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Finish, "%W"), solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" AND root_cause_2 = "'.$result0_now[1].'" AND root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Finish, "%W"), solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[2].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==2 && $num2 ==3){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 3</th><th>Date Start</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Start, "%W"), solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" AND root_cause_2 = "'.$result0_now[1].'" AND root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Start, "%W"), solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==2 && $num2 ==4){
			$table = '<table class="display" id="data">';
			$table .= '<thead><tr><th>Problem</th><th>Root Cause 3</th><th>Date Finish</th><th>Solution</th></tr></thead><tbody>';
			$sql0 = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_rule_probsolve WHERE problem = "'.$problem.'" GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
			$result0 = mysql_query($sql0);
			while ($result0_now = mysql_fetch_array($result0)){ 
				$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Finish, "%W"), solution FROM pmwo_ax_problem_solving WHERE problem = "'.$problem.'" AND root_cause_1 = "'.$result0_now[0].'" AND root_cause_2 = "'.$result0_now[1].'" AND root_cause_3 = "'.$result0_now[2].'" GROUP BY root_cause_1, root_cause_2, root_cause_3, DATE_FORMAT(Date_Finish, "%W"), solution';
				$result = mysql_query($sql); 
				while ($result_now=mysql_fetch_array($result)){
					$table .= '<tr><td>'.$result_now[0].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>';
				}
			}
			$table .= '</tbody></table>';
		}else if($num1==0 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_1="'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==1 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_2="'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==2 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and PAPS.root_cause_3="'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==3 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and DATE_FORMAT(PAPS.Date_Start, "%W") = "'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}else if($num1==4 && $num2 ==5){
			$sql = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving PAPS, pmwo_work_order PMO WHERE PAPS.APMJOBID=PMO.APMJOBID AND PAPS.problem = "'.$problem.'" and DATE_FORMAT(PAPS.Date_Finish, "%W") = "'.$item.'" AND PMO.DIMENSION2_ = "'.$item2.'" GROUP BY DIMENSION2_';
		}
		return $table;
	}
	
?>