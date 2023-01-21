<?php 
session_start();
include("header.php"); // Include the Page Layout header
include_once("mySQLConn.php");

//Check if user logged in 

if (! isset($_SESSION["ShopperID"])) {

    header ("Location: login.php");
    
    exit;
    }
?>

<script type="text/javascript">
function validateForm()
{
    // Check if password matched
	if (document.changePwd.pwd1.value != document.changePwd.pwd2.value) {
 	    alert("Passwords not matched!");
        return false;   // cancel submission
    }
    return true;  // No error found
}
</script>


<!-- Create a cenrally located container -->
<div style="width:80%; margin:auto;">
<form name="changePwd" method="post" onsubmit="return validateForm()">
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3" style="padding-top:30px">
            <span class="page-title">Change Password</span>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="pwd1">
         New Password:</label>
        <div class="col-sm-9">
            <input class="form-control" name="pwd1" id="pwd1" 
                   type="password" required />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="pwd2">
         Retype Password:</label>
        <div class="col-sm-9">
            <input class="form-control" name="pwd2" id="pwd2"
                   type="password" required />
        </div>
    </div>
    <div class="form-group row">       
        <div class="col-sm-9 offset-sm-3">
            <button type="submit" class='btn btn-dark'>Change Password</button>
        </div>
    </div>
</form>

<?php

// Process after user click the submit button
if (isset($_POST["pwd1"])) {
	// Read new password entered by user

	$new_pwd = $_POST['pwd1'];
	
	//Hash the default password
	//$hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
	
	// Update the new password hash
  //  include_once("mySQLConn.php");

    // Update the new password hash
    // include_once("mysql_conn.php");
    $qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?" ;
    $stmt = $conn->prepare($qry);
    // "s" - string, "j" - integer
    $stmt->bind_param("si", $new_pwd, $_SESSION["ShopperID"]);
    if ($stmt->execute()) {
    echo "<p>Your new password is changed successfully.</p>";
    }
    else {
    echo "<p><span style='color:red;'>
          Database update error!</span></p>";
    }
    $stmt->close();
    $conn->close();
	
}
?>


</div> <!-- Closing container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>