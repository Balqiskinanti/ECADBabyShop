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


<?php 
    $shopperID = $_SESSION["ShopperID"];
    $stmt = mysqli_prepare($conn, "SELECT Name, Address, Country, Phone, Email FROM shopper where ShopperID=?");
    mysqli_stmt_bind_param($stmt, "i", $shopperID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $address, $country, $phone, $email);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
?>
<!-- Create a cenrally located container -->
<div style="width:80%; margin:auto;">
<form name="changePwd" method="post" onsubmit="return validateForm()">
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3" style="padding-top:30px">
           <!-- <span class="page-title">Change Profile</span> -->
            <h3 class="mb-0">Update Profile</h3>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="name">Name:</label>
        <div class="col-sm-9">
            <input class="form-control" name="name" id="name" 
                   type="text" required value="<?php echo $name; ?>" /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="address">Address:</label>
        <div class="col-sm-9">
            <input class="form-control" name="address" id="address"
                      cols="25" rows="4" value="<?php echo $address; ?>" />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="country">Country:</label>
        <div class="col-sm-9">
            <input class="form-control" name="country" id="country" type="text" value="<?php echo $country; ?>" />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="phone">Phone:</label>
        <div class="col-sm-9">
            <input class="form-control" name="phone" id="phone" type="text" value="<?php echo $phone; ?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="email">
            Email Address:</label>
        <div class="col-sm-9">
            <input class="form-control" name="email" id="email" 
                   type="email" required value="<?php echo $email; ?>" /> (required)
        </div>
    </div>

    <div class="form-group row">       
        <div class="col-sm-9 offset-sm-3">
            <button type="submit" class='btn btn-dark' id="cta-btn">Update</button>
        </div>
    </div>
</form>

<?php

// Process after user click the submit button
if (isset($_POST["email"])) {
	// To Do 2: Read new password entered by user
    $new_name = $_POST['name'];
    $new_addr = $_POST['address'];
    $new_country = $_POST['country'];
    $new_hp = $_POST['phone'];
    $new_email = $_POST['email'];
	
	//Hash the default password
	//$hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
	
	//Update the new password hash
  //  include_once("mySQLConn.php");

    $query = "SELECT * FROM Shopper WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $new_email);
    $stmt->execute();
    $result1 = $stmt->get_result();
    $stmt->close();

    if ($result1->num_rows === 0) {
        $qry = "UPDATE Shopper SET Name=?,Address=?, Country=?, Phone=?, Email=? WHERE ShopperID=?";
        $stmt = $conn->prepare($qry);
        // "s" - string, "j" - integer
        $stmt->bind_param("sssssi",$new_name, $new_addr, $new_country, $new_hp, $new_email, $_SESSION["ShopperID"]);
        if ($stmt->execute()) {
        echo "<p>Your profile has been updated successfully.</p>";
        }
        else {
        echo "<p><span style='color:red;'>
              Database update error!</span></p>";
        }
    }

    else{
        echo '<script type="text/javascript">
    alert("Email typed in has been registered before, please login instead or choose Forget Password on the login page if you have forgotten your password");location="http://localhost/ECADBabyShop/editProfile.php";</script>'; 


//echo "Email typed in has been registered before, please login instead or choose Forget Password on the login page if you have forgotten your password";
//header("Location: index.php");
    }



   
    $stmt->close();
    $conn->close();

}
?>

</div> <!-- Closing container -->
<?php 
include("footer.php"); // Include the Page Layout footer
?>