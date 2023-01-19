<?php

    // <!-- Navbar links -->
    $content1 = "<div class='collapse navbar-collapse justify-content-end' id='collapsibleNavbar'>
        <ul class='navbar-nav'>
            <li class='nav-item'>
            <a type='button' class='nav-link btn btn-outline-secondary' href='../ECADBabyShop/login.php'>Log In</a>
            </li>
            <li class='nav-item'>
            <a  type='button' class='nav-link btn btn-dark' href='../ECADBabyShop/register.php'>Register</a>
            </li>
        </ul>
    </div>
    ";



    if(isset($_SESSION["ShopperName"])) { 
        //Display a greeting message, Change Password and logout links 
        //after shopper has logged in.

        $content1 = "
        <div class='collapse navbar-collapse justify-content-end' id='collapsibleNavbar'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a type='button' class='nav-link btn btn-outline-secondary' href='../ECADBabyShop/Pages/ShoppingCart/shoppingCart.php'>cartNum / totalAmt <img src='../ECADBabyShop/Images/Login/shopping-bag.png' width='30' height='30'></a>
                </li>
                <li class='nav-item'>
                    <a type='button' class='nav-link btn' href='#'>$_SESSION[ShopperName] <img src='../ECADBabyShop/Images/Login/user.png' width='30' height='30'></a>
                    <ul class='navbar-nav'>
                        <li class='nav-item'><a class='nav-link' href='#'>Change Password</a></li>
                        <li class='nav-item'><a class='nav-link' href='editProfile.php'>Update Profile</a></li>
                        <li class='nav-item'><a class='nav-link' href='logout.php'>Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        ";

        // //Display number of item in cart
        // if (isset($_SESSION["NumCartItem"]))
        // {
        //     if ($_SESSION["NumCartItem"] != 0)
        //         $content1 .= ", $_SESSION[NumCartItem] item(s) in shopping cart";
        // }
    }
?>

<nav class="navbar navbar-expand-md bg-light navbar-light sticky-top">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
        Logo
    </a>
    
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavBar">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navbar links -->
    <div class="collapse navbar-collapse justify-content-end links" id="collapsibleNavbar">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../ECADBabyShop/productCategories.php#">Product Catalogue</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Search Product</a>
        </li>
        </ul>
    </div>

    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
        <ul class="navbar-nav">
        <?php echo $content1; ?>
        </ul>
    </div>
</nav>
