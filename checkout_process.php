<?php
	include 'db.inc.php';
	session_start();
	$act = $_REQUEST['action'];
	if($act == 'genDigest')
	{
		echo genDigest();
	}

	function genDigest()
	{
		$cart_info = json_decode($_POST['cart'], true);
		$totalPrice = 0;
		$cart_information = "";
		foreach($cart_info as $key => $value)
		{
			$prod = ierg4210_prod_fetchById($key);
			$price = $prod[0]['price'];
			$subTotalPrice = (float)$price * (int)$value;
			$totalPrice += $subTotalPrice;
			$prod1 = $prod[0]['name'].'&'.$value.'&'.$subTotalPrice.'|';
			$cart_information .= $prod1;
		}
		return insertDigest($_SESSION['t4210']['em'], substr($cart_information, 0, -1), $totalPrice);
	}
?>