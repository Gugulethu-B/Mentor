<?php
// Start the session
session_start();

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once __DIR__ . '/../dbconnect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $industry = $_POST['industry'];
    $location = $_POST['location'];
    $skills = $_POST['skills'];
    $interests = $_POST['interests'];
    $linkedin_url = $_POST['linkedin_url'];
    $bio = $_POST['bio'];

    // Handle profile picture upload
    $profilePicture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            $profilePicture = $targetFile;
        }
    }

    // Insert profile data into the database
    $query = "INSERT INTO mentor_profiles (user_id, name, surname, industry, location, skills, interests, linkedin_url, bio, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssssss", $_SESSION['user_id'], $name, $surname, $industry, $location, $skills, $interests, $linkedin_url, $bio, $profilePicture);

    if ($stmt->execute()) {
        // Redirect to the mentor dashboard with a success message
        header("Location:mentor_dashboard.php?success=1");
        exit();
    } else {
        // Handle errors
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'create_mentor_profile.php';
              </script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Mentor Profile</title>
    <link rel="stylesheet" href="CSS/mentor.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Create Your Mentor Profile</h1>
    </header>
    <main>
        <form action="create_mentor_profile.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" required><br><br>

            <label for="industry">Industry:</label>
            <input type="text" id="industry" name="industry" required><br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required><br><br>

            <label for="skills">Skills:</label>
            <input type="text" id="skills" name="skills" required><br><br>

            <label for="interests">Interests:</label>
            <input type="text" id="interests" name="interests" required><br><br>

            <label for="linkedin_url">LinkedIn URL:</label>
            <input type="url" id="linkedin_url" name="linkedin_url"><br><br>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" required></textarea><br><br>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture"><br><br>

            <button type="submit" class="btn btn-primary">Create Profile</button>
        </form>

        
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>