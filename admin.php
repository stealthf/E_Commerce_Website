<?php
    include 'login_process.php';
    session_start();

    if(!validataLogin())
    {
        echo "Please login first";
        header("refresh:1;url=login.php");
        exit();
    }
    if($_SESSION['t4210']['flag'] != 1)
    {
        echo "You are not an admin";
        header("refresh:1;url=home.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin</title>
	<link href="./style/admin.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div class="head">
            <h3 class="head_text fl">Backstage Management System</h3>
    </div>
    <div class="operation_user clearfix">
        <div class="link fr">
            <b>Welcome&nbsp;<?php echo $_SESSION['t4210']['em'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="home.php" class="icon">Home</a><span></span><a href="#" class="icon">Refresh</a><span></span><a href="login_process.php?act=logout" class="icon">Logout</a>
        </div>
    </div>
    <div class="content clearfix">
        <div class="main">
            <div class="cont">
                <div class="title">Backstage Management</div>    
                <iframe frameborder="0" name="mainFrame" width="100%" height="522"></iframe> 
            </div>
        </div>
	<div class="menu">
        <div class="cont">
            <div class="title">Admin</div>
            	<ul class="mList">
                    <li>
                        <h3><span onclick="show('menu1','change1')" id="change1">+</span>Product Management</h3>
                        <dl id="menu1" style="display:none;">
                        	<dd><a href="insertPro.php" target="mainFrame">Add product</a></dd>
                            <dd><a href="listPro.php" target="mainFrame">Product list</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu2','change2')" id="change2">+</span>Category Management</h3>
                        <dl id="menu2" style="display:none;">
                        	<dd><a href="insertCate.php" target="mainFrame">Add category</a></dd>
                            <dd><a href="listCate.php" target="mainFrame">Category list</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu3','change3')" id="change3">+</span>Orders Management</h3>
                        <dl id="menu3" style="display:none;">
                            <dd><a href="listOrders.php" target="mainFrame">Order list</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
    	   function show(number,change){
	    		var menu=document.getElementById(number);
	    		var change=document.getElementById(change);
	    		if(change.innerHTML=="+"){
	    				change.innerHTML="-";
	        	}else{
						change.innerHTML="+";
	            }
    		   if(menu.style.display=='none'){
    	             menu.style.display='';
    		    }else{
    		         menu.style.display='none';
    		    }
        }
    </script>
</body>
</html>