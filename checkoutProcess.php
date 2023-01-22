<?php
session_start();

include("header.php"); // Include the Page Layout header
include_once("myPayPal.php"); // Include the file that contains PayPal settings
include_once("mySQLConn.php"); 


// Shipping Info Data
//$_SESSION["ShippingInfo"] = array($_POST["shippingName"], $_POST["shippingTel"] , $_POST["shippingEmail"] , $_POST["shippingCountry"], $_POST["shippingAddress"], $_POST["deliveryChoice"], $_POST["billingName"], $_POST["billingTel"], $_POST["billingEmail"], $_POST["billingCountry"], $_POST["billingAddress"] );

// Code to check inventory
$qry = "SELECT p.Quantity AS PQ, 
				   sc.Quantity AS SCQ,
				   p.ProductID AS ProductID,
				   p.ProductTitle AS ProductTitle
			FROM product p 
			INNER JOIN shopcartitem sc ON p.ProductID = sc.ProductID WHERE sc.ShopCartID = ?;";

$stmt = $conn->prepare($qry);
$stmt->bind_param("i", $_SESSION["Cart"]);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();

$outOfStock = false;
while ($row = $result->fetch_array()) {
    $remaining = $row["PQ"] - $row["SCQ"];
    if ($remaining < 0 )
    {
        $outOfStock = true;
        echo "$row[ProductTitle] is out of stock!<br />";
    }
}
if ($outOfStock == true)
{
    echo "Please return to shopping cart to amend your purchase.<br />";
    include("footer.php");
    exit;
}	

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
$_SESSION["Tax"] = number_format(($row['TaxRate'] / 100) * ($_SESSION['SubTotal'] + $_SESSION['Discount']),2);

// Compute Shipping Charge
// Get Bool from JY to set ship charge to 0
if ($_SESSION["SubTotal"] >= 200)
{
	$_SESSION["ShipCharge"] = 0;
}
else
{
	$_SESSION["ShipCharge"] = (int)$_SESSION["ShippingInfo"][5];
}


// Code to check calculations 
echo "Tax: ".$_SESSION["Tax"]."</br>";
echo "Discount: ".$_SESSION["Discount"]."</br>";
echo "SubTotal: ".$_SESSION["SubTotal"]."</br>";
echo "Base Subtotal: ".$_SESSION['SubTotal'] + $_SESSION['Discount']."</br>";
echo "Total: ".$_SESSION['SubTotal'] + $_SESSION['ShipCharge'] + $_SESSION['Tax']."</br>";


$paypal_data = '';
foreach($_SESSION['Items'] as $key=>$item) {
    $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item["quantity"]);
    if($item["isOfferStillOnGoing"])
    {
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["offeredPrice"]);
    }
    else
    {
        $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["price"]);
    }
    $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item["name"]);
    $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item["productId"]);
}

$padata = '&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
            '&PAYMENTACTION=Sale'.
            '&ALLOWNOTE=1'.
            '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
            '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION["SubTotal"] +
                                                $_SESSION["Tax"] + 
                                                $_SESSION["ShipCharge"] ).
            '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION["SubTotal"]). 
            '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($_SESSION["ShipCharge"]). 
            '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION["Tax"]). 	
            '&BRANDNAME='.urlencode("ECADBabyStore").
            $paypal_data.				
            '&RETURNURL='.urlencode($PayPalReturnURL ).
            '&CANCELURL='.urlencode($PayPalCancelURL);

//We need to execute the "SetExpressCheckOut" method to obtain paypal token
$httpParsedResponseAr = PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, 
                                    $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                     
    
