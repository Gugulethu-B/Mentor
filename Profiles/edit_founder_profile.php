<?php
// Start the session
session_start();

// Check if the user is logged in and is a founder
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: ../login.php");
    exit();
}

// Include database connection
include '../dbconnect.php';

// Fetch the founder's current profile data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM founders WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Profile not found.");
}

$profileData = mysqli_fetch_assoc($result);

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
    $startup_name = $_POST['startup_name'];
    $startup_website = $_POST['startup_website'];

    // Update the profile in the database
    $sql = "UPDATE founders SET
            name = '$name',
            surname = '$surname',
            industry = '$industry',
            location = '$location',
            skills = '$skills',
            interests = '$interests',
            linkedin_url = '$linkedin_url',
            bio = '$bio',
            startup_name = '$startup_name',
            startup_website = '$startup_website'
            WHERE user_id = $user_id";

    if (mysqli_query($conn, $sql)) {
        echo "Profile updated successfully!";
        header("Location: ../founder_dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Founder Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Founder Profile</h2>
        <form action="edit_founder_profile.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $profileData['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" value="<?php echo $profileData['surname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="industry">Industry:</label>
                <input type="text" id="industry" name="industry" value="<?php echo $profileData['industry']; ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo $profileData['location']; ?>" required>
            </div>
            <div class="form-group">
                <label for="skills">Skills:</label>
                <textarea id="skills" name="skills" rows="3" required><?php echo $profileData['skills']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="interests">Interests:</label>
                <textarea id="interests" name="interests" rows="3" required><?php echo $profileData['interests']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="linkedin_url">LinkedIn URL:</label>
                <input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo $profileData['linkedin_url']; ?>">
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" rows="5" required><?php echo $profileData['bio']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="startup_name">Startup Name:</label>
                <input type="text" id="startup_name" name="startup_name" value="<?php echo $profileData['startup_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="startup_website">Startup Website:</label>
                <input type="url" id="startup_website" name="startup_website" value="<?php echo $profileData['startup_website']; ?>">
            </div>
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
</body>
</html>