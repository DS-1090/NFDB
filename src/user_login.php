<?php
header("Access-Control-Allow-Origin: *");
session_start();
$servername = "mysql"; // Use the MySQL service name defined in docker-compose.yml
$username = "my_user";
$password = "my_user_password";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email_login'];
    $password = $_POST['Password_Login'];

    if (empty($email) || empty($password)) {
        echo "Email and password are required.";
        exit;
    }

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo "No user found with that email.";
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->bind_result($id, $db_email, $db_password);
    $stmt->fetch();
    if (password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $email;
        header("Location: http://127.0.0.1:5500/src/user_application_new_step1.html");
        exit;
    } else {
        echo "Invalid password.";
    }

    $stmt->close();
   }

$conn->close();
?>
