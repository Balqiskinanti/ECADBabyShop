<?php 
// Detect the current session
session_start(); 
// Include the Page Layout header
include("header.php"); 
?>
<script type="text/javascript">
function validateForm()
{
    // Check if password matched
    if (document.register.password.value != document.register.password2.value) {
        alert("Passwords not matched!");
        return false;

    }
	
	//            Check if telephone number entered correctly
	//           Singapore telephone number consists of 8 digits,
	//           start with 6, 8 or 9
    if (document.register.phone.value != ""){
        var str = document.register.phone.value;
        if (str.length != 8) {
            alert("Please enter a 8-digit phone number.");
            return false;
        }
        else if (str.substr(0,1) != "6" && 
                 str.substr(0,1) != "8" && 
                 str.substr(0,1) != "9" ) {
                    alert ("Phone number in Singapore should start with 6, 8 or 9.");
                    return false;
                 }
    }
    return true;  // No error found
}
</script>

<div style="width:80%; margin:auto;">
<form name="register" action="addMember.php" method="post" 
      onsubmit="return validateForm()">
      <div id="brand-name">EBS</div>
      <div id="promotion-list-title" style="padding-bottom:30px;">MEMBERSHIP REGISTRATION</div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="name">Name:</label>
        <div class="col-sm-9">
            <input class="form-control" name="name" id="name" 
                   type="text" required /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="address">Address:</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="address" id="address"
                      cols="25" rows="4" ></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="country">Country:</label>
        <div class="col-sm-9">
            <input class="form-control" name="country" id="country" type="text" />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="phone">Phone:</label>
        <div class="col-sm-9">
            <input class="form-control" name="phone" id="phone" type="text" />
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="email">
            Email Address:</label>
        <div class="col-sm-9">
            <input class="form-control" name="email" id="email" 
                   type="email" required /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="password">
            Password:</label>
        <div class="col-sm-9">
            <input class="form-control" name="password" id="password" 
                   type="password" required /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="password2">
            Retype Password:</label>
        <div class="col-sm-9">
            <input class="form-control" name="password2" id="password2" 
                   type="password" required /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="pwdqn">Password Question:</label>
        <div class="col-sm-9">
            <input class="form-control" name="pwdqn" id="pwdqn" type="text" required /> (required)
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="answer">Answer:</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="answer" id="answer"
                      cols="25" rows="4" required></textarea> (required)
        </div>
    </div>
    <div class="form-group row">       
        <div class="col-sm-9 offset-sm-3">
            <button type="submit" class='btn btn-dark' id="cta-btn">Register</button>
        </div>
    </div>
</form>
</div>
<?php 
// Include the Page Layout footer
include("footer.php"); 
?>