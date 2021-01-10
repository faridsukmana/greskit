<?php
//- Step 1. Daftarkan semua transaksi yang terdapat dalam market basket analysis
//--------- Mendapatkan kesleuruhan item dalam transaksi 
//--------- Masukkan transakasi dalam array agar eksekusi lebih cepat dalam proses checking pengelompokkan transaksi dalam item

function apro_association_rule(){
	$first = microtime(true);
	$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_ax_problem_solving';
	
	//Mendapatkan kesleuruhan item dalam transaksi 
	// Fungsi memiliki kesamaan dengan fungsi yang diterapkan dalam eclat association rule
	$items = get_item_eclat($sql);
	
	//- memasukkan semua transaksi dalam database ke dalam array 
	//- Fungsi terdapat di eclatrule.php karena memiliki fungsi yang sama untuk mendapatkan semua transaksi
	$tid_item = insert_transaction_array($sql);
	//$itemset_2nd = get_new_itemset($items,0.02,0.1,$tid_item,3);
	print_r ($items);
	$last = microtime(true);
	$total = $last-$first;
	echo '<br/> Total Excecution Time : '.$total;
}

function get_new_itemset($items,$min_sup,$min_conf,$trans,$loop){
	// itemset-1
	$i=0; $k=0; $n_loop=2; $itemset=array(); $sup=0; $con=0;
	while($i<sizeof($items)){
		$j =0; 
		while($j<sizeof($items)){
			if($i!=$j && $n_loop==2){
				$l=0; $count_items=0; $count_con=0;
				$sql = 'SELECT COUNT(problem) FROM pmwo_ax_problem_solving
					WHERE 
					(problem="'.$items[$i].'" AND root_cause_1="'.$items[$j].'") OR (problem="'.$items[$i].'" AND root_cause_2="'.$items[$j].'") OR 
					(problem="'.$items[$i].'" AND root_cause_2="'.$items[$j].'") OR (problem="'.$items[$i].'" AND root_cause_3="'.$items[$j].'") OR 
					(problem="'.$items[$j].'" AND root_cause_1="'.$items[$i].'") OR (problem="'.$items[$j].'" AND root_cause_2="'.$items[$i].'") OR 
					(problem="'.$items[$j].'" AND root_cause_2="'.$items[$i].'") OR (problem="'.$items[$j].'" AND root_cause_3="'.$items[$i].'") OR
					(root_cause_1="'.$items[$i].'" AND root_cause_2="'.$items[$j].'") OR (root_cause_1="'.$items[$i].'" AND root_cause_3="'.$items[$j].'") OR
					(root_cause_1="'.$items[$j].'" AND root_cause_2="'.$items[$i].'") OR (root_cause_1="'.$items[$j].'" AND root_cause_3="'.$items[$i].'") OR
					(root_cause_2="'.$items[$i].'" AND root_cause_3="'.$items[$j].'") OR (root_cause_2="'.$items[$j].'" AND root_cause_3="'.$items[$i].'")';
				$result = mysql_query($sql);
				$result_now = mysql_fetch_array($result);
				$count_items=$result_now[0]; //echo $items[$i].' <-> '.$items[$j].' <-> '.$count_items/sizeof($items).'<br/>'; //break;
				
				$sql = 'SELECT COUNT(problem) FROM pmwo_ax_problem_solving
					WHERE
					problem="'.$items[$i].'" OR root_cause_1="'.$items[$i].'" OR root_cause_2="'.$items[$i].'" OR root_cause_3="'.$items[$i].'"';
				$result = mysql_query($sql);
				$result_now = mysql_fetch_array($result);
				$count_con = $result_now[0]; //echo $items[$i].' <-> '.$count_con.'<br/>'; 
				/*while($l<sizeof($trans)){
					if(in_array($items[$i],$trans[$l]) && in_array($items[$j],$trans[$l])){
						$count_items++; //echo $l.' '.$items[$i].' - '.$items[$j].'<br/>'; //print_r(array_intersect($itemset[$k],$trans[$l]));
					}
					if(in_array($items[$i],$trans[$l])){
						$count_con++;
					}
					$l++;
				}*/
				$sup=$count_items/sizeof($trans); 
				$con=$count_items/$count_con;
				if($sup>$min_sup){
					$itemset[$k][$n_loop-2]=$items[$i];
					$itemset[$k][$n_loop-1]=$items[$j];
					//echo $k.' - '.$sup.' - '.$con.'<br/>';
					$k++;
				}
				
			} //if($j==6)break;
			$j++;
		}
		$i++;
	}
	
	// itemset-3
	$i=0; $itemset2=array(); $n_loop=3; $k=0;
	while($i<sizeof($items)){
		$j=0;
		while($j<sizeof($itemset)){
			if(!in_array($items[$i],$itemset[$j])){
				$count_items=0;$sup=0;
				$sql = 'SELECT COUNT(problem) FROM pmwo_ax_problem_solving
					WHERE 
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset[$j][0].'" AND root_cause_2="'.$itemset[$j][1].'") OR
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset[$j][1].'" AND root_cause_2="'.$itemset[$j][0].'") OR
					(problem="'.$itemset[$j][0].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset[$j][1].'") OR
					(problem="'.$itemset[$j][1].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset[$j][0].'") OR
					(problem="'.$itemset[$j][0].'" AND root_cause_1="'.$itemset[$j][1].'" AND root_cause_2="'.$items[$i].'") OR
					(problem="'.$itemset[$j][1].'" AND root_cause_1="'.$itemset[$j][0].'" AND root_cause_2="'.$items[$i].'") OR
					(root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset[$j][0].'" AND root_cause_3="'.$itemset[$j][1].'") OR
					(root_cause_1="'.$items[$i].'" AND root_cause_3="'.$itemset[$j][1].'" AND root_cause_3="'.$itemset[$j][0].'") OR
					(root_cause_1="'.$itemset[$j][0].'" AND root_cause_3="'.$items[$i].'" AND root_cause_3="'.$itemset[$j][1].'") OR
					(root_cause_1="'.$itemset[$j][1].'" AND root_cause_3="'.$items[$i].'" AND root_cause_3="'.$itemset[$j][0].'") OR
					(root_cause_1="'.$itemset[$j][0].'" AND root_cause_3="'.$itemset[$j][1].'" AND root_cause_3="'.$items[$i].'") OR
					(root_cause_1="'.$itemset[$j][1].'" AND root_cause_3="'.$itemset[$j][0].'" AND root_cause_3="'.$items[$i].'")';
				$result=mysql_query($sql);
				$result_now=mysql_fetch_array($result);
				$count_items=$result_now[0]; //echo  $items[$i].' <-> '.$itemset[$j][0].' <-> '.$itemset[$j][1].' <-> '.$count_items.'<br/>';
				$sup=$count_items/sizeof($trans);
				if($sup>$min_sup){
					$itemset2[$k][$n_loop-3]=$items[$i];
					$itemset2[$k][$n_loop-2]=$itemset[$j][0];
					$itemset2[$k][$n_loop-1]=$itemset[$j][1];
					$k++;
				}
			}//if($j==2)break;
			$j++;
		}
		$i++;
	}
	
	// itemset-4
	$i=0; $itemset3=array(); $n_loop=4; $k=0;
	while($i<sizeof($items)){
		$j=0;
		while($j<sizeof($itemset2)){
			if(!in_array($items[$i],$itemset2[$j])){
				$sql='SELECT COUNT(problem) FROM pmwo_ax_problem_solving
					WHERE
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset2[$j][0].'" AND root_cause_2="'.$itemset2[$j][1].'" AND root_cause_3="'.$itemset2[$j][2].'") OR
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset2[$j][0].'" AND root_cause_2="'.$itemset2[$j][2].'" AND root_cause_3="'.$itemset2[$j][1].'") OR
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset2[$j][1].'" AND root_cause_2="'.$itemset2[$j][0].'" AND root_cause_3="'.$itemset2[$j][2].'") OR
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset2[$j][1].'" AND root_cause_2="'.$itemset2[$j][2].'" AND root_cause_3="'.$itemset2[$j][0].'") OR
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset2[$j][2].'" AND root_cause_2="'.$itemset2[$j][0].'" AND root_cause_3="'.$itemset2[$j][1].'") OR
					(problem="'.$items[$i].'" AND root_cause_1="'.$itemset2[$j][2].'" AND root_cause_2="'.$itemset2[$j][1].'" AND root_cause_3="'.$itemset2[$j][0].'") OR
					(problem="'.$itemset2[$j][0].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset2[$j][1].'" AND root_cause_3="'.$itemset2[$j][2].'") OR
					(problem="'.$itemset2[$j][0].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset2[$j][2].'" AND root_cause_3="'.$itemset2[$j][1].'") OR
					(problem="'.$itemset2[$j][1].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset2[$j][0].'" AND root_cause_3="'.$itemset2[$j][2].'") OR
					(problem="'.$itemset2[$j][1].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset2[$j][2].'" AND root_cause_3="'.$itemset2[$j][0].'") OR
					(problem="'.$itemset2[$j][2].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset2[$j][1].'" AND root_cause_3="'.$itemset2[$j][0].'") OR
					(problem="'.$itemset2[$j][2].'" AND root_cause_1="'.$items[$i].'" AND root_cause_2="'.$itemset2[$j][0].'" AND root_cause_3="'.$itemset2[$j][1].'") OR
					(problem="'.$itemset2[$j][0].'" AND root_cause_1="'.$itemset2[$j][1].'" AND root_cause_2="'.$items[$i].'" AND root_cause_3="'.$itemset2[$j][2].'") OR
					(problem="'.$itemset2[$j][0].'" AND root_cause_1="'.$itemset2[$j][2].'" AND root_cause_2="'.$items[$i].'" AND root_cause_3="'.$itemset2[$j][1].'") OR
					(problem="'.$itemset2[$j][1].'" AND root_cause_1="'.$itemset2[$j][0].'" AND root_cause_2="'.$items[$i].'" AND root_cause_3="'.$itemset2[$j][2].'") OR
					(problem="'.$itemset2[$j][1].'" AND root_cause_1="'.$itemset2[$j][2].'" AND root_cause_2="'.$items[$i].'" AND root_cause_3="'.$itemset2[$j][0].'") OR
					(problem="'.$itemset2[$j][2].'" AND root_cause_1="'.$itemset2[$j][0].'" AND root_cause_2="'.$items[$i].'" AND root_cause_3="'.$itemset2[$j][1].'") OR
					(problem="'.$itemset2[$j][2].'" AND root_cause_1="'.$itemset2[$j][1].'" AND root_cause_2="'.$items[$i].'" AND root_cause_3="'.$itemset2[$j][0].'") OR
					(problem="'.$itemset2[$j][0].'" AND root_cause_1="'.$itemset2[$j][1].'" AND root_cause_2="'.$itemset2[$j][2].'" AND root_cause_3="'.$items[$i].'") OR
					(problem="'.$itemset2[$j][0].'" AND root_cause_1="'.$itemset2[$j][2].'" AND root_cause_2="'.$itemset2[$j][1].'" AND root_cause_3="'.$items[$i].'") OR
					(problem="'.$itemset2[$j][1].'" AND root_cause_1="'.$itemset2[$j][0].'" AND root_cause_2="'.$itemset2[$j][2].'" AND root_cause_3="'.$items[$i].'") OR
					(problem="'.$itemset2[$j][1].'" AND root_cause_1="'.$itemset2[$j][2].'" AND root_cause_2="'.$itemset2[$j][0].'" AND root_cause_3="'.$items[$i].'") OR
					(problem="'.$itemset2[$j][2].'" AND root_cause_1="'.$itemset2[$j][1].'" AND root_cause_2="'.$itemset2[$j][0].'" AND root_cause_3="'.$items[$i].'") OR
					(problem="'.$itemset2[$j][2].'" AND root_cause_1="'.$itemset2[$j][0].'" AND root_cause_2="'.$itemset2[$j][1].'" AND root_cause_3="'.$items[$i].'")';
				$result = mysql_query($sql);
				$result_now=mysql_fetch_array($result);
				$count_items=$result_now[0]; //echo  $items[$i].' <-> '.$itemset2[$j][0].' <-> '.$itemset2[$j][1].' <-> '.$itemset2[$j][2].' <-> '.$count_items.'<br/>';
				$sup=$count_items/sizeof($trans);
				if($sup>$min_sup){
					$itemset3[$k][$n_loop-4]=$items[$i];
					$itemset3[$k][$n_loop-3]=$itemset2[$j][0];
					$itemset3[$k][$n_loop-2]=$itemset2[$j][1];
					$itemset3[$k][$n_loop-1]=$itemset2[$j][2];
					$k++;
				}
			}
			$j++;
		}
		$i++;
	}
	//print_r($itemset3);
	
	echo '<table>';
	$i=0;
	while($i<sizeof($itemset3)){
		echo '<tr><td>'.$itemset3[$i][0].'</td><td>'.$itemset3[$i][1].'</td><td>'.$itemset3[$i][2].'</td><td>'.$itemset3[$i][3].'</td></tr>';
		$i++;
	}
	echo '</table>';
}

?>