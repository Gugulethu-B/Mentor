<?php
session_start();
require_once __DIR__ . '/../dbconnect.php';// Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $linkedin_url = $_POST['linkedin_url'];
    $bio = $_POST['bio'];
    $startup_name = $_POST['startup_name'];
    $startup_website = $_POST['startup_website'];
    $user_id = $_SESSION['user_id'];

    // Insert data into the founders table
    $sql = "INSERT INTO founders (user_id, name, surname, industry, location, skills, interests, linkedin_url, bio, startup_name, startup_website)
            VALUES ('$user_id', '$name', '$surname', '$industry', '$location', '$skills', '$interests', '$linkedin_url', '$bio', '$startup_name', '$startup_website')";

    if (mysqli_query($conn, $sql)) {
        echo "Profile created successfully!";
        header("Location: ../founder_dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Founder Profile</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="container">
        <h2>Create Founder Profile</h2>
        <form action="create_founder_profile.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <label for="industry">Industry:</label>
                <input type="text" id="industry" name="industry" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills:</label>
                <textarea id="skills" name="skills" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="interests">Interests:</label>
                <textarea id="interests" name="interests" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="linkedin_url">LinkedIn URL:</label>
                <input type="url" id="linkedin_url" name="linkedin_url">
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="startup_name">Startup Name:</label>
                <input type="text" id="startup_name" name="startup_name" required>
            </div>
            <div class="form-group">
                <label for="startup_website">Startup Website:</label>
                <input type="url" id="startup_website" name="startup_website">
            </div>
            <button type="submit" class="btn">Create Profile</button>
        </form>
    </div>
</body>
</html>