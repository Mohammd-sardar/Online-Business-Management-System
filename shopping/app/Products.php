<?php require_once('header.php');
if(checkRole()!='admin'){
redirect('index');
}
?>
<div class="container">


<div class="row rounded p-2 m-2 text-center"> 

<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 m-auto text-center shadow-sm rounded p-1">
<a href="products" class="float-start text-light bg-purple rounded p-1">Products</a> 
<a href="?add" class="btn btn-success btn-sm float-end"><span class="fa fa-plus"></span> Add Product </a>
</div>


<?php 
if(isset($_GET['add'])){
?>
<div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-6 m-auto text-center shadow-sm rounded mt-4">
<h4>Add Product</h4>
<form action="products" method="POST" class="m-2">

<div class="form-group text-start">
<label class="">Product Name: <span class="fa fa-pen"></span></label>
<input type="text" class="form-control text-center p-2 rounded" required 
placeholder="Product Name" name="productname">
</div>

<div class="form-group text-start">
<label class="">Product Price: <span class="fa fa-dollar"></span></label>
<input type="number" min="0" class="form-control text-center p-2 rounded" required 
placeholder="Product Price" name="productprice">
</div>

<div class="form-group text-start">
<label class="">Product Quantity: <span class="fa fa-list-ol"></span></label>
<input type="number" min="0" class="form-control text-center p-2 rounded" required 
placeholder="Product Quantity" name="productquantity" value="0">
</div>

<button class="btn btn-success btn-lg m-1" name="addproduct"> <span class="fa fa-plus"></span> Add Product</button>
</form>
</div>
<?php
}
elseif(isset($_GET['editproduct'])) {
$productId = request($_GET['editproduct']);
$checkProduct  = countData(" SELECT * FROM products WHERE id='{$productId}' ");
if($checkProduct < 1 ){
redirect('products');
}
else {
$getProduct  = findData(" SELECT * FROM products WHERE id='{$productId}' ");
?>
<div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-6 m-auto text-center shadow-sm rounded mt-4">
<h4>Edit Product</h4>
<form action="products" method="POST" class="m-2">
<input type="hidden" readonly name="productid" value="<?=$getProduct['id'];?>" required>
<div class="form-group text-start">
<label class="">Product Name: <span class="fa fa-pen"></span></label>
<input type="text" class="form-control text-center p-2 rounded" required 
placeholder="Product Name" name="productname" value="<?=$getProduct['productname'];?>">
</div>

<div class="form-group text-start">
<label class="">Product Price: <span class="fa fa-dollar"></span></label>
<input type="number" min="0" class="form-control text-center p-2 rounded" required 
placeholder="Product Price" name="productprice" value="<?=$getProduct['productprice'];?>">
</div>

<div class="form-group text-start">
<label class="">Product Quantity: <span class="fa fa-list-ol"></span></label>
<input type="number" min="0" class="form-control text-center p-2 rounded" required 
placeholder="Product Quantity" name="productquantity" value="<?=$getProduct['productquantity'];?>">
</div>

<button class="btn btn-warning btn-lg m-1" name="changeproduct"> <span class="fa fa-pen"></span> Edit Product</button>
</form>
</div>
<?php
}
}
?>

<div class="table-responsive mt-4">
<table class="table table-bordered table-hover text-center">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Price</th>
<th>Quantity</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php 
$allproducts = allData(" SELECT * FROM products ORDER BY id DESC ");
foreach($allproducts as $product){
?>
<tr>
<td><?=$product['id'];?></td>
<td><?=$product['productname'];?></td>
<td><?=$product['productprice'];?></td>
<td><?=$product['productquantity'];?></td>
<td>
   <a href="products?editproduct=<?=$product['id'];?>" class=" btn btn-sm btn-warning">
   <span class="fa fa-pen"></span>  Edit 
</a>
<a href="products?deleteproduct=<?=$product['id'];?>" class=" btn btn-sm btn-danger">
<span class="fa fa-pen"></span>  Delete 
</a>



</td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>


</div>



</div>
<?php 
if (isset($_POST['addproduct'])) {
$productname = request($_POST['productname']);
$productprice = request($_POST['productprice']);
$productquantity = request($_POST['productquantity']);
execute(" INSERT INTO products(productname,productprice,productquantity) 
VALUES('{$productname}','{$productprice}','{$productquantity}'); ");
message('Created!!','success');
redirect('products');
}


if (isset($_POST['changeproduct'])) {
    $productid = request($_POST['productid']);
    $productname = request($_POST['productname']);
    $productprice = request($_POST['productprice']);
    $productquantity = request($_POST['productquantity']);
    execute(" UPDATE products SET 
    productname='{$productname}' , productprice='{$productprice}' , productquantity='{$productquantity}' 
    WHERE id='{$productid}'  ");
    message('Updated!!','warning');
    redirect('products');
    }

if (isset($_GET['deleteproduct'])) {
$productId = request($_GET['deleteproduct']);
$checkProduct  = countData(" SELECT * FROM products WHERE id='{$productId}' ");
if($checkProduct > 0){
execute(" DELETE FROM products WHERE id='{$productId}' ");
message('Deleted!!','danger');
}
redirect('products');
}
?>
<?php require_once('footer.php');?>