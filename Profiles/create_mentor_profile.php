<?php
session_start();
require_once __DIR__ . '/../dbconnect.php'; // Include database connection

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header("Location: ../login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $linkedin_url = $_POST['linkedin_url'];
    $bio = $_POST['bio'];
    $user_id = $_SESSION['user_id'];

    // Insert data into the mentor_profiles table
    $sql = "INSERT INTO mentor_profiles (user_id, name, surname, industry, location, skills, interests, linkedin_url, bio)
            VALUES ('$user_id', '$name', '$surname', '$industry', '$location', '$skills', '$interests', '$linkedin_url', '$bio')";

    if (mysqli_query($conn, $sql)) {
        echo "Profile created successfully!";
        header("Location: ../mentor_dashboard.php"); // Redirect to mentor dashboard
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
    <title>Create Mentor Profile</title>
    <link rel="stylesheet" href="../styles.css">
    <style>/* General styles */
/* General styles */
/* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Wider container */
.container {
    max-width: 900px; /* Increased width */
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #007BFF;
    text-align: center;
    margin-bottom: 20px;
}

/* Form grid layout */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Two columns */
    gap: 20px; /* Space between fields */
}

/* Full-width fields */
.form-group.full-width {
    grid-column: span 3; /* Span across both columns */
}

/* Form group styles */
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group input[type="text"],
.form-group input[type="url"],
.form-group textarea {
    width: 50%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

/* Button styles */
.btn {
    display: inline-block;
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}</style>
</head>
<body>
<div class="container">
    <h2>Create Mentor Profile</h2>
    <form action="create_mentor_profile.php" method="post" class="form-grid">
        <!-- Side-by-side fields -->
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

        <!-- Full-width fields -->
        <div class="form-group full-width">
            <label for="skills">Skills:</label>
            <textarea id="skills" name="skills" rows="3" required></textarea>
        </div>
        <div class="form-group full-width">
            <label for="interests">Interests:</label>
            <textarea id="interests" name="interests" rows="3" required></textarea>
        </div>
        <div class="form-group full-width">
            <label for="linkedin_url">LinkedIn URL:</label>
            <input type="url" id="linkedin_url" name="linkedin_url">
        </div>
        <div class="form-group full-width">
            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="5" required></textarea>
        </div>

        <!-- Submit button -->
        <div class="form-group full-width">
            <button type="submit" class="btn">Create Profile</button>
        </div>
    </form>
</div>
    </form>
</div>
</body>
</html>