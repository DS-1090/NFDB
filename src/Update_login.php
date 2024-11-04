<?php
header("Access-Control-Allow-Origin: *");
session_start();

$servername = "vendorsql";
$username = "my_user";
$password = "my_user_password";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    if (empty($email) || empty($password) || empty($re_password)) {
        echo "Please fill all the details.";
        exit;
    }

    if ($password !== $re_password) {
        echo "Password does not match.";
        exit;
    }
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        header("Location: http://127.0.0.1:5501/Vendor_Portal/user_home.html");
    } else {
        echo "Error updating password: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
