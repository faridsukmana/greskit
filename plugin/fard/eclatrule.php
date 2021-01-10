<?php
//- Step 1. Lakukan pengelompokan item berdasarkan (item | TID_set) berdasarkan tipe Vertical Data Format --> function get_item($sql)
//---- A merupaka sekumpulan item yang berasal dari keseluruhan transaksi dalam Market Basket Analysis
//---- T merupakan kumpulan dari TID set yang didapatkan dari transaksi yang mengandung item A
//---- Memasukkan semua transaksi pada database ke dalam array agara lebih cepat dalam proses 
//---- Medapatkan format data vertikal (Item | TID_set)
//- Step 2. Menentukan nilai support masing-masing (Item | TID) dang mengeliminasi berdasarkan nilai minimum support 
//---- Melakukan irisan terhadap tiap (Item | TID) tahap pertama berdasarkan minimum support
//---- Daftarkan keseluruhan item ke dalam list_item_result untuk mendapatkan himpunan item yang memenuhi frekuensi itemset

function eclat_association_rule(){
	$first = microtime(true);
	$list_item_result=array();
	//- mendapatkan item dari kumpulan data dalam transaksi (pmwo_ax_problem_solving)
	$sql = 'SELECT problem, root_cause_1, root_cause_2, root_cause_3 FROM pmwo_ax_problem_solving';
	$items = get_item_eclat($sql);
	
	//- memasukkan semua transaksi dalam database ke dalam array
	$tid = insert_transaction_array($sql);
	$item_tid = get_item_tid($items,$tid);
	
	//- Menentukan nilai support masing-masing (Item | TID) dang mengeliminasi berdasarkan nilai minimum support 
	$c_1 = get_candidat_1step($item_tid,$items,0.02);
	
	//- Mencari irisan antara (Item | TID) tahap pertama dan mengeliminasi yang tidak memenuhi minimum support
	$list_item_result = get_1_frekuensi_itemset($items);
	$c_2 = get_candidat_2step($c_1,$items,0.02,$list_item_result,1);
	
	/*echo '<br><br/>';
	print_r($c_1); 
	echo '<br><br/>';
	print_r($item_tid); 
	echo '<br><br/>';
	print_r($tid);*/
	$last = microtime(true);
	$total = $last-$first;
	echo '<br/> Total Excecution Time : '.$total;
	
	return $content;
}
//- Step 1. Fungsi mendapatkan item
function get_item_eclat($sql){
	$items = array();
	$result = mysql_query($sql);
	while($result_now=mysql_fetch_array($result)){
		//if(!in_array($result_now[2],$items) && $result_now[2]!='-'){array_push($items,$result_now[2]);}
		if(!in_array($result_now[0],$items)){array_push($items,$result_now[0]);}
		if(!in_array($result_now[1],$items)){array_push($items,$result_now[1]);}
		if(!in_array($result_now[2],$items)){array_push($items,$result_now[2]);}
		if(!in_array($result_now[3],$items)){array_push($items,$result_now[3]);}
	}
	return $items;
}

//- Step 1. Masukkan transakasi dalam array agar eksekusi lebih cepat dalam proses checking pengelompokkan transaksi dalam item
function insert_transaction_array($sql){
	$tid = array(); $inc_tid=0;
	$result = mysql_query($sql);
	while($result_now=mysql_fetch_array($result)){
		$tid[$inc_tid][0]=$result_now[0]; $tid[$inc_tid][1]=$result_now[1]; $tid[$inc_tid][2]=$result_now[2]; $tid[$inc_tid][3]=$result_now[3];
		$inc_tid++;
	}
	return $tid;
}

//- Step 1. Medapatkan format data vertikal (Item | TID_set)
function get_item_tid($items,$tid){
	$inc_item=0; $item_tid=array();
	while($inc_item<sizeof($items)){
		$inc_tid=0;
		while($inc_tid<sizeof($tid)){
			if(in_array($items[$inc_item],$tid[$inc_tid])){
				$item_tid[$inc_item][$inc_tid]=$inc_tid; 
			}
			$inc_tid++; 
		}
		$inc_item++;
	}
	return $item_tid;
}

