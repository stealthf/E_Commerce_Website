<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<h3>Add Category</h3>
<form action="admin_process.php?act=insertCate" method="post">
<table width="70%" border="1" cellpadding="5" cellspacing="0" bgcolor="#cccccc">
	<tr>
		<td align="right">Category Name</td>
		<td><input type="text" name="cName" placeholder="Please input the category name" required="true" pattern="/^[\w\- ]+$/" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit"  value="Add Category"/></td>
	</tr>
</table>
</form>
</body>
</html>