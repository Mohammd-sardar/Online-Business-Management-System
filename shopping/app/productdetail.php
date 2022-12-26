<?php require_once('header.php');
if(checkRole()=='admin'){
redirect('index');
}

$productId = request($_GET['id']);
$sql = " SELECT * FROM products WHERE id='{$productId}' ";
$checkproduct  = countData($sql);
$getproduct  = findData($sql);
if($checkproduct === 0){
redirect('index');
}
?>
<div class="container">
<div class="row bg-light shadow rounded text-dark rounded p-2 m-2 text-center mt-2"> 


<button class="btn btn-info text-light p-1 m-1" style="width:50px;"
onclick="window.history.back()">
<span class="fa fa-arrow-left"></span>
</button>


<div class="col-12 col-sm-112 col-md-12 col-lg-12 m-auto text-center">
<h3><?=$getproduct['productname'];?></h3> 
</div>

<hr>

<div class="col-11 col-sm-11 col-md-6 col-lg-4 col-xl-4 m-auto text-center mt-2 p-2 rounded">
<img src="../assets/img/shopposter.png" alt="" class="card-img" 
style="width:100%;height:100%;object-fit:contain">
</div>

<div class="col-11 col-sm-11 col-md-6 col-lg-8 col-xl-8 m-auto text-center p-2 rounded mt-5">
<h4>Price: $<?=$getproduct['productprice'];?></h4>
<h4>Quantity: <?=$getproduct['productquantity'];?></h4>
<h4>Detail: </h4>
<p>.......</p>
</div>



<div class="footer">
<?php 
if(checkFavoriteIfAlreadyExist($getproduct['id'])){
?>
<a href="productdetail?removetofavorite=<?=$getproduct['id'];?>&id=<?=$getproduct['id'];?>" class=" btn btn-danger m-1 btn-sm">
<span class="fa fa-heart-circle-xmark"></span>
</a>
<?php
}
else {
?>
<a href="productdetail?addtofavorite=<?=$getproduct['id'];?>&id=<?=$getproduct['id'];?>" class=" btn btn-success m-1 btn-sm">
<span class="fa fa-heart-circle-plus"></span>
</a>
<?php
}
?>
<a href="orderform?productid=<?=$getproduct['id'];?>&id=<?=$getproduct['id'];?>" class="btn btn-warning m-1 btn-sm">
<span class="fa fa-shopping-cart"></span>
</a>
</div>


</div>
</div>

<?php 
addToFavorite('productdetail?id='.$productId);
removeToFavorite('productdetail?id='.$productId);
?>
<?php require_once('footer.php');?>