<?php 
// Detect the current session
session_start(); 
// Include the Page Layout header
include("header.php"); 
?>

<?php 
    $shopperID = $_SESSION["ShopperID"];
    $stmt = mysqli_prepare($conn, "SELECT Name FROM shopper where ShopperID=?");
    mysqli_stmt_bind_param($stmt, "i", $shopperID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
?>

<div style="width:80%; margin:auto;">
<form name="register" action="submit_feedback.php" method="post">
    <div class="form-group row">
        <div class="col-sm-9 offset-sm-3" style="padding-top:30px">
            <span class="page-title">Member's Feedback</span>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="shopperID">Shopper ID:</label>
        <div class="col-sm-9">
            <input class="form-control" name="shopperID" id="shopperID" 
                   type="text" readonly value="<?php if(isset($_SESSION['ShopperID'])) echo $_SESSION['ShopperID'];?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="name">Name:</label>
        <div class="col-sm-9">
            <input class="form-control" name="name" id="name" 
                   type="text" readonly value="<?php echo $name; ?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="subject">Subject:</label>
        <div class="col-sm-9">
            <input class="form-control" name="subject" id="subject" 
                   type="text" required /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="rating">Rating:</label>
        <div class="col-sm-9">
            <select name="rating" id="rating">
                <option value="1">1 star</option>
                <option value="2">2 star</option>
                <option value="3">3 star</option>
                <option value="4">4 star</option>
                <option value="5">5 star</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="feedback">Feedback:</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="feedback" id="feedback"
                      cols="25" rows="4" ></textarea>
        </div>
    </div>
    
    <div class="form-group row">       
        <div class="col-sm-9 offset-sm-3">
            <button type="submit" class='btn btn-dark'>Submit</button>
        </div>
    </div>
</form>
</div>
<?php 
// Include the Page Layout footer
include("footer.php"); 
?>