<?php
	include 'db.inc.php';
	$id=$_REQUEST['id'];
	$row=ierg4210_getCatById($id);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<h3>Edit Category</h3>
<form action="doAction.php?act=editCate&id=<?php echo $id;?>" method="post">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">Category Name</td>
		<td><input type="text" name="cName" placeholder="<?php echo $row[0]['name'];?>" required="true" pattern="^[\w\- ]+$" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="Edit Category"/></td>
	</tr>
</table>
</form>
</body>
</html>