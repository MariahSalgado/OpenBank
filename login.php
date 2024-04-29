<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$conn = new mysqli('localhost', 'Basic', '9173', 'banking');

if ($conn->connect_error) {
	die('Connection failed: ' . $conn->connect_error);
}

echo 'Connection established';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$uname = $conn->real_escape_string($_POST['uname']);
	$password = $conn->real_escape_string($_POST['password']);

	$stmt = $conn->prepare("SELECT CustomerID, password FROM Customers WHERE username = ?");
	if (!$stmt) {
	    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	} else {
	    $stmt->bind_param("s", $uname);
	    $stmt->execute();
	    $stmt->store_result();

	    if ($stmt->num_rows == 1) {
		$stmt->bind_result($customer_id, $stored_password);
		$stmt->fetch();

		if ($password === $stored_password) {
	        	$_SESSION['loggedin'] = true;
			$_SESSION['customer_id'] = $customer_id;
	        	$_SESSION['username'] = $uname;

	        	header("Location: dashboard.php");
	        	exit();
	    	} else {
	        	echo "Wrong username or password";
	    	}
	} else {
		echo "No such user exists";
}

	    $stmt->close();
	}
}

$conn->close();
?>

