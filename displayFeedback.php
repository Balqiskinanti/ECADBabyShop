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

<div class="owl-carousel owl-theme">
  <?php
    // Connect to database and retrieve reviews
    include_once("mySQLConn.php");

    $sql = "SELECT Subject, Content, Rank FROM feedback";
        $result = $conn->query($sql);

        if ($result->num_rows != 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="review-item">';
                echo '<h3>' . $row["Subject"] . '</h3>';
                echo '<p>' . $row["Content"] . '</p>';
                //echo '<p>Rating:' . $row["Rank"] . '</p>';
                echo '<p>Rating: ';
                for($i = 0; $i < $row["Rank"]; $i++){
                    echo '<i class="fas fa-star checked"></i>';
                }
                echo '</p>';
                echo '</div>';
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
            items:3
        },
        1000:{
            items:5
        }
    }
  });
});



</script>

