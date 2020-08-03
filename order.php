<?php
$item_name= filter_input(INPUT_POST, 'item');
$quantity= filter_input(INPUT_POST, 'quantity');
$customerid= filter_input(INPUT_POST, 'customerid');
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "shop";
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()){
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
	$sql = "INSERT INTO o_details (customerid,item_name,quantity) values ('$customerid','$item_name','$quantity')";
if ($conn->query($sql)){
echo "added sucessfully";
}
}
?>

