<?php 
session_start();
include("header.php"); // header
//include_once("checkoutProcess.php");
if (! isset($_SESSION["ShopperID"])) { // Check if user logged in 
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

$_SESSION["Message"] = $_POST["cusMsg"];
?>
<div class="container">
    <h1>Shipping & Billing</h1> <br>
    <p><u>Shipping & Billing</u> > Review Order & Payment</p> 
    <!-- The underline might be a link? 
    Colour in figma is #18A0FB. 
    link class does not seem to be coloured not sure what it does. -->
    <div class="col-10">
        <form name="checkoutShippingInfo" method="post" action="checkoutReview.php"> <!-- Add a onSubmit="something" to handle validation. -->
            <div class="form-group row">
                <div class="col-sm-10">
                    <h3><b>Shipping</b></h3>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="shippingName" name="shippingName" placeholder="Shipping Name *" maxlength="50" required> 
                </div>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="shippingTel" name="shippingTel" placeholder="Shipping Phone Number" maxlength="20">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="email" id="shippingEmail" name="shippingEmail" placeholder="Shipping Email *" maxlength="50" required> 
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="shippingCountry" name="shippingCountry" placeholder="Shipping Country *" maxlength="50" required> 
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="shippingAddress" name="shippingAddress" placeholder="Shipping Address *" maxlength="150" required> 
                </div>
            </div>
            <div class="form-group row">
                <?php
                if ($_SESSION["isDeliveryFree"])
                {
                    echo "<div class='col-sm-5'>";
                    echo "<input type='radio' id='deliveryNormal' name='deliveryChoice' value='5' disabled>";
                    echo "<label for='deliveryNormal' class='checkoutRadio' disabled>Normal Delivery (2 Days)</label>";
                    echo "</div>";
                    echo "<div class='col-sm-5'>";
                    echo "<input type='radio' id='deliveryExpress' name='deliveryChoice' value='0' checked='checked'>";
                    echo "<label for='deliveryExpress' class='checkoutRadio'>Express Delivery (24 Hrs)</label>";
                    echo "</div>";
                    echo "<h3 style='text-align:center; color:red;'> You are eligible for Free Shipping! </h3>";
                }
                else
                {
                    echo "<div class='col-sm-5'>";
                    echo "<input type='radio' id='deliveryNormal' name='deliveryChoice' value='5' checked='checked'>";
                    echo "<label for='deliveryNormal' class='checkoutRadio'>Normal Delivery (2 Days)</label>";
                    echo "</div>";
                    echo "<div class='col-sm-5'>";
                    echo "<input type='radio' id='deliveryExpress' name='deliveryChoice' value='10'>";
                    echo "<label for='deliveryExpress' class='checkoutRadio'>Express Delivery (24 Hrs)</label>";
                    echo "</div>";
                }
                ?>
            </div>
            
            <!-- Billing information form section -->
            <div class="form-group row">
                <div class="col-sm-10">
                    <h3><b>Billing</b></h3>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="billingName" name="billingName" placeholder="Billing Name *" maxlength="50" required> 
                </div>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="billingTel" name="billingTel" placeholder="Billing Phone Number" maxlength="20">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="email" id="billingEmail" name="billingEmail" placeholder="Billing Email *" maxlength="50" required> 
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="billingCountry" name="billingCountry" placeholder="Billing Country *" maxlength="50" required>  
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="billingAddress" name="billingAddress" placeholder="Billing Address *" maxlength="150" required> 
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button class="form-control invertBtn" type="submit">Next</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php 
// footer
include("footer.php"); 
?>