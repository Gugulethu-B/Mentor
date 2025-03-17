<?php
// Start the session
session_start();

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
        <p>You are logged in as a Mentor / Investor.</p>
    </header>
    <main>
        <a href="logout.php"><button>Log Out</button></a>
    </main>
</body>
</html>