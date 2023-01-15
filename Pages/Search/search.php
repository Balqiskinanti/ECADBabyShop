<?php
// db conn
include_once("mySQLConn.php");

// search value partial - name and description
$searchVal = NULL;
if(isset($_POST["partial-search"])){
    $searchVal = '%' . $_POST["partial-search"] . '%' ;
}

// category selected
$catVal = NULL;
if(isset($_POST["cat-select"]) && $_POST["cat-select"] != 0){
    $catVal = $_POST["cat-select"];
}

// gender selected
$genderVal = NULL;
if(isset($_POST["gender-select"]) && $_POST["gender-select"] != "All"){
    $genderVal = $_POST["gender-select"];
}

// on promotion currently?
$offered = NULL;
$validOffer = ")";
if(isset($_POST["offer-select"])){
    $offered = $_POST["offer-select"];
    if($_POST["offer-select"] == 1){
        $validOffer = " AND now() >= p.OfferStartDate AND now() <= p.OfferEndDate)";
    }
    if($_POST["offer-select"] == 0){
        $validOffer = " OR (p.Offered = 1 AND NOT( now() >= p.OfferStartDate AND now() <= p.OfferEndDate)))";
    }
}

// in stock currently?
$inStock = "";
if(isset($_POST["instock-select"])){
    if($_POST["instock-select"] == 1){
        $inStock = " AND p.Quantity > 0";
    }
}

// min price value
$minPrice = 0;
if(isset($_POST["min-price"])){
    if (empty($_POST["min-price"])){
        $minPrice = -1;
    }
    else{
        $minPrice = $_POST["min-price"];
    }
}

// max price value
$maxPrice = 0;
if(isset($_POST["max-price"])){
    if (empty($_POST["max-price"])){
        $maxPrice = -1;
    }
    else{
        $maxPrice = $_POST["max-price"];
    }
}

// get all products filtered
$qry = "SELECT DISTINCT p.*,c.*
From catproduct cp 
INNER JOIN product p 
ON cp.ProductID=p.ProductID
INNER JOIN category c
ON c.CategoryID = cp.CategoryID
INNER JOIN productspec ps
ON ps.ProductID = p.ProductID
INNER JOIN specification s
ON s.SpecID = ps.SpecID
WHERE (p.ProductTitle LIKE COALESCE(?, p.ProductTitle) OR p.ProductDesc LIKE COALESCE(?, p.ProductDesc))
AND  COALESCE(?, c.CategoryID) = c.CategoryID 
AND COALESCE(?, ps.SpecVal) = ps.SpecVal" . $inStock .
" AND (COALESCE(?, p.Offered) = p.Offered" . $validOffer . "ORDER BY p.ProductTitle ASC";

$stmt = $conn->prepare($qry);
$stmt->bind_param("ssisi", $searchVal, $searchVal, $catVal, $genderVal,  $offered);
$stmt->execute();
$result = $stmt->get_result();

// get all categories for dropdown
$qryGetCatList = "SELECT DISTINCT CategoryID ,CatName From category";
$resultCatList = $conn->query($qryGetCatList);

// get all gender for dropdown
$qryGetGenderList = "SELECT DISTINCT SpecVal From productspec WHERE SpecID = 4";
$resultGenderList = $conn->query($qryGetGenderList);

// close connection
$stmt->close();
$conn->close();  

// html for category option
$catListOptionHTMLElement = "";
while($row = $resultCatList->fetch_array()){
    $catListOptionHTMLElement .= '<option value=' . $row["CategoryID"] . ' >'. $row["CatName"] .'</option>';
}

// html for gender option
$genderListOptionHTMLElement = "";
while($row = $resultGenderList->fetch_array()){
    $genderListOptionHTMLElement .= '<option value='. $row["SpecVal"] .' >'. $row["SpecVal"] .'</option>';
}

