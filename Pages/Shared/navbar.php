<nav class="navbar navbar-expand-md bg-light navbar-light sticky-top">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
        Logo
    </a>
    
    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navbar links -->
    <div class="collapse navbar-collapse justify-content-end links" id="collapsibleNavbar">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#">Product Catalogue</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Search Product</a>
        </li>
        </ul>
    </div>

    <!-- rmeove later -->
   <div class='collapse navbar-collapse justify-content-end' id='collapsibleNavbar'>
        <ul class='navbar-nav'>
            <li class='nav-item'>
            <a type='button' class='nav-link btn btn-outline-secondary' href='#'>Log In</a>
            </li>
            <li class='nav-item'>
            <a  type='button' class='nav-link btn btn-dark' href='#'>Register</a>
            </li>
        </ul>
    </div>



    <?php

    // <!-- Navbar links -->
    $content1 = "<div class='collapse navbar-collapse justify-content-end' id='collapsibleNavbar'>
        <ul class='navbar-nav'>
            <li class='nav-item'>
            <a type='button' class='nav-link btn btn-outline-secondary' href='#'>Log In</a>
            </li>
            <li class='nav-item'>
            <a  type='button' class='nav-link btn btn-dark' href='#'>Register</a>
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
                    <a type='button' class='nav-link btn btn-outline-secondary' href='#'>$_SESSION[NumCartItem]</a>
                </li>
                <li class='nav-item'>
                    <a  type='button' class='nav-link btn btn-dark' href='#'>$_SESSION[ShopperName]</a>
                    <ul class='navbar-nav'>
                        <li class='nav-item'><a class='nav-link' href='#'>Change Password</a></li>
                        <li class='nav-item'><a class='nav-link' href='#'>Update Profile</a></li>
                        <li class='nav-item'><a class='nav-link' href='#'>Log Out</a></li>
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
</nav>
