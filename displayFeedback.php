<?php 
// Detect the current session
//session_start(); 
// Include the Page Layout header
//include("header.php"); 
?>

<link rel="stylesheet" href="css/owl.carousel.min.css">
<link rel="stylesheet" href="css/owl.theme.default.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<link rel="stylesheet" href="Css/site.css">

<div id="promotion-list-title"><i class="fas fa-star checked"></i>
                Feedbacks <i class="fas fa-star checked"></i>
            </div>
<div class="owl-carousel owl-theme">
  <?php
    // Connect to database and retrieve reviews
    include_once("mySQLConn.php");

    $sql = "SELECT feedback.Subject, feedback.Content, feedback.Rank, shopper.Name FROM feedback JOIN shopper ON feedback.ShopperID = shopper.ShopperID";
        $result = $conn->query($sql);

        if ($result->num_rows != 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="container">
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-12">';
                echo '<div class="review-item">';
                echo '<div class="profile-icon">';
                $pname = explode(" ", $row["Name"]);
                $initials = "";
                foreach($pname as $pn){
                    $initials .= $pn[0];
                }
                echo '<p>'.$initials.'</p>';
                echo '</div>';
                echo '<span class="username">' . $row["Name"] . '</span>';
                echo '<h3>' . $row["Subject"] . '</h3>';
                echo '<p>' . $row["Content"] . '</p>';
                //echo '<p>Rating:' . $row["Rank"] . '</p>';
                echo '<p>Rating: ';
                for($i = 0; $i < $row["Rank"]; $i++){
                    echo '<i class="fas fa-star checked"></i>';
                }
                echo '</p>';

                echo '</div>
                </div>
                </div>
                </div>';
            }
        }
        else{
            echo "No reviews found.";
        }
        $conn->close();
  ?>
</div>


<script>
    $(document).ready(function(){
  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true,
    autoHeight:true,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
  });
});



</script>

