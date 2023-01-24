<?php
// current session & db conn
include_once("mySQLConn.php");

$qry = "SELECT COUNT(*)
FROM product 
WHERE Offered = 1
AND
OfferStartDate <= now() AND
OfferEndDate >= now() AND
Quantity > 0
";

$result = $conn->query($qry);
$count = $result->fetch_array()[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EBS</title>
    <!-- Icon -->
    <link rel="shortcut icon" href="../../../ShortLogo.PNG" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Site JS -->
    <script src="js/script.js"></script>
    <!-- jQuery -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <!--Site's CSS-->
    <link rel="stylesheet" href="Css/site.css">
</head>

<body>
    <div>
        <div id="promotion-bar">
            Hurry! <?php echo $count ?> Promotions are on going. Grab items at discounted price*
        </div>

        <div id="navigation-bar">
            <?php include("navbar.php"); ?>
        </div>