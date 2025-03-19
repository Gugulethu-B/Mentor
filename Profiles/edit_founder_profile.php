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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        header {
            background-color: lightblue;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.2rem;
        }

        .profile-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #007BFF;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #007BFF;
        }

        .form-group input[type="text"],
        .form-group input[type="url"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .logout-section {
            text-align: center;
            margin-top: 20px;
        }

        .logout-section button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-section button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Founder Profile</h1>
        <p>Update your profile information below.</p>
    </header>
    <main>
        <div class="profile-section">
            <h2>Edit Profile</h2>
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
        <!-- Logout button -->
        <div class="logout-section">
            <a href="logout.php"><button>Log Out</button></a>
        </div>
    </main>
</body>
</html>