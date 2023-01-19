<?php
// Detect the current session
session_start();

// Include the PHP file that establishes the database connection handle: $conn
include_once("../../mySQLConn.php");

// Include the Page Layout header
include("../../Pages/Shared/header.php"); 

// Reading inputs entered in previous page
$email = $_POST["email"];
$pwd = $_POST["password"];

// SQL query to get the Shopper ID and Shopper’s name of a particular record 
// whereby the email address and passowrd in the Shopper table matches with the email address and password entered in the login page
$qry = "SELECT ShopperID, Name, Password FROM Shopper WHERE Email = ?";

// bind parameters to prevent sql injection 
$stmt = $conn->prepare($qry);
$stmt -> bind_param("s", $email);


// execute the query
$stmt ->execute();

// store the result back into $result
$result = $stmt->get_result();

$stmt->close();

if ($result->num_rows > 0)
{
	$row = $result->fetch_array();
	$dbPwd = $row["Password"];

    if ($pwd == $dbPwd)
    {
        // Save user's info in session variables
        $_SESSION["ShopperName"] = $row["Name"];
        $_SESSION["ShopperID"] = $row["ShopperID"];

        // Get active shopping cart
        $qry = "SELECT sc.ShopCartID, COUNT(sci.ProductID) AS NumItems FROM ShopCart sc LEFT JOIN ShopCartItem sci ON sc.ShopCartID=sci.ShopCartID WHERE sc.ShopperID=? AND sc.OrderPlaced=0";

        $stmt = $conn->prepare($qry);
        $stmt -> bind_param("s", $_SESSION["ShopperID"]);

        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_array();

            if ($row["NumItems"] > 0)
            {
                $_SESSION["Cart"] = $row["ShopCartID"];
                $_SESSION["NumCartItem"] = $row["NumItems"];
            }
        }

        // Redirect to home page
        header("Location: ../../index.php");
        exit;
    }
    
}
else
{
    echo "<h3 style='color:red'>Invalid Login Credentials</h3>";
}

// Include the Page Layout footer
include("./Pages/Shared/footer.php");
?>