<?php 
session_start(); // Detect the current session
include("header.php"); // Include the Page Layout header
?>
<!-- Create a cenrally located container -->
<div style="width:80%; margin:auto;">
<form action="" method="post">
	<div class="form-group row">
		<div class="col-sm-9 offset-sm-3">
			<span class="page-title">Forget Password</span>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="eMail">
         Email Address:</label>
		<div class="col-sm-9">
			<input class="form-control" name="eMail" id="eMail"
                   type="email" required value="<?php if(isset($_POST['eMail'])) echo $_POST['eMail'];?>" />
		</div>
	</div>

	<?php 
	if (isset($_POST["submit"])) { 
		$eMail = $_POST["eMail"];
		include_once("mySQLConn.php");
		$qry = "SELECT PwdQuestion FROM Shopper WHERE Email=?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("s", $eMail); 	// "s" - string 
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		if ($result->num_rows > 0) { 
			$row = $result->fetch_array();
			$pwdqn = $row['PwdQuestion'];
			echo '<div class="form-group row">
			<label class="col-sm-3 col-form-label" for="answer">'.$pwdqn.'</label>';
			echo '<div class="col-sm-9"><input class="form-control" type="text" id="answer" name="answer" required>
			</div>
	</div>';
		}
		else {
			echo "Invalid email, try again.";
		}
	}
	?>



	<div class="form-group row">      
		<div class="col-sm-9 offset-sm-3">
			<button type="submit" name="submit">Submit</button>
		</div>
	</div>
</form>

<!-- Insert Missing code here -->
<?php 

// To Do:  Starting ....
//$qry = "SELECT * FROM Shopper";
//$result = $conn->query($qry);

// Display each category in a row

//if (isset($_POST["answer"]) == $row[PwdAnswer]) {
// Process after user click the submit button
if (isset($_POST["answer"])) {
	// Read email address entered by user
	$eMail = $_POST["eMail"];
    $answer = $_POST["answer"];
	// Retrieve shopper record based on e-mail address
	include_once("mySQLConn.php");
	$qry = "SELECT * FROM Shopper WHERE Email=? AND PwdAnswer=?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("ss", $eMail, $answer); 	// "s" - string 
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
            if ($result->num_rows > 0) {
                //Update the default new password to shopper"s account
                $row = $result->fetch_array();
                $shopperId = $row["ShopperID"];
                $new_pwd = "password"; // Default password
                // Hash the default password
                //$hashed_pwd = password_hash($new_pwd, PASSWORD_DEFAULT);
                $qry = "UPDATE Shopper SET Password=? WHERE ShopperID=?";
                $stmt = $conn->prepare($qry);
                // "s" - string, "j" - integer
                $stmt->bind_param("si", $new_pwd, $shopperId);
                $stmt->execute();
                $stmt->close();
        
                // e-Mail the new password to user
                include("myMail.php");
                $to=$eMail; // use the gmail account created
                $from="ecadbabyshop@gmail.com"; // use the gmail account created
                $from_name= "ECADBabyShop";
                $subject="ECADBabyShop Login Password"; // e-mail title
                // HTML body message
                $body="<span style='color:black; font-size:12px'>
                Your new password is <span style='font-weight:bold'>
                $new_pwd</span>.<br />
                Do change this default password ASAP!</span>";
                // Initiate the e-mailing sending process
                if (smtpmailer($to, $from, $from_name, $subject, $body)) {
                echo
                "<p>Your new password is sent to:
                <span style='font-weight:bold'>$to</span>.</p>";
                }
                else {
                echo "<p><span style='color:red;'>
                Mailer Error: " . $error
                . "</span></p>";
                        
                    }
        
                }
            else {
                echo "<p><span style='color:red;'>
                      Wrong answer!</span></p>";
            }
            $conn->close();
        
        


}


?>
</div> <!-- Closing container -->



<?php 
include("footer.php"); // Include the Page Layout footer
?>