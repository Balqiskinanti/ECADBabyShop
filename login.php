<?php
// Detect the current session
session_start();
// header
include("header.php"); 
?>

<!-- Create a centrally located container -->
<div style="width:80%; margin:auto;">
<!-- Create a HTML Form within the container -->
<form action="./Pages/Login/checkLogin.php" method="post">
<!-- 1st row - Header Row -->
<div id="brand-name">
    EBS
</div>

<div id="promotion-list-title">
   WELCOME BACK, LET'S LOG IN!
</div>
<!-- 2nd row - Entry of email address -->
<div class="form-group row" style="justify-content:center!important; padding-top:30px">
    <div class="col-sm-4">
        <input class="form-control" type="email" name="email" id="email" placeholder="Email *" required/>
    </div>
</div>
<!-- 3rd row - Entry of password -->
<div class="form-group row" style="justify-content:center!important;">
    <div class="col-sm-4">
        <input class="form-control" type="password" name="password" id="password" placeholder="Password *" required/>
    </div>
</div>
<!-- 4th row - Login button -->
<div class="form-group row" style="justify-content:center!important;">
    <div class="col-sm-4">
        <button type='submit' class='btn btn-dark' style="margin:0!important; width:inherit;">Login</button>
        <p style="margin:0!important;padding-top:10px;">Don't have an account? <a href="register.php">Sign up here.</a></p>
        <p><a href="forgetPassword.php">Forget Password</a></p>
    </div>
</div>

</form>
</div>

<?php
// Include the Page Layout footer
include("footer.php");
?>