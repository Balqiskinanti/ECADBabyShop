<?php 
// header
include("./Pages/Shared/header.php"); 
?>
<div class="container">
    <h1>Shipping & Billing</h1> <br>
    <p><u>Shipping & Billing</u> > Review Order & Payment</p> 
    <!-- The underline might be a link? 
    Colour in figma is #18A0FB. 
    link class does not seem to be coloured not sure what it does. -->
    <div class="col-10">
        <form name="checkoutShippingInfo" method="post" action="#"> <!-- Reminder add in action php later. Add a onSubmit="something" to handle validation. -->
            <div class="form-group row">
                <div class="col-sm-10">
                    <h3><b>Shipping</b></h3>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="shippingName" name="shippingName" placeholder="Shipping Name *" required>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="shippingTel" name="shippingTel" placeholder="Shipping Phone Number">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="shippingEmail" name="shippingEmail" placeholder="Shipping Email *" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="shippingCountry" name="shippingCountry" placeholder="Shipping Country *" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="shippingAddress" name="shippingAddress" placeholder="Shipping Address *" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-5">
                    <input type="radio" id="deliveryNormal" name="deliveryChoice" value="#" required>
                    <label for="deliveryNormal" class="checkoutRadio">Normal Delivery (2 Days)</label>
                </div>
                <div class="col-sm-5">
                    <input type="radio" id="deliveryExpress" name="deliveryChoice" value="#" required>
                    <label for="deliveryExpress" class="checkoutRadio">Express Delivery (24 Hrs)</label>
                </div>
            </div>
            
            <!-- Billing information form section -->
            <div class="form-group row">
                <div class="col-sm-10">
                    <h3><b>Billing</b></h3>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="billingName" name="billingName" placeholder="Billing Name *" required>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" type="text" id="billingTel" name="billingTel" placeholder="Billing Phone Number">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="billingEmail" name="billingEmail" placeholder="Billing Email *" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="billingCountry" name="billingCountry" placeholder="Billing Country *" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="billingAddress" name="billingAddress" placeholder="Billing Address *" required>
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
include("./Pages/Shared/footer.php"); 
?>