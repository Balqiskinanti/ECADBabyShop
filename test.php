<?php
session_start();
include("header.php"); // Include the Page Layout header
include_once("myPayPal.php"); // Include the file that contains PayPal settings
include_once("mySQLConn.php");


// echo "Today is " . date("Y-m-d") . "<br>";
// echo "Today is " . date("Y-m-d h:i:s") . "<br>";
// $normal = date ( 'Y-m-j' , strtotime ( '+6 day' ) );
// $express = date ( 'Y-m-j' , strtotime ( '+6 weekdays' ) );
// echo $normal;
// echo $express;
// $now = new DateTime('now');
//echo "Today is " . $now . "<br>";

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
if ($_SESSION["Message"] != null)
{
    $msg = null;
}
else
{
    $msg = $_SESSION["Message"];
}

$deliveryDate = date("d-F-Y",strtotime($deliveryDate));



for($i=0;$i<11;$i++)
{
    echo $_SESSION["ShippingInfo"][$i]."</br>";
}
//echo $shipAddress."</br>";
echo $deliveryChoice."</br>";
echo $msg."</br>";
echo "Date: ".$deliveryDate."</br>";
echo $_SESSION["Cart"]."</br>";



include("footer.php"); // Include the Page Layout footer
?>