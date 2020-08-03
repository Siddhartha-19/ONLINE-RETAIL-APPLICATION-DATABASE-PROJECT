<!DOCTYPE html>
<html>
	<body>
		<?php
		$customerid= filter_input(INPUT_POST, 'customerid');
		$amount=filter_input(INPUT_POST, 'amount');
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
			echo "HI CUSTOMER $customerid";
			echo "your bill $amount";
			$sql = "SELECT * FROM PAYMENT WHERE customerid='$customerid'";
		$result = mysqli_query($conn,$sql);

		if (mysqli_num_rows($result)>0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)){
		    	echo "";
		        echo "$amount " . $row["customerid"] . $row["card_no"] . $row["bank_name"] ."<br>";
		?>
		        ENTER CVV:<input type="password" name="cvv">
		<?php
		    }
		}
		else
		{
			echo "ADD CARD";
		?>
			<form action="payments.php" method="post">
				card_no<input type="text" name="card_no">
				bank_name<input type="text" name="bank_name">
				CVV<input type="password" name="CVV">
				<input type="hidden" name = "customerid" value="<?php echo $customerid ?>">
				<input type="submit" name="submit" value="submit">
			</form>
		<?php
			$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
			if (mysqli_connect_error()){
			die('Connect Error ('. mysqli_connect_errno() .') '
			. mysqli_connect_error());
			}
			$Cardno= filter_input(INPUT_POST, 'card_no');
			$bankname= filter_input(INPUT_POST, 'bank_name');
			$cvv= filter_input(INPUT_POST,'CVV');
			$customerid= filter_input(INPUT_POST, 'customerid');
			$sql="INSERT INTO PAYMENT(customerid,card_no,cvv,bank_name) values ('$customerid','$Cardno',$cvv,'$bankname')";
		}
		}
		?>

