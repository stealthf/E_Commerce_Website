<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link type="text/css" rel="stylesheet" href="./style/login.css">
	</head>

<body>
<div class="headerBar">
	<div class="logoBar login_logo">
		<div class="comWidth">
			<div class="home_button">
				<a href="home.php">Home</a>
			</div>
			<div class="reg_button">
				<a href="login.php">Login</a>
			</div>
		</div>
	</div>
</div>

<div class="loginBox">
	<div class="login_cont">
	<form action="login_process.php?act=<?php echo ($action = 'changePass'); ?>" method="post">
			<ul class="login">
				<div class="l_tit">Email Address</div>
				<div class="mb_10"><input type="email"  name="email" placeholder="Please input your email address"class="login_input user_icon" required="true" /></div>
				<div class="l_tit">old password</div>
				<div class="mb_10"><input type="password"  name="oldpassword" class="login_input password_icon" required="true" /></div>
				<div class="l_tit">new password</div>
				<div class="mb_10"><input type="password"  name="newpassword" class="login_input password_icon" required="true" /></div>
				<div><input type="submit" value="change password" class="login_btn"></div>
			</ul>
		</form>
	</div>
</div>
</body>
</html>
