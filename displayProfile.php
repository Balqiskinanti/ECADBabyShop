<?php 
session_start();
include("header.php"); // Include the Page Layout header
include_once("mySQLConn.php");

//Check if user logged in 

if (! isset($_SESSION["ShopperID"])) {

    header ("Location: login.php");
    
    exit;
    }
?>


<?php 
    $shopperID = $_SESSION["ShopperID"];
    $stmt = mysqli_prepare($conn, "SELECT Name, Address, Country, Phone, Email, PwdQuestion, PwdAnswer FROM shopper where ShopperID=?");
    mysqli_stmt_bind_param($stmt, "i", $shopperID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $address, $country, $phone, $email, $pwqn, $pwans);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
?>

<!-- Header -->
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(./Images/Template/profilebaby.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white">Hello <?php echo $name; ?></h1>
            <p class="text-white mt-0 mb-5">This is your profile page.</p>
            <a href="editProfile.php" class="btn btn-info">Edit profile</a>
          </div>
        </div>
      </div>
    </div>

<div class="col-xl-12 order-xl-1 align-items-center">
          <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">My Profile</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form>
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-name">Name</label>
                        <input type="text" id="input-name" class="form-control form-control-alternative" placeholder="Name" readonly value="<?php echo $name; ?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" id="input-email" class="form-control form-control-alternative" readonly placeholder="Email" value="<?php echo $email; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-passwordqn">Password Question</label>
                        <input type="text" id="input-passwordqn" class="form-control form-control-alternative" readonly placeholder="Password Question" value="<?php echo $pwqn; ?>">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-pwqn">Password Question Answer</label>
                        <input type="text" id="input-pwqn" class="form-control form-control-alternative" readonly placeholder="Password Question Answer" value="<?php echo $pwans; ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4">
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-address">Address</label>
                        <input id="input-address" class="form-control form-control-alternative" readonly placeholder="Address" value="<?php echo $address; ?>" type="text">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-contact">Contact Number</label>
                        <input type="text" id="input-contact" class="form-control form-control-alternative" readonly placeholder="Contact Number" value="<?php echo $phone; ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-country">Country</label>
                        <input type="text" id="input-country" class="form-control form-control-alternative" readonly placeholder="Country" value="<?php echo $country; ?>">
                      </div>
                    </div>
                    <div class="col-lg-4">
                    <div class="form-group focused">
                        <label class="form-control-label" for="input-shopperid">Shopper ID</label>
                        <input type="text" id="input-shopperid" class="form-control form-control-alternative" readonly placeholder="Shopper ID" value="<?php if(isset($_SESSION['ShopperID'])) echo $_SESSION['ShopperID'];?>">
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?php 
include("footer.php"); // Include the Page Layout footer
?>