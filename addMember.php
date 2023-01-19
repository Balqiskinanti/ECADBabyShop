<?php
session_start();

include_once("mySQLConn.php");

$name = $_POST["name"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);


$query = "SELECT * FROM Shopper WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result1 = $stmt->get_result();
$stmt->close();

if ($result1->num_rows === 0) {
    $qry ="INSERT INTO Shopper (Name, Address, Country, Phone, Email, Password)
       VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($qry);
$stmt->bind_param("ssssss", $name, $address, $country, $phone, $email, $password);

if ($stmt->execute()) {

    $qry = "SELECT LAST_INSERT_ID() AS ShopperID";
    $result = $conn->query($qry);
    while ($row = $result->fetch_array()) {
        $_SESSION["ShopperID"] = $row["ShopperID"];
    }

    $Message = "Registration successful!<br />
                You are now logged in!<br />";
    $_SESSION["ShopperName"] = $name;
}
else{
    $Message = "<h3 style='color:red'>Error in inserting</h3>";
}

}

else{
    
    echo '<script type="text/javascript">
    alert("Email typed in has been registered before, please login instead or choose Forget Password on the login page if you have forgotten your password");location="http://localhost/ECADBabyShop/register.php";</script>'; 


//echo "Email typed in has been registered before, please login instead or choose Forget Password on the login page if you have forgotten your password";
//header("Location: index.php");
}



include("./Pages/Shared/header.php");
echo $Message;
include("./Pages/Shared/footer.php");

$stmt->close();
$conn->close();


?>