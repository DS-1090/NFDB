<?php
  header("Access-Control-Allow-Origin: *");
  $servername = "mysql"; // Use the MySQL service name defined in docker-compose.yml
  $username = "my_user";
  $password = "my_user_password";
  $dbname = "my_database";
  
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['mail']) ? filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL) : '';
    $password = isset($_POST['text']) ? htmlspecialchars($_POST['text']) : '';
    $aadhar = isset($_POST['aadhar']) ? htmlspecialchars($_POST['aadhar']) : '';
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password) && !empty($aadhar)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (email, password, aadhar) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $aadhar);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid input data. Please check your entries.";
    }
} else {
    echo "Invalid request method.";
}

   $conn->close();
?>