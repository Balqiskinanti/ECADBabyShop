<?php 
session_start(); 
// header
include("./Pages/Shared/header.php"); 
?>

<?php
// render categories
include("./Pages/ProductCatalogue/Details/title.php");
include("./Pages/ProductCatalogue/Details/details.php");
?>

<?php 
// footer
include("./Pages/Shared/footer.php"); 
?>