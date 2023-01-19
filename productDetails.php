<?php 
session_start(); 
// header
include("header.php"); 
?>

<?php
// render categories
include("./Pages/ProductCatalogue/Details/title.php");
include("./Pages/ProductCatalogue/Details/details.php");
?>

<?php 
// footer
include("footer.php"); 
?>