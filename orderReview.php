<?php 
session_start();
include("header.php"); 
include_once("mySQLConn.php"); 

echo "<div class='container'>";
echo "<h1>Thank you for your order</h1>";
echo " <div class='flexedArea'>";

$qry = "SELECT * FROM orderdata WHERE OrderID = ?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $_SESSION['OrderID']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();	
$conn->close(); 


echo "<p>Here is the summary of order ID #$_SESSION[OrderID]</p>";
while ($row = $result->fetch_array())
{
    $dateOrdered = date("d-F-Y",strtotime($row['DateOrdered']));
    echo "<p>Purchased on: ".$dateOrdered."</p>";
}
echo "</div>";   
//echo "</div>";
?>
<div class='row'>
    <div class="col-sm-6">
        <h2>Shipping</h2>
        <p><b>Shipping Name: </b>Item</p>
        <p><b>Shipping Phone Number: </b>Item</p>
        <p><b>Shipping Email: </b>Item</p>
        <p><b>Shipping Country: </b>Item</p>
        <p><b>Shipping Address: </b>Item</p>
        <p><b>Shipping Name: </b>Something Delivery</p>
    </div>
    <div class="col-sm-6">
        <h2>Billing</h2>
        <p><b>Shipping Name: </b>Item</p>
        <p><b>Shipping Phone Number: </b>Item</p>
        <p><b>Shipping Email: </b>Item</p>
        <p><b>Shipping Country: </b>Item</p>
        <p><b>Shipping Address: </b>Item</p>
    </div>
</div>
<div class='row'>
    <h2 class='col-sm-12'>Your Orders</h2>
    <div class="col-md-6 col-sm-12">
        <table>
            <tr>
                <td><img src="#" alt="Italian Trulli"></td>
                <td>
                    <span>QTY X Product Name</span><br>
                    <span>Price <s>Offered Price</s></span>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6 col-sm-12">
    <table>
            <tr>
                <td><img src="#" alt="Italian Trulli"></td>
                <td>
                    <span>QTY X Product Name</span><br>
                    <span>Price <s>Offered Price</s></span>
                </td>
            </tr>
        </table>
    </div>
</div>

</div>
<?php
include("footer.php"); // Include the Page Layout footer
?>