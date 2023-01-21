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

	// Retrieve from database and display shopping cart in a table
	$qry = "SELECT *, CASE WHEN p.Offered = 1 AND (CURRENT_DATE>= p.OfferStartDate AND CURRENT_DATE <= p.OfferEndDate) THEN (p.OfferedPrice * sci.Quantity) ELSE (p.Price * sci.Quantity) END AS Total, sci.Quantity AS sciQty, p.Quantity AS pQty FROM shopcartitem AS sci INNER JOIN product AS p ON sci.ProductID = p.ProductID WHERE sci.ShopCartID = ?;";
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


		// Declare an array to store the shopping cart items in session variable 
		$_SESSION["Items"] = array();
			

		// Display the shopping cart content
		$subTotal = 0; // Declare a variable to compute subtotal before tax
		echo "<tbody>"; // Start of table's body section
		while ($row = $result->fetch_array()) 
		{

			$formattedPrice = number_format($row["Price"], 2);
			$formattedTotalPrice = number_format($row["Total"], 2);

			echo "<tr>";
			echo "<td> </td>";
			echo "<td> <img src='./Images/Products/$row[ProductImage]'> </td>";
			echo "<td style='vertical-align: inherit'> <b>$row[Name] </b> 
			<br>";

			$now = new DateTime('now');
			($now->format('Y-m-d') >= $row["OfferStartDate"]  && $now->format('Y-m-d') <= $row["OfferEndDate"]) ? $isOfferStillOnGoing = true : $isOfferStillOnGoing = false;

			if ($row["Offered"] == 1 && $isOfferStillOnGoing)
			{
				$formattedOfferPrice = number_format($row["OfferedPrice"], 2);
				
				echo"<span class='card-text'>$$formattedOfferPrice</span> <span class='price-before'>$$formattedPrice</span>
				<br>";
			}
			else
			{
				echo"<span class='card-text'>$$formattedPrice</span>
				<br>";
			}
			echo "<div class='container' style='display:flex;padding-left:0px;'>";
			echo "<form action = 'cartFunctions.php' method = 'post'>";
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

			echo "<input type = 'hidden' name = 'action' value = 'update' />";
			echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			echo "</form>";

			echo "<form action = 'cartFunctions.php' method = 'post'>";
			echo "<input type = 'hidden' name = 'action' value = 'remove' />";
			echo "<input type = 'hidden' name = 'product_id' value = '$row[ProductID]' />";
			echo "<button type = 'submit' style='border:none;background-color:white;'> | Delete </button>";
			echo "</form>";

			echo "</td>";
			echo "<td style='vertical-align: bottom'>";
			echo "Total: <b>$$formattedTotalPrice</b>";
			echo "</td>";
			echo "</tr>";
			echo "</div>";

			if ($isOfferStillOnGoing)
			{
				$_SESSION["Items"] [] = array("productId" => $row["ProductID"], "name" => $row["Name"], "price" => $row["Price"], "quantity" => $row["sciQty"], "image" => $row["ProductImage"], "offeredPrice" => $row["OfferedPrice"], "isOfferStillOnGoing" => true);
			}
			else
			{
				$_SESSION["Items"] [] = array("productId" => $row["ProductID"], "name" => $row["Name"], "price" => $row["Price"], "quantity" => $row["sciQty"], "image" => $row["ProductImage"], "offeredPrice" => $row["OfferedPrice"], "isOfferStillOnGoing" => false);
			}
			

			// Accumulate the running sub-total
			$subTotal += $row["Total"];
		}
		echo "</tbody>"; // End of table's body section
		echo "</table>"; // End of table
		echo "</div>"; // End of Bootstrap responsive table

		
		// Display the subtotal at the end of the shopping cart
		echo "<p style = 'text-align:right; font-size: 20px'> Subtotal: S$" . number_format($subTotal, 2);
		$_SESSION["SubTotal"] = round($subTotal, 2);

		
		echo "<form method = 'post' action = 'checkoutShipping.php'>";
		echo "<button style = 'float:right;' class='invertBtn' >Checkout</button>";
		echo "</form></p>";

	}
	else {
		echo "<div class='col-12 text-center'>";
		echo "<img src='./Images/ShoppingCart/empty-cart.jpg' style = 'height:600px;'>";
		echo "<h2>There are no items in your cart presently.</h2>";
		echo "</div>";
	}
	$conn->close(); // Close database connection
}
else {
	echo "<div class='col-12 text-center'>";
	echo "<img src='./Images/ShoppingCart/empty-cart.jpg' style = 'height:600px;'>";
	echo "<h2>There are no items in your cart presently.</h2>";
	echo "</div>";
}
echo "</div>"; // End of container
include("footer.php"); // Include the Page Layout footer
?>