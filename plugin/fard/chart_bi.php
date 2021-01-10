<?php

	//***********************----------------------------function search-----------------------------------*****************************************//
	function query_search(){
	
	}
	
	//---menggabungkan keseluruhan field dan arah halaman post--//
	function post_submit($page,$array,$submit,$v_submit){
		$i=0; $tab = '';
		while($i<sizeof($array)){
			$tab .= $array[$i];
			$i++;
		}
		//====0 if without submit=====//
		if($submit==0){
			$content .= '<table class="mytable"><td width=100></td><td><form name="ref_auto" action="'.$page.POST.'" method="POST"></td>'.$tab.'
					</form><div id="temp"><div></table>';
		}
		//====1 if with submit========//
		else if($submit==1){
			$content .= '<table class="mytable"><form action="'.$page.POST.'" method="POST" enctype="multipart/form-data">'.$tab.'
					<tr><td></td><td><input type="submit" name="submit" value="'.$v_submit.'" class="submit"></td></tr>
					<tr><td></td><td><input type="reset" name="submit" value="Reset" class="submit"></td></tr>
					</form></table>';
		}
		//====2 if with submit========//
		else if($submit==2){
			$content .= '<table class="mytable"><form action="'.$page.POST.'" method="POST" enctype="multipart/form-data">'.$tab.'
					<tr><td></td><td><input type="submit" name="submit" value="'.$v_submit.'" class="submit"></td></tr>
					</form></table>';
		}
		return $content;
	}
	
	//---menggabungkan keseluruhan field dan arah halaman post--//
	function post_search($page,$array,$submit){
		$i=0; $tab = '';
		while($i<sizeof($array)){
			$tab .= $array[$i];
			$i++;
		}
		//====0 if without submit=====//
		if($submit==0){
			$content .= '<table class="mytable"><form name="ref_auto" action="'.$page.POST.'" method="POST">'.$tab.'
					</form><div id="temp"><div></table>';
		}
		//====1 if with submit========//
		else if($submit==1){
			$content .= '<table class="mytable"><form action="'.$page.POST.'" method="POST">'.$tab.'
					<tr><td width=100></td><td><input type="submit" name="submit" value="Search" class="submit"></tr>
					</form></table>';
		}
		return $content;
	}
	
	//-----------------menampilkan field pencarian--------------//
	function field_search($sentences,$queryorarray,$title,$name,$add, $submit_id, $val_selected){
		//------if $sentences is query------------//
		if($queryorarray==0){
			$query = $sentences;
			$result = mysql_query($query) or die ('failed');
			$option = '';
			$i=0;
			if(sizeof($add)>0){
				$i = 0;
				while($i<sizeof($add)){
					if(strcmp($add[$i],'all')==0){
						if($val_selected=='')
							$option .= '<option value="" selected="true">'.$add[$i].'</option>';
						else
							$option .= '<option value="">'.$add[$i].'</option>';
					}else{
						if(strcmp($add[$i],$val_selected)==0)
							$option .= '<option value="'.$add[$i].'" selected="true">'.$add[$i].'</option>';
						else
							$option .= '<option value="'.$add[$i].'">'.$add[$i].'</option>';
					}
					$i++;
				}
			}
			while($result_now=mysql_fetch_array($result)){
				if(strcmp($result_now[0],$val_selected)==0)
					$option .= '<option value="'.$result_now[0].'" selected="true">'.$result_now[0].'</option>';
				else
					$option .= '<option value="'.$result_now[0].'">'.$result_now[0].'</option>';
			}
			
			//-----------------------javascript efect not use submit----------------------------//
			if($submit_id==0){
				$submit_id = 'OnChange=document.ref_auto.submit();';
			}
			
			$content = '<tr><td>'.$title.' : </td><td><select '.$submit_id.' name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}
		
		//------if $sentences is aray------------//
		else if($queryorarray==1){
			$i=0;
			$option = '';
			$i=0;
			if(sizeof($add)>0){
				$i = 0;
				while($i<sizeof($add)){
					if(strcmp($add[$i],'all')==0){
						if($val_selected=='')
							$option .= '<option value="" selected="true">'.$add[$i].'</option>';
						else
							$option .= '<option value="">'.$add[$i].'</option>';
					}else{
						if(strcmp($add[$i],$val_selected)==0)
							$option .= '<option value="'.$add[$i].'" selected="true">'.$add[$i].'</option>';
						else
							$option .= '<option value="'.$add[$i].'">'.$add[$i].'</option>';
					}
					$i++;
				}
			}
			$i=0;
			while($i<sizeof($sentences)){
				if(strcmp($sentences[$i],$val_selected)==0)
					$option .= '<option value="'.$sentences[$i].'" selected="true">'.$sentences[$i].'</option>';
				else
					$option .= '<option value="'.$sentences[$i].'">'.$sentences[$i].'</option>';
				$i++;
			}
			
			if($submit_id==0){
				$submit_id = 'OnChange=document.ref_auto.submit();';
			}
			
			
			$content = '<tr><td>'.$title.' : </td><td><select '.$submit_id.' name="'.$name.'" class="select">'.$option.'</select></td></tr>';
		}
		
		return $content;
	} 
	//***********************------------------------------------------------------------------------------*****************************************//
	
	//***********************-------------------fungsi chart ----------------------------------------------*****************************************//
	function chart_bi($title, $query, $page, $manual,$model,$width,$height,$color1){
		
		
		if(!$query==''){
			$result = mysql_query($query) or die('failed');
			$set='';$graph = ''; $categories=''; $data1=''; $data2=''; $data3='';
			//----------manual code configuration for chart----------------//
			if(strcmp($manual,'SQLLG')==0){
				$i=0;
				while($result_now=mysql_fetch_array($result)){
					$set .= "<set name='".$result_now["Grade"]."' value='".number_format($result_now['Quantity_Sold'],0,",",".")."' color='".$color1[$result_now["Grade"]]."'/>";
					$i++;
				}
				$graph = "<graph caption='".$title."' showNames='1'  decimalPrecision='0'>".$set."</graph>";
				$render = render_charts('FCF_Pie2D.swf',$graph,$width,$height);	
			}
			
			else if(strcmp($manual,'SQLLG2')==0){
				while($result_now=mysql_fetch_array($result)){
					if($result_now['Quantity_Sold']==0){
						$postif_margin = '0';
						$ngatif_margin = '0';
						$nett_margin = '0';
					}else{
						$postif_margin = Round($result_now['Positive_Margin']/$result_now['Quantity_Sold']*100,2);
						$ngatif_margin = Round($result_now['Negatif_Margin']/$result_now['Quantity_Sold']*100,2);
						$nett_margin = Round($result_now['nett_margin']/$result_now['Quantity_Sold'],2);
					}
					
					if($result_now['sales']==0){
						$nett_margin = '0';
					}else{
						$nett_margin = Round($result_now['nett_margin']/$result_now['sales']*100,2);
					}
					$categories.="<category name='".$result_now["Grade"]."' />";
					$data1.="<set value='".number_format($postif_margin,0,",",".")."' />";
					$data2.="<set value='".number_format($ngatif_margin,0,",",".")."' />";
					$data3.="<set value='".number_format($nett_margin,0,",",".")."' />";
				}
				$set = "<categories>".$categories."</categories>
						<dataset seriesName='Positif Margin' color='0ca43e' showValues='0'>".$data1."</dataset>
						<dataset seriesName='Negatif Margin' color='8f0000' showValues='0'>".$data2."</dataset>
						<dataset seriesName='% Net Margin ' color='ffe400' showValues='0' parentYAxis='S'>".$data3."</dataset>";
				$graph = "<graph caption='".$title."' PYAxisName='positif and Negatif value' SYAxisName='Net Value' numberSuffix='%25'
						showvalues='0'  numDivLines='4' formatNumberScale='0' decimalPrecision='0'
						anchorSides='10' anchorRadius='3' anchorBorderColor='009900'>".$set."</graph>";
				$render = render_charts('FCF_MSColumn2DLineDY.swf',$graph,$width,$height);	
			}
			
			else if(strcmp($manual,'SQLLG3')==0){
				while($result_now=mysql_fetch_array($result)){
					$set .= "<set name='".$result_now[1]."' value='".number_format($result_now['Quantity_Sold'],0,",",".")."'/>";
				}
				$graph = "<graph caption='".$title."' showNames='1'  decimalPrecision='0'>".$set."</graph>";
				$render = render_charts('FCF_Pie2D.swf',$graph,$width,$height);	
			}
			
			else if(strcmp($manual,'SQLLG4')==0){
				while($result_now=mysql_fetch_array($result)){
					if($result_now['Quantity_Sold']==0){
						$postif_margin = '0';
						$ngatif_margin = '0';
						$nett_margin = '0';
					}else{
						$postif_margin = Round($result_now['Positive_Margin']/$result_now['Quantity_Sold']*100,2);
						$ngatif_margin = Round($result_now['Negative_Margin']/$result_now['Quantity_Sold']*100,2);
						$nett_margin = Round($result_now['Nett_Margin']/$result_now['Quantity_Sold'],2);
					}
					
					if($result_now['sales']==0){
						$nett_margin = '0';
					}else{
						$nett_margin = Round($result_now['Nett_Margin']/$result_now['sales']*100,2);
					}
					$categories.="<category name='".$result_now[1]."' />";
					$data1.="<set value='".number_format($postif_margin,0,",",".")."' />";
					$data2.="<set value='".number_format($ngatif_margin,0,",",".")."' />";
					$data3.="<set value='".number_format($nett_margin,0,",",".")."' />";
				}
				$set = "<categories>".$categories."</categories>
						<dataset seriesName='Positif Margin' color='0ca43e' showValues='0'>".$data1."</dataset>
						<dataset seriesName='Negatif Margin' color='8f0000' showValues='0'>".$data2."</dataset>
						<dataset seriesName='% Net Margin ' color='ffe400' showValues='0' parentYAxis='S'>".$data3."</dataset>";
				$graph = "<graph caption='".$title."' PYAxisName='positif and Negatif value' SYAxisName='Net Value' numberSuffix='%25'
						showvalues='0'  numDivLines='4' formatNumberScale='0' decimalPrecision='0'
						anchorSides='10' anchorRadius='3' anchorBorderColor='009900'>".$set."</graph>";
				$render = render_charts('FCF_MSColumn2DLineDY.swf',$graph,$width,$height);	
			}
			
			else if(strcmp($manual,'DASHLINE')==0){
				$data = ''; $i = 0;
				$color = array('AFD8F8','F6BD0F','8BBA00','FF8E46','008E8E','D64646','8E468E','588526','B3AA00','008ED6','9D080D','A186BE');
				while($result_now=mysql_fetch_array($result)){
					$name = str_replace('&',' and ',$result_now[0]);
					$data.="<set name= '".$result_now[0]."' value='".$result_now[1]."' color='".$color[$i]."'link='".$page.$name."' />";
					$i++;
				}
				$graph = "<graph caption='".$title."' PYAxisName='' SYAxisName='' formatNumberScale='0' decimalPrecision='0'
						>".$data."</graph>";
				
				$render = render_charts('FCF_Column2D.swf',$graph,$width,$height);
			}
			
			else if(strcmp($manual,'DASHLINEDEC')==0){
				$data = ''; $i = 0;
				$color = array('AFD8F8','F6BD0F','8BBA00','FF8E46','008E8E','D64646','8E468E','588526','B3AA00','008ED6','9D080D','A186BE');
				while($result_now=mysql_fetch_array($result)){
					$name = str_replace('&',' and ',$result_now[0]);
					$data.="<set name= '".$result_now[0]."' value='".$result_now[1]."' color='".$color[$i]."'link='".$page.$name."' />";
					$i++;
				}
				$graph = "<graph caption='".$title."' PYAxisName='' SYAxisName='' formatNumberScale='0' decimalPrecision='1'
						>".$data."</graph>";
				
				$render = render_charts('FCF_Column2D.swf',$graph,$width,$height);
			}
			//-------------------------------------------------------------//
			
			else if(strcmp($manual,'LINK-IT-NETWORK')==0){
				$set = "<set name='IT-NW-DWT' value='0' link='".$page.$name."'/>";
				while($result_now=mysql_fetch_array($result)){
					$name = str_replace('&',' and ',$result_now[0]);
					$set .= "<set name='".$name."' value='".$result_now[1]."' link='".$page.$name."'/>";
					$graph = "<graph caption='".$title."' showNames='1' pieSliceDepth='25' decimalPrecision='2' formatNumberScale='0' thousandSeparator='.' decimalSeparator=','>".$set."</graph>";
				}
				$render = render_charts('FCF_Pie2D.swf',$graph,$width,$height);	
			}
			
			else{
				while($result_now=mysql_fetch_array($result)){
					$name = str_replace('&',' and ',$result_now[0]); //echo $name.'<br>';
				//	$set .= "<set name='".$name."' value='".number_format($result_now[1],0,",",".")."'/>";
					if(strcmp($manual,'LINK')==0){ //echo '<br/>'.$name.' = '.$result_now[1];
						$set .= "<set name='".$name."' value='".$result_now[1]."' link='".$page.$name."'/>";
						$graph = "<graph caption='".$title."' showNames='1' pieSliceDepth='25' decimalPrecision='2' formatNumberScale='0' thousandSeparator='.' decimalSeparator=','>".$set."</graph>";
					}else if(strcmp($manual,'LINKDES')==0){
						$set .= "<set name='".$name."' value='".$result_now[1]."' link='".$page.$name."'/>";
						$graph = "<graph caption='".$title."' showNames='1' pieSliceDepth='25' decimalPrecision='2' formatNumberScale='2' thousandSeparator='.' decimalSeparator=','>".$set."</graph>";
					}else{
						$set .= "<set name='".$name."' value='".number_format($result_now[1],0,",",".")."' />";
						$graph = "<graph caption='".$title."' showNames='1' pieSliceDepth='25' decimalPrecision='0' formatNumberScale='0' thousandSeparator='.' decimalSeparator=','>".$set."</graph>";
					}
				}
				
					$render = render_charts('FCF_Pie2D.swf',$graph,$width,$height);	
			}
			
			if($model==0){
			$content = '<div align="center">'.$render.'</div>';
			}else if($model==1){
				$content = $render;
			}
		}else{
			$content = '<div align="center" class="warning">No Definition to Render This Command to Chart</div >';
		}
		
		
		return $content;
	}
	
	function render_charts($kind,$xml,$width,$height){
		$chart = renderChartHTML("plugin/Chart/chart/".$kind, "", $xml, "", $width, $height);
		return $chart;
	}
	//***********************------------------------------------------------------------------------------*****************************************//
?>