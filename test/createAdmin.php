<?php
	$pass = "admin";
	//$salt = mt_rand();
	$salt = 772421634;
	$password = hash_hmac('sha256', $pass, $salt);
	echo $salt;
	echo "<br />";
	echo $password;
	//INSERT INTO users (email, salt, password, flag) VALUES ("xuezhibo@gmail.com", 772421634, "3dd2a722b80c1ac4ce9f3269eb09f2cf4f65678b19b7ca1be39df2f6191c65b4", 1);
?>