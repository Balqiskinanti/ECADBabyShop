<?php 
session_start();
// header
include("header.php"); 
?>

<?php
// render categories
include("./Pages/ProductCatalogue/Categories/title.php");
include("./Pages/ProductCatalogue/Categories/categories.php");
?>

<?php 
// footer
include("footer.php"); 
?>