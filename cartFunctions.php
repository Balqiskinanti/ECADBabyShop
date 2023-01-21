<?php 
session_start();
if (isset($_POST['action'])) {
 	switch ($_POST['action']) {
    	case 'add':
        	addItem();
            break;
        case 'update':
            updateItem();
            break;
		case 'remove':
            removeItem();
            break;
    }
}
function addItem() {
	// Check if user logged in 
	if (! isset($_SESSION["ShopperID"])) {
		// redirect to login page if the session variable shopperid is not set
		header ("Location: login.php");
		exit;
	}

	include_once("mySQLConn.php"); // Establish database connection handle: $conn
	// Check if a shopping cart exist, if not create a new shopping cart

	if (! isset($_SESSION["Cart"]))
	{
		// Create a shopping cart for the shopper
		$qry = "INSERT INTO ShopCart(ShopperID) Values(?)";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $_SESSION["ShopperID"]);
		$stmt->execute();
		$stmt->close();

		$qry = "SELECT LAST_INSERT_ID() AS ShopCartID";
		$result = $conn->query($qry);
		$row = $result->fetch_array();
		$_SESSION["Cart"] = $row["ShopCartID"];
	}

  	// If the ProductID exists in the shopping cart, 
  	// update the quantity, else add the item to the Shopping Cart.
  	$pid = $_POST["product_id"];
	$quantity = $_POST["quantity"];
	$qry = "SELECT * FROM ShopCartItem WHERE ShopCartID = ? AND ProductID = ?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("ii", $_SESSION["Cart"], $pid);
	$stmt->execute();

	$result = $stmt->get_result();
	$stmt->close();

	$addNewItem = 0;

	if ($result->num_rows > 0) // Selected product exists in the shopping cart
	{
		// Increase quantity of purchase
		$qry = "UPDATE ShopCartItem SET Quantity = LEAST(Quantity + ?, 10) WHERE ShopCartID = ? AND ProductID = ?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("iii", $quantity, $_SESSION["Cart"], $pid);
		$stmt->execute();
		$stmt->close();
		$addNewItem = $quantity;
	}
	else // Selected product has yet to be added into the shopping cart
	{
		$qry = "INSERT INTO ShopCartItem(ShopCartID, ProductID, Price, Name, Quantity) SELECT ?, ?, Price, ProductTitle, ? FROM Product WHERE ProductID = ?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("iiii", $_SESSION["Cart"], $pid, $quantity, $pid);
		$stmt->execute();
		$stmt->close();
		$addNewItem = $quantity;
	}

  	// Update session variable used for counting number of items in the shopping cart.
	if (isset($_SESSION["NumCartItem"]))
	{
		$_SESSION["NumCartItem"] = $_SESSION["NumCartItem"] + $addNewItem;
	}
	else
	{
		$_SESSION["NumCartItem"] = $quantity;
	}

	$qry = "SELECT *, CASE WHEN p.Offered = 1 AND (CURRENT_DATE>= p.OfferStartDate AND CURRENT_DATE <= p.OfferEndDate) THEN (p.Price - p.OfferedPrice) END AS Discount, p.Quantity AS pQty, sci.Quantity AS sciQty FROM ShopCartItem sci INNER JOIN Product p ON sci.ProductID = p.ProductID WHERE sci.ShopCartID = ? AND sci.ProductID = ?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("ii", $_SESSION["Cart"], $pid);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$row = $result->fetch_array();

	if ($row["Discount"] != NULL)
	{
		// To store discount to be used at checkout.
		$_SESSION["Discount"] = $row["Discount"] * $row["sciQty"];
		$basePrice = $row["Price"] - $row["Discount"];
		$subTotal = $row["sciQty"] * $basePrice;

		if (isset($_SESSION["SubTotal"]))
		{
			$_SESSION["SubTotal"] += $subTotal;
		}
		else
		{
			$_SESSION["SubTotal"] = $subTotal;
		}
	}
	else
	{
		$subTotal = $row["Price"] * $row["sciQty"];

		if (isset($_SESSION["SubTotal"]))
		{
			$_SESSION["SubTotal"] += $subTotal;
		}
		else
		{
			$_SESSION["SubTotal"] = $subTotal;
		}
	}

	// Update session variable used for counting subtotal in the shopping cart.
	//$_SESSION["Discount"] = $discount;

	$conn->close();
	// Redirect shopper to shopping cart page
	header("Location: shoppingCart.php");
	exit;
}

function updateItem() {
	// Check if shopping cart exists 
	if (! isset($_SESSION["Cart"])) {
		// redirect to login page if the session variable cart is not set
		header ("Location: login.php");
		exit;
	}
	// TO DO 2
	// Write code to implement: if a user clicks on "Update" button, update the database
	// and also the session variable for counting number of items in shopping cart.
	$cartid = $_SESSION["Cart"];
	$pid = $_POST["product_id"];
	$quantity = $_POST["quantity"];

	include_once("mySQLConn.php"); // Establish database connection handle: $conn

	// Update $_SESSION["NumCartItems"] when quantity is changed in shopper's active cart
	$qry = "SELECT * FROM ShopCartItem WHERE ProductID = ? AND ShopCartID = ?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("ii", $pid, $cartid);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	$row = $result->fetch_array();
	if ($quantity < $row["Quantity"])
	{
		$_SESSION["NumCartItem"] -= $row["Quantity"] - $quantity;
		$_SESSION["SubTotal"] -= $row["Price"] * ($row["Quantity"] - $quantity); 
	}
	else
	{
		$_SESSION["NumCartItem"] += $quantity - $row["Quantity"];
		$_SESSION["SubTotal"] += $row["Price"] * ($quantity - $row["Quantity"]); 
	}

	$qry = "UPDATE ShopCartItem SET Quantity = ? WHERE ProductID = ? AND ShopCartID = ?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("iii", $quantity, $pid, $cartid);
	$stmt->execute();
	$stmt->close();
	$conn->close();
	


	header("Location: shoppingCart.php");
	exit;
}

function removeItem() {
	if (! isset($_SESSION["Cart"])) {
		// redirect to login page if the session variable cart is not set
		header ("Location: login.php");
		exit;
	}
	// TO DO 3
	// Write code to implement: if a user clicks on "Remove" button, update the database
	// and also the session variable for counting number of items in shopping cart.
	$pid = $_POST["product_id"];
	$cartid = $_SESSION["Cart"];

	include_once("mySQLConn.php"); // Establish database connection handle: $conn

	$qry = "SELECT Quantity FROM ShopCartItem WHERE ProductID = ? AND ShopCartID = ?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("ii", $pid, $cartid);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$row = $result->fetch_array();
	$_SESSION["NumCartItem"] -= $row["Quantity"];
	$_SESSION["SubTotal"] -= $row["Price"];

	$qry = "DELETE FROM ShopCartItem WHERE ProductID = ? AND ShopCartID = ?";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("ii", $pid, $cartid);
	$stmt->execute();
	$stmt->close();
	$conn->close();

	// unset($_SESSION["NumCartItem"]);
	// unset($_SESSION["SubTotal"]);

	header ("Location: shoppingCart.php");
}
?>