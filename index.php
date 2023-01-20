<?php 
// current session
session_start();

// header
include("header.php"); 
?>

<?php
// render main
include("./Pages/Main/cta.php");
include("./Pages/Main/promotionListCarousel.php");
include("./Pages/Main/purchaseSteps.php");
include("displayFeedback.php");
//include("./Pages/Main/feedback.php");
?>

<?php 
// footer
include("footer.php"); 
?>