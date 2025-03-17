<?php
// Start the session
session_start();

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
// Include the database connection file
require_once __DIR__ . '/../dbconnect.php';


// Fetch mentor profile data
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM mentor_profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
$stmt->close();

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
    $profilePicture = $profile['profile_picture']; // Keep existing picture by default
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
            $profilePicture = $targetFile;
        }
    }

    // Update profile data in the database
    $query = "UPDATE mentor_profiles SET name = ?, surname = ?, industry = ?, location = ?, skills = ?, interests = ?, linkedin_url = ?, bio = ?, profile_picture = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssi", $name, $surname, $industry, $location, $skills, $interests, $linkedin_url, $bio, $profilePicture, $userId);

    if ($stmt->execute()) {
        // Redirect to the mentor dashboard with a success message
        header("Location: /Networking/mentor_dashboard.php?success=1");
        exit();
    }
     else {
        // Handle errors
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href = 'edit_mentor_profile.php';
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
    <title>Edit Mentor Profile</title>
    <link rel="stylesheet" href="/Networking/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Edit Your Mentor Profile</h1>
    </header>
    <main>
        <form action="edit_mentor_profile.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $profile['name']; ?>" required><br><br>

            <label for="surname">Surname:</label>
            <input type="text" id="surname" name="surname" value="<?php echo $profile['surname']; ?>" required><br><br>

            <label for="industry">Industry:</label>
            <input type="text" id="industry" name="industry" value="<?php echo $profile['industry']; ?>" required><br><br>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $profile['location']; ?>" required><br><br>

            <label for="skills">Skills:</label>
            <input type="text" id="skills" name="skills" value="<?php echo $profile['skills']; ?>" required><br><br>

            <label for="interests">Interests:</label>
            <input type="text" id="interests" name="interests" value="<?php echo $profile['interests']; ?>" required><br><br>

            <label for="linkedin_url">LinkedIn URL:</label>
            <input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo $profile['linkedin_url']; ?>"><br><br>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" required><?php echo $profile['bio']; ?></textarea><br><br>

            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture"><br><br>

            <?php if ($profile['profile_picture']) { ?>
    <p>Current Profile Picture:</p>
    <img src="/Networking/<?php echo $profile['profile_picture']; ?>" alt="Profile Picture" width="150"><br><br>
<?php } ?>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>