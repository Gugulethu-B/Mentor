<?php
// Include the database connection file
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role']; // Get the selected role

    // Check if the email already exists
    $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);

    if (!$checkStmt) {
        die("Prepare failed: " . $conn->error);
    }

    $checkStmt->bind_param("s", $email);

    if (!$checkStmt->execute()) {
        die("Execute failed: " . $checkStmt->error);
    }

    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Email already exists
        echo "<script>
                alert('This email is already registered. Please use a different email.');
                window.location.href = 'signup.php';
              </script>";
    } else {
        // Email does not exist, proceed with sign-up
        $insertQuery = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);

        if (!$insertStmt) {
            die("Prepare failed: " . $conn->error);
        }

        $insertStmt->bind_param("ssss", $name, $email, $password, $role);

        if ($insertStmt->execute()) {
            // Redirect back to signup.php with the user's name
            header("Location: signup.php?userName=" . urlencode($name));
            exit();
        } else {
            // Handle other errors
            echo "<script>
                    alert('Error: " . $insertStmt->error . "');
                    window.location.href = 'signup.php';
                  </script>";
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>