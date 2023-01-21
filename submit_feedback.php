<?php
session_start();

include_once("mySQLConn.php");

$shopperID = $_POST["shopperID"];
$subject = $_POST["subject"];
$rating = $_POST["rating"];
$feedback = $_POST["feedback"];

$stmt = $conn->prepare("INSERT INTO feedback (ShopperID, Subject, Content, Rank) VALUES (?, ?, ?, ?)");
$stmt->bind_param("issi",$shopperID, $subject, $feedback, $rating);

if ($stmt->execute()) {
    $Message = "Feedback submitted successfully.";
}
else{
    $Message = "Error: " . $stmt->error;
}

include("header.php");
echo $Message;
include("footer.php");

$stmt->close();
$conn->close();
?>