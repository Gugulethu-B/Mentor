<?php
// Start the session
session_start();

// Check if the user is logged in and is a founder
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'founder') {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'dbconnect.php';

// Check if the founder has a profile
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM founders WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

$hasProfile = mysqli_num_rows($result) > 0;
$profileData = $hasProfile ? mysqli_fetch_assoc($result) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Founder Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
        <p>You are logged in as a Startup Founder / Small Business Owner.</p>
    </header>
    <main>
        <?php if (!$hasProfile): ?>
            <!-- Display profile creation prompt -->
            <div class="profile-prompt">
                <p>You haven't created your profile yet. Click the button below to get started.</p>
                <a href="Profiles/create_founder_profile.php"><button>Create Profile</button></a>
            </div>
        <?php else: ?>
            <!-- Display founder profile -->
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
                    <p><strong>Startup Name:</strong> <?php echo $profileData['startup_name']; ?></p>
                    <p><strong>Startup Website:</strong> <a href="<?php echo $profileData['startup_website']; ?>" target="_blank"><?php echo $profileData['startup_website']; ?></a></p>
                </div>
                <a href="Profiles/edit_founder_profile.php"><button>Edit Profile</button></a>
            </div>
        <?php endif; ?>

        <!-- Logout button -->
        <div class="logout-section">
            <a href="logout.php"><button>Log Out</button></a>
        </div>
    </main>
</body>
</html>