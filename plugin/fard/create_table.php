<?php
	//==================================================function page request (query) only to show table =========================================================//
	//#######################pada function di halaman ini berisi fungsi yang digunakan untuk mendukung searching dengan bentuk tabel##############################//
	//==============================#################################manage your table in bottom here####################=========================================// 
	
	//-----------------------------------------------function choose_table--------------------------------------------------------------------------------------//
	//----------------make radio button  0 for query 1 for array-----------------------------------//
	// 1. berfungsi untuk mengenerate pembuatan radio button secara otomatis 
	// 2. parameter berisikan alamat halaman, isi berupa array atau query, data berisi array atau query, ???????  
	// 3. parameter $choose digunakan untuk memilih isi data dari radio button apakah didapatkan dari database (1) ataukah diperoleh dari array (2)
	function radio_button($page,$sentences, $choose, $sumgroup){
		$radio = '';
		if($choose==0){
		
		}else if($choose==1){
			$i = 0;
			while($i<sizeof($sentences)-$sumgroup){
				$radio .= '<input type="radio" name="'.$sentences[sizeof($sentences)-1].'" value="'.$sentences[$i].'">'.$sentences[$i];
				$i++;
			}
		}
		$radio .= '<br/><input type="submit" name="submit" value="Choose" class="submit">';
		$content = '<div align="center"><form action='.$page.' method="POST">'.$radio.'</form></div>';
		return $content;
	}
	//---------------------------------------------------------------------//
	
	//--------------Generator Automatic Checkbox---------------------------//
	// 1. function yang berfungsi untuk mengenerate cekbox secara otomatis dengan value/nilai adalah field dari database yang sudah ditentukan oleh pembuat
	// 2. function ini hanya sebatas untuk mengenerate kolom dari field database berdasarkan kategori Misal Kolom Monitor Memiliki tabel berisikan type dan nomor
	// 3. parameter $array berisikan parameter berupa nomor field dalam database sesuai yang digunakan dalam function query() dan $titlearray berfungsi untuk memberi judul cekbox
	// 4. Setelah function ini digunakan maka selanjutnya adalah menggunakan function sum_table_self() untuk menggabungkan kolom / field database yang terpilih berdasarkan kategori
	function choose_table_self($page,$array,$titlearray){
		$i = 0; $content = '';
		while($i<sizeof($array)){
			$button_check .= '<td><input type="checkbox" name="cekbox'.$titlearray[$i].'" value="'.$array[$i].'" />'.$titlearray[$i].'</td>';
			if(($i%6 ==0 and $i> 0) or ($i==mysql_num_rows($result)-1)){
				$content .= '<tr>'.$button_check.'</tr>';	
				$button_check = '';
			}
			$i++;	
		}
		
		$submit .= '<input type="submit" name="submit" value="Choose" class="submit">';
			
		if(sizeof($sentences)>0){
			$content = '<div align="center"><form method="POST" action="'.$page.POST.'&monthval=true"><table class="mytable">'.$content.'</table>'.$submit.'</form></div>';
		}
		
		return $content;
	}
	//---------------------------------------------------------------------//
	
	//------------Concate value of automatic checkbox----------------------//
	// 1. function ini berfungsi untuk menggabungkan nilai yang diperoleh dari function choose_table_self dan nantinya akan digunakan pada function query() dan sum_table()
	function concate_get_table_self($titlearray){
		$i = 0; $content = '';
		while ($i<sizeof($titlearray)){
			$content .= $_REQUEST["cekbox".$titlearray[$i]];
			$i++;
		}	
		return $content;
	}
	//---------------------------------------------------------------------//
	
	//--------------by field name------------------------------------------//
	// 1. berfungsi untuk mengambil nama field dalam database dan menerapkan dalam tabel halam web untuk memilih table mana yang akan ditampilkan
	// 2. parameter berisikan alamat halaman ($page) dan query ($query) dari field yang akan ditampilkan dalam halam web
	function choose_table($page,$query){
		$result = mysql_query($query) or die('failed');
		$button_check = '';
		//----------Get name coloum query from name field table-----------//
		$i = 0;
		while($i<mysql_num_fields($result)){
			$button_check .= '<td><input type="checkbox" name="cekbox'.$i.'" value="'.$i.'" />'.str_replace('_',' ',mysql_field_name($result,$i)).'</td>';
			if(($i%8 ==0 and $i> 0) or ($i==mysql_num_fields($result)-1)){
				$content .= '<tr>'.$button_check.'</tr>';	
				$button_check = '';
			}
			$i++;
		}
		//----------------------------------------------------------------//
		$submit .= '<input type="submit" name="submit" value="Choose" class="submit">';
		$content = '<div align="center"><form method="POST" action="'.$page.POST.'"><table class="mytable">'.$content.'</table>'.$submit.'</form></div>';
		return $content;
	}
	
	//------------by row name---------------------------------------------//
	// 1. berfungsi mengambil nama row dalam database dan menerapkan dalam tabel pada halaman web untuk dipilih dan ditampilkan dalam bentuk radio button
	// 2. parameter yang digunakan yaitu alamat halaman, query atau array, $field hanya digunakan untuk $sentences yang query untuk mengambil nomor field, proses yang dijalankan query atau array
	// 3. parameter $choose digunakan untuk memilih isi data dari radio button apakah didapatkan dari database (1) ataukah diperoleh dari array (2)
	function choose_table_row($page,$sentences,$field,$choose){
		//----------------jika $sentences adalah query-------------------------------
		if($choose==0){
			$result = mysql_query($sentences) or die('failed');
			$button_check = '';
			//----------Get name row query from name field table-----------//
			$i = 0;
			while($result_now=mysql_fetch_array($result)){
				$button_check .= '<td><input type="checkbox" name="cekbox'.$result_now[0].'" value="'.$result_now[0].'" />'.$result_now[$field].'</td>';
				if(($i%6 ==0 and $i> 0) or ($i==mysql_num_rows($result)-1)){
					$content .= '<tr>'.$button_check.'</tr>';	
					$button_check = '';
				}
				$i++;
			}
			//----------------------------------------------------------------//
			$submit .= '<input type="submit" name="submit" value="Choose" class="submit">';
			
			if(mysql_num_rows($result)>0)
				$content = '<br/><div align="center"><form method="POST" action="'.$page.POST.'&monthval=true"><table class="mytable">'.$content.'</table>'.$submit.'</form></div>';
		}
		
		//----------------jika $sentences adalah array-------------------------------
		else if($choose==1){
			$i = 0;
			while($i<sizeof($sentences)){
				$button_check .= '<td><input type="checkbox" name="cekbox'.$sentences[$i].'" value="'.$sentences[$i].'" />'.$sentences[$i].'</td>';
				if(($i%6 ==0 and $i> 0) or ($i==sizeof($sentences)-1)){
					$content .= '<tr>'.$button_check.'</tr>';	
					$button_check = '';
				}
				$i++;
			}
			$submit .= '<input type="submit" name="submit" value="Choose" class="submit">';
			
			if(sizeof($sentences)>0)
				$content = '<div align="center"><form method="POST" action="'.$page.POST.'&monthval=true"><table class="mytable">'.$content.'</table>'.$submit.'</form></div>';
			}
		return $content;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------//
	
	//----------------------------------------function to take field by checkbox and return value as string-----------------------------------------------------//
	// 1. berfungsi mengambil nilai dari tabel yang ditandai dengan cek pada radio button, dan fungsi ini hanya untuk fungsi yang diseleksi query adalah field bukan row
	// 2. Nilai yang dikembalikan adalah berupa angka contoh 0123,11.,12.
	// 3. cekbok".$i adalah nama dari radio button yang terpilih, dan kemudian diambil nilainya
	function get_choose_table($query){
		$result = mysql_query($query) or die('failed');
		$button_check = '';
		//----------Get name coloum query from name field table-----------//
		$i = 0;
		$val = '';
		while($i<mysql_num_fields($result)){
			if($i>10 and isset($_REQUEST["cekbox".$i]))
				$content .= ','.$_REQUEST["cekbox".$i].'.';
			else if($i<10 and isset($_REQUEST["cekbox".$i]))
				$content .= $_REQUEST["cekbox".$i];
			
			$i++;
		}
		return $content;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------//
		
	// 1. befungsi mengambil nilai dari tabek yang ditandai dengan radio button dan funsgi ini hanya untuk fungsi yang diseleksi query adalah row
	// 2. Nilai yang dikembalikan adalah angka contoh 0123,11.,12.
	// 3. cekbok".$i adalah nama dari radio button yang terpilih dan kemudian diambil nilainya
	// 4. $choose untuk nilai 0 merupakan pilihan parameter berupa query sedangkan 1 adalah array
	function get_choose_row($query,$choose){
		$content = '';
		if($choose==0){
			$result = mysql_query($query) or die('failed');
			$button_check = '';
			//----------Get name row query from name table------------------//
			$i = 0;
			$val = '';
			while($result_now=mysql_fetch_array($result)){
				$val = $result_now[0];
				if($val>=10 and isset($_REQUEST["cekbox".$val]))
					$content .= ','.$_REQUEST["cekbox".$val].'.';
				else if($val<10 and isset($_REQUEST["cekbox".$val]))
					$content .= $_REQUEST["cekbox".$val];
				
				$i++;
			}
		}else if($choose==1){
			$arrcekbox = array();
			$i = 0; $j = 0;
			while($i<sizeof($query)){
				if($_REQUEST["cekbox".$query[$i]]!=''){
					$arrcekbox[$j] = $_REQUEST['cekbox'.$query[$i]]; 
					$j++;
				}
				//	$content .= $i.' '.$_REQUEST['cekbox'.$query[$i]].', '; 
				$i++;
			}
			$content = $arrcekbox;
		}
		return $content;
	}
	
	//-----------------------------------------------function sum table, coloumn u want to show-----------------------------------------------------------------//
	// 1. berfungsi untuk memecahkah field yang dipilih pada tabel database sesuai dengan angka 0123,11.,12. sehing akan ditampung dalam array 0 1 2 3 11 12
	// 2. function ini berfungsi untuk memanggil field atau arrow yang digunakan sebagai judul kolom dari tabel sebuah website
	function sum_table($coloumn){
		//----------Get sum of coloum in query ---------------------------//
		$sum_tb = 0;
		for($i=0; $i<strlen($coloumn); $i++){
			if(strcmp($coloumn[$i],',')==0){
				$i++;
				$char = $coloumn[$i];
				$i++;
				while(strcmp($coloumn[$i],'.')!=0){
					$char .= $coloumn[$i];
					$i++;
				}
				$table[$sum_tb] = (int)$char; 
				$sum_tb++;
			}else{
				$table[$sum_tb] = (int)$coloumn[$i];
				$sum_tb++;
			}
		}
		//----------------------------------------------------------------//
		
		return $table;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------//
	
	//---------------------------------------------fungsi melakukan pengecekan apakan ini termasuk format tanggal atau bukan -----------------------------------//
	function date_or_not($input){
		$date = explode('-',$input); 
		$tahun = 0; $tanggal = 0; $bulan = 0;
		$tahun = strlen($date[0]);
		$tanggal = strlen($date[2]);
		$bulan = strlen($date[1]);
		if($tahun==4 && $tanggal==2 && $bulan==2)
			return true;
		else
			return false;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------//
	
	//---------------------------------------------function you want show table page, query , coloumn u want, detail, delete, edit------------------------------//
	// 1. parameter yang ingin ditampilkan dalam tabel sebuah halaman website pada function query yaitu judul halaman, query, kolom yang dipilih, detail, delete, edit, kolom tambahan, untuk tambahan judul berupa merger, manual link, link.
	// 2. untuk parameter $det , $del dan $ed nilai 1 berarti tidak digunakan. 
	// 3. untuk $titlearray, setiap kolom dalam tabel database harus memiliki 1 perwakilan untuk titlearray
	function query($page, $query, $coloumn, $det, $del, $ed, $manual, $titlearray, $manual_link, $link){
		$content = ''; $total_1 = 0; $total_2 = 0; $total_3 = 0; $total_4 = 0;
		$table = sum_table($coloumn);
		$alink = sum_table($link);
		
		$result = mysql_query($query) or die('failed');
		
		//----------Add title table with use merger table-----------------//
		/*	$merge = '';
			if($merger==0){
				$merge = '<tr>'; $i=0;
				while($i<sizeof($titlearray)){
					$coloum_total = sizeof(sum_table($array[$i]));	
					if($coloum_total>1){
						$merge .= '<th colspan="'.$coloum_total.'">'.$titlearray[$i].'</th>';
					}else{
						$merge .= '<th></th>';
					}
					$i++;
				}
				$merge .= '</tr>';
		}
		*/
		//----------------------------------------------------------------//
		
		//----------Get name coloum query from name field table-----------//
		$head = '<thead>';
		
			//$head .= $merge;
		$i = 0;
		
		//--------For automatic number head-------
		if(strcmp($manual,'PURCHASING')==0)
			$head .= '<tr><th rowspan=2>LIST RF NUMBER</th><th rowspan=2>EDIT DATA</th><th rowspan=2>NO</th>';
		else if(strcmp($manual,'BUDGETCHAR')==0)
			$head .= '<tr><th rowspan=3>NO</th>';
		else
			$head .= '<tr><th>NO</th>';
			
		while($i<sizeof($table)){
			
			if(strcmp($manual,'PODETAIL')==0 && $i==3){
			    $title_tab = mysql_field_name($result,$table[$i]);
			}else if(strcmp($manual,'NDETPRO')==0 && ($i==2 || $i==3 || $i==4 ||$i==6 ||$i==7 ||$i==8 ||$i==9)){
				$title_tab = mysql_field_name($result,$table[$i]).'__________';
			}else if(strcmp($manual,'BUDGETCHAR')==0){
				$head .= '
						<th rowspan="3" >GROUP OF EXPENSE</th>
						<th rowspan="3">GROUP CODE</th>
						<th rowspan="3">GROUP NAME</th>
						<th rowspan="3">LEDGER ACCOUNT</th>
						<th rowspan="3">ACCOUNT NAME</th>
						<th rowspan="3">COST CENTER</th>
						<th colspan="4">'.$_SESSION['mper'].' 2015</th>
						<th rowspan="3">REASON_OVER_BUDGET VS ACTUAL</th>
					</tr>
					<tr>
						<th rowspan="2">ACTUAL</th>
						<th rowspan="2">PLAN</th>
						<th colspan="2">ACTUAL VS PLAN (VARIANCE)</th>
					</tr>
					<tr>
						<th>AMOUNT</th>
						<th>PERCENT</th>
				';
				break;
			}else if(strcmp($manual,'PURCHASING')==0){
			    $head .= '
						
						<th colspan=6><b>PLAN PO DATA<b></th>
						<th colspan=9><b>PO HEADER DATA<b></th>
						<th colspan=5><b>PO LINE DATA<b></th>
						<th colspan=2><b>VENDOR DATA<b></th>
						<th colspan=3><b>RECEIVING DATA<b></th>
						<th colspan=4><b>INVOICE DATA<b></th>
						<th colspan=5><b>FAKTUR PAJAK DATA<b></th>
						<th colspan=4><b>I/R DATA<b></th>
						<th colspan=4><b>OTHERS<b></th>
					</tr>	
					<tr>
						<th>PR NO</th>
						<th>PR CREATEDBY</th>
						<th>PR CREATEDDATE</th>
						<th>PR APPROVEDDATE</th>
						<th>PR FIRMEDDATE</th>
						<th>PR FIRMEDBY</th>
						
						<th>PO NO</th>
						<th>PO DATE</th>
						<th>STATUS</th>
						<th>CURRENCY</th>
						<th>LINE AMOUNT</th>
						<th>TOTALAMOUNT</th>
						<th>SUMTAX</th>
						<th>SUMMARKUP</th>
						<th>NETAMOUNT</th>
						
						<th>ITEMID</th>
						<th>ITEM_TEXT_(DESCRIPTION_OF_PURCHASE_ORDER)</th>
						<th>PRICE</th>
						<th>QTY</th>
						<th>UNIT</th>
						
						<th>NO</th>
						<th>NAME</th>
						
						<th>STATUS</th>
						<th>DATE</th>
						<th>LATE STATUS</th>
						
						<th>NO</th>
						<th>STATUS</th>
						<th>DUE DATE</th>
						<th>COMPLETE DATE</th>
						
						<th>NO</th>
						<th>STATUS</th>
						<th>DUE DATE</th>
						<th>RETUR</th>
						<th>RETUR DATE</th>
						
						<th>NO</th>
						<th>DATE</th>
						<th>NO TWO</th>
						<th>DATE TWO</th>
						
						<th>NOTA RETUR</th>
						<th>DEBIT CREDIT NOTE</th>
						<th>BL NUMBER</th>
						<th>LC NUMBER</th>
						';
				break;
			}else{
			    $title_tab = str_replace('_',' ',mysql_field_name($result,$table[$i]));
			}
			$head .= '<th>'.$title_tab.'</th>';
			$i++;
		}
		//----------------------------------------------------------------//
		
		//-----********add your manual table in here***********-----------//
			if(strcmp($manual,'SQLPO')==0){
				$head .= '<th>PO Number</th><th>Currency</th><th>Amount</th>';
			}else if(strcmp($manual,'SQLLG3')==0){
				$head .= '<th>%Positif Margin From Qty Sold</th><th>%Negatif Margin From Qty Sold</th><th>Nett Margin (USD/MT)</th><th>% Nett Margin (USD/MT)</th>';
			}else if(strcmp($manual,'SQLLG5')==0){
			//	$head .= '<th>Sales Price</th><th>Cogs/MT</th><th>Sales Expanse/MT</th><th>Nett Margin (USD/MT)</th><th>% Nett Margin (USD/MT)</th>';
				$head .= '<th>%Positif Margin From Qty Sold</th><th>%Negatif Margin From Qty Sold</th><th>Sales Expanse/MT</th><th>Nett Margin (USD/MT)</th><th>% Nett Margin (USD/MT)</th>';
			}else if(strcmp($manual,'SQLLG6')==0){
			//	$head .= '<th>Sales Price</th><th>Cogs/MT</th><th>Sales Expanse/MT</th><th>Nett Margin (USD/MT)</th><th>% Nett Margin (USD/MT)</th>';
				$head .= '<th>%Positif Margin From Qty Sold</th><th>%Negatif Margin From Qty Sold</th><th>Sales Expanse/MT</th><th>Nett Margin (USD/MT)</th><th>% Nett Margin (USD/MT)</th>';
			}else if(strcmp($manual,'UPS')==0){
				$head .= '<th>WO Number</th><th>Last Check</th><th>Last Condition</th>';
			}else if(strcmp($manual,'PODETAIL')==0){
				$head .= '<th>VAT</th><th>Witholding Tax</th>';
			}
		//----------------------------------------------------------------//
		
		//------------condition header table edit delete and edit---------//
		if($det==0){
			if(strcmp($manual,'PURCHASING--')==0)
				$head .= '<th>LIST RF NUMBER</th>';
			else
				$head .= '<th>Detail</th>';
		}
		if($del==0){
			$head .= '<th>Delete</th>';
		}
		if($ed==0){
			if(strcmp($manual,'PURCHASING--')==0)
				$head .= '<th>EDIT DATA</th>';
			else
				$head .= '<th>Edit</th>';
		}
		if(strcmp($manual,'DRSS')==0){
			$head .= '<th>Solution</th>';
		}
		//--------------------------------------------------------------//
		
		$head .= '</tr></thead>';
		
		$body = '<tbody>';
		$j = 1;
		while($result_now=mysql_fetch_array($result)){
			$body .= '<tr>';
			
			// ===========Only for edit and detail in PURCHASING =======================
			if(strcmp($manual,'PURCHASING')==0){
			//	$body .= '<td><a href="'.$page.DETAIL.'&id='.$result_now[6].'"><img src="view/images/detail.png"></img></a></td>';
				$body .= "<td><a href=\"".$page.DETAIL.'&iddet='.$result_now[6]."\" onclick=\"$('#dlg').dialog('open')\"><img src=\"view/images/detail.png\"></img></a></td>";
				$body .= "<td><a href=\"".$page.EDIT.'&id='.$result_now[0]."\" onclick=\"$('#dlg').dialog('open')\"><img src=\"view/images/edit.png\"></img></a></td>";	
			}
			//==================================================================
			
			$body .= '<td>'.$j.'</td>';
			$i = 0; $k=0; $l =0;
			
			while($i<sizeof($table)){
				/*if(is_numeric($result_now[$table[$i]]))
				//	$body .= '<td>'.number_format($result_now[$table[$i]],0,",",".").'</td>';
					$body .= '<td>'.$result_now[$table[$i]].'</td>';
				else*/ 
				if(date_or_not($result_now[$table[$i]])){
					$date = explode('-',$result_now[$table[$i]]); 
					$tahun = $date[0];
					$tanggal = $date[2];
					$bulan = $date[1];
					if (checkdate($bulan, $tanggal, $tahun))
						$body .= '<td>'.$result_now[$table[$i]].'</td>';
					else
						$body .= '<td>-</td>';
				}
				else{
					if($alink[$k]===$i){
						//============avoid data character but detected as number like in sql 65432 is char but in php detected numeric====
						if((strcmp($manual,'LEDGER')==0) and (is_numeric($result_now[$table[$i]]))){
							$body .= '<td>'.$result_now[$table[$i]].'</td>';
						}
						//============Give a link to data===================
						else if((strcmp($manual,'LEDGER')==0)){
							$body .= '<td><a href='.$manual_link[$i].'&idlink='.$result_now[$table[$i]].'&acc='.$result_now[2].'&costam='.$result_now[6].'>'.$result_now[$table[$i]].'</a></td>';
						}
						else{
							$body .= '<td><a href='.$manual_link[$i].'&idlink='.$result_now[$table[$i]].'>'.$result_now[$table[$i]].'</a></td>';
						}
						$k++;
					}else
						//===========format of numeric data in table==========
						if((strcmp($manual,'CPO')==0 or strcmp($manual,'LPO')==0 or strcmp($manual,'BUDGET')==0 or strcmp($manual,'LEDGER')==0 or strcmp($manual,'DASHBUD')==0) and (is_numeric($result_now[$table[$i]]))){
							$body .= '<td align="right">'.number_format($result_now[$table[$i]],2,",",".").'</td>';
						}
						//===========format normal data=======================
						else{
							$body .= '<td>'.$result_now[$table[$i]].'</td>';
						}
				}
				$i++;
			}
			
			//--------------***********for add manual table **********------------------//
				$data = ''; $currency = ''; $amount = ''; $itext = '';
				// ------ untuk membandingkan di dalam kondisi bandingkan $manual --//
				if(strcmp($manual,'SQLPO')==0){
					$query2 = 'SELECT CITREQPOJOBID, INVENTTRANSREFID, CURRENCYCODE, INVOICEAMOUNT, ITEMTXT FROM pmwo_po WHERE CITREQPOJOBID = "'.$result_now[0].'"';
					$result2 = mysql_query($query2);
					while($result_now2 = mysql_fetch_array($result2)){
						$data .= $result_now2[1].' <br/> ';
						$currency .= $result_now2[2].' <br/> ';
						$amount .= $result_now2[3].' <br/> ';
						$itext = $result_now2[4];
					} 
					$body .= '<td>'.$data.'</td><td>'.$currency.'</td><td>'.$amount.'</td>';
				}else if(strcmp($manual,'UPS')==0){
					$query2 = SQLUPSHISTORY.' AND PU.Ups_ID = "'.$result_now[0].'" ORDER BY PUH.Date_History DESC';
					$result2 = mysql_query($query2);
					$result_now2 = mysql_fetch_array($result2);
					$last_check = $result_now2[3];
					$last_con = $result_now2[2];
					$wo_num = $result_now2[4];
					$body .= '<td>'.$wo_num.'</td><td>'.$last_check.'</td><td>'.$last_con.'</td>';
				}else if(strcmp($manual,'CPO')==0){
					$total_1 = $total_1 + $result_now[1];
					$total_2 = $total_2 + $result_now[2];
				}else if(strcmp($manual,'LEDGER')==0){
					$total_1 = $total_1 + $result_now[5];
					$total_2 = $total_2 + $result_now[6];
				}else if(strcmp($manual,'PODETAIL')==0){
					$tax = $result_now[22];
					$amount = $result_now[19];
					$tax_val = get_tax($tax,$amount);
					$body .= '<td>'.$tax_val['vat'].'</td><td>'.$tax_val['wh'].'</td>';
				}
			//--------------------------------------------------------------------------//
			
			if($det==0){
				if(strcmp($manual,'PODETAIL')==0)
					$body .= '<td><a href="'.$page.DETAIL.'&id='.$result_now[1].'"><img src="view/images/detail.png"></img></a></td>';
				else if(strcmp($manual,'PURCHASING')==0)
					$body .= '<td><a href="'.$page.DETAIL.'&id='.$result_now[6].'"><img src="view/images/detail.png"></img></a></td>';
				else
					$body .= '<td><a href="'.$page.DETAIL.'&id='.$result_now[0].'"><img src="view/images/detail.png"></img></a></td>';
			}
			if($del==0){
				$body .= '<td><a href="'.$page.DELETE.'&id='.$result_now[0].'"><img src="view/images/delete.png"></img></a></td>';
			}
			if($ed==0){
				if(strcmp($manual,'PURCHASING')==0 || strcmp($manual,'BUDGETCHAR')==0)
					$body .= "<td><a href=\"".$page.EDIT.'&id='.$result_now[0]."\" onclick=\"$('#dlg').dialog('open')\"><img src=\"view/images/edit.png\"></img></a></td>";
				else
					$body .= '<td><a href="'.$page.EDIT.'&id='.$result_now[0].'"><img src="view/images/edit.png"></img></a></td>';
			}
			if(strcmp($manual,'DRSS')==0){
				$body .= '<td><a href="'.$page.SOL.'&id='.$result_now[0].'"><img src="view/images/solution.png"></img></a></td>';
			}
			$body .= '</tr>';
			$j++;			
		}
		$body .= '</tbody>';
		
		//-----------------***********for add manual table**********--------------------//
			if(strcmp($manual,'SQLLG')==0){
				$tfoot = '<tfoot><tr>';
				$tfoot .= '<th></th>';
				$i=0;
				while($i<sizeof($table)){
					if($i==1){
						$tfoot .= '<th>'.number_format($total_1,2,",",".").'</th>';
					}else{
						$tfoot .= '<th></th>';
					}
					$i++;
				}
				$tfoot .= '<th></th><th></th><th>'.number_format($total_4,0,",",".").'</th>';
				$tfoot .= '</tr></tfoot>';
			}else if(strcmp($manual,'CPO')==0){
				$tfoot = '<tfoot><tr>';
				$tfoot .= '<th></th>';
				$i=0;
				while($i<sizeof($table)){
					if($i==1){
						$tfoot .= '<th>'.number_format($total_1,2,",",".").'</th>';
					}else if($i==2){
						$tfoot .= '<th>'.number_format($total_2,2,",",".").'</th>';
					}else{
						$tfoot .= '<th></th>';
					}
					$i++;
				}
			//	$tfoot .= '<th></th><th></th>';
				$tfoot .= '</tr></tfoot>';
			}else if(strcmp($manual,'LEDGER')==0){
				$tfoot = '<tfoot><tr>';
				$tfoot .= '<th></th>';
				$i=0;
				while($i<sizeof($table)){
					if($i==6){
						$tfoot .= '<th>'.number_format($total_2,2,",",".").'</th>';
					}else{
						$tfoot .= '<th></th>';
					}
					$i++;
				}
			//	$tfoot .= '<th></th><th></th>';
				$tfoot .= '</tr></tfoot>';
			}
			
		//------------------------------------------------------------------------------//
		
		//----------------------------------body paging for show table------------------//
		$table = '<div id="scrolling"><table class="display" id="data">'.$head.$body.$tfoot.'</table></div>';
	
		//----------------------------------body scroll for show table------------------//
	//	$table = '<table id="scroll" width="100%" border="0" cellspacing="0" cellpadding="0">'.$head.$body.'</table>';
		
		$content = $table;
		return $content;
	}
	//-----------------------------------------------------------------------------------------------------------------------------------//
	
	function get_text_in_record($text, $foundtext){
		$content = '';
		$word_pos = strpos(strtolower($text), strtolower($foundtext));
		if($word_pos){
			$word = substr(strtolower($text),$word_pos+13, strlen($text));
			$content = strtoupper($word);
			$content = preg_replace('/[^a-zA-Z0-9]/', '', $content);
		}else{
			$content = '';
		}
		return $content;
	}
	
	//---------------------------function show detail title query For select, and table--------------------------------------------------//
	// 1. function ini berfungsi untuk menampilkan detail dari query yang ingin ditampilkan sesuai data yang muncul pada halaman website
	function query_detail($title, $page, $squery, $table, $whercon){
		$query = 'SELECT '.$squery.' FROM '.$table.' WHERE '.$whercon;
		$result = mysql_query($query) or die('failed');
		$num_field = mysql_num_fields($result);
		
		$i=0;
		$table = '';
		while($result_now=mysql_fetch_array($result)){
			while($i<$num_field){
				$table .= '<tr><td width=250>'.mysql_field_name($result,$i).'</td><td> : </td><td width=200>'.$result_now[$i].'</td></tr>';
				$i++;
			}
		}
		
		$content = '<table class="mytable">'.$table.'</table>';
		return $content;
	}
	//--------------------------------------------------------------------------------------------------------------------------------------//
	
	//-------------------------function query delete page address and table you want delete-------------------------------------------------//
	// 1. function ini berfungsi untuk menghapus data sesuai dengan query yang ingin dihapus
	function query_delete($page, $table, $whercon){
		$query = 'DELETE FROM '.$table.' WHERE '.$whercon;
		//echo $query;
		mysql_query($query) or die('failed');
		$content = '<script>location.href="'.$page.'";</script>'; 
		return $content;
	}
	//--------------------------------------------------------------------------------------------------------------------------------------//
	
	//-------------------------function use to convert date to mysql-------------------------------------------------//
	function convert_date_time($sentences){
		$month = array('Jan-','Feb-','Mar-','Apr-','May-','Jun-','Jul-','Aug-','Sep-','Oct-','Nov-','Dec-');
		$month_name = array('Jan'=>'01','Feb'=>'02','Mar'=>'03','Apr'=>'04','May'=>'05','Jun'=>'06','Jul'=>'07','Aug'=>'08','Sep'=>'09','Oct'=>'10','Nov'=>'11','Dec'=>'12');
		$date = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24',
					  '25','26','27','28','29','30','31');
					  
		$arr = explode(',',$sentences);
		$i=0;
		while($i<sizeof($arr)){
			$j=0;
			while($j<sizeof($month)){
				if(strpos($arr[$i],$month[$j])){
					$dt = str_replace('"',"",$dt);
					$sprt = explode("-",$arr[$i]);					
					$num_date = $date[(int)$sprt[0]];
					$month_num = $month_name[$sprt[1]];
					$y = substr(date('Y'),0,-2);
					$y .= $sprt[2];
					$y = str_replace("\t","",$y);
					$y = str_replace("'","",$y);
					$dt = "'".$y.'-'.$month_num.'-'.$num_date.' 00:00:00'."'";
					$sentences = str_replace($arr[$i],$dt,$sentences);
					$set_break = true;
					break;	
				}else{
				//	$sentences .= '<br/>'.$arr[$i].' , '.$month[$j];
				}
				$j++;
			}
			if($set_break==true)
				break;
			$i++;
		}
		
		$content = $sentences;
		return $content;
	}
	//--------------------------------------------------------------------------------------------------------------------------------------//
	
	//-------------------------function get table in sentences query -----------------------------------------------------------------------//
	// 1. berfungsi mengambil nama tabel yang terdapat dalam kalimat query
	function get_table($sentences){
		$pos = strpos($sentences,'(');
		$sentences = substr($sentences, 0, $pos-1);
		$sentences = str_replace(' ','',$sentences);
		$sentences = str_replace('insertinto','',$sentences);
		$sentences = str_replace('values','',$sentences);
		$content = $sentences;
		return $content;
	}
	//--------------------------------------------------------------------------------------------------------------------------------------//
	
	//-------------------------function query add page address and table you want delete----------------------------------------------------//
	// 1. function ini berfungsi untuk menambahkan data berupa query
	function query_add($sentences){
		$table = get_table($sentences);
		$query = 'SELECT * FROM '.$table;
		$result = mysql_query($query);
		
		if($result){
		//	$content = '<div class="warning" align="center">insert SQL sucess</div>';
			while($result_now = mysql_fetch_array($result)){
				$id_val = $result_now[0];	
			}
			$id_val = $id_val+1;
			
			$arr = explode('(',$sentences);
			$q1 = $arr[0];
			$q2 = $arr[1];
			$squery = $q1."('".$id_val."',".$q2;
			$squery = convert_date_time($squery);
			
			$query = $squery;
			$result = mysql_query($query);
			if($result){
				$content = '<div class="warning" align="center">insert SQL sucess to table '.$table.'</div>';
			}else{
				$content = '<div class="warning" align="center">insert SQL failed, Wrong Query Sentences</div>';
			}
		}else{
			$content = '<div class="warning" align="center">insert SQL failed, Wrong Query Sentences, name of table not found</div>';
		}
		
		
		
	//	$content .= $squery;
		return $content;
	}
	//--------------------------------------------------------------------------------------------------------------------------------------//
	
	//-----------------------------------------show add or edit table-------------------------------------------------------------------------//
	
	function add_field($page,$query){
		$result = mysql_query($query);
		$num_field = mysql_num_fields($result);
		$i = 1;
		$tab = '';
		
		//----edit this for show what type field in html with u want----//
		$coloumn = '0001111156';
		
		//----name of table type in html in array-----------------------//
		$name = array('','user','app','insert','view','delete','no','all','submit','reset');
		
		//----number of field u want to add in form example submit and reset---------//
		$add = 2;
		
		$num_field = $num_field+$add;
		
		$table = sum_table($coloumn);
		
		while($i<$num_field){
			if($i<$num_field-$add){
				$field = str_replace('_',' ',mysql_field_name($result,$i));
				$tab .= input($table[$i],$field,$name[$i],'',0);
			}else{
				$tab .= input($table[$i],'','',$name[$i],0);
			}
			$i++;
		}
		$content = '<form action="'.$page.ADD.POST.'" method="POST" ><table class="mytable">'.$tab.'</table></form>';
		return $content;
	}
	
	//----------------------------------kind of type input in html---------------------------------------------------------------------//
	function input($type,$field,$name,$value,$edit,$query){
		if($type==0){ echo $query;
			if($edit==0){ 
			$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" class="input" name="'.$name.'" value="'.$value.'" /></td></tr>';
			}else{
				$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" class="input" name="'.$name.'" /></td></tr>';
			}
		}if($type==16){
			if($edit==0){
			$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" class="time" name="'.$name.'" value="'.$value.'" /></td></tr>';
			}else{
				$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" class="time" name="'.$name.'" /></td></tr>';
			}
		}else if($type==1){
			if($edit==0){
				$content = '<tr><td width=200>'.$field.' : </td><td><input type="checkbox" name="'.$name.'" value=""/></td></tr>';
			}else{
				$content = '<tr><td width=200>'.$field.' : </td><td><input type="checkbox" name="'.$name.'" value="v" checked/></td></tr>';
			}
		}else if($type==2){
			if($edit==0){
				$content = '<tr><td width=200>'.$field.' : </td><td><input type="password" class="input" name="'.$name.'" value="'.$value.'" /></td></tr>';
			}else{
				$content = '<tr><td width=200>'.$field.' : </td><td><input type="password" class="input" name="'.$name.'" /></td></tr>';
			}
		}else if($type==3){
			if($edit==0){
			$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" name="'.$name.'" value="'.$value.'" id="datepicker" class="inputadd"/><td></tr>';
			}else{
				$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" name="'.$name.'" id="datepicker" class="inputadd"/></td></tr>';
			}
		}else if($type==12){
			$content = '<tr><td width=100>'.$field.' : </td><td><input type="file" name="'.$name.'" /><td></tr>';
		}else if($type==11){
			if(strcmp($name,'status')==0){
				if($edit==0){
					$content = '<tr><td width=200>'.$field.' : </td><td><input type="radio" name="'.$name.'" value="Expired" checked/>Expired</td></tr>';
					$content .= '<tr><td width=200></td><td><input type="radio" name="'.$name.'" value="Unexpired"/>Unexpired</td></tr>';
				}else if($edit==1){		
					$query = $query.' WHERE license_id="'.$_REQUEST['id'].'"';
					$result2 = mysql_query($query);
					$result_now2 = mysql_fetch_array($result2);
					if(strcmp($result_now2['Status'],'expired')==0){
						$content = '<tr><td width=200>'.$field.' : </td><td><input type="radio" name="'.$name.'" value="Expired" checked/>Expired</td></tr>';
						$content .= '<tr><td width=200></td><td><input type="radio" name="'.$name.'" value="Unexpired"/>Unexpired</td></tr>';
					}else if(strcmp($result_now2['Status'],'unexpired')==0){
						$content = '<tr><td width=200>'.$field.' : </td><td><input type="radio" name="'.$name.'" value="Expired"/>Expired</td></tr>';
						$content .= '<tr><td width=200></td><td><input type="radio" name="'.$name.'" value="Unexpired"/ checked>Unexpired</td></tr>';
					}
				}
			}
		}else if($type==4){
			if($edit==0){
				$date = explode('-',$value); 
				$tahun = $date[0];
				$tanggal = $date[2];
				$bulan = $date[1];
				if (checkdate($bulan, $tanggal, $tahun)){
					$value = $bulan.'/'.$tanggal.'/'.$tahun;
					$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" name="'.$name.'" value="'.$value.'" class="datepicker" class="inputadd" /></td></tr>';
				}else{
					$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" name="'.$name.'" class="datepicker" class="inputadd" /></td></tr>';
				}	
				
			}else{
				$content = '<tr><td width=100>'.$field.' : </td><td><input type="text" name="'.$name.'" class="datepicker" class="inputadd" /></td></tr>';
			}
		}else if($type==10){
			$content = '<tr><td width=100>'.$field.' : </td><td>'.$value.'<td></tr>';
		}else if($type==13){
			if($edit==0){
				$content = '<tr><td width=100>'.$field.' : </td><td><textarea rows="3" cols="34" name="'.$name.'" wrap="physical">'.$value.'</textarea><td></tr>';
			}else{
				$content = '<tr><td width=100>'.$field.' : </td><td><textarea rows="3" cols="34" name="'.$name.'" wrap="physical"></textarea><td></tr>';
			}
		}
		//====================================just to make checklist from query =======================================================//
		else if($type==8){
			$content = '<tr><td><br/><br/></td></tr><tr><td width=300 colspan="3"><div class="title">CHECK ACTION FORM YOU WANT USE TO THIS SCHEDULE</div></td><td></td><td></td></tr>';
			$content .= '<tr><td width=300><b>Action Category</b></td><td><b>Action List</b></td><td><b>Check</b></td></tr>';
			$result = mysql_query($query);
			$i =0; 
			while($result_now=mysql_fetch_array($result)){
				$query2 = 'SELECT Id_Action from pmwo_checklist WHERE Id_Action="'.$result_now[0].'" AND Id_SM="'.$_REQUEST['id'].'"';
				$result_now2 = mysql_query($query2);
				$num_rows = mysql_num_rows($result_now2);
				if($num_rows>0){
					$content .= '<tr><td width=300>'.$result_now[1].' : </td><td>'.$result_now[2].'</td><td><input type="checkbox" name="'.$name.$result_now[0].'" value="v" checked/></td></tr>';
				}else{
					$content .= '<tr><td width=300>'.$result_now[1].' : </td><td>'.$result_now[2].'</td><td><input type="checkbox" name="'.$name.$result_now[0].'" value=""/><td></tr>';
				}
				$i++;
			}
		}
		else if($type==9){
			$content = '';
			$result = mysql_query($query);	
			$i = 1;
			$content .= '<tr><td width=30 align="center"><b>No</b></td><td width=300 align="center"><b>Category</b></td><td width=300 align="center"><b>Action</b></td><td align="center"><b>Note</b></td><td align="center"><b>Checked</b></td></tr>';
			while($result_now = mysql_fetch_array($result)){
				$query2 = 'SELECT Ceck FROM pmwo_checklist WHERE Id_Action="'.$result_now[0].'" AND Id_SM="'.$_REQUEST['id'].'"';
				$result2 = mysql_query($query2);
				$result_now2 = mysql_fetch_array($result2);
				if(strcmp($result_now2[0],'v')==0){
					$content .= '<tr><td width=30>'.$i.'</td><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td><input type="text" class="input" name="text'.$result_now[0].'" value="'.$result_now[3].'" /></td><td><input type="checkbox" name="'.$name.$result_now[0].'" value="v" checked/></td></tr>';
				}else{
					$content .= '<tr><td td width=30>'.$i.'</td><td width=300>'.$result_now[1].'</td><td width=300>'.$result_now[2].'</td><td><input type="text" class="input" name="text'.$result_now[0].'" value="'.$result_now[3].'" /></td><td><input type="checkbox" name="'.$name.$result_now[0].'" value=""/></td></tr>';
				}
				$i++;
			}
		}
		//=====================================================================================================================//
		else if($type==5){
			$content = '<tr><td></td><td><input type="submit" value="'.$value.'" class="submit"/></td></tr>';
		}else if($type==6){
			$content = '<tr><td></td><td><input type="reset" value="'.$value.'" class="submit"/></td></tr>';
		}else if($type==7){
			if($edit==0){ 
				$result = mysql_query($query) or die ('failed 7'); 
				$num_field = mysql_num_fields($result);
				$name_option = '';
				$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<=$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					if(strcmp($result_now[0],$value)==0)
						$option .= '<option value="'.$result_now[0].'" selected="true">'.$name_option.'</option>';
					else
						$option .= '<option value="'.$result_now[0].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}else{
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
				$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					$option .= '<option value="'.$result_now[0].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}
			$content = '<tr><td width=100>'.$field.' : </td><td><select name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}else if($type==14){
			if($edit==0){
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
				if(strcmp($name,'accname')==0){
					$option .= '<option value="" selected="true">-</option>';
				}
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<=$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					if(strcmp($result_now[0],$value)==0)
						$option .= '<option value="'.$result_now[0].'" selected="true">'.$name_option.'</option>';
					else
						$option .= '<option value="'.$result_now[0].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}else{
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
			//	$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					$option .= '<option value="'.$result_now[0].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}
			$content = '<tr><td width=100>'.$field.' : </td><td><select name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}else if($type==15){
			if($edit==0){
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
			//	$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<=$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					if(strcmp($result_now[1],$value)==0)
						$option .= '<option value="'.$result_now[1].'" selected="true">'.$name_option.'</option>';
					else
						$option .= '<option value="'.$result_now[1].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}else{
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
			//	$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					$option .= '<option value="'.$result_now[1].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}
			$content = '<tr><td width=100>'.$field.' : </td><td><select name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}else if($type==18){
			if($edit==0){
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
			//	$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<=$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					if(strcmp($result_now[1],$value)==0)
						$option .= '<option value="'.$result_now[0].'" selected="true">'.$name_option.'</option>';
					else
						$option .= '<option value="'.$result_now[0].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}else{
				$result = mysql_query($query) or die ('failed');
				$num_field = mysql_num_fields($result);
				$name_option = '';
			//	$option .= '<option value="" selected="true">-</option>';
				while($result_now=mysql_fetch_array($result)){
					for($i=1; $i<$num_field; $i++){
						$name_option .= $result_now[$i].' ';
					}
					
					$option .= '<option value="'.$result_now[0].'">'.$name_option.'</option>';
					
					$name_option = '';
				}
			}
			$content = '<tr><td width=100>'.$field.' : </td><td><select name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}else if($type==17){
			if($edit==0){
				$i=0; $option .= '<option value="" selected="true">-</option>'; 
				while($i<sizeof($query)){
					if(strcmp($query[$i],$value)==0)
						$option .= '<option value="'.$query[$i].'" selected="true">'.$query[$i].'</option>';
					else
						$option .= '<option value="'.$query[$i].'">'.$query[$i].'</option>';
					$i++;
				}
			}else{
				$i=0; $option .= '<option value="" selected="true">-</option>';
				while($i<sizeof($query)){
					$option .= '<option value="'.$query[$i].'">'.$query[$i].'</option>';
					$i++;	
				}
			}
			$content = '<tr><td width=100>'.$field.' : </td><td><select name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}
		return $content;
	}
	
	//------------------------------function search field------------------------------------------------------------------------------//
	function search(){
		
	}
	//---------------------------------------------------------------------------------------------------------------------------------//
	
	//-------------------------------function to query insert data----------------------------------------------------------------------//
	function insert($data,$table){
		$i=0;
		$query = 'INSERT INTO '.$table.' VALUES(';
		while ($i<sizeof($data)){
			if($i==sizeof($data)-1)
				$query .= '"'.$data[$i].'")';
			else
				$query .= '"'.$data[$i].'",';
			$i++;
		}
		
	//	echo $query;
		$result = mysql_query($query);
		
		if($result){
			$content = '<div align="center" class="warning">Insert Successed</div>';
		}else{
			$content = '<div align="center" class="warning">Insert Failed</div>';
		}
		
		return $content;
	}
	
	//-------------------------------function to query edit data----------------------------------------------------------------------//
	//fungsi ini berfungsi untuk edit data dengan parameter query utnuk mengedit data database, dan parameter yang diisi adalah //
	// data yang berisikan nilai yang berasal dari input, tabel dari database, kondisi dari query , nama field atau kolom database //
	function edit($data,$table,$con,$array){
		//name field
		$name_field = $array;
		
		$i=0;
		$query = 'UPDATE '.$table.' SET ';
		while ($i<sizeof($data)){
			if($i==sizeof($data)-1)
				$query .= $name_field[$i].'="'.$data[$i].'"';
			else
				$query .= $name_field[$i].'="'.$data[$i].'",';
			$i++;
		}
		
		$query .= ' WHERE '.$con;
		
	//	echo $query;
		
		$result = mysql_query($query);
		
		if($result){
			$content = '<div align="center" class="warning">Update Successed</div>';
		}else{
			$content = '<div align="center" class="warning">Update Failed</div>';
		}
		
	//	$content = $query;
		
		return $content;
	}
	
	//-----------------------------function to edit data--------------------------------------------------------------------------------//
	// pada fungsi ini digunakan untuk membuat atau mengenerate form dari edit data berdasarakan kebutuhan yang sudah dibuat pada fungsi page_function
	// parameter yang ada adalah halaman , query dasar tanpa kondisi, kondisi dalam query berupa, id dari data yang ingin dipilih biasanya adalah primary key,
	// pengurutan data yang ingin ditampilkan berdasarkan apa, nama input yang digenerate, jenis input yang ingin dipilih, dan jumlah input yang ingin ditambahkan
	// $query2 digunakan untuk isian inputan berupa select;
	function edit_field($page,$query,$query2,$con,$id,$orderby,$array,$field,$add){
		$query = $query.' WHERE '.$con.'  ORDER BY '.$orderby.' ASC';
	//	echo $query;
		$result = mysql_query($query) or die('failed');
		$num_field = mysql_num_fields($result);
		$i = 1; $j=0;
		$tab = '';
		
		//----edit this for show what type field in html with u want----//
		$coloumn = $field;
		
		//----name of table type in html in array-----------------------//
		$name = $array;
		
		//----number of field u want to add in form example submit and reset---------//
		$add = $add;
		
		$num_field = $num_field+$add;
		
		$table = sum_table($coloumn);
		$result_now = mysql_fetch_array($result);
		while($i<$num_field){
			if($i<$num_field-$add){
				$field = str_replace('_',' ',mysql_field_name($result,$i));
				if(strcmp($result_now[$i],'v')==0){
					$tab .= input($table[$i],$field,$name[$i],'',1,$query2[$j]);
				}else if(strcmp($result_now[$i],'expired')==0 || strcmp($result_now[$i],'unexpired')==0){
					$tab .= input($table[$i],$field,$name[$i],'',1,$query2[$j]);
				}else{
					$tab .= input($table[$i],$field,$name[$i],$result_now[$i],0,$query2[$j]);
				}
				$j++;
				
			}else{
			//	echo $query2[$j];
				$tab .= input($table[$i],'',$name[$i],$name[$i],0,$query2[$j]);
				$j ++;
			}
			$i++;
		}
		$content = '<form action="'.$page.EDIT.POST.'&id='.$id.'" method="POST" enctype="multipart/form-data"><table class="mytable">'.$tab.'</table></form>';
		return $content;
	}
	
	//--------------------function used multiselect in data ------------------------//
	function multiselect($data_name,$data_value,$name){
		$i=0; $data='';
		while($i<sizeof($data_name)){
		//	if($i<2){
				$data .= '<option value="'.$data_value[$i].'" selected="selected">'.$data_name[$i].'</option>';
		//	}else{
		//		$data .= '<option value="'.$data_value[$i].'">'.$data_name[$i].'</option>';
		//	}
			
			$i++;
		}
		
		$input = '<tr><td>Selected Coloumn </td><td width=100><select id="countries" class="multiselect" multiple="multiple" name="'.$name.'[]">
				  '.$data.'
				  </select></div></tr></td>'; 
		$content = $input;
		return $content; 
	}
    //--------------------------------------------------------------------------------	
?>