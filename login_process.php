<?php
// Include the database connection file
require_once 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user data from the database
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name, $hashed_password, $role);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // Start a session
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;

        // Redirect based on role
        if ($role == 'founder') {
            header("Location: founder_dashboard.php");
        } elseif ($role == 'mentor') {
            header("Location: mentor_dashboard.php");
        }
        exit();
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>