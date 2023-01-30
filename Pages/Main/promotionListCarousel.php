<?php
// current session & db conn
include_once("mySQLConn.php");

$qry = "SELECT *
From catproduct cp 
INNER JOIN product p 
ON cp.ProductID=p.ProductID
INNER JOIN category c
ON c.CategoryID = cp.CategoryID
WHERE p.Offered = 1 AND
p.OfferStartDate <= current_date() AND
p.OfferEndDate >= current_date()
";

$result = $conn->query($qry);

// close connection
//$conn->close();

// categories containers 
$htmlElement = "";
$htmlElementSecondPage = "";
$count = 1;
while($row = $result->fetch_array()){
    $imgPath = $row["ProductImage"];
    $title = $row["ProductTitle"];
    $cid = $row["CategoryID"];
    $catName= $row["CatName"];

    $now = new DateTime('now');
    ($now->format('Y-m-d') >= $row["OfferStartDate"]  && $now->format('Y-m-d') <= $row["OfferEndDate"]) ? $isOfferStillOnGoing = true : $isOfferStillOnGoing = false;
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $price =  "$" . number_format($row["OfferedPrice"],2) : $price = "$" . number_format($row["Price"],2);
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $oldPrice =  "$" . number_format($row["Price"],2) : $oldPrice = "";
    
    // indicators : offer & out of stock
    // if still offerred but out of stock, out of stock indicator will be shown
    $indicatorHTML = "";
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $indicatorHTML = "<div style='text-align: center; background-color: #0ACF83; color: white;'>On Offer</div>" : $indicatorHTML = "";
    ($row["Quantity"] == 0) ? $indicatorHTML = "<div style='text-align: center; background-color: red; color: white;'>Out of Stock</div>" : $indicatorHTML = $indicatorHTML;

    if($count <= 3){
        $count+=1;
        $htmlElement .= '
            <div class="col-md-4 mb-3">
                <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                    <div class="card h-100">
                        <div class="img-wrapper">
                            <img class="img-fluid" alt="100%x280" src="./Images/Products/' . $imgPath .'">' . 
                            
                            $indicatorHTML

                        . '</div>
                        <div class="card-body">
                            <h4 class="card-title"><b>' . $title . '</b></h4>
                            <p class="card-text" style="padding-top:10px;">' . $price . '<span class="price-before">' . $oldPrice . '</span></p>
                        </div>
                    </div>
                </a>
            </div>
        ';
    }
    elseif($count <=6){
        $count+=1;
        $htmlElementSecondPage .= '
            <div class="col-md-4 mb-3">
                <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                    <div class="card h-100">
                        <div class="img-wrapper">
                            <img class="img-fluid" alt="100%x280" src="./Images/Products/' . $imgPath .'">' . 
                            
                            $indicatorHTML

                        . '</div>
                        <div class="card-body">
                            <h4 class="card-title"><b>' . $title . '</b></h4>
                            <p class="card-text" style="padding-top:10px;">' . $price . '<span class="price-before">' . $oldPrice . '</span></p>
                        </div>
                    </div>
                </a>
            </div>
        ';
    }
}
?>

<div id="promotion-list-carausel">
    <div id="promotion-list-small-title">
        PROMOTION
    </div>

    <div id="promotion-list-title">
        GRAB THEM BEFORE THEY'RE GONE 🛒
    </div>

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6 text-right">
                    <a class="btn btn-primary mb-3 mr-1 btn-carausel" href="#carouselExampleIndicators2" role="button" data-slide="prev" style="background-color: white;border:none;color:black; padding:2px!important">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a class="btn btn-primary mb-3 btn-carausel" href="#carouselExampleIndicators2" role="button" data-slide="next" style="background-color: white;border:none;color:black;padding:2px!important">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
    
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">

                                    <?php echo $htmlElement ?>
    
                                </div>
                            </div>
                            <?php 
                                if($htmlElementSecondPage != ""){
                                    echo '
                                        <div class="carousel-item">
                                            <div class="row">' .
                
                                                $htmlElementSecondPage

                                            .'</div>
                                        </div>
                                    ';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>