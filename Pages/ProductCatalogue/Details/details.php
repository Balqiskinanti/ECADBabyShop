<?php
// db conn
include_once("mySQLConn.php");

// get product details $pid
$pid = $_GET["pid"];
$cid = $_GET["cid"];
$catName = $_GET["catName"];

$qry = "SELECT * 
FROM product 
WHERE ProductID=?";

$stmt = $conn->prepare($qry);
$stmt->bind_param("i",$pid);
$stmt->execute();
$result = $stmt->get_result();

// html element for product details
$htmlElement = "";
while($row = $result->fetch_array()){
    $imgPath = $row["ProductImage"];
    $title = $row["ProductTitle"];
    $description = $row["ProductDesc"];

    $now = new DateTime('now');
    ($now->format('Y-m-d') >= $row["OfferStartDate"]  && $now->format('Y-m-d') <= $row["OfferEndDate"]) ? $isOfferStillOnGoing = true : $isOfferStillOnGoing = false;
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $price =  "$" . $row["OfferedPrice"] : $price = "$" . $row["Price"];
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $oldPrice =  "$" . $row["Price"] : $oldPrice = "";

    // indicators : offer & out of stock
    // if still offerred but out of stock, out of stock indicator will be shown
    $indicatorHTML = "";
    $disabled = "";
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $indicatorHTML = "<div style='text-align: center; background-color: #0ACF83; color: white;'>On Offer</div>" : $indicatorHTML = "";
    ($row["Quantity"] == 0) ? $indicatorHTML = "<div style='text-align: center; background-color: red; color: white;'>Out of Stock</div>" : $indicatorHTML = $indicatorHTML;
    ($row["Quantity"] == 0) ? $disabled = "disabled" : $disabled = "";

    // get specification of product
    $qry = "SELECT s.SpecName, ps.SpecVal 
    FROM productspec ps
    INNER JOIN specification s ON ps.SpecID=s.SpecID
    WHERE ps.ProductID=?
    ORDER BY ps.priority DESC";

    $stmt = $conn->prepare($qry);
    $stmt->bind_param("i",$pid);
    $stmt->execute();
    $specResult = $stmt->get_result();

    // close connection
    $stmt->close();
    $conn->close();

    // html element for specification
    $specHTML = '';
    while($specRow = $specResult->fetch_array()){
        $specHTML .= '<p style="font-size: small;"><b>' . $specRow["SpecName"] . '</b> : ' . $specRow["SpecVal"] . '</p>';
    }
    
    $htmlElement .= '
        <div style="padding-left: 100px;">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color:white!important;">
                    <li class="breadcrumb-item"><a href="productCategories.php" style="font-size: small;">Categories</a></li>
                    <li class="breadcrumb-item"><a href="productListings.php?cid=' . $cid . '&' . 'catName=' . $catName . '" style="font-size: small;">'. $catName .'</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a style="font-size: small!important; text-decoration: none; color: darkgray;">' . $title . '</a></li>
                </ol>
            </nav>
        </div>

        <div class="container-fluid m-0" style="padding:80px 100px; padding-top: 5px;">
        <div class="row">
            <div class="col-sm-4">
                <div class="img-wrapper h-100">
                    <img alt="100%x280" src="./Images/Products/' . $imgPath . '">
                    ' . $indicatorHTML . '
                </div>
            </div>
            <div class="col-sm-5">
                <div class="h-100">
                    <h2>
                        ' . $title . '
                    </h2>
                    <p style="font-size: small;">
                        ' . $description . '
                    </p>
                    <p class="card-text">' . $price . ' <span class="price-before">' . $oldPrice . '</span></p>
                    <input class="form-control ' . $disabled . '" style="background-color:white!important;" id="disabledInput" type="number" placeholder="0" min="0" max="10">
                    <a type="button" class="nav-link btn btn-dark m-0 ' . $disabled .'" style="margin-top: 10px!important;" href="#">Add to Cart</a>
                </div>
            </div>
            <div class="col-sm-3">
            <div class="h-100">
                <p style="font-size: small; margin-bottom: 30px;">
                    <mark style="padding: 10px;"><b>Specifications</b></mark>
                </p>' . $specHTML . '
            </div>
            </div>
        </div>
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