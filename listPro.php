<?php
	include 'db.inc.php';
	$rows=ierg4210_prod_fetchall();
	//$totalProd=getTotalProd()[0]['count'];
	if(!($rows))
		echo "There is no category";
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Insert title here</title>
		<link rel="stylesheet" href="./style/admin.css">
		<link rel="stylesheet" href="./style/jquery-ui-1.10.4.custom.css">
		<script type="text/javascript" src="./script/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="./script/jquery-ui-1.10.4.custom.js"></script>
		<script type="text/javascript" src="./script/jquery-ui-1.10.4.custom.min.js"></script>
	</head>
	<body>
		<div id="checkPro"  style="display:none;">
		</div>
		<div class="details">
            <div class="details_operation clearfix">
                <div class="bui_select">
                    <input type="button" value="Add" class="add"  onclick="addProd()">
                </div>            
            </div>
            <table class="table" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th width="15%">id</th>
                        <th width="25%">Product Name</th>
                        <th width="25%">Category</th>
                        <th>Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $row):?>
                        <tr>
                            <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['pid'];?></label></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php 
                            	$catName=ierg4210_getCatById($row['catid'])[0]['name'];
                            	echo $catName;
                            ?></td>
                            <td align="center">
                            	<input type="button" value="detail" class="btn" onclick="checkPro(<?php echo $row['pid'];?>,'<?php echo $row['name'];?>')">
                            	<input type="button" value="edit" class="btn" onclick="editPro(<?php echo $row['pid'];?>)">
                            	<input type="button" value="delete" class="btn"onclick="delPro(<?php echo $row['pid'];?>)">
                            	<div id="checkPro<?php echo $row['pid'];?>" style="display:none;">
					            <table class="table" cellspacing="0" cellpadding="0">
					                <tr>
					                    <td width="20%" align="right">Product Name</td>
					                    <td><?php echo $row['name'];?></td>
					                </tr>
					                <tr>
					                    <td width="20%"  align="right">Category</td>
					                    <td><?php echo ierg4210_getCatById($row['catid'])[0]['name'];?></td>
					                </tr>
					                <tr>
					                    <td  width="20%"  align="right">Price</td>
					                    <td><?php echo $row['price'];?></td>
					                </tr>
					                <tr>
					                    <td width="20%"  align="right">Picture</td>
					                    <td>
					                    	<?php
					                    		$prodImg=ierg4210_img_fetchbyPId($row['pid']);
					                    	?>
					                    	<img width="200" height="200" src="images/<?php echo $prodImg[0]['imagePath'];?>" alt=""/>
					                	</td>
					                </tr>
					                <tr>
					                    <td  width="20%"  align="right">Description</td>
					                    <td><?php echo $row['description'];?></td>
					                </tr>
					            </table>
					            </div>
                            </td>
                        </tr>
                    <?php endforeach;?>  
                </tbody>
            </table>
        </div>
		<script type="text/javascript">
			function checkPro(id,title){
				$("#checkPro"+id).dialog({
				  height:"auto",
			      width: "100%",
			      modal:false,
			      title:"Product Name: "+title,
			      show:"slide"
				});
			}
			function editPro(id){
				window.location="editPro.php?id="+id;
			}
			function delPro(id){
				window.location="admin_process.php?act=delPro&id="+id;
			}
			function addProd(){
				window.location="insertPro.php";
			}
		</script>
	</body>
</html>