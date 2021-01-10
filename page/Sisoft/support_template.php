<?php
	//***********SUPPORT TEMPLATE UNTUK MENAMBAHKAN FEATURE TEMPLATE*********************//
	function task_work_order(){
		$query = 'SELECT COUNT(*) FROM work_order WHERE WorkStatusID<>"WS000007"'; $result = mysql_exe_query(array($query,1)); $resultnow=mysql_exe_fetch_array(array($result,1)); $total=$resultnow[0];
		$query = 'SELECT WS.WorkStatus Work_Status, COUNT(WS.WorkStatus) Total FROM work_order WO, work_status WS WHERE WO.WorkStatusID=WS.WorkStatusID AND WS.WorkStatus<>"Job Finished" GROUP BY WS.WorkStatus ORDER BY WS.WorkStatusID ASC';
		$result = mysql_exe_query(array($query,1));
		$bar=array();$namebar=array();$i=0;
		while($resultnow=mysql_exe_fetch_array(array($result,1))){
			$namebar[$i]=$resultnow[0];
			$bar[$i]=$resultnow[1];
			$i++;
		} 
		
		if($total!=0){
			$bar1 = ROUND($bar[0]/$total*100);
			$bar2 = ROUND($bar[1]/$total*100);
			$bar3 = ROUND($bar[2]/$total*100);
			$bar4 = ROUND($bar[3]/$total*100);
		}else{
			$bar1 = 0;
			$bar2 = 0;
			$bar3 = 0;
			$bar4 = 0;
		}
		
		
		$content = '
			<li class="dropdown">
                    <a class="" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>'.$namebar[0].'</strong>
                                        <span class="pull-right text-muted">'.$bar[0].' From '.$total.'</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$bar1.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar1.'%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>'.$namebar[1].'</strong>
                                        <span class="pull-right text-muted">'.$bar[1].' From '.$total.'</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="'.$bar2.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar2.'%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>'.$namebar[2].'</strong>
                                        <span class="pull-right text-muted">'.$bar[2].' From '.$total.'</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="'.$bar3.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar3.'%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>'.$namebar[3].'</strong>
                                        <span class="pull-right text-muted">'.$bar[3].' From '.$total.'</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="'.$bar4.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar4.'%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Total Status WO Not Completed</strong>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
		';
		return $content;
	}
?>