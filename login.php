<?php
$username= filter_input(INPUT_POST, 'username');
$customerid= filter_input(INPUT_POST, 'customerid');
$password= filter_input(INPUT_POST, 'password');
if (!empty($username)){
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "shop";
// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
if (mysqli_connect_error()){
die('Connect Error ('. mysqli_connect_errno() .') '
. mysqli_connect_error());
}
else{
$sql = "SELECT CUSTOMERID FROM CUSTOMER WHERE userid='$username' and pasword='$password' and customerid='$customerid'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)>0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)){
        echo "HI CUSTOMER" . $row["CUSTOMERID"] ."<br>";
    }
}

else{
echo "login failed";
echo "please login";
}
$conn->close();
}
}
else{
echo "userid should not be empty";
die();
}
?>
<!DOCTYPE html>
<html>
	<body>
	<table border="1px" style="color:blue;">
	<tr>
	<th>sl_no</th>
	<th>INAME</th>
	<th>price</th>
	</tr>
	<?php
	$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
	$sql="SELECT * FROM ITEMS";
	$result=mysqli_query($conn,$sql);
	if (mysqli_num_rows($result)>0){
		echo "Price per unit quantity";
		while($row=mysqli_fetch_assoc($result)){
			echo "<tr><td>".$row["item_no"]."</td><td>".$row["iname"]."</td><td>".$row["price_in_Rs"]."</td></tr>";
		}
	}
	?>
	</table>
		<form action="login.php" method="post" >
		"Items:"<input type="text" name="item">
		"Quantity"<input type="number" name="quantity">
		<input type="hidden" name = "customerid" value="<?php echo $customerid ?>">
		<input type="hidden" name = "username" value="<?php echo $username ?>">
		<input type="hidden" name = "password" value="<?php echo $password ?>">
		<input type="submit" value= "add_item">
		</form>
		<?php
		$item_name= filter_input(INPUT_POST, 'item');
		$quantity= filter_input(INPUT_POST, 'quantity');
		$customerid= filter_input(INPUT_POST, 'customerid');
		$price_in_Rs=0;
		$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
		if (mysqli_connect_error()){
		die('Connect Error ('. mysqli_connect_errno() .') '
		. mysqli_connect_error());
		}
		else{
			$sql="SELECT price_in_Rs FROM items WHERE iname='$item_name' ";
			$result=mysqli_query($conn,$sql);
			if (mysqli_num_rows($result)>0){
				while($row=mysqli_fetch_assoc($result)){
					$price_in_Rs=$row["price_in_Rs"];
					$price_in_Rs=$price_in_Rs*$quantity;
				}
			}
			$sql = "INSERT INTO o_details (customerid,item_name,quantity,price) values ('$customerid','$item_name','$quantity','$price_in_Rs')";
			if ($conn->query($sql)){
			echo "added sucessfully";
			}
		}
		?>
		<table border="1px" style="color:blue;">
			<tr>
			<th>ITEM</th>
			<th>QUANTITY</th>
			<th>PRICE</th>
			</tr>
			<?php
			$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
			$sql="SELECT * FROM o_details where customerid='$customerid'";
			$result=mysqli_query($conn,$sql);
			if (mysqli_num_rows($result)>0){
				echo "<br>"."Your's Order";
				while($row=mysqli_fetch_assoc($result)){
					echo "<tr><td>".$row["item_name"]."</td><td>".$row["quantity"]."</td><td>".$row["price"]."</td></tr>";
				}
			}
			?>
			<tr>
				<td colspan="2">Total Amount</td>
					<?php
						$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
						$sql="SELECT SUM(PRICE) FROM o_details where customerid='$customerid'";
						$result=mysqli_query($conn,$sql);
						if (mysqli_num_rows($result)){
							while($row=mysqli_fetch_assoc($result)){
								$amount=$row["SUM(PRICE)"];
								echo "<td>".$row["SUM(PRICE)"]."</td>";
							}
						}
					  ?>
			</tr>
		</table>
		<form action="payments.php" method="post">
			<input type="hidden" name = "customerid" value="<?php echo $customerid ?>">
			<input type="hidden" name = "amount" value="<?php echo $amount ?>">
			<input type="submit" name="submit" value="Go For Payment">
		</form>
		<form action="customer.html">
			<input type="submit" name="submit" value="logout" style="size: 40px;align-items: center;">
		</form>
	</body>
</html>