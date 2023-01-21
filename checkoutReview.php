<?php 
session_start();
include("header.php"); // Include the Page Layout header

if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

echo "<div class='container'>";
echo "<h1>Shipping & Billing</h1> <br>";
echo "<p>Shipping & Billing > <u>Review Order & Payment</u></p>";
echo "<p class='section-header'>Your Orders</p>";
if(isset($_SESSION["Cart"]))
{
	echo "<p><a href='shoppingCart.php'><u>Return to shopping bag to make changes</u></a></p>";

	include_once("mySQLConn.php");
	$qry = "SELECT * FROM shopcartitem WHERE ShopCartID = ?;";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i", $_SESSION["Cart"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	
	if ($result->num_rows > 0) 
	{
		echo "<div class='table-responsive' >"; // Bootstrap responsive table
		echo "<table class='table table-hover'>"; // Start of table

		foreach ($_SESSION["Items"] as $key => $value)
		{
			$img = "./Images/Products/$value[image]";
			echo "<tr>";
			echo "<td><img src='$img'></td>";
			if ($value["offeredPrice"] != null)
			{
				$basePrice = $value['price'] * $value['quantity'];
				$discountPrice = $value['offeredPrice'] * $value['quantity'];

				$basePrice = number_format($basePrice, 2);
				$discountPrice = number_format($discountPrice, 2);

				echo "<td>$value[quantity] x $value[name] </br>";
				echo "<span class='card-text'>$$discountPrice</span>";
				echo "<span class='price-before'>$$basePrice</span>";
				echo "</td>";
			}
			else
			{
				$basePrice = $value['price'] * $value['quantity'];
				$basePrice = number_format($basePrice, 2);

				echo "<td>$value[quantity] x $value[name] </br>";
				echo "<span class='card-text'>$$basePrice</span>";
				echo "</td>";
			}
			echo "</tr>";
		}

		echo "</table>"; // End of Table
		

		$subTotal = number_format($_SESSION["SubTotal"], 2);
		echo "<div class='checkoutPayPal'>";

		echo "<p class=''>Subtotal: $$subTotal</p>";
		echo "<form method = 'post' action = 'checkoutProcess.php'>";
		echo "<input type = 'image' style='width:100%' src = 'https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif'>";
		echo "</form></p>";
		echo"</div>";		
		echo "</div>"; // End of responsive table
	}
	else 
	{
		echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
	}
	$conn->close(); // Close database connection
}
else
{
	echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
}

echo "</div>"; // End of Container


include("footer.php"); // Include the Page Layout footer
?>