// html for product list
$htmlElement = "";
while($row = $result->fetch_array()){
    $imgPath = $row["ProductImage"];
    $title = $row["ProductTitle"];
    $description = $row["ProductDesc"];
    $cid = $row["CategoryID"];
    $catName= $row["CatName"];

    $now = new DateTime('now');
    ($now->format('Y-m-d') >= $row["OfferStartDate"]  && $now->format('Y-m-d') <= $row["OfferEndDate"]) ? $isOfferStillOnGoing = true : $isOfferStillOnGoing = false;
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $price =  "$" . $row["OfferedPrice"] : $price = "$" . $row["Price"];
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $priceVal =  $row["OfferedPrice"] : $priceVal = $row["Price"];
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $oldPrice =  "$" . $row["Price"] : $oldPrice = "";

    // indicators : offer & out of stock
    // if still offerred but out of stock, out of stock indicator will be shown
    $indicatorHTML = "";
    $disabled = "";
    ($row["Offered"] == 1 && $isOfferStillOnGoing) ? $indicatorHTML = "<div style='text-align: center; background-color: #0ACF83; color: white;'>On Offer</div>" : $indicatorHTML = "";
    ($row["Quantity"] == 0) ? $indicatorHTML = "<div style='text-align: center; background-color: red; color: white;'>Out of Stock</div>" : $indicatorHTML = $indicatorHTML;
    ($row["Quantity"] == 0) ? $disabled = "disabled" : $disabled = "";

    if($maxPrice == -1 || $minPrice == -1){
        if($maxPrice == -1 && $minPrice == -1){
            $htmlElement .= '
                <div class="col-md-4 mb-3">
                    <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                        <div class="card h-100">
                            <div class="img-wrapper">
                                <img class="img-fluid" alt="100%x280" src="./Images/Products/'. $imgPath . '">'. $indicatorHTML .'
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><b>'. $title .'</b></h4>
                                <p class="card-text">' . $price . ' <span class="price-before">' . $oldPrice . '</span></p>
                            </div>
                        </div>
                    </a>
                </div>
            ';
        }
        elseif($minPrice == -1){
            if($priceVal <= $maxPrice){
                $htmlElement .= '
                    <div class="col-md-4 mb-3">
                        <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                            <div class="card h-100">
                                <div class="img-wrapper">
                                    <img class="img-fluid" alt="100%x280" src="./Images/Products/'. $imgPath . '">'. $indicatorHTML .'
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><b>'. $title .'</b></h4>
                                    <p class="card-text">' . $price . ' <span class="price-before">' . $oldPrice . '</span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                ';
            }
        }
        elseif($maxPrice == -1){
            if($priceVal >= $minPrice){
                $htmlElement .= '
                    <div class="col-md-4 mb-3">
                        <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                            <div class="card h-100">
                                <div class="img-wrapper">
                                    <img class="img-fluid" alt="100%x280" src="./Images/Products/'. $imgPath . '">'. $indicatorHTML .'
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><b>'. $title .'</b></h4>
                                    <p class="card-text">' . $price . ' <span class="price-before">' . $oldPrice . '</span></p>
                                </div>
                            </div>
                        </a>
                    </div>
                ';
            }
        }
    }
    elseif(($maxPrice != 0 && $minPrice != 0)) {
        if($priceVal >= $minPrice && $priceVal <= $maxPrice){
            $htmlElement .= '
                <div class="col-md-4 mb-3">
                    <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                        <div class="card h-100">
                            <div class="img-wrapper">
                                <img class="img-fluid" alt="100%x280" src="./Images/Products/'. $imgPath . '">'. $indicatorHTML .'
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><b>'. $title .'</b></h4>
                                <p class="card-text">' . $price . ' <span class="price-before">' . $oldPrice . '</span></p>
                            </div>
                        </div>
                    </a>
                </div>
            ';
        }
    }
    else{
        $htmlElement .= '
            <div class="col-md-4 mb-3">
                <a href="productDetails.php?pid=' . $row["ProductID"] . '&' . 'productName=' . $title . '&' . 'cid=' . $cid . '&' . 'catName=' . $catName . '" style="text-decoration:none;color:black;">
                    <div class="card h-100">
                        <div class="img-wrapper">
                            <img class="img-fluid" alt="100%x280" src="./Images/Products/'. $imgPath . '">'. $indicatorHTML .'
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><b>'. $title .'</b></h4>
                            <p class="card-text">' . $price . ' <span class="price-before">' . $oldPrice . '</span></p>
                        </div>
                    </div>
                </a>
            </div>
        ';
    }
    
}  
?>


