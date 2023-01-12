<?php
// current session & db conn
include_once("mySQLConn.php");

// get all products from category $cid
$cid = $_GET["cid"];

$qry = "SELECT p.*
From catproduct cp 
INNER JOIN product p 
ON cp.ProductID=p.ProductID
WHERE cp.CategoryID=?";

$stmt = $conn->prepare($qry);
$stmt->bind_param("i",$cid);
$stmt->execute();
$result = $stmt->get_result();

// close connection
$stmt->close();
$conn->close();

// categories containers 
$htmlElement = "";
while($row = $result->fetch_array()){
    $imgPath = $row["ProductImage"];
    $title = $row["ProductTitle"];
    $now = new DateTime('now');
    ($now->format('Y-m-d') >= $row["OfferStartDate"]  && $now->format('Y-m-d') <= $row["OfferEndDate"]) ? $isOfferStillOnGoing = true : $isOfferStillOnGoing = false;
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $price =  "$" . $row["OfferedPrice"] : $price = $row["Price"];
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $oldPrice =  "$" . $row["Price"] : $oldPrice = "";

    // indicators : offer & out of stock
    // if still offerred but out of stock, out of stock indicator will be shown
    $indicatorHTML = "";
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $indicatorHTML = "<div style='text-align: center; background-color: #0ACF83; color: white;'>On Offer</div>" : $indicatorHTML = "";
    ($row["Quantity"] == 0) ? $indicatorHTML = "<div style='text-align: center; background-color: red; color: white;'>Out of Stock</div>" : $indicatorHTML = $indicatorHTML;
    
    $htmlElement .= '
        <div class="col-md-4 mb-3">
            <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '" style="text-decoration:none;color:black;">
                <div class="card h-100">
                    <div class="img-wrapper">
                        <img class="img-fluid" alt="100%x280" src="./Images/Products/' . $imgPath .'">' . 
                        
                        $indicatorHTML

                    . '</div>
                    <div class="card-body">
                        <h4 class="card-title"><b>' . $title . '</b></h4>
                        <p class="card-text" style="padding-top:10px;">$ ' . $price . '<span class="price-before">' . $oldPrice . '</span></p>
                    </div>
                </div>
            </a>
        </div>
    ';
}

?>

<div style="padding-top:50px;">
    <div class="container-fluid">
        <div class="row">
            <?php echo $htmlElement ?>
        </div>
    </div>
</div>