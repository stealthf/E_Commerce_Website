<?php
	header("content-type:text/html;charset=utf-8");

	$filename = $_FILES['myFile']['name'];
	$type = $_FILES['myFile']['type'];
	$temp_name = $_FILES['myFile']['tmp_name'];
	$error = $_FILES['myFile']['error'];
	$size = $_FILES['myFile']['size'];

	$allowExtName = array("jpeg", "jpg", "png", "gif");
	$maxSize = 5000000;

	if($error == UPLOAD_ERR_OK){

		$extName = getExtName($filename);

		if(!in_array($extName, $allowExtName))
			exit("invaild file format");
		if($size > $maxSize)
			exit("file is too large");

		$filename = getUnicName().".".$extName;
		$filePath = "images";
		if(file_exists($filePath))
			rmdir($filePath);

		$destination = $filePath."/".$filename;

		if(is_uploaded_file($temp_name)){
			if(move_uploaded_file($temp_name, $destination)){
				$mes = "Upload successfully";
			}else{
				$mes = "Move file failed";
			}
		}else{
			echo "This file is not uploaded by HTTP POST";
		}
	}
	else
		$mes = "Upload Failed";

	echo $mes;

	function getUnicName(){
		return md5(uniqid(microtime(true),true));
	}

	function getExtName($filename){
		return strtolower(end(explode(".",$filename)));
	}
?>