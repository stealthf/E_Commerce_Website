<?php
include 'upload.inc.php';

function ierg4210_DB() {
	// connect to the database
	// TODO: change the following path if needed
	// Warning: NEVER put your db in a publicly accessible location
	$db = new PDO('sqlite:/var/www/cart.db');
	
	// enable foreign key support
	$db->query('PRAGMA foreign_keys = ON;');

	// FETCH_ASSOC: 
	// Specifies that the fetch method shall return each row as an
	// array indexed by column name as returned in the corresponding
	// result set. If the result set contains multiple columns with
	// the same name, PDO::FETCH_ASSOC returns only a single value
	// per column name. 
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	return $db;
}

function ierg4210_img_fetchbyPId($pid) {
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM images WHERE pid=?;");
    $q->bindParam(1, $pid);
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_img_fetchall() {
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM images LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_cat_fetchall() {
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM categories LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_prod_fetchall(){
	global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM products LIMIT 100;");
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_getCatById($catid){
	global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM categories WHERE catid=?;");
    $q->bindParam(1, $catid);
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_prod_fetchByCId($catid){
	global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM products WHERE catid=?;");
    $q->bindParam(1, $catid);
    if ($q->execute())
        return $q->fetchAll();
}

function ierg4210_prod_fetchById($pid){
	global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM products WHERE pid=?;");
    $q->bindParam(1, $pid);
    if ($q->execute())
        return $q->fetchALL();
}

function insertCate(){
    global $db;
    $db = ierg4210_DB();
    $arr=$_POST["cName"];
    $nameValidation="/^[\w\- ]+$/";
    if(!preg_match($nameValidation, $arr))
    {
        $mes="invalid category name<br/><a href='insertCate.php'>Add Categtory</a>";
        return $mes;
    }
    $q = $db->prepare("INSERT INTO categories (name) VALUES (?);");
    $q->bindParam(1, $arr);
    if ($q->execute()){
        $mes="Add category successfully!<br/><a href='insertCate.php'>Add Categtory</a>|<a href='listCate.php'>Check Categtory</a>";
    }else{
        $mes="Add category failed!<br/><a href='insertCate.php'>Add Categtory</a>|<a href='listCate.php'>Check Categtory</a>";
    }
    return $mes;
}

function ierg4210_editCate($catid){
    global $db;
    $db = ierg4210_DB();
    $arr=$_POST["cName"];
    $nameValidation="/^[\w\- ]+$/";
    if(!preg_match($nameValidation, $arr))
    {
        $mes="invalid category name<br/><a href='listCate.php'>Edit Categtory</a>";
        return $mes;
    }
    $q = $db->prepare("UPDATE categories SET name=? WHERE catid=?;");
    $q->bindParam(1, $arr);
    $q->bindParam(2, $catid);
    if ($q->execute()){
        $mes="Edit category successfully!<br/><a href='listCate.php'>Check Categtory</a>";
    }else{
        $mes="Edit category failed!<br/><a href='listCate.php'>Edit again</a>";
    }
    return $mes;
}

function ierg4210_delCate($catid){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("DELETE FROM categories WHERE catid=?;");
    $q->bindParam(1, $catid);
    if ($q->execute()){
        $mes="Delete category successfully!<br/><a href='listCate.php'>Check Categtory</a>";
    }else{
        $mes="Delete category failed!<br/><a href='listCate.php'>Edit again</a>";
    }
    return $mes;
}

function insertProduct(){
    global $db;
    $db = ierg4210_DB();
    $uploadFile=uploadFile();
    $catid = $_POST["catid"];
    $name = $_POST["pName"];
    $price = $_POST["price"];
    $desc = $_POST["description"];

    $nameValidation="/^[\w\- ]+$/";
    $priceValidation="/^[+]?\d+([.]\d+)?$/";
    if(!preg_match($nameValidation, $name))
    {
        $mes="invalid product name<br/><a href='insertPro.php'>Add Product</a>";
        return $mes;
    }
    if(!preg_match($priceValidation, $price))
    {
        $mes="invalid product price, please input positive number<br/><a href='insertPro.php'>Add Product</a>";
        return $mes;
    }
    
    $q = $db->prepare("INSERT INTO products (catid, name, price, description) VALUES (?, ?, ?, ?);");
    $q->bindParam(1, $catid);
    $q->bindParam(2, $name);
    $q->bindParam(3, $price);
    $q->bindParam(4, $desc);
    if ($q->execute()){
        $lastId = $db->lastInsertId();
        $imagePath = $uploadFile['name'];
        insertImage($lastId, $imagePath);
        $mes="<p>Add successfully!</p><a href='insertPro.php' target='mainFrame'>Add Porduct</a>|<a href='listPro.php' target='mainFrame'>Product list</a>";
    }else{
        if(file_exists("images/".$uploadFile['name'])){
            unlink("images/".$uploadFile['name']);
        }
        $mes="<p>Add Failed!</p><a href='insertPro.php' target='mainFrame'>Add again</a>";
    }
    return $mes;
}

function insertImage($pid, $path){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("INSERT INTO images (pid, imagePath) VALUES (?, ?);");
    $q->bindParam(1, $pid);
    $q->bindParam(2, $path);
    if ($q->execute())
        return $q->fetchALL();
}

function getTotalProd(){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT COUNT(*) as count FROM products;");
    if ($q->execute())
        return $q->fetchALL();
}

function getTotalCate(){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT COUNT(*) as count FROM categories;");
    if ($q->execute())
        return $q->fetchALL();
}

function getCateByPage($offset, $pageSize){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM categories order by catid asc limit {$offset},{$pageSize};");
    if ($q->execute())
        return $q->fetchALL();
}

function editProduct($pid){
    global $db;
    $db = ierg4210_DB();
    
    $catid = $_POST["catid"];
    $name = $_POST["pName"];
    $price = $_POST["price"];
    $desc = $_POST["description"];

    $nameValidation="/^[\w\- ]+$/";
    $priceValidation="^[+]?\d+([.]\d+)?$";
    if(!preg_match($nameValidation, $arr))
    {
        $mes="invalid product name<br/><a href='listPro.php'>Edit Product</a>";
        return $mes;
    }
    if(!preg_match($priceValidation, $price))
    {
        $mes="invalid product price, please input positive number<br/><a href='listPro.php'>Edit Categtory</a>";
        return $mes;
    }
    
    $q = $db->prepare("UPDATE products SET catid=?, name=?, price=?, description=? WHERE pid=?;");
    $q->bindParam(1, $catid);
    $q->bindParam(2, $name);
    $q->bindParam(3, $price);
    $q->bindParam(4, $desc);
    $q->bindParam(5, $pid);

    $uploadFile=uploadFile();

    if ($q->execute()){
        if($uploadFile){
            $imagePath = $uploadFile['name'];
            updateImage($pid, $imagePath);
        }
        $mes="<p>Edit successfully!</p><a href='listPro.php' target='mainFrame'>Product list</a>";
    }else{
        if($uploadFile){
            if(file_exists("images/".$uploadFile['name'])){
                unlink("images/".$uploadFile['name']);
            }
        }
        $mes="<p>Edit Failed!</p><a href='editPro.php' target='mainFrame'>Edit again</a>";
    }
    return $mes;
}

function updateImage($pid, $path){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("UPDATE images SET imagePath=? WHERE pid=?;");
    $q->bindParam(1, $path);
    $q->bindParam(2, $pid);
    if ($q->execute())
        return $q->fetchALL();
}

function delProduct($pid){
    global $db;
    $db = ierg4210_DB();
    $prodImg=ierg4210_img_fetchbyPId($pid);
    if($prodImg){
        if(file_exists("images/".$prodImg[0]['imagePath'])){
            unlink("images/".$prodImg[0]['imagePath']);
        }
    }
    delImage($pid);
    $q = $db->prepare("DELETE FROM products WHERE pid=?;");
    $q->bindParam(1, $pid);
    if ($q->execute()){
        $mes="delete successfully!<br/><a href='listPro.php' target='mainFrame'>Check Product</a>";
    }else{
        $mes="delete failed!<br/><a href='listPro.php' target='mainFrame'>delete again</a>";
    }
    return $mes;
}

function delImage($pid){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("DELETE FROM images WHERE pid=?;");
    $q->bindParam(1, $pid);
    $q->execute();
}

function getUser($email){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM users WHERE email=?;");
    $q->bindParam(1, $email);
    if ($q->execute())
        return $q->fetchAll();
}

function checkUser($email, $password){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM users WHERE email=? AND password=?;");
    $q->bindParam(1, $email);
    $q->bindParam(2, $password);
    if ($q->execute())
        return $q->fetchAll();
}

function insertUser($email, $salt, $password){
    global $db;
    $db = ierg4210_DB();
    $flag = 0;
    $q = $db->prepare("INSERT INTO users (email, salt, password, flag) VALUES (?, ?, ?, ?);");
    $q->bindParam(1, $email);
    $q->bindParam(2, $salt);
    $q->bindParam(3, $password);
    $q->bindParam(4, $flag);
    if ($q->execute()){
        $mes="register successfully!<br/><a href='login.php' target='mainFrame'>Login</a>";
    }else{
        $mes="register failed!<br/><a href='register.php' target='mainFrame'>register again</a>";
    }
    return $mes;
}

function changePass($email, $newpassword){
    global $db;
    $db = ierg4210_DB();
    
    $q = $db->prepare("UPDATE users SET password=? WHERE email=?;");
    $q->bindParam(1, $newpassword);
    $q->bindParam(2, $email);
    if ($q->execute()){
        $mes="change password successfully!";
    }else{
        $mes="change password failed!<br/><a href='changePass.php' target='mainFrame'>change again</a>";
    }
    return $mes;
}

function insertDigest($user, $cart_info, $totalPrice){
    global $db;
    $db = ierg4210_DB();

    $currency = "HKD";
    $email = "xuezhiboo-facilitator3@gmail.com";
    $salt = mt_rand();
    $digest = sha1($currency.$email.$salt.$cart_info.$totalPrice);

    $trac = "notyet";
    $returnval = json_encode(array("err"=>"err"));
    
    $q = $db->prepare("INSERT INTO orders (user, digest, salt, transactionid) VALUES (?, ?, ?, ?);");
    $q->bindParam(1, $user);
    $q->bindParam(2, $digest);
    $q->bindParam(3, $salt);
    $q->bindParam(4, $trac);
    if ($q->execute(array($user,$digest,$salt,$trac))){
        $invoice = $db->lastInsertId();
        $returnval = json_encode(array("digest"=>$digest,"invoice"=>$invoice));
    }

    return $returnval;
}

function getOrders(){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM orders;");
    if ($q->execute())
        return $q->fetchAll();
}

function getUserOrders($user){
    global $db;
    $db = ierg4210_DB();
    $q = $db->prepare("SELECT * FROM orders WHERE user = ?;");
    $q->bindParam(1, $user);
    if ($q->execute())
        return $q->fetchAll();
}
?>