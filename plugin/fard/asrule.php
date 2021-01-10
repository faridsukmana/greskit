<?php
	//====mendapatkan jumlah array berdasarkan kolom.//	
	function combination_item_set($frek_item_set,$sql,$min_support,$num_trans){
		$i = 0; $sum_sql = sizeof($sql); $sum_array = 0; 
		while($i<$sum_sql){																	//jumlah sql yang dipanggil
			$result = mysql_query($sql[$i]);												
			while($result_now = mysql_fetch_array($result)){
				if(empty($array [$result_now[0]][2])){
					$sum_array = $sum_array+1;
					$array [$sum_array][2] = $result_now[0]; 								//masukkan nama urutan root cause dalam item_set
				}
				$array [$result_now[0]][3] = $result_now[0]; 								//mendapatkan nama root cause dari work order
				$array [$result_now[0]][4] = $array [$result_now[0]][4] + $result_now[1];	//mendapatkan jumlah root cause dari work order
			}
			$i++;
		}
		
		$array['sum_array'][0] = $sum_array;
		
		//mendapatkan kumpulan item yang memiliki itemset lebih besar dari yang ditentukan	
		$i = 0; $j = 0; //echo '<table class="mytable">';
		while($i<$array['sum_array'][0]){
			if($array [$array[$i][2]][4]>=$frek_item_set){
				$support = $array [$array[$i][2]][4]/$num_trans;
				if($support>=$min_support){
					$item[$j][0] = $array [$array[$i][2]][3];									// array 0 untuk item adalah nama dari item
					$item[$j][1] = $array [$array[$i][2]][4];									// array 1 untuk item adalah jumlah dari item
				//	echo '<tr><td width=250>'.$item[$j][0].'</td><td>'.$item[$j][1].'</td></tr>';
					$j++;
				}
			}
			$i++;
		}
		
	//	echo '</table>';
		$item['item'][0] = $j;
		
		$item = remove_duplicat($item);
		
		//=================show in table==============
		$j=0;
		echo '<table class="mytable">';
		while($j<$item['item'][0]){
			echo '<tr><td width=250>'.$item[$j][0].'</td><td>'.$item[$j][1].'</td></tr>';
			$j++;
		}
		echo '</table>';
		
		return $item;
	}
	
	
	//======================menghilangkan duplikat array============================================
	function remove_duplicat($item){
		$i=0; $j=0; $k=0; $item1 = ''; $item2 = ''; 
		while($i<$item['item'][0]){
			$item1 = $item[$i][0]; $j = 0; 
			while($j<$item['item'][0]){
				$item2 = $item[$j][0]; 
				if(strcmp($item1,$item2)==0 && empty($pos[$item1])){
					$new_item[$k][0] = $item[$i][0];
					$new_item[$k][1] = $item[$i][1];
					$k++;
					$pos[$item1] = 1;
				}
				$j++;
			}
			if(empty($pos[$item1])){
				$new_item[$k][0] = $item[$i][0];
				$new_item[$k][1] = $item[$i][1];
				$k++;
			}
			$i++;
		}
		
		$new_item['item'][0] = $k; 
		
		//$item = $new_item;
		
		return $new_item;
	}
	
	
	//========================fungsi dengan pengelompokan 2 item ============================
	function combination_2_array_itemset($frek_item_set, $item, $min_support, $num_trans){
		$i = 0; $j = 0; $k =0; 
		while($i<($item['item'][0]-1)){
			$item1 = $item[$i][0]; $j = $i+1;
			while($j<$item['item'][0]){
			//	echo '<br>----------<br/>';
				$item2 = $item[$j][0];
				$item_comb_two[$k][0] = $item1;
				$item_comb_two[$k][1] = $item2;
				$item_comb_two[$k][2] = count_combination_2_array_itemset($item1, $item2);
			//	echo $item_comb_two[$k][0].' and '.$item_comb_two[$k][1].' = '.$item_comb_two[$k][2].'<br/>'; 
				$k++;
				$item_comb_two[$k][0] = $item2;
				$item_comb_two[$k][1] = $item1;
				$item_comb_two[$k][2] = count_combination_2_array_itemset($item2, $item1);
			//	echo $item_comb_two[$k][0].' and '.$item_comb_two[$k][1].' = '.$item_comb_two[$k][2].'<br/>'; 
				$k++;
				$j++;
			} 
			$i++;
		}
		
		$item_comb_two['item'][0] = $k;
		$j = 0; $k=0; echo '<table class="mytable">';
		while($j<$item_comb_two['item'][0]){
			if($item_comb_two[$j][2]>=$frek_item_set){
				$support = $item_comb_two[$j][2]/$num_trans;
				if($support>=$min_support){
					$item_comb_two[$k][0] = $item_comb_two[$j][0];
					$item_comb_two[$k][1] = $item_comb_two[$j][1];
					$item_comb_two[$k][2] = $item_comb_two[$j][2];
				//	echo $item_comb_two[$k][0].' and '.$item_comb_two[$k][1].' = '.$item_comb_two[$k][2].'<br/>'; 
					echo '<tr><td>'.$item_comb_two[$k][0].'</td><td>'.$item_comb_two[$k][1].'</td><td>'.$item_comb_two[$k][2].'</td></tr>';
					$k++;
				}
			}
			$j++;
		}
		echo '<table>';
		
		$item_comb_two['item'][0] = $k;
		
		return $item_comb_two;
	}
	
	//==================CARA 1. mendapatkan jumlah item 2-itemset============================ 
	function count_combination_2_array_itemset($item1, $item2){
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item1.'" AND root_cause_2 = "'.$item2.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = mysql_num_rows($ex_sql);
	/*	$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item2.'" AND root_cause_2 = "'.$item1.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);*/
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item1.'" AND root_cause_3 = "'.$item2.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);
	/*	$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item2.'" AND root_cause_3 = "'.$item1.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);*/
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_2 = "'.$item1.'" AND root_cause_3 = "'.$item2.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);
	/*	$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_2 = "'.$item2.'" AND root_cause_3 = "'.$item1.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);*/
		return $r_sql;
	}
	
	//==================CARA 2. mendapatkan jumlah item 2-itemset============================
