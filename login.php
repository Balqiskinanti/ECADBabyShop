<?php
// Detect the current session
session_start();
// header
include("./Pages/Shared/header.php"); 
?>

<!-- Create a centrally located container -->
<div style="width:80%; margin:auto;">
<!-- Create a HTML Form within the container -->
<form action="./Pages/Login/checkLogin.php" method="post">
<!-- 1st row - Header Row -->
<div class="form-group row">
    <div class="col-sm-12" style="text-align: center;">
        <h1 class="page-title">LOG IN</h1>
    </div>
</div>
<!-- 2nd row - Entry of email address -->
<div class="form-group row">
    <div class="col-sm-3 offset-4">
        <input class="form-control" type="email" name="email" id="email" placeholder="Email *" required/>
    </div>
</div>
<!-- 3rd row - Entry of password -->
<div class="form-group row">
    <div class="col-sm-3 offset-4">
        <input class="form-control" type="password" name="password" id="password" placeholder="Password *" required/>
    </div>
</div>
<!-- 4th row - Login button -->
<div class="form-group row">
    <div class="col-sm-9 offset-sm-3">
        <button type='submit'>Login</button>
        <p>Don't have an account? <a href="register.php">Sign up here.</a></p>
        <p><a href="forgetPassword.php">Forget Password</a></p>
    </div>
</div>

</form>
</div>

<?php
// Include the Page Layout footer
include("./Pages/Shared/footer.php");
?>