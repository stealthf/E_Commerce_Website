<?php
	include 'db.inc.php';
	include 'csrf_process.php';
	session_start();

	$act=$_REQUEST['act'];
	if($act=='login'){
		checkLogin();
	}elseif($act=='reg'){
		register();
	}elseif($act=='logout'){
		logout();
	}elseif($act=='changePass'){
		changePassword();
	}elseif($act=='setCookies'){
		setCookies($_POST['name']);
	}elseif($act=='resetPassword'){
		resetPassword();
	}

	/*if(!csrf_verifyNonce($act, $_POST['nonce']))
	{
		echo "csrf attack";
		header("refresh:1;url=login.php");
		exit();
	}*/

	function checkLogin()
	{
		//$emailValidation = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/";
		$email = $_POST['email'];
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$salt = getUser($sanitized_email)[0]['salt'];
		$password = hash_hmac('sha256', $_POST['password'], $salt);
		
		if(empty($sanitized_email) || empty($password))
		{
			echo "please input email address and password";
			header("refresh:1;url=login.php");
			exit();
		}else
		{
			if(!filter_var($sanitized_email, FILTER_VALIDATE_EMAIL))
			{
				echo "this eamil address is not valid";
				header("refresh:1;url=login.php");
				exit();
			}
		}
		if(checkUser($sanitized_email, $password))
		{
			echo "login successfully";
			$exp = time() + 3600 * 24 * 3;
			$token = array(
				'em'=>getUser($sanitized_email)[0]['email'],
				'flag'=>getUser($sanitized_email)[0]['flag'],
				'exp'=>$exp,
				'k'=>hash_hmac('sha1', $exp.getUser($sanitized_email)[0]['password'], getUser($sanitized_email)[0]['salt'])
			);
			setcookie('t4210', json_encode($token), $exp, '', '', false, true);
			$_SESSION['t4210'] = $token;
			if(getUser($sanitized_email)[0]['flag']==1)
				header("location:admin.php");
			if(getUser($sanitized_email)[0]['flag']==0)
				header("location:home.php");
			exit();
		}
		else
		{
			echo "invalid email or password";
			header("refresh:1;url=login.php");
			exit();
		}
		
	}

	function validataLogin()
	{
		if(!empty($_SESSION['t4210']))
			return $_SESSION['t4210'];
		if(!empty($_COOKIE['t4210']))
		{
			if($t = json_decode(stripslashes($_COOKIE['t4210']), true))
			{
				if(time() > $t['exp'])
					return false;
				if($r=getUser($t['em']))
				{
					$realk = hash_hmac('sha1', $t['exp'].$r[0]['password'], $r[0]['salt']);
					if($realk == $t['k'])
					{
						$_SESSION['t4210'] = $t;
						return $t['em'];
					}
				}
			}
		}
		return false;
	}

	function register()
	{
		//$emailValidation = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/";
		$email = $_POST['email'];
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$salt = mt_rand();
		$password = hash_hmac('sha256', $_POST['password'], $salt);
		if(!filter_var($sanitized_email, FILTER_VALIDATE_EMAIL))
		{
			echo "this eamil address is not valid";
			header("refresh:1;url=register.php");
			exit();
		}
		if(!empty(getUser($sanitized_email)))
		{
			echo "this email address was registered";
			header("refresh:1;url=register.php");
			exit();
		}
		$mes = insertUser($sanitized_email, $salt, $password);
		echo $mes;
	}

	function logout()
	{
		$_SESSION = array();
		if(isset($_COOKIE['t4210'])){
			setcookie('t4210',"",time()-1);
		}
		session_destroy();
		header("location:home.php");
	}

	function changePassword()
	{
		$email = $_POST['email'];
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$salt = getUser($sanitized_email)[0]['salt'];
		$oldpassword = hash_hmac('sha256', $_POST['oldpassword'], $salt);
		$newpassword = hash_hmac('sha256', $_POST['newpassword'], $salt);
		if(empty($sanitized_email) || empty($oldpassword) || empty($newpassword))
		{
			echo "please input email address and password";
			header("refresh:1;url=changePass.php");
			exit();
		}
		if(checkUser($sanitized_email, $oldpassword))
		{
			$mes = changePass($sanitized_email, $newpassword);
			echo $mes;
			logout();
		}else{
			echo "wrong email or original password";
			header("refresh:1;url=changePass.php");
		}
	}

	function setCookies($name)
	{
	    $exp = time() + 3600 * 24 * 3;
		$token = array(
			'em'=>$name,
			'exp'=>$exp,
		);
		setcookie('t4210', json_encode($token), $exp, '', '', false, true);
		$_SESSION['t4210'] = $token;
		return $token;
	}

	function resetPassword()
	{
		$email = $_POST['email'];
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$salt = getUser($sanitized_email)[0]['salt'];
		$resetkey = md5($salt);
		if(!empty(getUser($sanitized_email)))
		{
			$message = "https://secure.s2.ierg4210.ie.cuhk.edu.hk/Assignment/newPassword.php?key=".$sanitized_email."&resetkey=".$resetkey;
			$subject = "reset password";
			if(mail($sanitized_email, $subject, $message))
			{
				echo "The reset email sent to your mail box";
			}

		}
		else
			echo $sanitized_email." is not registered";
	}
?>