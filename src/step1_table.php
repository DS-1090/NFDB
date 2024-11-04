<?php
header("Access-Control-Allow-Origin: *");

// Database connection parameters
$servername = "mysql"; // Use the MySQL service name defined in docker-compose.yml
$username = "my_user";
$password = "my_user_password";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create the table
$sql_step1 = "CREATE TABLE IF NOT EXISTS step1 (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    applicant_photo LONGBLOB NOT NULL,
    state VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    telephone_number VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    address_proof_id_number VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
// Execute the query
if ($conn->query($sql_step1 ) === TRUE) {
    echo "Table 'step1' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>