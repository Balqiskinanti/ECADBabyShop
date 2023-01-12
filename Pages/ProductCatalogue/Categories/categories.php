<?php
// current session & db conn
include_once("mySQLConn.php");

// get all categories
$qry = "SELECT * FROM category";
$result = $conn->query($qry);

// close connection
$conn->close();

// categories containers 
$htmlElement = "";
while($row = $result->fetch_array()){
    $imgPath = $row["CatImage"];
    $title = $row["CatName"];
    $desc = $row["CatDesc"];
    $htmlElement .= '
        <div class="col-md-4 mb-3">
            <a href="productListings.php?cid=' . $row["CategoryID"] . '&' . 'catName=' . $title . '" style="text-decoration:none;color:black;">
                <div class="card h-100">
                    <div class="img-wrapper">
                        <img class="img-fluid" alt="100%x280" src="./Images/Category/' . $imgPath .'">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><b>' . $title . '</b></h4>
                        <p class="card-text" style="font-size:small; padding-top:10px;">' . $desc . '</span></p>
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