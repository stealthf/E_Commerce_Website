<?php
	include 'db.inc.php';

	$key = $_REQUEST['key'];
	$salt = $_REQUEST['resetkey'];
	if($key && $salt)
	{
		if(!empty(getUser($key)) && $salt == md5(getUser($key)[0]['salt']))
		{
			$initpassword = mt_rand();
			$newpassword = hash_hmac('sha256', $initpassword, getUser($key)[0]['salt']);
			changePass($key, $newpassword);
			$message = $initpassword;
			$subject = "reset password";
			if(mail($key, $subject, $message))
			{
				echo "The reset password sent to your mail box";
			}
		}
	}
?>