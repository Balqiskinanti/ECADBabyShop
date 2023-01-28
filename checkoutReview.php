<?php 
session_start();
include("header.php"); // Include the Page Layout header

if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

// Post data recieved from checkoutShipping.
$_SESSION["ShippingInfo"] = array($_POST["shippingName"], $_POST["shippingTel"] , $_POST["shippingEmail"] , $_POST["shippingCountry"], $_POST["shippingStreetAddress"], $_POST["shippingPostalCode"], $_POST["shippingCity"], $_POST["deliveryChoice"], $_POST["billingName"], $_POST["billingTel"], $_POST["billingEmail"], $_POST["billingCountry"], $_POST["billingStreetAddress"], $_POST["billingPostalCode"], $_POST["billingCity"] );

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
			if ($value["isOfferStillOnGoing"])
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

		// Compute discount
		$discount = 0;

		$qry = "SELECT *, CASE WHEN p.Offered = 1 AND (CURRENT_DATE>= p.OfferStartDate AND CURRENT_DATE <= p.OfferEndDate) THEN (p.Price - p.OfferedPrice) END AS Discount, p.Quantity AS pQty, sci.Quantity AS sciQty FROM ShopCartItem sci INNER JOIN Product p ON sci.ProductID = p.ProductID WHERE sci.ShopCartID = ?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $_SESSION["Cart"]);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		while($row = $result->fetch_array()) 
		{
			$discount += $row["Discount"];
		}
		// Compute GST Rate
		$qry = "SELECT * FROM `gst` WHERE CURRENT_DATE >= EffectiveDate ORDER BY EffectiveDate DESC LIMIT 1;";
		$result = $conn->query($qry);
		$row = mysqli_fetch_assoc($result);
		$_SESSION["Tax"] = number_format(($row['TaxRate'] / 100) * ($_SESSION['SubTotal'] + $discount),2);

		$total = $_SESSION["SubTotal"] + $_SESSION["Tax"] + $_SESSION["ShipCharge"];

		echo "<p style='font-size:large; text-align:right;'>Subtotal: $$subTotal</p>";
		echo "<p style='font-size:large; text-align:right;'>Tax($row[TaxRate]%): $$_SESSION[Tax]</p>";
		echo "<p style='font-size:large; text-align:right;'>Shipping Fee: $$_POST[deliveryChoice]</p>";
		echo "<p>Total: $$total</p>";
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