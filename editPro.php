<?php 
	include 'db.inc.php';
	$categorys=ierg4210_cat_fetchall();
	if(!($categorys && is_array($categorys)))
		echo "Sorry, there is no category";
	$id=$_REQUEST['id'];
	$prodInfo=ierg4210_prod_fetchById($id);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link href="./style/common.css"  rel="stylesheet"  type="text/css">
		<script type="text/javascript" src="./script/jquery-1.6.4.js"></script>
	</head>
	<body>
		<h3>Edit Product</h3>
		<form action="admin_process.php?act=editPro&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
			<table width="70%"  border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
				<tr>
					<td align="right">Product Name</td>
					<td><input type="text" name="pName"  placeholder="<?php echo $prodInfo[0]['name'];?>" required="true"pattern="^[\w\- ]+$" /></td>
				</tr>
				<tr>
					<td align="right">Category</td>
					<td>
					<select name="catid">
						<?php foreach($categorys as $category):?>
						<option value="<?php echo $category['catid'];?>"><?php echo $category['name'];?></option>
						<?php endforeach;?>
					</select>
					</td>
				</tr>
				<tr>
					<td align="right">Price</td>
					<td><input type="text" name="price"  placeholder="<?php echo $prodInfo[0]['price'];?>" required="true" pattern="^[+]?\d+([.]\d+)?$" /></td>
				</tr>
				<tr>
					<td align="right">Description</td>
					<td>
						<textarea name="description" style="width:100%;height:150px;" placeholder="<?php echo $prodInfo[0]['description'];?>"></textarea>
					</td>
				</tr>
				<tr>
					<td align="right">Image</td>
					<td>
						<input type="file"  name="myFile"  /><br/>
						<div id="attachList" class="clear"></div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit"  value="Submit"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>