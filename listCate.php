<?php
	include 'db.inc.php';
	$rows=ierg4210_cat_fetchall();
	if(!($rows))
		echo "There is no category";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Insert title here</title>
		<link rel="stylesheet" href="./style/admin.css">
	</head>
	<body>
		<div class="details">
            <div class="details_operation clearfix">
                <div class="bui_select">
                    <input type="button" value="Add" class="add"  onclick="addCate()">
                </div>            
            </div>
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th width="15%">id</th>
                        <th width="25%">Category Name</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $row):?>
                        <tr>
                            <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['catid'];?></label></td>
                            <td><?php echo $row['name'];?></td>
                            <td align="center"><input type="button" value="edit" class="btn" onclick="editCate(<?php echo $row['catid'];?>)"><input type="button" value="delete" class="btn"  onclick="delCate(<?php echo $row['catid'];?>)"></td>
                        </tr>
                    <?php endforeach;?>  
                </tbody>
            </table>
        </div>
		<script type="text/javascript">
			function editCate(id){
				window.location="editCate.php?id="+id;
			}
			function delCate(id){
				window.location="admin_process.php?act=delCate&id="+id;
			}
			function addCate(){
				window.location="insertCate.php";
			}
		</script>
	</body>
</html>