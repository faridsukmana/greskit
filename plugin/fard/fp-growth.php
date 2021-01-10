<?php
	function fpgrowth_association_rule(){
		$first = microtime(true);
		//- mendapatkan item dari kumpulan data dalam transaksi (pmwo_ax_problem_solving)
		$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_ax_problem_solving';
		$items = get_item_fpg($sql);
		
		//- urutan counter item berdasarkan descending order
		arsort($items[1]); 
		$item_frequent=$items[1];
		//- mendapatkan nama dari key pada array
		$key_name = array_keys($item_frequent);
		
		//- Fungsi menghapus item yang memiliki nilai lebih kecil dari minimum frekuensi itemset
		$new_item_frequent = remove_item_fpg($item_frequent,$key_name,1);
		$new_key_name = array_keys($new_item_frequent);
		
		//- Fungsi mengambil keseluruhan transaksi dalam database dan memasukkan ke dalam array agar lebih cepat eksekusi
		//- sekaligus melakukan pengurutan terhadap transaksi berdasarkan item_frequent
		$trans = insert_transaction_fpg($sql,$new_item_frequent); 
		
		//- Fungsi memasukkan item dan count ke dalam array berdasarkan data transaksi -//
		$frequent_trans = set_pattern_count($trans);
		
		//- Melakukan proses FP-Growth meliputi conditional pattern base, conditional fp-tree, dan frequent pattern
		$total_trans = sizeof($trans); $min_sup=0.02;
		process_fp_tree($new_key_name,$frequent_trans,$min_sup,$total_trans);
		
		$last = microtime(true);
		$total = $last-$first;
		echo '<br/> Total Excecution Time : '.$total;
		//print_r($frequent_trans[0]);
		//return $content;
	}
	
	//- Step 1. Fungsi mendapatkan item
	function get_item_fpg($sql){
		$items = array(); $counter = array();
		$result = mysql_query($sql);
		while($result_now=mysql_fetch_array($result)){
			//if(!in_array($result_now[2],$items) && $result_now[2]!='-'){array_push($items,$result_now[2]);}
			if(!in_array($result_now[0],$items)){array_push($items,$result_now[0]); $counter[$result_now[0]]=1;}else{$counter[$result_now[0]]++;}
			if(!in_array($result_now[1],$items)){array_push($items,$result_now[1]); $counter[$result_now[1]]=1;}else{$counter[$result_now[1]]++;}
			if(!in_array($result_now[2],$items)){array_push($items,$result_now[2]); $counter[$result_now[2]]=1;}else{$counter[$result_now[2]]++;}
			if(!in_array($result_now[3],$items)){array_push($items,$result_now[3]); $counter[$result_now[3]]=1;}else{$counter[$result_now[3]]++;}
		}
		return array($items,$counter);
	}
	
	//- Step 1. Hapus item yang memiliki nilai lebih kecil dari minimum frequent itemset
	function remove_item_fpg($item_frequent,$key_name,$min_freqitem){
		$i=0; 
		while($i<sizeof($item_frequent)){ 
			if($item_frequent[$key_name[$i]]>$min_freqitem){
				$new_item_frequent[$key_name[$i]]=$item_frequent[$key_name[$i]];
			} 
			$i++;
		}
		return $new_item_frequent;
	}
	
	//- Step 1. Masukkan transakasi dalam array agar eksekusi lebih cepat dalam proses checking pengelompokkan transaksi dalam item
	//- dan melakukan pengurutan berdasarkan item frequent serta menghapus item dalam transaksi yang tidak memenuhi frequent item
	function insert_transaction_fpg($sql,$new_item_frequent){
		$tid = array(); $inc_tid=0;
		$result = mysql_query($sql);
		while($result_now=mysql_fetch_array($result)){
			$trans = array();
			$trans[$result_now[0]] = $new_item_frequent[$result_now[0]];
			$trans[$result_now[1]] = $new_item_frequent[$result_now[1]];
			$trans[$result_now[2]] = $new_item_frequent[$result_now[2]];
			$trans[$result_now[3]] = $new_item_frequent[$result_now[3]]; 
			arsort($trans);
			$new_trans = (array_intersect($trans,$new_item_frequent));
			$tid[$inc_tid] = array_keys($new_trans);
			$inc_tid++; 
		}
		
		return $tid;
	}
	
	//- Step 2. Insert semua transaksi ke dalam array pattern dan jumlah transaksi ke dalam array count 
	function set_pattern_count($trans){
		$inc_pattern=0; $inc_count=0;$i=0;$k=0;$pattern=array();$count=array();$insert=true; 
		while($i<sizeof($trans)){
			$insert=true;
			if(sizeof($pattern)==0){
				$pattern[$k]=$trans[$i]; 
				$count[$k]=1;
				$k++;
			}else{
				$j=0;
				while($j<sizeof($pattern)){ 
					if ($trans[$i]===$pattern[$j]){
						$count[$j]++;$insert=false;
						break;
					}
					$j++;
				}
				if($insert){
						$pattern[$k]=$trans[$i];
						$count[$k]=1;
						$k++;
				}
			}
			$i++;
		}
		return array($pattern,$count);
	}
	
	//- Step 3. Melakukan tahap pembentukan rule menggunakan fp-growth
	function process_fp_tree($new_key_name,$frequent_trans,$min_sup,$total_trans){ 
		$i = sizeof($new_key_name)-1; echo '<table>';$j=0; $data_temp=array();$count_temp=array();
		while($i>=0){
			//if($i==150){
			$pat_base=get_conditional_pattern_base($new_key_name[$i], $frequent_trans); //break;
			$freq_pat[$new_key_name[$i]]=$pat_base[0];
			$freq_count[$new_key_name[$i]]=$pat_base[1];
			$data_temp=$pat_base[0]; 
			$count_temp=$pat_base[1];
			$k=0;
			while($k<sizeof($count_temp)){
				$data[$j][0]=$data_temp[$k][0];$data[$j][1]=$data_temp[$k][1];$data[$j][2]=$data_temp[$k][2];$data[$j][3]=$data_temp[$k][3];
				$count[$j]=$count_temp[$k];
				$j++;
				$k++;
			}
			//show_pattern_min_sup($pat_base[0],$pat_base[1],$min_sup,$total_trans);
			//print_r($freq_pat[$new_key_name[$i]]);
			//}
			$i--;
		}
		show_pattern_min_sup($data,$count,$min_sup,$total_trans);
		echo '</table>';
	}
	
	//- Step 4. Mendapatkan conditional pattern base yang berasal dari item dengan 
	//- Pattern base | Count
	function get_conditional_pattern_base($key_name, $frequent_trans){
		$i=0; $j=0; $trans = $frequent_trans[0]; $count= $frequent_trans[1];
		while($i<sizeof($trans)){
			if(in_array($key_name,$trans[$i])){ 
				$new_trans[$j] = array_diff($trans[$i],array($key_name)); 
				$new_count[$j] = $count[$i];
				//echo $new_count[$j].' - '.$key_name.' - '.$new_trans[$j].'<br/>';
				$j++;
			}
			$i++;
		}
		$pat_base=get_conditional_fp_tree($key_name,$new_trans,$new_count);
		//print_r($new_trans);print_r($new_count);
		return $pat_base;
	}
	
	//- Step 5. Mendapatkan conditional FP-Tree dari hasil conditional pattern base/
	function get_conditional_fp_tree($key_name,$trans,$count){
		if(sizeof($trans)==1){
			$new_con = array();
			$new_con = $trans[0];
			$new_count = $count[0];
			//echo $new_count.' - '.$key_name.' - '.$new_trans[0].'<br/>';
		}else{
			$i=1; $new_con = array(); $new_count=0;
			while($i<sizeof($trans)){
				if($i==1){
					$new_con = array_intersect($trans[$i-1],$trans[$i]);
					$new_count = $count[$i-1]+$count[$i];
				}else{
					$new_con = array_intersect($new_con,$trans[$i]);
					$new_count = $new_count+$count[$i];
				}
				$i++;
			}
			if(sizeof($new_con)>0){
				$new_count=$new_count;
			}else{
				$new_count=0;
			}
			//echo $new_count.' - '.$key_name.' - '.$new_con[1].'<br/>';
		}
		$pat_base=get_frequent_pattern($key_name,$new_con,$new_count);
		//print_r($new_con);print_r($new_count);
		return $pat_base;
	}
	
	//- Step 6. Membentuk Frequent pattern hasil dari conditional pattern base -//
	//- Pattern|key_name
	function get_frequent_pattern($key_name,$trans,$count){ 
		$new_key = array($key_name); 
		if(sizeof($trans)==1){
			$new_pat[0]=array(); 
			$new_pat[0]=array_merge($trans,$new_key);$new_pat[0][1]=$key_name;
			$new_count[0]=$count;
			//echo $new_count[0].' > '.$key_name.' > '.$new_pat[0][0].' > '.$new_pat[0][1].'<br/>';
			$pat_base=array($new_pat,$new_count);
		}else if(sizeof($trans)>1){
			$pat_base=get_combination_array($key_name,$trans,$count);
		}
		//print_r($new_pat);print_r($new_count);
		return $pat_base;
	}
	
	//- Step 6. Mebentuk kombinasi array untuk membentuk frequent pattern -//
	function get_combination_array($key_name,$trans,$count){ 
		//--reindex key values and remove empty values
		$arr=array_values(array_filter($trans)); //print_r($arr);
		if(sizeof($arr)==3){ 
			$i=0;$k=0;$h=0;$new_pat[]=array();
			while($i<sizeof($arr)){
				$new_count[$h]=$count;$new_pat[$h][0]=$arr[$i];$new_pat[$h][1]=$key_name;
				//echo $new_count[$h].' > '.$key_name.' > '.$new_pat[$h][0].' > '.$new_pat[$h][1].'<br/>';
				$h++;
				$j=$i+1;
				while($j<sizeof($arr)){
					if($j!=$i){
					$new_count[$h]=$count;
					$new_pat[$h][0]=$arr[$i];
					$new_pat[$h][1]=$arr[$j];
					$new_pat[$h][2]=$key_name;
					//echo $new_count[$h].' > '.$key_name.' > '.$new_pat[$h][0].' > '.$new_pat[$h][1].' > '.$new_pat[$h][2].'<br/>';
					$h++;
					}
						
					while($k<sizeof($arr)){
						if($k!=$i && $k!=$j && $j!=$i){
						$new_count[$h]=$count;
						$new_pat[$h][0]=$arr[$i];
						$new_pat[$h][1]=$arr[$j];
						$new_pat[$h][2]=$arr[$k];
						$new_pat[$h][3]=$key_name;
						//echo $new_count[$h].' > '.$key_name.' > '.$new_pat[$h][0].' > '.$new_pat[$h][1].' > '.$new_pat[$h][2].' > '.$new_pat[$h][3].'<br/>';
						$h++;
						}
						$k++;
					}
						
					$j++;
				}
				$i++;
			}
		}else{
			$i=0;$k=0;$h=0;$new_pat[]=array();
			while($i<sizeof($arr)){
				$new_count[$h]=$count;$new_pat[$h][0]=$arr[$i];
				//echo $new_count[$h].' > '.$key_name.' > '.$new_pat[$h][0].' > '.$new_pat[$h][1].'<br/>';
				$h++;
				$j=$i+1;
				while($j<sizeof($arr)){
					if($j!=$i){
					$new_count[$h]=$count;
					$new_pat[$h][0]=$arr[$i];
					$new_pat[$h][1]=$arr[$j];
					$new_pat[$h][2]=$key_name;
					//echo $new_count[$h].' > '.$key_name.' > '.$new_pat[$h][0].' > '.$new_pat[$h][1].' > '.$new_pat[$h][2].'<br/>';
					$h++;
					}	
					$j++;
				}
				$i++;
			}
		}
		//print_r($new_pat);
		return array($new_pat,$new_count);
	}
	
	//- Step 6. Get Pattern yang memiliki nilai support lebih besar dari minimum support
	function show_pattern_min_sup($data,$count,$min_sup,$total_trans){
		$i=0; //print_r($data);
		/*while($i<sizeof($data)){
			$sup=$count[$i]/$total_trans;
			if($sup>$min_sup)
				echo '<tr><td>'.round($sup,4).'</td><td>'.$data[$i][0].'</td><td>'.$data[$i][1].'</td><td>'.$data[$i][2].'</td><td>'.$data[$i][3].'</td></tr>';
			$i++;
		}*/
		$data_temp=array();$count_temp=array();$j=0;//print_r($count);
		while($i<sizeof($data)){ 
			if(sizeof($count_temp)==0){
				$data_temp[$j][0]=$data[$i][0];
				$data_temp[$j][1]=$data[$i][1];
				$data_temp[$j][2]=$data[$i][2];
				$data_temp[$j][3]=$data[$i][3];
				$count_temp[$j]=$count[$i];
				$j++;
			}else{
				$k=0; 
				while($k<sizeof($count_temp)){
					if($data_temp[$k][0]==$data[$i][0] && $data_temp[$k][1]==$data[$i][1] && $data_temp[$k][2]==$data[$i][2] && $data_temp[$k][3]==$data[$i][3]){ 
						$count_temp[$k]+=$count[$i];
						break;
					}
					$k++;
				}
				if($k==sizeof($count_temp)){
					$data_temp[$j][0]=$data[$i][0];
					$data_temp[$j][1]=$data[$i][1];
					$data_temp[$j][2]=$data[$i][2];
					$data_temp[$j][3]=$data[$i][3];
					$count_temp[$j]=$count[$i];
					$j++;
				}
			}
			$i++;
		}
		
		$i=0;
		while($i<sizeof($data_temp)){
			$sup=$count_temp[$i]/$total_trans;
			if($sup>$min_sup)
				echo '<tr><td>'.round($sup,4).'</td><td>'.$data_temp[$i][0].'</td><td>'.$data_temp[$i][1].'</td><td>'.$data_temp[$i][2].'</td><td>'.$data_temp[$i][3].'</td></tr>';
			$i++;
		}
	}
?>