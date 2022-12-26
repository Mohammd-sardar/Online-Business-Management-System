<?php require_once('header.php');
if(checkRole()=='admin'){
redirect('index');
}
?>
<div class="container">

<div class="row">
<div class="col-12 col-sm-11 col-md-8 col-lg-8 m-auto text-center shadow-sm rounded mb-3">
<h3>Your Favorites</h3> 
</div
</div>


<div class="row bg-light shadow rounded text-dark rounded p-2 m-2 text-center"> 
<?php 
$favorites = allData(" SELECT * FROM favorites WHERE accountid='$authId'");
foreach($favorites as $favorite){
$favoriteid = $favorite['id'];
$productid = $favorite['productid'];
$getproduct =  findData(" SELECT * FROM products WHERE id='{$productid}' ");
$productprice = $getproduct['productprice'];
$productname = $getproduct['productname'];
productsCard($getproduct);
}
?>
</div>
</div>


<?php 
addToFavorite('favorite');
removeToFavorite('favorite');
?>
<?php require_once('footer.php');?>