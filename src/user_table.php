<?php
  $servername = "mysql"; // Use the MySQL service name defined in docker-compose.yml
  $username = "my_user";
  $password = "my_user_password";
  $dbname = "my_database";
  
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
  }
  $sql = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    aadhar VARCHAR(12) NOT NULL UNIQUE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>