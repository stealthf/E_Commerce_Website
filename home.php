<?php
	include 'db.inc.php';
	$categorys=ierg4210_cat_fetchall();
	if(!($categorys && is_array($categorys)))
	{
		echo "Sorry, the website is still under the development";
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shopping Mall</title>
	<link rel="stylesheet" href="./style/home.css" type="text/css">
	<script type="text/javascript" src="script/jquery-1.7.1.min.js"></script>
	
</head>
<body>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = 'https://connect.facebook.net/zh_CN/sdk.js#xfbml=1&version=v3.2&appId=350986122364746&autoLogAppEvents=1';
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div class="main">
		<div class="top"></div>
		<div class="fb-like" data-href="https://secure.s2.ierg4210.ie.cuhk.edu.hk/Assignment/home.php" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
		<div class="button_container">
			<div class="header_left">
				<a href="home.php">Home</a>
			</div>
			<div class="header_right">
				<div class="login_btn">
					<a href="admin.php">Admin /&nbsp</a>
					<a href="login.php">Login /&nbsp</a>
					<a href="changePass.php">Change password</a>
				</div>
			</div>
		</div>

		<div class="product_container">
			<ul class="product_list_ul">
				<?php foreach($categorys as $category):?>
				<li><a href="category.php?id=<?php echo $category['catid'];?>" target=_"blank"><img class="clothes" src="images/<?php echo $category['name'];?>.jpg" /></a><?php echo $category['name'];?></li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</body>
</html>