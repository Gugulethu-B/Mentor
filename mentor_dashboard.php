<?php
// Start the session
session_start();

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'dbconnect.php';

// Check if the mentor has a profile
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM mentor_profiles WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

$hasProfile = mysqli_num_rows($result) > 0;
$profileData = $hasProfile ? mysqli_fetch_assoc($result) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
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

        .profile-prompt, .profile-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-prompt p {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .profile-prompt button, .profile-section button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .profile-prompt button:hover, .profile-section button:hover {
            background-color: #0056b3;
        }

        .profile-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #007BFF;
        }

        .profile-details p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .profile-details strong {
            color: #007BFF;
        }

        .profile-details a {
            color: #007BFF;
            text-decoration: none;
        }

        .profile-details a:hover {
            text-decoration: underline;
        }

        .btn-primary {
            display: block;
            width: fit-content;
            margin: 20px auto;
            background-color: #007BFF;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
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
        <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
        <p>You are logged in as a Mentor.</p>
    </header>
    <main>
        <?php if (!$hasProfile): ?>
            <!-- Display profile creation prompt -->
            <div class="profile-prompt">
                <p>You haven't created your profile yet. Click the button below to get started.</p>
                <a href="Profiles/create_mentor_profile.php"><button>Create Profile</button></a>
            </div>
        <?php else: ?>
            <!-- Display mentor profile -->
            <div class="profile-section">
                <h2>Your Profile</h2>
                <div class="profile-details">
                    <p><strong>Name:</strong> <?php echo $profileData['name'] . ' ' . $profileData['surname']; ?></p>
                    <p><strong>Industry:</strong> <?php echo $profileData['industry']; ?></p>
                    <p><strong>Location:</strong> <?php echo $profileData['location']; ?></p>
                    <p><strong>Skills:</strong> <?php echo $profileData['skills']; ?></p>
                    <p><strong>Interests:</strong> <?php echo $profileData['interests']; ?></p>
                    <p><strong>LinkedIn:</strong> <a href="<?php echo $profileData['linkedin_url']; ?>" target="_blank"><?php echo $profileData['linkedin_url']; ?></a></p>
                    <p><strong>Bio:</strong> <?php echo $profileData['bio']; ?></p>
                </div>
                <a href="Profiles/edit_mentor_profile.php"><button>Edit Profile</button></a>
            </div>
        <?php endif; ?>
        <a href="/Networking/match_users.php" class="btn btn-primary">Find Matches</a>
        <!-- Logout button -->
        <div class="logout-section">
            <a href="logout.php"><button>Log Out</button></a>
        </div>
    </main>
</body>
</html>