/*	function count_combination_2_array_itemset($item1, $item2){	
		$same1 = false; $same2 = false; $sum_item = 0; $item[1] = $item1; $item[2] = $item2; 
		$sql = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_ax_problem_solving';
		$result = mysql_query($sql) or die('Failed');
		while($result_now = mysql_fetch_array($result)){
			$i = 1;  $same = 0; $temp = ''; $same1 = false; $same2 = false;
			while($i<=2){
				$j = 0;
				while($j<=2){ //echo $item1.' , '.$result_now[$j].'<br/>';
					if((strcmp($item1,$result_now[$j])==0) && $i==1){
						$same1=true; $temp = $j;
					//	if($same1){
					//		$text = $result_now[$j].' and ';
					//	}
					}else if((strcmp($item2,$result_now[$j])==0) && $i==2 && $same1 && $j!=$temp){
						$same2=true; $sum_item++; break;
					//	if($same2){
					//		echo $text.$result_now[$j].'<br/>';
					//	}
					}
					$j++;
				}
				$i++;
			}
			
		}
					
		return $sum_item;
	}*/
	
	//========================funsgi dengan pengelompokan 3 item ================================================
	function combination_3_array_itemset($frek_item_set, $item, $min_support, $num_trans){
		$i = 0; $k = 0;
		while($i<$item['item'][0]-1){
			$item1[0] = $item[$i][0];
			$item1[1] = $item[$i][1];
			$j = $i+1;
			while($j<$item['item'][0]){
				$item2[0] = $item[$j][0];
				$item2[1] = $item[$j][1];
				$value = available_same_item($item1, $item2); //if($value) $v_ = '<span style="color:blue">Good</span>'; else $v_ = '<span style="color:red">Bad</span>';
				if($value){
				//	$v_ = '<span style="color:blue">Good</span>'; 
				//	echo $item1[0].','.$item1[1].' <b>and</b> '.$item2[0].','.$item2[1].' = '.$v_.'<br/>';
					$item_one = combination_3_itemset_be_one($item1, $item2); 
					$item_comb_three[$k][0] = $item_one[0];
					$item_comb_three[$k][1] = $item_one[1];
					$item_comb_three[$k][2] = $item_one[2];
					$item_comb_three[$k][3] = count_combination_3_array_itemset($item_one[0], $item_one[1], $item_one[2]);
				//	echo $item_one[0].' and '.$item_one[1].' and '.$item_one[2].' = '.$item_comb_three[$k][3].'<br/>';
					$k++;
				//	$item_one = combination_3_itemset_be_one($item1, $item2); 
					$item_comb_three[$k][0] = $item_one[0];
					$item_comb_three[$k][1] = $item_one[2];
					$item_comb_three[$k][2] = $item_one[1];
					$item_comb_three[$k][3] = count_combination_3_array_itemset($item_one[0], $item_one[2], $item_one[1]);
				//	echo $item_one[0].' and '.$item_one[1].' and '.$item_one[2].' = '.$item_comb_three[$k][3].'<br/>';
					$k++;
				//	$item_one = combination_3_itemset_be_one($item1, $item2); 
					$item_comb_three[$k][0] = $item_one[1];
					$item_comb_three[$k][1] = $item_one[0];
					$item_comb_three[$k][2] = $item_one[2];
					$item_comb_three[$k][3] = count_combination_3_array_itemset($item_one[1], $item_one[0], $item_one[2]);
				//	echo $item_one[0].' and '.$item_one[1].' and '.$item_one[2].' = '.$item_comb_three[$k][3].'<br/>';
					$k++;
				//	$item_one = combination_3_itemset_be_one($item1, $item2); 
					$item_comb_three[$k][0] = $item_one[1];
					$item_comb_three[$k][1] = $item_one[2];
					$item_comb_three[$k][2] = $item_one[0];
					$item_comb_three[$k][3] = count_combination_3_array_itemset($item_one[1], $item_one[2], $item_one[0]);
				//	echo $item_one[0].' and '.$item_one[1].' and '.$item_one[2].' = '.$item_comb_three[$k][3].'<br/>';
					$k++;
				//	$item_one = combination_3_itemset_be_one($item1, $item2); 
					$item_comb_three[$k][0] = $item_one[2];
					$item_comb_three[$k][1] = $item_one[0];
					$item_comb_three[$k][2] = $item_one[1];
					$item_comb_three[$k][3] = count_combination_3_array_itemset($item_one[2], $item_one[0], $item_one[1]);
				//	echo $item_one[0].' and '.$item_one[1].' and '.$item_one[2].' = '.$item_comb_three[$k][3].'<br/>';
					$k++;
					$item_comb_three[$k][0] = $item_one[2];
					$item_comb_three[$k][1] = $item_one[1];
					$item_comb_three[$k][2] = $item_one[0];
					$item_comb_three[$k][3] = count_combination_3_array_itemset($item_one[2], $item_one[1], $item_one[0]);
				//	echo $item_one[0].' and '.$item_one[1].' and '.$item_one[2].' = '.$item_comb_three[$k][3].'<br/>';
					$k++;
				}
				$j++;
			}
			$i++;
		}
		
		$item_comb_three['item'][0] = $k;
		$j = 0; $k=0; //echo '<table class="mytable">';
		while($j<$item_comb_three['item'][0]){
			if($item_comb_three[$j][3]>=$frek_item_set){
				$support = $item_comb_three[$j][3]/$num_trans;
				if($support>$min_support){
					$item_comb_three[$k][0] = $item_comb_three[$j][0];
					$item_comb_three[$k][1] = $item_comb_three[$j][1];
					$item_comb_three[$k][2] = $item_comb_three[$j][2];
					$item_comb_three[$k][3] = $item_comb_three[$j][3];
				//	echo $item_comb_three[$k][0].' and '.$item_comb_three[$k][1].' and '.$item_comb_three[$k][2].' = '.$item_comb_three[$k][3].'<br/>'; 
				//	echo '<tr><td>'.$item_comb_three[$k][0].'</td><td>'.$item_comb_three[$k][1].'</td><td>'.$item_comb_three[$k][2].'</td><td>'.$item_comb_three[$k][3].'</td></tr>';
					$k++;
				}
			}
			$j++;
		}
	//	echo '</table>';
		$item_comb_three['item'][0] = $k;
		
		$item = remove_duplicat_3_itemset($item_comb_three);
		
		return $item;
	}
	
	//=================remove duplikat dari3-itemset========================================================
	function remove_duplicat_3_itemset($item){
		$i=0; $j=0; $k=0; $item1 = ''; $item2 = ''; echo '<table class="mytable">';
		while($i<$item['item'][0]){
			$item1_1 = $item[$i][0];
			$item1_2 = $item[$i][1];
			$item1_3 = $item[$i][2]; $item_s = $item[$i][0].$item[$i][1].$item[$i][2];
			$j = 0; 
			while($j<$item['item'][0]){
				$item2_1 = $item[$j][0];
				$item2_2 = $item[$j][1];
				$item2_3 = $item[$j][2];
				if(strcmp($item1_1,$item2_1)==0 && strcmp($item1_2,$item2_2)==0 && strcmp($item1_3,$item2_3)==0 && empty($pos[$item_s])){
					$new_item[$k][0] = $item[$i][0];
					$new_item[$k][1] = $item[$i][1];
					$new_item[$k][2] = $item[$i][2];
					$new_item[$k][3] = $item[$i][3];
					echo '<tr><td>'.$new_item[$k][0].'</td><td>'.$new_item[$k][1].'</td><td>'.$new_item[$k][2].'</td><td>'.$new_item[$k][3].'</td></tr>';
					$k++;
					$pos[$item_s] = 1;
				}
				$j++;
			}
			if(empty($pos[$item_s])){
				$new_item[$k][0] = $item[$i][0];
				$new_item[$k][1] = $item[$i][1];
				$new_item[$k][2] = $item[$i][2];
				$new_item[$k][3] = $item[$i][3];
				echo '<tr><td>'.$new_item[$k][0].'</td><td>'.$new_item[$k][1].'</td><td>'.$new_item[$k][2].'</td><td>'.$new_item[$k][3].'</td></tr>';
				$k++;
			}
			$i++;
		}
		echo '</table>';
		
		$new_item['item'][0] = $k; 
		
		return $new_item;
	}
	
	///=================apakah didalam 2 item yang digabungkan terdapat item yang sama ======================
	function available_same_item($item1, $item2){
		$value = false; $i = 0; $j = 0;
		while($i<2){
			$temp_item1 = $item1[$i]; 
			while($j<2){
				$temp_item2 = $item2[$j];
				if(strcmp($temp_item1,$temp_item2)==0){
					$value = true;
				}
				$j++;
			}
			$i++;
		}
		return $value;
	}
	
	//=================menggabungkan item menjadi 1 ==================================================
	function combination_3_itemset_be_one($item1, $item2){
		$i = 0; $j = 0; $k = 0; $value_of_item = ''; 
		while($i<2){
			$temp_item1 = $item1[$i]; $j=0;	
			while($j<2){
				$temp_item2 = $item2[$j];
				if(strcmp($temp_item1,$temp_item2)==0){
					$value_of_item = $temp_item1; $temp_i = $i; $temp_j = $j; 
				}
				$j++;
			}
			$i++;
		}
		
		$i = 0;
		
		$item[$k] = $value_of_item; $k++;
		
		while($i<2){
			if(strcmp($item1[$i],$value_of_item)<>0){
		//	if($i<>$temp_i){
				$item[$k] = $item1[$i]; $k++; 
			}	
			$i++;
		}
		
		$j=0;
		while($j<2){
				if(strcmp($item2[$j],$value_of_item)<>0){
		//	if($j<>$temp_j){
				$item[$k] = $item2[$j]; $k++;
			}
			$j++;
		}
		
		return $item;
	}
	
	//============CARA 1 mendapatkan jumlah item 3-itemset =================================
	function count_combination_3_array_itemset($item1, $item2, $item3){
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item1.'" AND root_cause_2 = "'.$item2.'" AND root_cause_3 = "'.$item3.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = mysql_num_rows($ex_sql);
	/*	$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item1.'" AND root_cause_2 = "'.$item3.'" AND root_cause_3 = "'.$item2.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item2.'" AND root_cause_2 = "'.$item1.'" AND root_cause_3 = "'.$item3.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item2.'" AND root_cause_2 = "'.$item3.'" AND root_cause_3 = "'.$item1.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item3.'" AND root_cause_2 = "'.$item1.'" AND root_cause_3 = "'.$item2.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);
		$sql = 'SELECT * FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item3.'" AND root_cause_2 = "'.$item2.'" AND root_cause_3 = "'.$item1.'"';
		$ex_sql = mysql_query($sql);
		$r_sql = $r_sql+mysql_num_rows($ex_sql);*/
		return $r_sql;
	}
	
	//============CARA 2 mendapatkan jumlah item 3-itemset =================================
