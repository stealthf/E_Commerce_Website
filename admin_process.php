<?php
	include 'db.inc.php';

	$id=$_REQUEST['id'];
	$act=$_REQUEST['act'];
	if($act=='insertCate'){
		$mes=insertCate();
	}elseif($act=='editCate'){
		$mes=ierg4210_editCate($id);
	}elseif($act=='delCate'){
		$mes=ierg4210_delCate($id);
	}elseif($act=='insertPro'){
		$mes=insertProduct();
	}elseif($act=='editPro'){
		$mes=editProduct($id);
	}elseif($act=='delPro'){
		$mes=delProduct($id);
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php 
	if($mes){
		print_r($mes);
	}
?>
</body>
</html>