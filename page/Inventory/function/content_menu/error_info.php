<?php
	function empty_info($data){
		$info = $data[0];
		$content = '<div class="alert alert-danger" style="max-width: 500px; margin:auto;" align="center" >'.$info.'</div>';
		return $content;
	}
	function success_info($data){
		$info = $data[0];
		$content = '<div class="alert alert-success" style="max-width: 500px; margin:auto;" align="center" >'.$info.'</div>';
		return $content;
	}
?>