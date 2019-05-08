<?php
	include 'db.inc.php';
	session_start();
	if ($_REQUEST['id']) {
		$pid = $_REQUEST['id'];
		$prods=ierg4210_prod_fetchById($pid);
		$catInfo = ierg4210_getCatById($prods[0]['catid']);
		$categorys=ierg4210_cat_fetchall();
		$prodImg=ierg4210_img_fetchbyPId($prods[0]['pid']);
		if(!($prods && is_array($prods)))
			echo "Sorry, the website is still under the development";
	} elseif ($_REQUEST['pid']) {
		$pid = $_REQUEST['pid'];
		$prods=ierg4210_prod_fetchById($pid);
		echo $prods[0]['name'] . "|" . $prods[0]['price'];
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Shopping Mall</title>
	<link href="./style/home.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="script/jquery-1.7.1.min.js"></script>
</head>
<body>
	<div class="main">
		<div class="top"></div>
		<div class="button_container">
			<div class="header_left">
				<a href="product.php?id=<?php echo $pid;?>" target="_blank"><?php echo $prods[0]['name'];?></a>
				<a href="category.php?id=<?php echo $catInfo[0]['catid'];?>" target="_blank"><?php echo $catInfo[0]['name'];?> >&nbsp</a>
				<a href="home.php">Home >&nbsp</a>
			</div>
			<div class="header_right">
				<div class="login_btn">
					<a href="#">Welcome&nbsp;<?php echo $_SESSION['t4210']['em'];?></a>
					<a href="admin.php">&nbsp Admin /&nbsp</a>
					<a href="login_process.php?act=logout">Logout /&nbsp</a>
					<a href="listUserOrders.php">orders</a>
				</div>
				<div class="cart_btn">
					<img src="images/cart.jpg">
					<span>Shopping Cart</span>
					<div class="dropdown_content">
						<ul id="product_list"></ul>
						<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" onsubmit ="return mysubmit(this)">
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="upload" value="1" />
							<input type="hidden" name="business" value="xuezhiboo-facilitator3@gmail.com" />
							<input type="hidden" name="currency_code" value="HKD" />
							<input type="hidden" name="custom" value="0" />
							<input type="hidden" name="invoice" value="0" />

							<input type="submit" name="submitbtn" value="Checkout" /> 
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="product_product_container">
			<img class="product_category_resize" src="images/<?php echo $prodImg[0]['imagePath'];?>" />
			<div class="product_details">
				<h2 id="pName"><?php echo $prods[0]['name'];?></h2>
				<br />
				<h3>Price: </h3><span id="pPrice"><?php echo $prods[0]['price'];?></span>
				<br />
				<h3>Quantity: </h3>
				<input name="number" type="number" id="number" value="1" pattern="^[+]?\d+([.]\d+)?$">
				<div class="product_description">
					<h4>Product Description</h4>
					<p><?php echo $prods[0]['description'];?></p>
				</div>
				<br />
				<button class="buy_btn">Buy</button>
				<button class="addToCart_btn" onclick="addToCart(<?php echo $prods[0]['pid'];?>)">Add to Cart</button>
			</div>
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

	<script type="text/javascript">

		showCart();

		function addToCart(pid)
		{
	        $.ajax({
				type: "GET",
				url: "product.php",
				data: 'pid=' + pid,
				success:function(response) {
					var num = document.getElementById("number").value;
					var keyName = "bat" + pid;

					var info = response.split('|');
					for (var i = 0; i < localStorage.length; i++) {
			            if (localStorage.key(i) == keyName) {
			                //localStorage.removeItem(localStorage.key(i));
			                num = parseInt($.parseJSON(localStorage.getItem(localStorage.key(i))).num) + parseInt(num); 
			            }	
			        }
	    	        var product = { "num": num, "pName": info[0],"pPrice": info[1], "pid": pid, "subTotalPrice": num * parseInt(info[1])};
					var batString = JSON.stringify(product);
					CART.sync("bat"+pid, batString);
					showCart();
				}});
		}

		const CART = {
				async sync(name,bitString){
	                await localStorage.setItem(name, bitString);
            	}
			};

		function showCart()
		{
			var result = "";
			var totalPrice = 0;
			var list = document.getElementById("product_list");

			while (list.firstChild) {
			    list.removeChild(list.firstChild);
			}

			for (var i = 0; i < localStorage.length; i++) 
			{
	            var localValue = localStorage.getItem(localStorage.key(i));
	            console.log(localValue)
	            var key = localStorage.key(i);
	            if (key != "bat"&&key.indexOf("bat")>=0) 
	            {
	                var obj = $.parseJSON(localValue);
	                var id = obj.pid;
	                var num = obj.num;
	                var pName = obj.pName;
	                var price = obj.pPrice;
	                var subTotalPrice = obj.subTotalPrice;
	            }
	            result += "Prod ID: " + id + " quantity: " + num + "Prod price: " + price + " Name: " + pName + "subTotalPrice: " + subTotalPrice;

	            totalPrice += parseInt(subTotalPrice);

		        var item = document.createElement("div");

		        let title = document.createElement('b');
		        title.textContent =id + ": ";
		        title.className = 'title';
		        item.appendChild(title);

		        let name = document.createElement('b');
		        name.textContent =pName + " ";
		        name.className = 'name';
		        item.appendChild(name);

		        let controls = document.createElement('span');
		        controls.className = 'controls';
		        item.appendChild(controls);

		        let plus = document.createElement('button');
		        plus.textContent = ' + ';
		        plus.setAttribute('data-id', id)
		        controls.appendChild(plus);
		        plus.addEventListener('click', incrementCart);
		                
		        let qty = document.createElement('span');
		        qty.textContent = num;
		        controls.appendChild(qty);
		                
		        let minus = document.createElement('button');
		        minus.textContent = ' - ';
		        minus.setAttribute('data-id', id)
		        controls.appendChild(minus);
		        minus.addEventListener('click', decrementCart);

		        let proPrice = document.createElement('b');
		        proPrice.className = 'price';
		        proPrice.textContent = " " + subTotalPrice;
		        controls.appendChild(proPrice);

			    list.appendChild(item);
			}
	    }

        function incrementCart(ev){
            ev.preventDefault();
            let id = parseInt(ev.target.getAttribute('data-id'));
            var keyName = "bat" + id;
            var totalPrice = 0;
            //console.log(ev.target.parentElement.querySelector('b').textContent);
            let pName = ev.target.parentElement.parentElement.querySelector(".name").textContent;
            //console.log(ev.target.parentElement.parentElement.querySelector(".name").textContent);
			for (var i = 0; i < localStorage.length; i++) {
	            if (localStorage.key(i) == keyName) {
	                //localStorage.removeItem(keyName);
	                num = parseInt($.parseJSON(localStorage.getItem(localStorage.key(i))).num) + 1;
	                pPrice = parseFloat($.parseJSON(localStorage.getItem(localStorage.key(i))).pPrice);
	                subTotalPrice = pPrice * num;
	            }
	        }
			var product = { "num": num, "pName": pName,"pPrice": pPrice, "pid": id, "subTotalPrice": subTotalPrice };
	        var batString = JSON.stringify(product);

	        CART.sync("bat"+id, batString);
	        let controls = ev.target.parentElement;
            let qty = controls.querySelector('span');
            let price = controls.querySelector('b');
            for (var i = 0; i < localStorage.length; i++) {
	            if (localStorage.key(i) == keyName) {
	                qty.textContent = $.parseJSON(localStorage.getItem(localStorage.key(i))).num;
	                price.textContent = $.parseJSON(localStorage.getItem(localStorage.key(i))).subTotalPrice;
	            }
	            totalPrice += parseInt($.parseJSON(localStorage.getItem(localStorage.key(i))).subTotalPrice);
	        }
	        document.getElementById("product_list").querySelector('.checkout').textContent = "Checkout $" + totalPrice;
	        //localStorage.setItem("bat"+id, batString);
    	}

    	function decrementCart(ev){
            ev.preventDefault();
            let id = parseInt(ev.target.getAttribute('data-id'));
            var keyName = "bat" + id;
            var totalPrice = 0;
            let pName = ev.target.parentElement.parentElement.querySelector(".name").textContent;
			for (var i = 0; i < localStorage.length; i++) {
	            if (localStorage.key(i) == keyName) {
	                //localStorage.removeItem(keyName);
	                num = parseInt($.parseJSON(localStorage.getItem(localStorage.key(i))).num) - 1;
	                pPrice = parseFloat($.parseJSON(localStorage.getItem(localStorage.key(i))).pPrice);
	                subTotalPrice = pPrice * num;
	            }
	        }
			var product = { "num": num, "pName": pName,"pPrice": pPrice, "pid": id, "subTotalPrice": subTotalPrice };
	        var batString = JSON.stringify(product);

	        CART.sync("bat"+id, batString);
	        let controls = ev.target.parentElement;
            let qty = controls.querySelector('span');
            let price = controls.querySelector('b');
            for (var i = 0; i < localStorage.length; i++) {
	            if (localStorage.key(i) == keyName) {
	                qty.textContent = $.parseJSON(localStorage.getItem(localStorage.key(i))).num;
	                price.textContent = $.parseJSON(localStorage.getItem(localStorage.key(i))).subTotalPrice;
	                if(parseInt($.parseJSON(localStorage.getItem(localStorage.key(i))).num) <= 0)
	                {
	                	document.getElementById('product_list').removeChild(controls.parentElement);
	                	localStorage.removeItem(localStorage.key(i));
	                }
	            }
	            if(localStorage.getItem(localStorage.key(i)) != null)
	            {
			        totalPrice += parseInt($.parseJSON(localStorage.getItem(localStorage.key(i))).subTotalPrice);
			    }
	        }
	        document.getElementById("product_list").querySelector('.checkout').textContent = "Checkout $" + totalPrice;
	        //localStorage.setItem("bat"+id, batString);
    	}

    	function mysubmit(form)
    	{
    		
    		var cart = {};
    		var cart_name = {};
    		var cart_price = {};
    		
    		for (var i = 0; i < localStorage.length; i++) 
			{
	            var localValue = localStorage.getItem(localStorage.key(i));
	            var key = localStorage.key(i);
	            if (key != "bat"&&key.indexOf("bat")>=0) 
	            {
	                var obj = $.parseJSON(localValue);
	                var id = obj.pid;
	                var num = obj.num;
	                var name = obj.pName;
	                var price = obj.pPrice;
	                cart[id.toString()] = num;
	                cart_name[id.toString()] = name;
	                cart_price[id.toString()] = price;
	            }
	        }

    		$.ajax({
			type: "POST",
			url: "checkout_process.php?action=genDigest",
			data: {"cart": cart},
			success:function(response) {
				var result = jQuery.parseJSON(response);
				form.custom.value = result["digest"];
				form.invoice.value = result["invoice"];
				var k = 1;
				for(var key in cart)
				{
					var newItem = document.createElement('input');
					newItem.type="hidden";
					newItem.name="item_name_"+k;
					newItem.value=cart_name[key].toString();
					form.appendChild(newItem);

					var newItem2 = document.createElement('input');
					newItem2.type="hidden";
					newItem2.name="quantity_"+k;
					newItem2.value=cart[key].toString();
					form.appendChild(newItem2);

					var newItem3 = document.createElement('input');
					newItem3.type="hidden";
					newItem3.name="amount_"+k;
					newItem3.value=cart_price[key].toString();
					form.appendChild(newItem3);

					k++;
				}
				form.submit();
				localStorage.clear();
			}});
    		return false;
    	}
	</script>

</body>
</html>