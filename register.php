<?php
	include 'csrf_process.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Register</title>
<link type="text/css" rel="stylesheet" href="./style/login.css">
</head>

<body>
<div class="headerBar">
	<div class="logoBar red_logo">
		<div class="comWidth">
			<h3 class="welcome_title">Welcome Register</h3>
			<div class="reg_button">
				<a href="home.php">Home</a>
			</div>
		</div>
	</div>
</div>

<div class="regBox">
	<div class="login_cont">
	<form action="login_process.php?act=<?php echo ($action = 'reg'); ?>" method="post">
			<ul class="login">
				<div class="l_tit">Email Address</div>
				<div class="mb_10"><input type="email"  name="email" placeholder="Please input your email address"class="login_input user_icon" required /></div>
				<div class="l_tit">password</div>
				<div class="mb_10"><input type="password"  name="password" class="login_input password_icon" required /></div>
				<div><input type="submit" value="Register" class="reg_btn"></div>
			</ul>
		</form>
	</div>
</div>
</body>
</html>
