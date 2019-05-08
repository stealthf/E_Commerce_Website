<?php
	include 'db.inc.php';
	$proId = intval($_POST['pid']);
	$number = intval($_POST['number']);
	$price = ierg4210_prod_fetchById($proId)[0]['price'];