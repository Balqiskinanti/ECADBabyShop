<?php 
session_start();
// header
include("header.php"); 
?>

<div style="min-height:80vh;padding-left:100px;padding-right:100px">
    <div id="brand-name">
        EBS
    </div>

    <div id="promotion-list-title" style="padding-right:50px;">
        FREQUENTLY ASKED QUESTIONS
    </div>

    <div id="accordion" style="padding-top:30px">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Do I need to be a member to purchase items?
                </button>
            </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                Yes. you need to register as a member to buy our items. However, you can always browse our items without creating an account.
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                How do I get the products with the latest offers?
                </button>
            </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
                Simply navigate to the "Search Product" link in the navigation bar, and filter "In Offer" products. Search and filters functions such as price, categories and specifications are also available for your convenience!
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                What methods of payment do you take?
                </button>
            </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                We currently accept PayPal.
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                How long will my shipping take?
                </button>
            </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
            <div class="card-body">
                We offer 2 types of delivery.<br/>
                <b>Normal Delivery</b> : within 2 working days <br/>
                <b>Express Delivery</b> : within 24 hours
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Do you accept exchange & refunds?
                </button>
            </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
            <div class="card-body">
                We will refund any items you return (with labels and tags still attached) within 30 days of purchase, excluding the delivery fee. Please send us an email together with the order number and items SKUs and quantity that you wish to refund. Once we have received your return, we will send you an email confirming receipt of the parcel and process your refund.
                For reasons of hygiene, underwear, and bathing items are not eligible for refund or exchange.    
            </div>
            </div>
        </div>
    </div>
</div>

<?php 
// footer
include("footer.php"); 
?>