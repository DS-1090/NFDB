<?php
header("Access-Control-Allow-Origin: *");
session_start();
$servername = "mysql"; // Use the MySQL service name defined in docker-compose.yml
$username = "my_user";
$password = "my_user_password";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = $conn->real_escape_string($_POST['fname']);
    $state = $conn->real_escape_string($_POST['states']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $telephone = $conn->real_escape_string($_POST['telephone']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['faddress']);
    $addressProofId = $conn->real_escape_string($_POST['addressProofId']);
    
    // Handle file upload
    $targetDir = "uploads/"; // Make sure this directory exists and is writable
    $photoFileName = basename($_FILES["photo-file-upload"]["name"]);
    $targetFilePath = $targetDir . $photoFileName;

    // Check if file is an image
    $check = getimagesize($_FILES["photo-file-upload"]["tmp_name"]);
    if($check === false) {
        die("File is not an image.");
    }

    // Upload file
    if (move_uploaded_file($_FILES["photo-file-upload"]["tmp_name"], $targetFilePath)) {
        // Prepare SQL statement
        $sql = "INSERT INTO step1 (fname, photo_file_path, state, gender, telephone, email, address, address_proof_id) 
                VALUES ('$fname', '$targetFilePath', '$state', '$gender', '$telephone', '$email', '$address', '$addressProofId')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>