<div class="container-fluid m-0">

    <!-- Search Form -->
    <form  method="post" action="" class="row">
        <div class="col-sm-10">
            <div class="form">
                <i class="fa fa-search"></i>
                <input name="partial-search" type="text" class="form-control form-input" placeholder="Search by Product Name or Description">
            </div>
        </div>
        <div class="col-sm-2" style="margin-top: 50px; padding-left: 0;">
        <button type="submit" class="nav-link btn btn-dark m-0" style="height:50px; width:inherit;">Search</button>
        </div>
    </form>

    <div class="row" style="padding-top: 30px; margin-left:8px;">
        <!-- Filter Form -->
        <div class="col-sm-3" style="padding-top:10px; border-radius:10px; border:1px solid #d1d5db;">
            <form  method="post" action="" >

                <!-- Categories -->
                <p style="font-size:small;  margin-bottom: 5px;"><b>Categories</b></p>
                <select name="cat-select" class="col form-select form-select-lg" aria-label=".form-select-sm example" style="height: 40px; border-radius:5px; border:1px solid #d1d5db;">
                    <option value=0 selected>All</option>
                    <?php echo $catListOptionHTMLElement ?>
                </select>

                <!-- Gender -->
                <p style="font-size:small; padding-top: 20px; margin-bottom: 5px;"><b>Gender</b></p>
                <select name="gender-select" class="col form-select form-select-lg" aria-label=".form-select-sm example" style="height: 40px; border-radius:5px; border:1px solid #d1d5db;">
                    <option value="All" selected>All</option>
                    <?php echo $genderListOptionHTMLElement ?>
                </select>

                <!-- Price Range -->
                <p style="font-size:small; padding-top: 20px; margin-bottom: 5px;" ><b>Price Range</b></p>
                <div class="row">
                    <div class="col-5" style="padding: 0; padding-left: 15px;">
                        <div class="input-group">
                            <span class="input-group-addon form-control col-1">$</span>
                            <input name="min-price" type="number" class="form-control" placeholder="Min" min="0">
                        </div>
                    </div>
                    <div class="col-1 justify-content-center align-self-center">
                        -
                    </div>
                    <div class="col-5" style="padding: 0; padding-left: 15px;">
                        <div class="input-group">
                            <span class="input-group-addon form-control col-1">$</span>
                            <input name="max-price" type="number" class="form-control" placeholder="Max" min="0">
                        </div>
                    </div>
                </div>

                <!-- On Offer -->
                <p style="font-size:small; padding-top: 20px; margin-bottom: 5px;"><b>On Offer?</b></p>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="radio" value=1 name="offer-select">
                        <label for="age1">Yes</label><br>  
                    </div>
                    <div class="col-sm-3">
                        <input type="radio" value=0 name="offer-select">
                        <label for="age1">No</label><br>  
                    </div>
                </div>  

                <!-- In Stock -->
                <p style="font-size:small; padding-top: 10px; margin-bottom: 5px;"><b>In Stock?</b></p>
                <div class="row">
                    <div class="col-sm-3">
                        <input type="radio" value=1 name="instock-select">
                        <label for="age1">Yes</label><br>  
                    </div>
                    <div class="col-sm-3">
                        <input type="radio" value=0 name="instock-select">
                        <label for="age1">No</label><br>  
                    </div>
                </div> 

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="nav-link btn btn-dark m-0" style="margin-top: 10px!important;width:inherit!important;">Apply Filter </button>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="nav-link btn btn-outline-secondary m-0" style="margin-top: 10px!important;width:inherit!important; margin-bottom:10px!important;">Reset Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Product List -->
        <div class="col-sm-9">
            <div class="row">
                <?php echo $htmlElement ?>
            </div>
        </div>
    </div>
</div>