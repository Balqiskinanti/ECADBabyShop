<?php
// Detect the current session
session_start();

// Include the PHP file that establishes the database connection handle: $conn
include_once("mySQLConn.php");

// Include the Page Layout header
include("header.php"); 

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
        $qry = "SELECT *, sci.Quantity AS sciQty, 
                CASE WHEN p.Offered = 1 AND (CURRENT_DATE>= p.OfferStartDate AND CURRENT_DATE <= p.OfferEndDate) 
                THEN (p.OfferedPrice * sci.Quantity) ELSE (p.Price * sci.Quantity) END AS Total 
                FROM shopcartitem AS sci 
                INNER JOIN shopcart AS sc ON sc.ShopCartID = sci.ShopCartID 
                INNER JOIN product AS p ON p.ProductID = sci.ProductID
                WHERE sc.ShopperID = ? AND sc.OrderPlaced = 0;";

        $stmt = $conn->prepare($qry);
        $stmt -> bind_param("s", $_SESSION["ShopperID"]);

        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_array())
            {
                $_SESSION["Cart"] = $row["ShopCartID"];
                $_SESSION["SubTotal"] += $row["Total"] ;
                $_SESSION["NumCartItem"] += $row["sciQty"];
            }
        }

        // Redirect to home page
        header("Location: index.php");
        exit;
    }
    
}
else
{
    echo "<h3 style='color:red'>Invalid Login Credentials</h3>";
}

// Include the Page Layout footer
include("footer.php");
?>