<?php
	include 'csrf_process.php';
	session_start();
?>
<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link type="text/css" rel="stylesheet" href="./style/login.css">
	<script type="text/javascript" src="script/jquery-1.7.1.min.js"></script>
	</head>

<body>
	<script>
		window.fbAsyncInit = function() {
		FB.init({
		  appId      : '{350986122364746}',
		  cookie     : true,
		  xfbml      : true,
		  version    : '{v3.2}'
		});
		  
		FB.AppEvents.logPageView();   
		  
		};

		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v3.2&appId=350986122364746&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		function statusChangeCallback(response) {
            if (response.status === 'connected') {
                FB.api('/me', function (response) {
                    $.ajax({
						type: "POST",
						url: "login_process.php?act=setCookies",
						data: 'name=' + response.name,
						success:function(newresponse) {
							window.location.href = "home.php";
						}});	
                });
            }
            else{
            	$.ajax({
					type: "POST",
					url: "login_process.php?act=logout",
					data: 'name=' + response.name,
					success:function(newresponse) {
						window.location.href = "home.php";
					}});	
            }
        }

		function checkLoginState() {
			FB.getLoginStatus(function(response) {
				statusChangeCallback(response);
			});
		}
		
	</script>
<div class="headerBar">
	<div class="logoBar login_logo">
		<div class="comWidth">
			<div class="home_button">
				<a href="home.php">Home</a>
			</div>
			<div class="reg_button">
				<a href="register.php">Register</a>
			</div>
		</div>
	</div>
</div>

<div class="loginBox">
	<div class="login_cont">
	<form action="login_process.php?act=<?php echo ($action = 'login'); ?>" method="post">
			<ul class="login">
				<div class="l_tit">Email Address</div>
				<div class="mb_10"><input type="email"  name="email" placeholder="Please input your email address"class="login_input user_icon" required /></div>
				<div class="l_tit">password</div>
				<div class="mb_10"><input type="password"  name="password" class="login_input password_icon" required /></div>
				<input type="hidden" name="nonce" value="<?php echo csrf_getNonce($action); ?>" />
				<div><input type="submit" value="Login" class="login_btn"></div>
				<br>
				<fb:login-button scope="public_profile,email" data-auto-logout-link="true" onlogin="checkLoginState();"> </fb:login-button>
				<div><a href="resetPassword.php" class="login_btn">Forget Password</div>
			</ul>
		</form>
	</div>
</div>
</body>
</html>
