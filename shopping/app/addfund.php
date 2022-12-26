<?php require_once('header.php');
if(checkRole()=='admin'){
redirect('index');
}
?>
<div class="container">
<div class="row bg-light shadow rounded text-dark rounded p-2 m-2 text-center mt-2"> 


<div class="col-12 col-sm-11 col-md-8 col-lg-8 m-auto text-center">
<h3>Add Fund</h3> 
</div>



<div class="col-12 col-sm-11 col-md-6 col-lg-6 m-auto text-center mt-2">
<form action="addfund" method="POST" class="shadow-sm p-2 rounded">
<div class="form-group text-start">
<label for="walletLabel"> <span class="fa fa-wallet"></span> Wallet</label>
<input type="number" min="10" value="10" name="wallet" class="form-control mb-3" id="walletLabel" 
placeholder="Wallet" required>
</div>
<button class="btn btn-success btn-lg mb-2" name="addfund"> 
<span class="fa fa-dollar"></span> Add
</button>
</form> 
</div>



</div>
</div>
<?php 



if (isset($_POST['addfund'])) {
$wallet = request($_POST['wallet']);
execute(" UPDATE accounts SET wallet=wallet+'{$wallet}' WHERE account_id ='{$authId}' ");
message('Fund Added ! ','success');
redirect('addfund');
}



?>
<?php require_once('footer.php');?>