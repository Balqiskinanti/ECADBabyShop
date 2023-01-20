<?php 
// Include the code that contains shopping cart's functions.
// Current session is detected in "cartFunctions.php, hence need not start session here.
include_once("cartFunctions.php");
include("header.php"); // Include the Page Layout header

if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

echo "<div id='myShopCart' style='margin:auto'>"; // Start a container
if (isset($_SESSION["Cart"])) {
	include_once("mySQLConn.php"); // Establish database connection handle: $conn
	// To Do 1 (Practical 4): 
	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT *, (p.Price * sci.Quantity) AS Total, sci.Quantity AS sciQty, p.Quantity AS pQty FROM shopcartitem AS sci INNER JOIN product AS p ON sci.ProductID = p.ProductID WHERE sci.ShopCartID = ?;";
	$stmt = $conn->prepare($qry);
	$stmt->bind_param("i", $_SESSION["Cart"]);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	
	if ($result->num_rows > 0) {
		// To Do 2 (Practical 4): Format and display 
		// the page header and header row of shopping cart page
		echo "<p class='page-title' style='text-align:center'>Shopping Cart</p>"; 
		echo "<div class='table-responsive' >"; // Bootstrap responsive table
		echo "<table class='table table-hover'>"; // Start of table
		echo "<thead class = 'cart-header'>"; // Start of table's header section
		echo "<tr>"; // Start of header row
		echo "<th width = '150px'> </th>";
		echo "<th width = '250px'> </th>";
		echo "<th width = '500px'> </th>"; 
		echo "<th>&nbsp;</th>";
		echo "</tr>"; // End of header row
		echo "</thead>"; // End of table's header section

		// To Do 5 (Practical 5):
		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"] = array();
			
		// To Do 3 (Practical 4): 
		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		echo "<tbody>"; // Start of table's body section
		while ($row = $result->fetch_array()) 
		{
			// echo "<tr>";
			// echo "<td style = 'width:50%'>$row[Name] <br>";
			// echo "<b>Product ID: $row[ProductID]</b></td>";
			// $formattedPrice = number_format($row["Price"], 2);

			// echo "<td>$formattedPrice</td>";
			// echo "<td>";
			// echo "<form action = 'cartFunctions.php' method = 'post'>";
			// echo "<select name = 'quantity' onChange = 'this.form.submit()'>";

			// for ($i = 1; $i <= 10; $i++) // To populate drop-down list from 1 to 10
			// {
			// 	if ($i == $row["sciQty"]) 
			// 		// Select drop-down list item with value same as the quantity of purchase
			// 		$selected = "selected";
			// 	else
			// 		$selected = "";
			// 	echo "<option value ='$i' $selected>$i</option>";
			// }
			// echo "</select>";

			// echo "<input type = 'hidden' name = 'action' value = 'update' />";
			// echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			// echo "</form>";
			// echo "</td>";

			// $formattedTotal = number_format($row["Total"], 2);
			// echo "<td>$formattedTotal </td>";
			// echo "<td>"; // Column for remove item from shopping cart
			// echo "<form action = 'cartFunctions.php' method = 'post'>";
			// echo "<input type = 'hidden' name = 'action' value = 'remove' />";
			// echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			// echo "<input type = 'image' src='images/trash-can.png' title = 'Remove Item' />";
			// echo "</form>";
			// echo "</td>";
			// echo "</tr>";

			// // To Do 6 (Practical 5):
		    // // Store the shopping cart items in session variable as an associate array
			// $_SESSION["Items"] [] = array("productId" => $row["ProductID"], "name" => $row["Name"], "price" => $row["Price"], "quantity" => $row["sciQty"], "image" => $row["ProductImage"], "offeredPrice" => $row["OfferedPrice"]);

			// // Accumulate the running sub-total
			// $subTotal += $row["Total"];
			$formattedPrice = number_format($row["Price"], 2);
			$formattedOfferPrice = number_format($row["OfferedPrice"], 2);

			echo "<tr>";
			echo "<td> </td>";
			echo "<td> <img src='./Images/Products/$row[ProductImage]'> </td>";
			echo "<td style='vertical-align: inherit'> $row[Name] 
			<br>
			<span class='card-text'>$$formattedOfferPrice</span> <span class='price-before'>$$formattedPrice</span>
			<br>";
			echo "<div class='container' style='display:flex;padding-left:0px;'>";
			echo "<select name = 'quantity' onChange = 'this.form.submit()'>";
			for ($i = 1; $i <= 10; $i++) // To populate drop-down list from 1 to 10
			{
				if ($i == $row["sciQty"]) 
					// Select drop-down list item with value same as the quantity of purchase
					$selected = "selected";
				else
					$selected = "";
				echo "<option value ='$i' $selected>$i</option>";
			}
			echo "</select>";
			echo "<form action = 'cartFunctions.php' method = 'post'>";
			echo "<input type = 'hidden' name = 'action' value = 'remove' />";
			echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			echo "<button type = 'submit' style='border:none;background-color:white;'> | Delete </button>";
			echo "</form>";

			echo "</td>";
			echo "</tr>";
			echo "</div>";

		}
		echo "</tbody>"; // End of table's body section
		echo "</table>"; // End of table
		echo "</div>"; // End of Bootstrap responsive table
		// To Do 4 (Practical 4): 
		// Display the subtotal at the end of the shopping cart
		echo "<p style = 'text-align:right; font-size: 20px'> Subtotal: S$" . number_format($subTotal, 2);
		$_SESSION["SubTotal"] = round($subTotal, 2);

						   
														 
		echo "<form method = 'post' action = 'checkoutShipping.php'>";
		echo "<button style = 'float:right;' class='invertBtn' >Checkout</button>";
		echo "</form></p>";
		// foreach ($_SESSION["Items"] as $key => $value)
		// {
		// 	echo $key . " - " . $value["name"] . "<br>";
		// }
	}
	else {
		echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
	}
	$conn->close(); // Close database connection
}
else {
	echo "<h3 style='text-align:center; color:red;'>Empty shopping cart!</h3>";
}
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>