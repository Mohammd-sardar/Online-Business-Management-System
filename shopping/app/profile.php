<?php require_once('header.php');?>
<div class="container">
<div class="row bg-light shadow rounded text-dark rounded p-2 m-2 text-center"> 

<div class="col-12 col-sm-11 col-md-8 col-lg-8 m-auto text-center">
<h3>Profile Page</h3> 
</div>

<div class="col-12 col-sm-11 col-md-6 col-lg-6 m-auto text-center">
<form action="profile" method="POST" class="shadow-sm p-2 rounded">

<div class="form-group text-start">
<label for="usernamelabel"> <span class="fa fa-user"></span>Change Username</label>
<input type="text" name="username" value="<?=$authName;?>" class="form-control mb-3" id="usernamelabel" 
placeholder="Username">
</div>

<div class="form-group text-start">
<label for="emaillabel"> <span class="fa fa-envelope"></span>Change Email</label>
<input type="email" name="email" value="<?=$authEmail;?>" class="form-control mb-3" id="emaillabel" 
placeholder="Email">
</div>

<button class="btn btn-warning btn-lg mb-2" name="saveprofile"> 
<span class="fa fa-save"></span> Save Profile
</button>

</form> 
</div>


<div class="col-12 col-sm-11 col-md-6 col-lg-6 m-auto text-center">
<form action="profile" method="POST" class="shadow-sm p-2 rounded">

<div class="form-group text-start">
<label for="oldpasswordlabel"> <span class="fa fa-lock"></span> Old Password</label>
<input type="password" name="oldpassword" class="form-control mb-3" id="oldpasswordlabel" 
placeholder="Old Password">
</div>

<div class="form-group text-start">
<label for="newpasswordlabel"> <span class="fa fa-lock"></span> New Password</label>
<input type="password" name="newpassword" class="form-control mb-3" id="newpasswordlabel" 
placeholder="New Password">
</div>


<button class="btn btn-danger btn-lg mb-2" name="savepassword"> 
<span class="fa fa-key"></span> Change Password
</button>

</form> 
</div>



</div>






</div>
<?php 
if (isset($_POST['saveprofile'])) {
$username = request($_POST['username']);
$email = request($_POST['email']);
if(empty($username) && empty($email)) {
message('All Fields are Required','warning');
redirect('profile');
}
if(empty($username)) {
message('Username is Required','warning');
redirect('profile');
}
if(empty($email)) {
message('Email is Required','warning');
redirect('profile');
}

$checkDuplicateData = countData(" SELECT * FROM accounts 
WHERE (account_name='{$username}' OR account_email='{$email}') AND account_id!='{$authId}'  ");
if($checkDuplicateData===0){
execute(" UPDATE accounts SET account_name='{$username}',account_email='{$email}' 
WHERE account_id ='{$authId}' ");
message('Profile Updated ! ','success');
redirect('profile');
}
else {
message('Already Added','warning');
redirect('profile');
}

}

if (isset($_POST['savepassword'])) {
$oldpassword = md5(request($_POST['oldpassword']));
$newpassword = md5(request($_POST['newpassword']));
if(empty($oldpassword) && empty($newpassword)) {
message('All Fields are Required','warning');
redirect('profile');
}
if(empty($oldpassword)) {
message('Old Password is Required','warning');
redirect('profile');
}
if(empty($newpassword)) {
message('New Passowrd is Required','warning');
redirect('profile');
}

$checkDuplicateData = countData(" SELECT * FROM accounts 
WHERE account_password='{$oldpassword}' AND account_id='{$authId}'  ");
if($checkDuplicateData > 0){
execute(" UPDATE accounts SET account_password='{$newpassword}'
WHERE account_id ='{$authId}' ");
message('Password Updated ! ','success');
redirect('profile');
}
else {
message('Old Password is Incorrect','warning');
redirect('profile');
}

}






?>
<?php require_once('footer.php');?>