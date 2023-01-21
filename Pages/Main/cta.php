<?php 
$button = '<a  type="button" class="btn btn-dark" href="../ECADBabyShop/login.php" id="cta-btn">Get Started</a>';
if(isset($_SESSION["ShopperName"])){
    $button = '<a  type="button" class="btn btn-dark" href="../ECADBabyShop/productCategories.php" id="cta-btn">Shop Now</a>';
}
?>

<div id="landing">
    <div id="brand-name">
        EBS
    </div>

    <div id="cta">
        <div class="container-fluid m-0">
            <div class="row">
                <div class="col-sm-6" id="cta-text">
                    <h1>
                        Treat Your <span style="color: var(--logo-color);">Little Ones</span> <br/>
                        With the Best Gifts
                    </h1>
                    <p>
                        EBS delivers high quality, age-appropriate, and <br/>
                        comfortable new-born items straight to your door.
                    </p>
                    <?php echo $button ?>
                </div>
                <div class="col-sm-6" id="cta-img">
                    <img src="./Images/Template/Baby.png" alt="Baby image">
                </div>
            </div>
        </div>
    </div>
</div>