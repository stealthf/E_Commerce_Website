<?php
	include 'db.inc.php';
	$rows=getOrders();
	if(!($rows))
		echo "There is no orders";
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
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th width="15%">oid</th>
                        <th width="25%">users</th>
                        <th width="25%">digest</th>
                        <th width="25%">transactionid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $row):?>
                        <tr>
                            <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['oid'];?></label></td>
                            <td><?php echo $row['user'];?></td>
                            <td><?php echo $row['digest'];?></td>
                            <td><?php echo $row['transactionid'];?></td>
                        </tr>
                    <?php endforeach;?>  
                </tbody>
            </table>
        </div>
	</body>
</html>