<?php
	header("content-type:text/html;charset=utf-8");

	uploadFile();

	function buildFile(){
		if(!$_FILES)
			return;
		$fileInfo = $_FILES['myFile'];
		return $fileInfo;
	}

	function uploadFile($filePath="testImg", $allowExtName=array("jpeg", "jpg", "png", "gif"), $maxSize=5000000){
		if(!file_exists($filePath))
			mkdir($filePath);

		$fileInfo = buildFile();

		if(!$fileInfo)
			return;

		if($fileInfo['error'] == UPLOAD_ERR_OK){

			$extName = getExtName($fileInfo['name']);

			if(!in_array($extName, $allowExtName))
				exit("invaild file format");
			if($fileInfo['size'] > $maxSize)
				exit("file is too large");

			$filename = getUnicName().".".$extName;
			$destination = $filePath."/".$filename;

			if(is_uploaded_file($fileInfo['tmp_name'])){
				if(move_uploaded_file($fileInfo['tmp_name'], $destination)){
					$fileInfo['name']=$filename;
					unset($fileInfo['tmp_name'],$fileInfo['size'],$fileInfo['type']);
					$uploadedFile=$fileInfo;
				}else{
					$mes = "Move file failed";
				}
			}else{
				echo "This file is not uploaded by HTTP POST";
			}
		}
		else{
			$mes = "Upload Failed";
		}
		return $uploadedFile;
	}

	function getUnicName(){
		return md5(uniqid(microtime(true),true));
	}

	function getExtName($filename){
		return strtolower(end(explode(".",$filename)));
	}
?>