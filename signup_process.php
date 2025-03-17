<?php
// Include the database connection file
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role']; // Get the selected role

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        // Display a success message as a pop-up and redirect to the login page
        echo "<script>
                alert('Sign Up Successful! Welcome, $name.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'signup.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>