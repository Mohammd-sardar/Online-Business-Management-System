<?php require_once('../server/app.php');
$getAuth = fetchAuth();
if($getAuth!=null) {
$authId = $getAuth['account_id'];
$authName = $getAuth['account_name'];
$authEmail = $getAuth['account_email'];
$authWallet = $getAuth['wallet'];
}
else {
$authId = null;
$authName = null;
$authEmail = null;
$authWallet = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lazy Shop</title>
<link rel="stylesheet" href="../assets/css/icons.css">
<link rel="stylesheet" href="../assets/css/bootstrap.css">
<link rel="stylesheet" href="../assets/css/app.css">
</head>
<body>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/bootstrap.js"></script>
<script src="../assets/js/icons.js"></script>

<nav class="navbar navbar-expand-lg bg-purple fixed-top navbar-dark text-white mb-5">
<div class="container-fluid ">
<a class="navbar-brand" href="index"><span class="fa fa-shop"></span> Lazy Shop</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navlist" aria-controls="navlist" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navlist">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item">
<a class="nav-link text-white" href="index"><span class="fa fa-home"></span> Home</a>
</li>



<?php 
if(isAuth()){
if($getAuth['role']==='admin'){
?>
<li class="nav-item">
<a class="nav-link text-white" href="products"><span class="fa fa-basket-shopping"></span> Products</a>
</li>
<?php
}
else {
?>
<li class="nav-item">
<a class="nav-link text-white" href="favorite"><span class="fa fa-heart"></span> Favorite</a>
</li>
<li class="nav-item">
<a class="nav-link text-white" href="orders"><span class="fa fa-shopping-cart"></span> Orders</a>
</li>
<?php
}
}
else {
?>
<li class="nav-item">
<a class="nav-link text-white" href="about"><span class="fa fa-address-card"></span> About</a>
</li>
<li class="nav-item">
<a class="nav-link text-white" href="contact"><span class="fa fa-envelope"></span> Contact</a>
</li>
<?php
}
?>
</ul>

<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
<?php 
if(isAuth()){
?>


<?php 
if(checkRole()!='admin'){
?>
<li class="nav-item">
<a class="nav-link text-white" href="addfund">
<span class="fa fa-wallet"></span> $<?=$authWallet;?>
</a>
</li>
<?php
}
?>





<li class="nav-item">
<a class="nav-link text-white" href="profile"><span class="fa fa-user"></span> <?=$authName;?> - 
<?=checkRole();?> <span class="fa fa-shield"></span> </a>
</li>



<li class="nav-item">
<a class="nav-link text-white" href="logout"><span class="fa fa-sign-in-alt"></span> Logout</a>
</li>
<?php
}
else {
?>
<li class="nav-item">
<a class="nav-link text-white" href="login"><span class="fa fa-right-to-bracket"></span> Login</a>
</li>
<li class="nav-item">
<a class="nav-link text-white" href="register"><span class="fa fa-user-plus"></span> Register</a>
</li>
<?php
}
?>

</ul>

</div>
</div>
</nav>
<br><br><br><br>
<div class="container">
<?php 
messagebox();
?>
</div>
























<?php 
$actroute = str_replace('/shopping/app/','',$_SERVER['REQUEST_URI']);

function checkFavoriteIfAlreadyExist($pId){
global $authId;
return countData(" SELECT * FROM favorites WHERE 
productid='{$pId}' AND accountid='{$authId}' ");
}



function productsCard($product){
global $actroute;
?>
<div class="col-6 col-sm-6 col-md-3 col-lg-3 col-xl-3 text-center m-auto">
<a href="productdetail?id=<?=$product['id'];?>" class="card rounded border-0 shadow-sm m-2 ">
<div class="card-header">
<img src="../assets/img/shopposter.png" alt="" class="card-img" 
style="width:100%;height:200px;object-fit:contain">
<h5 class="card-title"><?=$product['productname'];?></h5>
</div>
<div class="card-footer m-2 border-0 rounded">
<?php 
if(isAuth()){
if(checkFavoriteIfAlreadyExist($product['id'])){
?>
<a href="<?=$actroute;?>?removetofavorite=<?=$product['id'];?>" class=" btn btn-danger m-1 btn-sm">
<span class="fa fa-heart-circle-xmark"></span>
</a>
<?php
}
else {
?>
<a href="<?=$actroute;?>?addtofavorite=<?=$product['id'];?>" class=" btn btn-success m-1 btn-sm">
<span class="fa fa-heart-circle-plus"></span>
</a>
<?php
}
?>
<a href="orderform?productid=<?=$product['id'];?>" class="btn btn-warning m-1 btn-sm">
<span class="fa fa-shopping-cart"></span>
</a>
<?php
}
?>
<button class="btn btn-primary btn-sm m-1">$<?=$product['productprice'];?></button>
</div>
</a>
</div>
<?php
}






function addToFavorite($page){
global $authId;
if (isset($_GET['addtofavorite'])) {
$productId = request($_GET['addtofavorite']);
$checkProduct  = countData(" SELECT * FROM products WHERE id='{$productId}' ");
if($checkProduct > 0){
if(checkFavoriteIfAlreadyExist($productId) > 0){
message('Already Added !!','warning');
}
else {
execute(" INSERT INTO favorites(productid,accountid) VALUES('{$productId}','{$authId}'); ");
message('Added To Favorite !!','success');
}
}
else {
 message('Wrong Id !!','danger');
}
redirect($page);
}
}



function removeToFavorite($page){
global $authId;
if (isset($_GET['removetofavorite'])) {
$productId = request($_GET['removetofavorite']);
$checkProduct  = countData(" SELECT * FROM products WHERE id='{$productId}' ");
if($checkProduct > 0){
if(checkFavoriteIfAlreadyExist($productId) > 0){
execute(" DELETE FROM favorites WHERE productid='{$productId}' AND accountid='{$authId}' ");
message('Removed From Favorite !!','success');
}
}
else {
 message('Wrong Id !!','danger');
}
redirect($page);
}
}












