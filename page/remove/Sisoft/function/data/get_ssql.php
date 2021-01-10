<?php
	require_once('connect.php');
	require_once(_ROOT_.'define.php');
	
	//======Fungsi mengenerate data dari SQL server ke MySQL=======
	function DumpSQLServerMy($command){
		$content = '';
		$conn_SS = con_DB_Open_SS('ax-db2', 'gferry', '123', 'TPC-AX-PROD-LIVE');
		
		//==========Definisikan data yang akan digenerate disini===
		if(strcmp($command,'ar_details')==0){
			$query = 'DELETE FROM ar_detail';
			mysql_query($query);
			//========Syarat yang perlu ditambahkan yaitu jika SETTLEAMOUNTCUR pada CUSTTRANS masih 0, sebagai tanda jika transaksi masih belum ditutup
			$query = "SELECT CTA.MarkupGroup, CTA.AccountNum, CTA.Name, Convert(Varchar(10),CTS.TransDate,120), Convert(Varchar(10),CTS.DueDate,120), CTT.Invoice, CTT.CurrencyCode, CTS.AmountCur, CTA.CITY, CTA.PAYMTERMID, CTA.CURRENCY, CTA.CREDITMAX, CTA.CREDITRATING, Convert(Varchar(10),CTT.MODIFIEDDATE,120) FROM CUSTTABLE CTA, CUSTTRANS CTT, CUSTTRANSOPEN CTS WHERE CTA.AccountNum=CTT.AccountNum AND CTT.RECID=CTS.REFRECID AND (CTT.Voucher LIKE 'INV%' OR CTT.Voucher = 'JV-22756' OR CTT.Voucher = 'JV-22757' OR CTT.Voucher = 'JV-22758' OR CTT.Voucher = 'JV-22759') AND CTT.TransDate >= DATEADD(MONTH, -6, GETDATE())";
			
			$rs = execute_query_SS($conn_SS, $query);
			while(!$rs->EOF){
				
				$mark = $rs->Fields[0];
				$acc = $rs->Fields[1];
				$name = $rs->Fields[2];
				$inv = $rs->Fields[3];
				$due = $rs->Fields[4];
				$noinv = $rs->Fields[5];
				$cur = $rs->Fields[6];
				$ammcur = $rs->Fields[7];
				$city = $rs->Fields[8];
				$payterm = $rs->Fields[9];
				$curr = $rs->Fields[10];
				$cremax = $rs->Fields[11];
				$crerat = $rs->Fields[12];
				$moddate = $rs->Fields[13];
				
				if(strcmp($noinv,'INV-16003353')==0){
					$due = '2016-11-23';
				}
					
				$sql = 'INSERT INTO ar_detail (MarkupGroup, AccountNum, Name, TransDate, DueDate, Invoice, CurrencyCode, AmountCur, CITY, PAYMTERMID, CURRENCY, CREDITMAX, Coface, Modifieddate) VALUES ("'.$mark.'","'.$acc.'","'.$name.'","'.$inv.'","'.$due.'","'.$noinv.'","'.$cur.'","'.$ammcur.'","'.$city.'","'.$payterm.'","'.$curr.'","'.$cremax.'","'.$crerat.'","'.$moddate.'")'; 
				mysql_query($sql); 
				
				$rs->MoveNext(); 
				$i++;
			}
			close_query_SS($rs);
		}
		
		$query = 'DELETE FROM ar_gendatetime';
		mysql_query($query) or die('DELETE DATA ar_gendatetime failed');
		
		date_default_timezone_set('Asia/Jakarta');
		$date_time = date('Y-m-d H:i:s');
		$sql = 'INSERT INTO ar_gendatetime (gen_datetime) VALUES ("'.$date_time.'")';
		mysql_query($sql) or die('INSERT DATA ar_gendatetime failed');
		$content .= '<br/><br/><div class="note">GENERATE AR DATA IN '.$date_time.'</div>';
		$content .= '<div class="note">IF NOT SHOW ERROR, RESTORE DATABASE SUCCESS</div>'; 
		return $content;
	}
?>