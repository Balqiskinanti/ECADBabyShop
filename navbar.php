<?php
    //  Navbar links 
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

        //Display number of item in cart
        if (! isset($_SESSION["NumCartItem"]))
        {
            $_SESSION["NumCartItem"] = 0;
        }

        if (! isset($_SESSION["SubTotal"]))
        {
            $_SESSION["SubTotal"] = 0;
            $formattedSubTotal = $_SESSION["SubTotal"];
        }
        else
        {
            $formattedSubTotal = number_format($_SESSION["SubTotal"], 2);
        }

        $content1 = "
        <div class='collapse navbar-collapse justify-content-end' id='collapsibleNavbar'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a type='button' class='nav-link btn btn-outline-secondary' href='shoppingCart.php'>$_SESSION[NumCartItem] / $$formattedSubTotal <img src='../ECADBabyShop/Images/Login/shopping-bag.png' width='30' height='30'></a>
                </li>
                <li class='nav-item dropdown'>
                    <a type='button' class='nav-link dropdown-toggle' id='navbarDropdown' data-toggle='dropdown' href='#'>$_SESSION[ShopperName] <img src='../ECADBabyShop/Images/Login/user.png' width='30' height='30'></a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
                        <a class='dropdown-item' href='changePassword.php' style='font-size:small!important;padding:.25rem .5rem!important;'>Change Password</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='editProfile.php'style='font-size:small!important;padding:.25rem .5rem!important;'>Update Profile</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='displayProfile.php'style='font-size:small!important;padding:.25rem .5rem!important;'>View Profile</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='memberRating.php' style='font-size:small!important;padding:.25rem .5rem!important;'>Write Feedback ✍️</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='logout.php' style='font-size:small!important;padding:.25rem .5rem!important;'>Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
        ";
    }
?>

<nav class="navbar navbar-expand-md bg-light navbar-light sticky-top">
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
        <img src="Images/Template/LongLogo.PNG" alt="" style="height: 50px;" >
    </a>
    
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navbar links -->
    <div class="collapse navbar-collapse justify-content-end links" id="collapsibleNavbar">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="productCategories.php">Product Catalogue</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="search.php">Search Product</a>
        </li>
        </ul>
    </div>

    <?php echo $content1;?>
</nav>