<?php
	function kendalltau($symp, $root){
		$table = '<table class="display" id="data">';
		$table .= '<thead><tr><th>Problem</th><th>'.$symp.'</th><th>'.$root.'</tr></thead></tbody>';
		
		$sql_rule = 'SELECT problem FROM pmwo_rule_probsolve GROUP BY problem';
		$result_rule = mysql_query($sql_rule);
		while($result_now_rule = mysql_fetch_array($result_rule)){
			$problem = $result_now_rule[0];
			$sql_sym = 'SELECT R.problem, sum(R.sym) FROM (SELECT problem, count(root_cause_1) AS sym FROM pmwo_ax_problem_solving WHERE problem="'.$problem.'" AND root_cause_1 = "'.$symp.'" AND root_cause_3 = "-"  GROUP BY problem UNION SELECT problem, count(root_cause_1) AS sym FROM pmwo_ax_problem_solving WHERE problem="'.$problem.'" AND root_cause_1 = "'.$symp.'" AND root_cause_3 <> "-"  GROUP BY problem UNION SELECT problem, count(root_cause_2) AS sym FROM pmwo_ax_problem_solving WHERE problem="'.$problem.'" AND root_cause_2 = "'.$symp.'" AND root_cause_3 <> "-"  GROUP BY problem) AS R GROUP BY R.problem'; 
			$result_sym = mysql_query($sql_sym);
			$result_now_sym = mysql_fetch_array($result_sym); //echo $result_now_sym[0];
			if($result_now_sym[1]>0) $csym = $result_now_sym[1]; else $csym = 0;
			
			$sql_rot = 'SELECT R.problem, sum(R.rot) FROM (SELECT problem, count(root_cause_2) AS rot FROM pmwo_ax_problem_solving WHERE problem="'.$problem.'" AND root_cause_2 = "'.$root.'" AND root_cause_3 = "-" GROUP BY problem UNION SELECT problem, count(root_cause_3) AS rot FROM pmwo_ax_problem_solving WHERE problem="'.$problem.'" AND root_cause_3 = "'.$root.'" AND root_cause_3 <> "-"  GROUP BY problem UNION SELECT problem, count(root_cause_3) AS rot FROM pmwo_ax_problem_solving WHERE problem="'.$problem.'" AND root_cause_3 = "'.$root.'" AND root_cause_3 <> "-"  GROUP BY problem) AS R GROUP BY R.problem';
			$result_rot = mysql_query($sql_rot);
			$result_now_rot = mysql_fetch_array($result_rot); //echo $result_now_rot[0];
			if($result_now_rot[1]>0) $crot = $result_now_rot[1]; else $crot = 0;
			
			$table .= '</tr><td>'.$problem.'</td><td>'.$csym.'</td><td>'.$crot.'</td></tr>';
		}
		
		$table .= '</tbody>';
		return $table;
	}
	
	//-------------function phi without prob--------
	function phi_with_prob($prob,$symp, $root){
		$i = 0; $j = 0;
		$val = get_val_table_with_prob($prob,$symp, $root);
		$output = '<div align="center"><b>'.$prob.'</b></div><div align="center">'.$symp.'</div><div align="center">'.$root.'</div>';
		$table = generate_table($val);
		$phi = round(get_phi($val),3);
		$chisquare_hit = round(get_chisquare($phi,$val),3);
		$output .= $table;
		
		$output .= '<div align="center">Phi-value : ('.$val[1][1].'x'.$val[2][2].')-('.$val[1][2].'x'.$val[2][1].')/sqrt('.$val[1][3].'x'.$val[2][3].'x'.$val[3][1].'x'.$val[3][3].')';
		$output .= ' = <u>'.$phi.'</u></div>';
		
		
		if($phi<0){
			$phi = $phi*-1;
			$output .= '<div align="center">Korelasi negatif, ';
		}else{
			$output .= '<div align="center">Korelasi positif, ';
		}
		
		if($phi>=0 && $phi<0.09){
			$output .= 'Tidak ada korelasi kedua data</div>';
			$strong = false;
		}else if($phi>0.09 && $phi<0.5){
			$output .= 'Korelasi lemah antara kedua data</div>';
			$strong = false;
		}else if($phi>0.5 && $phi<0.8){
			$output .= 'Korelasi sedang antara kedua data</div>';
			$strong = true;
		}else if($phi>0.8 && $phi<1){
			$output .= 'Korelasi kuat antara kedua data</div>';
			$strong = true;
		}else if($phi==1){
			$output .= 'Korelasi sempurna antara kedua data</div>';
			$strong = true;
		}
		
		$output .= '<div align="center">Chi-Square Hitung : '.$val[3][3].'x'.$phi.'^2 = ';		
		$output .= ' <u>'.$chisquare_hit.'</u></div>'; 
		if($chisquare_hit>3.841){
			$output .= '<div align="center">Hubungan kedua data signifikan, Chi-Square Hitung>3.841</div>';
			$sign = true;
		}else{
			$output .= '<div align="center">Hubungan kedua data tidak signifikan, Chi-Square Hitung<3.841</div>';
			$sign = false;
		}
		
		if($strong && $sign)
			$output .= get_solution ($symp, $root);
		else
			$output .= '<br/><br/><div align="center" style="color:red"><b>SORRY, NO HAVE SOLUTION</b></div>';
		
		//$output .= '<br/><br/>'.$val[0]; 
		
		return $output;
	}
	
	//-------------function phi with prob--------
	function phi($symp, $root){
		$i = 0; $j = 0;
		$val = get_val_table($symp, $root);
		$table = generate_table($val);
		$phi = round(get_phi($val),3);
		$chisquare_hit = round(get_chisquare($phi,$val),3);
		$output = $table;
		
		$output .= '<div align="center">Phi-value : ('.$val[1][1].'x'.$val[2][2].')-('.$val[1][2].'x'.$val[2][1].')/sqrt('.$val[1][3].'x'.$val[2][3].'x'.$val[3][1].'x'.$val[3][3].')';
		$output .= ' = <u>'.$phi.'</u></div>';
		
		
		if($phi<0){
			$phi = $phi*-1;
			$output .= '<div align="center">Korelasi negatif, ';
		}else{
			$output .= '<div align="center">Korelasi positif, ';
		}
		
		if($phi>=0 && $phi<0.09){
			$output .= 'Tidak ada korelasi kedua data</div>';
			$strong = false;
		}else if($phi>0.09 && $phi<0.5){
			$output .= 'Korelasi lemah antara kedua data</div>';
			$strong = false;
		}else if($phi>0.5 && $phi<0.8){
			$output .= 'Korelasi sedang antara kedua data</div>';
			$strong = true;
		}else if($phi>0.8 && $phi<1){
			$output .= 'Korelasi kuat antara kedua data</div>';
			$strong = true;
		}else if($phi==1){
			$output .= 'Korelasi sempurna antara kedua data</div>';
			$strong = true;
		}
		
		$output .= '<div align="center">Chi-Square Hitung : '.$val[3][3].'x'.$phi.'^2 = ';		
		$output .= ' <u>'.$chisquare_hit.'</u></div>'; 
		if($chisquare_hit>3.841){
			$output .= '<div align="center">Hubungan kedua data signifikan</div>';
			$sign = true;
		}else{
			$output .= '<div align="center">Hubungan kedua data tidak signifikan</div>';
			$sign = false;
		}
		
		if($strong && $sign)
			$output .= get_solution ($symp, $root);
		else
			$output .= '<br/><br/><div align="center" style="color:red"><b>SORRY, NO HAVE SOLUTION</b></div>';
		
		$output .= '<br/><br/>'.$val[0]; 
		
		return $output;
	}
	
	function generate_table($val){
		$table  = '<table class="mytable"><tr><td></td><td>Available in Root Cause</td><td>No Available in Root Cause</td><td>Total</td></tr>';
		$table .= '<tr><td>Available in Symptom</td><td>'.$val[1][1].'</td><td>'.$val[1][2].'</td><td>'.$val[1][3].'</td></tr>';
		$table .= '<tr><td>No Available in Symptom</td><td>'.$val[2][1].'</td><td>'.$val[2][2].'</td><td>'.$val[2][3].'</td></tr>';
		$table .= '<tr><td>Total</td><td>'.$val[3][1].'</td><td>'.$val[3][2].'</td><td>'.$val[3][3].'</td></tr>';
		$table .= '</table><br/>';
		return $table;
	}
	
	function get_phi($val){
		$phi_x = ($val[1][1]*$val[2][2])-($val[1][2]*$val[2][1]);
		$phi_y = sqrt($val[1][3]*$val[2][3]*$val[3][1]*$val[3][3]);
		if($phi_y == 0)
			$phi = 0;
		else	
			$phi = $phi_x/$phi_y;
		return $phi;
	}
	
	function get_chisquare($phi,$val){
		$chi_square = $val[3][3]*pow($phi,2);
	/*	$c1 = pow($val[1][1]-($val[1][3]/$val[3][3]*$val[3][1]),2)/($val[1][3]/$val[3][3]*$val[3][1]);
		$c2 = pow($val[1][2]-($val[1][3]/$val[3][3]*$val[3][2]),2)/($val[1][3]/$val[3][3]*$val[3][2]);
		$c3 = pow($val[2][1]-($val[2][3]/$val[3][3]*$val[3][1]),2)/($val[2][3]/$val[3][3]*$val[3][1]);
		$c3 = pow($val[2][2]-($val[2][3]/$val[3][3]*$val[3][2]),2)/($val[2][3]/$val[3][3]*$val[3][2]);
		$chi_square = $c1+$c2+$c3+$c4;*/
		return $chi_square;
	}
	
	function get_solution ($symp, $root){
		$i =1;
		$table = '<br/><table class="mytable"><tr><td width="50">No</td><td width="800" align="center"><b>Solution</b></td></tr>';
		$sql = 'SELECT solution FROM pmwo_ax_problem_solving WHERE (root_cause_1="'.$symp.'" AND root_cause_2 = "'.$root.'") OR (root_cause_2="'.$symp.'" AND root_cause_3 = "'.$root.'") GROUP BY solution';	
		$result = mysql_query($sql);
		while($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td>'.$i.'</td><td>'.$result_now[0].'</td></tr>';
			$i++;
		}
		$table .= '<table>';
		return $table;
	}
	
	//------------Get value of size 2x2 table without problem----------
	function get_val_table($symp, $root){
		$table = '<div align="center"><b>HOW TO GROUPING DATA BY SYMPTOM AND ROOT CAUSE AVAILABLE IN DATA</b></div>';
		$sql_data_ada_ada = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_3="'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3="'.$root.'")'; 
		$result = mysql_query($sql_data_ada_ada);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>Availabble in Data || Available in Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>';
	
		$sql_ada_ada = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3="'.$root.'")'; 
		$result = mysql_query($sql_ada_ada);
		$result_now = mysql_fetch_array($result);
		$val_ada_ada = $result_now[0];
	//	echo '<b>ada ada = '.$val_ada_ada.'</b><br/>';
		
		$sql_data_ada_tidak = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3<>"'.$root.'")'; 
		$result = mysql_query($sql_data_ada_tidak);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>Availabble in Data || No Available in Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>';
		
		$sql_ada_tidak = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_3<>"'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3<>"'.$root.'")'; 
		$result = mysql_query($sql_ada_tidak);
		$result_now = mysql_fetch_array($result);
		$val_ada_tidak = $result_now[0];
	//	echo '<b>ada tidak = '.$val_ada_tidak.'</b><br/>';
		
		$sql_data_tidak_ada = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'")'; 
		$result = mysql_query($sql_data_tidak_ada);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>No Availabble in Data || Available ini Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>';
		
		$sql_tidak_ada = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'")'; 
		$result = mysql_query($sql_tidak_ada);
		$result_now = mysql_fetch_array($result);
		$val_tidak_ada = $result_now[0];
	//	echo '<b>tidak ada = '.$val_tidak_ada.'</b><br/>';
		
		$sql_data_tidak_tidak = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'")'; 
		$result = mysql_query($sql_data_tidak_tidak);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>No Availabble in Data || No Available ini Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>';
		
		$sql_tidak_tidak = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_3<>"'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'")'; 
		$result = mysql_query($sql_tidak_tidak);
		$result_now = mysql_fetch_array($result);
		$val_tidak_tidak = $result_now[0];
	//	echo '<b>tidak ada = '.$val_tidak_tidak.'</b><br/>';
		
		$total = $val_ada_ada+$val_ada_tidak+$val_tidak_ada+$val_tidak_tidak;
	//	echo 'total = '.$total.'<br/>';
		
		$value_data[0] = $table.'<br/><br>';
		$value_data[1][1]=$val_ada_ada;
		$value_data[1][2]=$val_ada_tidak;
		$value_data[1][3]=$val_ada_ada+$val_ada_tidak;
		$value_data[2][1]=$val_tidak_ada;
		$value_data[2][2]=$val_tidak_tidak;
		$value_data[2][3]=$val_tidak_ada+$val_tidak_tidak;
		$value_data[3][1]=$val_ada_ada+$val_tidak_ada;
		$value_data[3][2]=$val_ada_tidak+$val_tidak_tidak;
		$value_data[3][3]=$value_data[3][1]+$value_data[3][2];
		return $value_data;
	}
	
	//------------Get value of size 2x2 table with problem----------
	function get_val_table_with_prob($prob,$symp, $root){
		$table = '<div align="center"><b>HOW TO GROUPING DATA BY SYMPTOM AND ROOT CAUSE AVAILABLE IN DATA</b></div>
				  <div align="center">'.$symp.'</div><div align="center">'.$root.'</div>';
		$sql_data_ada_ada = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_3="'.$root.'" AND problem="'.$prob.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3="'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_data_ada_ada);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>Availabble in Data || Available in Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>'; //echo $table;
	
		$sql_ada_ada = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'" AND problem="'.$prob.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3="'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_ada_ada);
		$result_now = mysql_fetch_array($result);
		$val_ada_ada = $result_now[0];
		//echo '<b>ada ada = '.$val_ada_ada.'</b><br/>';
		
		$sql_data_ada_tidak = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_data_ada_tidak);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>Availabble in Data || No Available in Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>'; //echo $table;
		
		$sql_ada_tidak = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1="'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_ada_tidak);
		$result_now = mysql_fetch_array($result);
		$val_ada_tidak = $result_now[0];
		//echo '<b>ada tidak = '.$val_ada_tidak.'</b><br/>';
		
		$sql_data_tidak_ada = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_data_tidak_ada);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>No Availabble in Data || Available ini Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>'; //echo $table;
		
		$sql_tidak_ada = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_tidak_ada);
		$result_now = mysql_fetch_array($result);
		$val_tidak_ada = $result_now[0];
		//echo '<b>tidak ada = '.$val_tidak_ada.'</b><br/>';
		
		$sql_data_tidak_tidak = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_data_tidak_tidak);
		$table .= '<table class="mytable"><tr><td colspan="3" align="center"><b>No Availabble in Data || No Available ini Data<b><td><tr>';
		while ($result_now = mysql_fetch_array($result)){
			$table .= '<tr><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td width=300>'.$result_now[3].'</td></tr>';
		}
		$table .= '</table>'; echo $table;
		
		$sql_tidak_tidak = 'SELECT count(problem) FROM pmwo_data_probsolve WHERE (root_cause_1<>"'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'" AND problem="'.$prob.'")'; 
		$result = mysql_query($sql_tidak_tidak);
		$result_now = mysql_fetch_array($result);
		$val_tidak_tidak = $result_now[0];
		//echo '<b>tidak tidak = '.$val_tidak_tidak.'</b><br/>';
		
		$total = $val_ada_ada+$val_ada_tidak+$val_tidak_ada+$val_tidak_tidak;
		//echo 'total = '.$total.'<br/>';
		
		$value_data[0] = $table.'<br/><br>';
		$value_data[1][1]=$val_ada_ada;
		$value_data[1][2]=$val_ada_tidak;
		$value_data[1][3]=$val_ada_ada+$val_ada_tidak;
		$value_data[2][1]=$val_tidak_ada;
		$value_data[2][2]=$val_tidak_tidak;
		$value_data[2][3]=$val_tidak_ada+$val_tidak_tidak;
		$value_data[3][1]=$val_ada_ada+$val_tidak_ada;
		$value_data[3][2]=$val_ada_tidak+$val_tidak_tidak;
		$value_data[3][3]=$value_data[3][1]+$value_data[3][2];
		return $value_data;
	}
	
	//******************membandingkan antara AR dan TAR**********//
	function comp_phi_with_prob($prob,$symp, $root){
		$val = get_val_table_with_prob($prob,$symp, $root); 
		$phi = round(get_phi($val),3);
		$chisquare_hit = round(get_chisquare($phi,$val),3); echo phi_with_prob($prob,$symp, $root);
		$value[1]=$phi;
		$value[2]=$chisquare_hit;
		return $value;
	}
	
	function comp_phi($symp, $root){
		$val = get_val_table($symp, $root); 
		$phi = round(get_phi($val),3);
		$chisquare_hit = round(get_chisquare($phi,$val),3); //echo phi($symp, $root);
		$value[1]=$phi;
		$value[2]=$chisquare_hit;
		return $value;
	}
	
	function comp_phi_tar($symp, $root){
		$val = get_val_table_tar($symp, $root);
		$phi = round(get_phi($val),3);
		
		return $phi;
	}
	
	function get_val_table_tar($symp, $root){
		$table = '<div align="center"><b>HOW TO GROUPING DATA BY SYMPTOM AND ROOT CAUSE AVAILABLE IN DATA</b></div>';
	
		$sql_ada_ada = 'SELECT count(problem) FROM pmwo_data_probsolve_asrule WHERE (root_cause_1="'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3="'.$root.'")'; 
		$result = mysql_query($sql_ada_ada);
		$result_now = mysql_fetch_array($result);
		$val_ada_ada = $result_now[0];
	//	echo '<b>ada ada = '.$val_ada_ada.'</b><br/>';
		
		$sql_ada_tidak = 'SELECT count(problem) FROM pmwo_data_probsolve_asrule WHERE (root_cause_1="'.$symp.'" AND root_cause_3<>"'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2="'.$symp.'" AND root_cause_3<>"'.$root.'")'; 
		$result = mysql_query($sql_ada_tidak);
		$result_now = mysql_fetch_array($result);
		$val_ada_tidak = $result_now[0];
	//	echo '<b>ada tidak = '.$val_ada_tidak.'</b><br/>';
		
		$sql_tidak_ada = 'SELECT count(problem) FROM pmwo_data_probsolve_asrule WHERE (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3="'.$root.'")'; 
		$result = mysql_query($sql_tidak_ada);
		$result_now = mysql_fetch_array($result);
		$val_tidak_ada = $result_now[0];
	//	echo '<b>tidak ada = '.$val_tidak_ada.'</b><br/>';
		
		$sql_tidak_tidak = 'SELECT count(problem) FROM pmwo_data_probsolve_asrule WHERE (root_cause_1<>"'.$symp.'" AND root_cause_3<>"'.$root.'") OR (root_cause_1<>"'.$symp.'" AND root_cause_2<>"'.$symp.'" AND root_cause_3<>"'.$root.'")'; 
		$result = mysql_query($sql_tidak_tidak);
		$result_now = mysql_fetch_array($result);
		$val_tidak_tidak = $result_now[0];
	//	echo '<b>tidak ada = '.$val_tidak_tidak.'</b><br/>';
		
		$total = $val_ada_ada+$val_ada_tidak+$val_tidak_ada+$val_tidak_tidak;
	//	echo 'total = '.$total.'<br/>';
		
		$value_data[0] = $table.'<br/><br>';
		$value_data[1][1]=$val_ada_ada;
		$value_data[1][2]=$val_ada_tidak;
		$value_data[1][3]=$val_ada_ada+$val_ada_tidak;
		$value_data[2][1]=$val_tidak_ada;
		$value_data[2][2]=$val_tidak_tidak;
		$value_data[2][3]=$val_tidak_ada+$val_tidak_tidak;
		$value_data[3][1]=$val_ada_ada+$val_tidak_ada;
		$value_data[3][2]=$val_ada_tidak+$val_tidak_tidak;
		$value_data[3][3]=$value_data[3][1]+$value_data[3][2];
		return $value_data;
	}
?>