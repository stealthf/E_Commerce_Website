<?php
	include 'db.inc.php';
	session_start();
	$catid = $_REQUEST['id'];
	$catInfo = ierg4210_getCatById($catid);	
	$categorys=ierg4210_cat_fetchall();
	$prods=ierg4210_prod_fetchByCId($catid);
	if(!($prods && is_array($prods)))
		echo "Sorry, the website is still under the development";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shopping Mall</title>
	<link type="text/css" rel="stylesheet" href="./style/home.css">
</head>
<body>
	<div class="main">
		<div class="top"></div>
		<div class="button_container">
			<div class="header_left">
				<a href="category.php?id=<?php echo $catid;?>" target="_blank"><?php echo $catInfo[0]['name'];?></a>
				<a href="home.php">Home >&nbsp</a>
			</div>
			<div class="header_right">
				<div class="login_btn">
					<a href="#">Welcome&nbsp;<?php echo $_SESSION['t4210']['em'];?></a>
					<a href="admin.php">&nbsp Admin /&nbsp</a>
					<a href="login_process.php?act=logout">Logout</a>
				</div>
			</div>
		</div>
		<div class="category_product_container">
			<ul class="product_list_ul">
				<?php foreach($prods as $prod):
					$prodImg=ierg4210_img_fetchbyPId($prod['pid']);
				?>
				<li><a href="product.php?id=<?php echo $prod['pid'];?>" target=_"blank"><img class="clothes" src="images/<?php echo $prodImg[0]['imagePath'];?>" /></a><p><?php echo $prod['name'];?></p><span>$<?php echo $prod['price'];?></span></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="category_list">
			<p>Category List</p>
			<div class="category_list_container">
				<?php foreach($categorys as $category):?>
				<a href="category.php?id=<?php echo $category['catid'];?>" target=_"blank""><?php echo $category['name'];?></a>
				<?php endforeach;?>
			</div>
		</div>
	</div>

</body>
</html>