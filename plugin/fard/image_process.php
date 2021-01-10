<?php
	function upload_image($name){
		$errors=0;
		$image =$_FILES[$name]["name"];
		$uploadedfile = $_FILES[$name]['tmp_name'];
		
		if($image){
			$filename = stripslashes($_FILES[$name]['name']);
			$extension = getExtension($filename);
			$extension = strtolower($extension);
			
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
			//	$content = 'Unknown Image extension';
				$errors=1;
			}
			else{
				$size=filesize($_FILES[$name]['tmp_name']); 
				if ($size > MAX_SIZE*1024){
				//	$content = "You have exceeded the size limit";
					$errors=2;
				}
				
				if($extension=="jpg" || $extension=="jpeg" ){
					$uploadedfile = $_FILES[$name]['tmp_name'];
					$src = imagecreatefromjpeg($uploadedfile);
				}
				else if($extension=="png"){
					$uploadedfile = $_FILES[$name]['tmp_name'];
					$src = imagecreatefrompng($uploadedfile);
				}
				else {
					$src = imagecreatefromgif($uploadedfile);
				}
				
				list($width,$height)=getimagesize($uploadedfile);
				
				$newwidth=800;
				$newheight=($height/$width)*$newwidth;
				$tmp=imagecreatetruecolor($newwidth,$newheight);
				
			/*	$newwidth1=100;
				$newheight1=($height/$width)*$newwidth1;
				$tmp1=imagecreatetruecolor($newwidth1,$newheight1);*/
				
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
			//	imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, $width,$height);
				
				$filename = "view/upload_doc/". $_FILES[$name]['name'];
			//	$filename = "D:/Upload_Data/Image_Observe_SHE/". $_FILES[$name]['name'];
			//	$filename1 = "view/upload_images/small/". $_FILES[$name]['name'];

				imagejpeg($tmp,$filename,100);
			//	imagejpeg($tmp1,$filename1,100);

				imagedestroy($src);
				imagedestroy($tmp);
			//	imagedestroy($tmp1);
				$errors = 0;
			}
		
		}
		return $errors;
	}
	
	function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; } 

        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
		return $ext;
	}
	
	function note_error($errors){
		switch ($errors){
			case 0:
				$content = 'upload success';
				break;
			case 1:
				$content = 'Unknown Image extension';
				break;
			case 2:
				$content = 'You have exceeded the size limit';
				break;
		}
		return $content;
	}
?>