<?php

echo "Today is " . date("Y-m-d") . "<br>";
echo "Today is " . date("Y-m-d h:i:s") . "<br>";
$normal = date ( 'Y-m-j' , strtotime ( '+6 day' ) );
$express = date ( 'Y-m-j' , strtotime ( '+6 weekdays' ) );
echo $normal;
echo $express;
$now = new DateTime('now');
echo "Today is " . $now . "<br>";

?>