//Respond according to message we receive from Paypal
if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
{					
    if($PayPalMode=='sandbox')
        $paypalmode = '.sandbox';
    else
        $paypalmode = '';
            
    //Redirect user to PayPal store with Token received.
    $paypalurl ='https://www'.$paypalmode. 
                '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.
                $httpParsedResponseAr["TOKEN"].'';
    header('Location: '.$paypalurl);

}
else 
{
    //Show error message
    echo "<div style='color:red'><b>SetExpressCheckOut failed : </b>".
          urldecode($httpParsedResponseAr["L_LONGMESSAGE0"])."</div>";
    echo "<pre>".print_r($httpParsedResponseAr)."</pre>";
}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"])) 
{	
	//we will be using these two variables to execute the "DoExpressCheckoutPayment"
	//Note: we haven't received any payment yet.
	$token = $_GET["token"];
	$playerid = $_GET["PayerID"];
	$paypal_data = '';
	
	// Get all items from the shopping cart, concatenate to the variable $paypal_data
	// $_SESSION['Items'] is an associative array
    foreach($_SESSION['Items'] as $key=>$item) {
        $paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item["quantity"]);
        if($item["isOfferStillOnGoing"])
        {
            $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["offeredPrice"]);
        }
        else
        {
            $paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($item["price"]);
        }
        $paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item["name"]);
        $paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item["productId"]);
    }
    
	
	//Data to be sent to PayPal
	$padata = '&TOKEN='.urlencode($token).
			  '&PAYERID='.urlencode($playerid).
			  '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
			  $paypal_data.	
			  '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($_SESSION["SubTotal"]).
              '&PAYMENTREQUEST_0_TAXAMT='.urlencode($_SESSION["Tax"]).
              '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($_SESSION["ShipCharge"]).
			  '&PAYMENTREQUEST_0_AMT='.urlencode($_SESSION["SubTotal"] + 
			                                     $_SESSION["Tax"] + 
								                 $_SESSION["ShipCharge"]).
			  '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
	
	//We need to execute the "DoExpressCheckoutPayment" at this point 
	//to receive payment from user.
	$httpParsedResponseAr = PPHttpPost('DoExpressCheckoutPayment', $padata, 
	                                   $PayPalApiUsername, $PayPalApiPassword, 
									   $PayPalApiSignature, $PayPalMode);
	
	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || 
	   "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
	{
		// Update stock inventory in product table 
		// after successful checkout
		// SQL to get all the products in shopping cart.
		// SQL to get product quantity in Shopping Cart
		// SQL To remove the quantity purchased in shopping cart.
		$qry = "SELECT p.Quantity AS PQ, 
					   sc.Quantity AS SCQ,
					   p.ProductID AS ProductID
 				FROM product p 
				INNER JOIN shopcartitem sc ON p.ProductID = sc.ProductID WHERE sc.ShopCartID = ?;";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("i", $_SESSION["Cart"]);
		$stmt->execute();
		$result = $stmt->get_result();

		$stmt->close();

		while ($row = $result->fetch_array())
		{
			$remaining = $row["PQ"] - $row["SCQ"];
			$qry = "UPDATE product SET Quantity = ? WHERE ProductID = ?";
			$stmt = $conn->prepare($qry);
			$stmt->bind_param("ii", $remaining, $row["ProductID"]);
			$stmt->execute();
			$stmt->close();
		}
		
	
		// To Do 2: Update shopcart table, close the shopping cart (OrderPlaced=1)
		$total = $_SESSION["SubTotal"] + $_SESSION["Tax"] + $_SESSION["ShipCharge"];
		$qry = "UPDATE shopcart SET OrderPlaced = 1, Quantity = ?, SubTotal = ?, Tax = ?, ShipCharge = ?, Discount = ?, Total = ?
				WHERE ShopCartID = ?";
		$stmt = $conn->prepare($qry);
		$stmt->bind_param("iddddi", $_SESSION["NumCartItem"], 
						   $_SESSION["SubTotal"], $_SESSION["Tax"],
                           $_SESSION["ShipCharge"], $discount, $total,
						   $_SESSION["Cart"]);
		$stmt->execute();
		$stmt->close();
		
		//We need to execute the "GetTransactionDetails" API Call at this point 
		//to get customer details
		$transactionID = urlencode(
		                 $httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
		$nvpStr = "&TRANSACTIONID=".$transactionID;
		$httpParsedResponseAr = PPHttpPost('GetTransactionDetails', $nvpStr, 
		                                   $PayPalApiUsername, $PayPalApiPassword, 
										   $PayPalApiSignature, $PayPalMode);

		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
        {

            // $_SESSION["ShippingInfo"] = array($_POST["shippingName"], $_POST["shippingTel"] , $_POST["shippingEmail"] , $_POST["shippingCountry"], $_POST["shippingAddress"], $_POST["deliveryChoice"], $_POST["billingName"], $_POST["billingTel"], $_POST["billingEmail"], $_POST["billingCountry"], $_POST["billingAddress"] );

            $shippingName = $_SESSION["ShippingInfo"][0];
            $shippingTel = $_SESSION["ShippingInfo"][1];
            $shippingEmail = $_SESSION["ShippingInfo"][2];
            $shippingCountry = $_SESSION["ShippingInfo"][3];
            $shippingAddress = $_SESSION["ShippingInfo"][4];
			if((int)$_SESSION["ShippingInfo"][5] == 5)
			{
				$deliveryChoice = "Normal";
				$deliveryDate = date ( 'Y-m-j' , strtotime ( '+2 weekdays' ) );
			}
			else
			{
				$deliveryChoice = "Express";
				$deliveryDate = date ( 'Y-m-j' , strtotime ( '+1 day' ) );
			}
            $billingName = $_SESSION["ShippingInfo"][6];
            $billingTel = $_SESSION["ShippingInfo"][7];
            $billingEmail = $_SESSION["ShippingInfo"][8];
            $billingCountry = $_SESSION["ShippingInfo"][9];
            $billingAddress = $_SESSION["ShippingInfo"][10];
			$deliveryDate = 0;
			$msg = "Testing";
			
            
			// Insert an Order record with shipping information
			// Get the Order ID and save it in session variable.
			$qry = "INSERT INTO `orderdata` (`ShopCartID`, `ShipName`, `ShipAddress`, `ShipCountry`, `ShipPhone`, `ShipEmail`, `BillName`, `BillAddress`, `BillCountry`, `BillPhone`, `BillEmail`, `DeliveryDate`, `DeliveryTime`, `DeliveryMode`, `Message`, `OrderStatus`, `DateOrdered`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, ?, ?,'1', current_timestamp()";
			$stmt = $conn->prepare($qry);
			$stmt->bind_param("isssissssissss", $_SESSION["Cart"],$shippingName, $shippingTel, $shippingEmail, $shippingCountry, $deliveryChoice, $billingName, $billingTel, $billingCountry, $billingAddress, $deliveryDate, $deliveryChoice);
			$stmt->execute();
			$stmt->close();

			$qry = "SELECT LAST_INSERT_ID() AS OrderID";
			$result = $conn->query($qry);
			$row = $result->fetch_array();
			$_SESSION["OrderID"] = $row["OrderID"];

				
			$conn->close();
				  
			//Reset the "Number of Items in Cart" session variable to zero.
			$_SESSION["NumCartItem"] = 0;
	  		
			//Clear the session variable that contains Shopping Cart ID.
			unset($_SESSION["Cart"]);
			
			// To Do 4C: Redirect shopper to the order confirmed page.
			header("Location: orderReview.php");
			exit;
		} 
		else 
		{
		    echo "<div style='color:red'><b>GetTransactionDetails failed:</b>".
			                urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo "<pre>".print_r($httpParsedResponseAr)."</pre>";
			$conn->close();
		}
	}
	else {
		echo "<div style='color:red'><b>DoExpressCheckoutPayment failed : </b>".
		                urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
		echo "<pre>".print_r($httpParsedResponseAr)."</pre>";
	}
}

//header ("Location: orderReview.php");
include("footer.php"); // Include the Page Layout footer
?>