/*	function count_combination_3_array_itemset($item1, $item2, $item3){
		$sum_item = 0;  
		$sql = 'SELECT root_cause_1, root_cause_2, root_cause_3 FROM pmwo_ax_problem_solving';
		$result = mysql_query($sql) or die('Failed');
		while($result_now = mysql_fetch_array($result)){
			$i = 1;  $same = 0; $temp1 = ''; $temp2 = ''; $same1 = false; $same2 = false; $same3 = false;
			while($i<=3){
				$j = 0;
				while($j<=2){ 
					if((strcmp($item1,$result_now[$j])==0) && $i==1){
						$same1=true; $temp1 = $j;
					}else if((strcmp($item2,$result_now[$j])==0) && $i==2 && $same1 && $j!=$temp1){
						$same2=true; $temp2 = $j;
					}else if((strcmp($item3,$result_now[$j])==0) && $i==3 && $same2 && $j!=$temp1 && $j!=$temp2){
						$same3=true; $sum_item++; break;
					}
					$j++;
				}
				$i++;
			}
		}
					
		return $sum_item;
	}*/
	
	//======================mendapatkan rule berdasarkan tingkat support dan konfidence==========================================
	function generate_all_rule($item, $min_confidence){
		$i = 0; $body = ''; $j = 0; $bool = false; $k = 0;
		$sql = 'DELETE FROM pmwo_data_probsolve';
		mysql_query($sql);
		
	//	$head = '<thead><tr><th>Problem</th><th>Why 1</th><th>Why 2</th><th>Why 3</th><th>Solution</th><th>Description</th></tr><thead>';
		while($i<$item['item'][0]){
		//	$body .= get_right_rule($item[$i][0],$item[$i][1],$item[$i][2],$item[$i][3],$min_confidence); 
			$sql = 'SELECT COUNT(root_cause_1), problem FROM pmwo_ax_problem_solving WHERE root_cause_1 = "'.$item[$i][0].'" AND root_cause_2 = "'.$item[$i][1].'"';
			$result = mysql_query($sql);
			$result_now = mysql_fetch_array($result);
			echo $i.'-----'.$item[$i][0].' AND '.$item[$i][1].' -> '.$item[$i][2].' = '.$result_now[0].'<br/>'; 
			if(($item[$i][3]/$result_now[0])>$min_confidence){
			//	echo $item[$i][0].' AND '.$item[$i][1].' -> '.$item[$i][2].'<br/>';
				$sql = 'INSERT INTO pmwo_rule_probsolve VALUES ("'.$j.'","'.$result_now[1].'","'.$item[$i][0].'","'.$item[$i][1].'","'.$item[$i][2].'")';
				$sql_data = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_ax_problem_solving WHERE problem = "'.$result_now[1].'" AND root_cause_1 = "'.$item[$i][0].'" AND root_cause_2 = "'.$item[$i][1].'" AND root_cause_3 = "'.$item[$i][2].'"'; echo $sql_data.'<br>';
				$result_data = mysql_query($sql_data);
				while($result_now_data = mysql_fetch_array($result_data)){
					if($result_now_data[3] == "-" ){
						$sql_ = 'INSERT INTO pmwo_data_probsolve VALUES ("'.$k.'","'.$result_now_data[0].'","'.$result_now_data[1].'","-","'.$result_now_data[2].'")';
						mysql_query($sql_);
					}else{
						$sql_ = 'INSERT INTO pmwo_data_probsolve VALUES ("'.$k.'","'.$result_now_data[0].'","'.$result_now_data[1].'","'.$result_now_data[2].'","'.$result_now_data[3].'")';
						mysql_query($sql_);
					}
					$k++;
				}
				echo "=================total k = ".$k.'<br/>';
				
				echo $j.' . '.$item[$i][0].' && '.$item[$i][1].' && '.$item[$i][2].' --> '.$item[$i][3].'/'.$result_now[0].'='.$item[$i][3]/$result_now[0].'<br/>';
				mysql_query($sql); $j++;
			}
			$i++;
		}
		 return $j;
	//	$body = '<tbody>'.$body.'</tbody>';
		
	//	$table = '<div id="scrolling"><table class="display" id="data">'.$head.$body.$tfoot.'</table></div>';
	//	return $table;
	}
	
	function get_right_rule($item1,$item2,$item3,$frek_item_all,$min_confidence){
		$i = 0; $data = ''; $j = 0;
		while($i<6){
			if($i==0){
				$sql = 'SELECT P.problem, P.root_cause_1, P.root_cause_2, P.root_cause_3, P.solution, A.core_location FROM pmwo_ax_problem_solving P, pmwo_ax_core_location A WHERE P.root_cause_1 = "'.$item1.'" AND P.root_cause_2 = "'.$item2.'" AND P.root_cause_3 = "'.$item3.'" AND P.description = A.id_core GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
				$result = mysql_query($sql);
				while($result_now = mysql_fetch_array($result)){
					$data[$j] = '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>'; $j++;
				}
			}else if($i==1){
				$sql = 'SELECT P.problem, P.root_cause_1, P.root_cause_2, P.root_cause_3, P.solution, A.core_location FROM pmwo_ax_problem_solving P, pmwo_ax_core_location A WHERE P.root_cause_1 = "'.$item1.'" AND P.root_cause_2 = "'.$item3.'" AND P.root_cause_3 = "'.$item2.'" AND P.description = A.id_core GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
				$result = mysql_query($sql);
				while($result_now = mysql_fetch_array($result)){
					$data[$j] = '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>'; $j++;
				}
			}else if($i==2){
				$sql = 'SELECT P.problem, P.root_cause_1, P.root_cause_2, P.root_cause_3, P.solution, A.core_location FROM pmwo_ax_problem_solving P, pmwo_ax_core_location A WHERE P.root_cause_1 = "'.$item2.'" AND P.root_cause_2 = "'.$item1.'" AND P.root_cause_3 = "'.$item3.'" AND P.description = A.id_core GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
				$result = mysql_query($sql);
				while($result_now = mysql_fetch_array($result)){
					$data[$j] = '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>'; $j++;
				}
			}else if($i==3){
				$sql = 'SELECT P.problem, P.root_cause_1, P.root_cause_2, P.root_cause_3, P.solution, A.core_location FROM pmwo_ax_problem_solving P, pmwo_ax_core_location A WHERE P.root_cause_1 = "'.$item2.'" AND P.root_cause_2 = "'.$item3.'" AND P.root_cause_3 = "'.$item1.'" AND P.description = A.id_core GROUP BY root_cause_1, root_cause_2, root_cause_3'; 
				$result = mysql_query($sql);
				while($result_now = mysql_fetch_array($result)){
					$data[$j] = '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>'; $j++;
				}
			}else if($i==4){
				$sql = 'SELECT P.problem, P.root_cause_1, P.root_cause_2, P.root_cause_3, P.solution, A.core_location FROM pmwo_ax_problem_solving P, pmwo_ax_core_location A WHERE P.root_cause_1 = "'.$item3.'" AND P.root_cause_2 = "'.$item2.'" AND P.root_cause_3 = "'.$item1.'" AND P.description = A.id_core GROUP BY root_cause_1, root_cause_2, root_cause_3';
				$result = mysql_query($sql);
				while($result_now = mysql_fetch_array($result)){
					$data[$j] = '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>'; $j++;
				}
			}else if($i==5){
				$sql = 'SELECT P.problem, P.root_cause_1, P.root_cause_2, P.root_cause_3, P.solution, A.core_location FROM pmwo_ax_problem_solving P, pmwo_ax_core_location A WHERE P.root_cause_1 = "'.$item3.'" AND P.root_cause_2 = "'.$item1.'" AND P.root_cause_3 = "'.$item2.'" AND P.description = A.id_core GROUP BY root_cause_1, root_cause_2, root_cause_3';
				$result = mysql_query($sql);
				while($result_now = mysql_fetch_array($result)){
					$data[$j] = '<tr><td>'.$result_now[0].'</td><td>'.$result_now[1].'</td><td>'.$result_now[2].'</td><td>'.$result_now[3].'</td><td>'.$result_now[4].'</td><td>'.$result_now[5].'</td></tr>'; $j++;
				}
			}
			
			$i++;
		}
		
		$i = 0; $k = 0; $content = ''; $temp_data = '';
		
		while($i<$j){
			$temp_data = $data[$i]; $k = $i+1;
			if($j>1){
				while($k<$j){
				if(strcmp($temp_data,$data[$k])<>0){
					$content .= $data[$k];
					$temp_data = $data[$k];
				}
				$k++;
			}
			}else{
				$content .= $data[$i];
			}
			$i++;
		}
		
		return $content;
	}
	
	function association_rule(){
		//---------------mendefinisikan variabel frekuensi untuk itemset------------------------------------------
		$query = 'SELECT Var_Name, Var_Value FROM pmwo_var_asrule WHERE Var_Category = "Asc Rule"';
		$result = mysql_query($query);
		while($result_now = mysql_fetch_array($result)){
			if(strcmp($result_now[0],'Frekuensi Item Set')==0){
				$frek_item_set = $result_now[1];
			}else if(strcmp($result_now[0],'Minimum Support')==0){
				$min_support = $result_now[1];
			}else if(strcmp($result_now[0],'Minimum Confidence')==0){
				$min_confidence = $result_now[1];
			}
		}
	//	$frek_item_set = 3;
	//	$min_support = 0.001;
		echo 'Minimum Support = '.$min_support.' and Minimum Confidence = '.$min_confidence.'<br>';
		
		$query = 'SELECT COUNT(root_cause_1) FROM pmwo_ax_problem_solving';
		$result = mysql_query($query);
		$result_now = mysql_fetch_array($result);
		$num_trans = $result_now[0];
		
		//-----------------melibatkan 1 itemset ------------------------------------------------------------------
		$sql[0] = 'SELECT root_cause_1, COUNT(root_cause_1) FROM pmwo_ax_problem_solving GROUP BY root_cause_1';
		$sql[1] = 'SELECT root_cause_2, COUNT(root_cause_2) FROM pmwo_ax_problem_solving GROUP BY root_cause_2';
		$sql[2] = 'SELECT root_cause_3, COUNT(root_cause_3) FROM pmwo_ax_problem_solving GROUP BY root_cause_3';
		$item = combination_item_set($frek_item_set,$sql,$min_support,$num_trans);
		
		//-----------------melibatkan 2 itemset -------------------------------------------------------------------
		$item2 = combination_2_array_itemset($frek_item_set,$item,$min_support,$num_trans);
		
		//-----------------melibatkan 3 itemset -------------------------------------------------------------------
		$item3 = combination_3_array_itemset($frek_item_set, $item2,$min_support,$num_trans);
		
		//-----------------Dapatkan rule sesuai dengan work order--------------------------------------------------
		$sql = 'DELETE FROM pmwo_rule_probsolve';
		mysql_query($sql);
		$item4 = generate_all_rule($item3, $min_confidence);
		return $item4;
	//	echo $item4;
	
	//	$j = 0; 
	//	while($j<$item2['item'][0]){
		//	echo '<tr><td width=250>'.$item[$j][0].'</td><td>'.$item[$j][1].'</td></tr>';
		//	echo '<tr><td>'.$item2[$j][0].'</td><td>'.$item2[$j][1].'</td><td>'.$item2[$j][2].'</td></tr>';
		//	echo '<tr><td>'.$item3[$j][0].'</td><td>'.$item3[$j][1].'</td><td>'.$item3[$j][2].'</td><td>'.$item3[$j][3].'</td></tr>';
		//	$sql = 'INSERT INTO pmwo_rule_probsolve VALUES ("'.$j.'","'.$item3[$j][0].'","'.$item3[$j][1].'","'.$item3[$j][2].'")';
		//	mysql_query($sql);
	//		$j++;
	//	}
		
	}
?>