//- Step 2. Menentukan nilai support masing-masing (Item | TID) dang mengeliminasi berdasarkan nilai minimum support 
function get_candidat_1step($item_tid,$items,$min_sup){
	$i=0; $k=0;
	while($i<sizeof($item_tid)){
		$sup = sizeof($item_tid[$i])/sizeof($items);
		if($sup>$min_sup){
			$c_I[$i] = $item_tid[$i]; //echo $i.' : '.$sup.'<br/>';
		}
		$i++;
	}
	return $c_I;
}

//- Step 2. Melakukan irisan terhadap tiap (Item | TID) tahap pertama berdasarkan minimum support
function get_candidat_2step($item_tid,$items,$min_sup,$list_item_result,$loop){
	$i=0; $k=0; 
	while($i<sizeof($item_tid)){
		$j=$i+1;
		while($j<sizeof($item_tid)){
			if($item_tid[$i]!=null && $item_tid[$j]!=null && array_intersect($item_tid[$i],$item_tid[$j])!=null){
				$sup = sizeof(array_intersect($item_tid[$i],$item_tid[$j]))/sizeof($items);
				if($sup>$min_sup && $loop==1){
					$l=0;
					while($l<$loop){
						$list_item_result_II[$k][$l] = $list_item_result[$i][$l];
						$l++;
					}
					$list_item_result_II[$k][$loop]=$items[$j];
					$c_II[$k] = array_intersect($item_tid[$i],$item_tid[$j]);  //if($loop==2)echo $i.' '.$j.' '.$sup.'<br/>';
					$k++;
				}else if($sup>$min_sup && $loop>1){ //print_r($list_item_result); 
					if(array_intersect($list_item_result[$i],$list_item_result[$j])!=null){
						$list_item_result_II[$k]=array_unique(array_merge($list_item_result[$i],$list_item_result[$j]));
						$c_II[$k] = array_intersect($item_tid[$i],$item_tid[$j]);  //if($loop==2)echo $i.' '.$j.' '.$sup.'<br/>';
						$k++;
					}
				}
			}
			$j++;
		}
		$i++;
	}
	
	$loop++;
	if($loop<4){
		//print_r($list_item_result_II);
		get_candidat_2step($c_II,$items,$min_sup,$list_item_result_II,$loop);
	}else{
		$i=0;$k=0;$item_rule=array();
		$table = Sizeof($list_item_result_II).'<br/><table>';
		
		while($i<Sizeof($list_item_result_II)){
			if(!in_array($list_item_result_II[$i],$item_rule)){
				$item_rule[$k]=$list_item_result_II[$i];
				$table .= '<tr><td>'.$i.'</td><td>'.$item_rule[$k][0].'</td><td>'.$item_rule[$k][1].'</td><td>'.$item_rule[$k][2].'</td><td>'.$item_rule[$k][3].'</td></tr>';
				$k++;
			}
			$i++;
		}
		$table .= '</table>';
		/*$table .= '<table>';
		while($i<Sizeof($list_item_result_II)){
			$table .= '<tr><td>'.$i.'</td><td>'.$list_item_result_II[$i][0].'</td><td>'.$list_item_result_II[$i][1].'</td><td>'.$list_item_result_II[$i][2].'</td><td>'.$list_item_result_II[$i][3].'</td></tr>';
			$i++;
		}
		$table .= '</table>';*/
		echo $table;
		//print_r($list_item_result_II);
		return $c_II;
	}
}

//- Step 2. Daftarkan keseluruhan item ke dalam list_item_result untuk mendapatkan himpunan item yang memenuhi frekuensi itemset
function get_1_frekuensi_itemset($items){
	$i=0;
	while($i<sizeof($items)){
		$frekuensi_items[$i][0]=$items[$i];
		$i++;
	}
	return $frekuensi_items;
}
?>