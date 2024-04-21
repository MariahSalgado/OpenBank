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

	$stmt = $conn->prepare("SELECT password FROM Customers WHERE username = ?");
	if (!$stmt) {
	    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	} else {
	    $stmt->bind_param("s", $uname);
	    $stmt->execute();
	    $stmt->store_result();
	    $stmt->bind_result($stored_password);
	    $stmt->fetch();

	    if ($stmt->num_rows == 1 && $password === $stored_password) {
	        $_SESSION['loggedin'] = true;
	        $_SESSION['username'] = $uname;

	        header("Location: dashboard.html");
	        exit();
	    } else {
	        echo "Wrong username or password";
	    }

	    $stmt->close();
	}
}
$conn->close();
?>

