<?php 
session_start();
include("header.php"); 
include_once("mySQLConn.php"); 

echo "<div class='container'>";
echo "<h1>Thank you for your order</h1>";
echo "<div class='flexedArea'>";

$qry = "SELECT * FROM orderdata WHERE OrderID = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $_SESSION['OrderID']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();	



echo "<p>Here is the summary of order ID #$_SESSION[OrderID]</p>";
while ($row = $result->fetch_array())
{
    $dateOrdered = date("d-F-Y",strtotime($row['DateOrdered']));
    echo "<p>Purchased on: ".$dateOrdered."</p>";

    echo "</div>";
    echo "<div class='row'>"; // Div for Shipping + Billing
    echo "<div class='col-sm-6'>"; // Shipping Info Div
    echo "<h2>Shipping</h2>";
    echo "<p><b>Shipping Name: </b>$row[ShipName]</p>";
    echo "<p><b>Shipping Phone Number: </b>$row[ShipPhone]</p>";
    echo "<p><b>Shipping Email: </b>$row[ShipEmail]</p>";
    echo "<p><b>Shipping Country: </b>$row[ShipCountry]</p>";
    echo "<p><b>Shipping Address: </b>$row[ShipAddress]</p>";
    echo "<p><b>Delivery Method: </b>$row[DeliveryMode] Delivery</p>";
    echo "</div>"; // End of Shipping
    echo "<div class='col-sm-6'>"; // Billing Info Div
    echo "<h2>Billing</h2>";
    echo "<p><b>Billing Name: </b>$row[BillName]</p>";
    echo "<p><b>Billing Phone Number: </b>$row[BillPhone]</p>";
    echo "<p><b>Billing Email: </b>$row[BillEmail]</p>";
    echo "<p><b>Billing Country: </b>$row[BillCountry]</p>";
    echo "<p><b>Billing Address: </b>$row[BillAddress]</p>";
    echo "</div>"; // End of Billing
    echo "</div>"; // End of Div for Shipping + Billing
}
echo "<div class='row'>"; // Display products purchased
echo "<h2 class='col-sm-12'>Your Orders</h2>";

$qry = "SELECT *,p.Quantity AS pQty, sci.Quantity AS sciQty FROM orderdata AS od 
INNER JOIN shopcartitem AS sci ON od.ShopCartID = sci.ShopCartID
INNER JOIN product AS p ON sci.ProductID = p.ProductID
WHERE od.OrderID = ?;";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $_SESSION["OrderID"]);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close(); 

while ($row = $result->fetch_array())
{
    $img = "./Images/Products/$row[ProductImage]";
    echo "<div class='col-md-6 col-sm-12'>";
    echo "<table>";
    echo "<tr>";
    echo "<td><img src='$img'></td>";

    $now = new DateTime('now');
    ($now->format('Y-m-d') >= $row["OfferStartDate"]  && $now->format('Y-m-d') <= $row["OfferEndDate"]) ? $isOfferStillOnGoing = true : $isOfferStillOnGoing = false;

    if ($isOfferStillOnGoing)
    {
        $basePrice = $row['Price'] * $row['sciQty'];
        $discountPrice = $row['OfferedPrice'] * $row['sciQty'];

        $basePrice = number_format($basePrice, 2);
        $discountPrice = number_format($discountPrice, 2);

        echo "<td>$row[sciQty] x $row[Name] </br>";
        echo "<span class='card-text'>$$discountPrice</span>";
        echo "<span class='price-before'>$$basePrice</span>";
        echo "</td>";
    }
    else
    {
        $basePrice = $row['Price'] * $row['sciQty'];
        $basePrice = number_format($basePrice, 2);

        echo "<td>$row[sciQty] x $row[Name] </br>";
        echo "<span class='card-text'>$$basePrice</span>";
        echo "</td>";
    }
    echo "</tr>";
    echo "</table>";
    echo "</div>"; // End div for products display
}


echo "</div>";
echo "<p><b>(Please contact ebs@gmail.com for any enquiries)</b></p>";
echo "</div>";

include("footer.php"); // Include the Page Layout footer
?>