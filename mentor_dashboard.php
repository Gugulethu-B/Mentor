<?php
// Start the session
session_start();

// Check if the user is logged in and is a mentor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mentor') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once 'dbconnect.php';

// Fetch mentor profile data
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM mentor_profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <link rel="stylesheet" href="\Networking\CSS\mentor.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?>!</h1>
        <p>You are logged in as a Mentor / Investor.</p>
    </header>
    <main>
    <?php if ($profile) { ?>
    <!-- Display profile information -->
    <div class="profile-container">
        <h2>Your Profile</h2>
        <!-- Profile Picture Frame -->
        <div class="profile-picture-frame">
            <?php if ($profile['profile_picture']) { ?>
                <img src="/Networking/<?php echo $profile['profile_picture']; ?>" alt="Profile Picture">
            <?php } else { ?>
                <span>No Image</span>
            <?php } ?>
            <label for="profile-picture-upload">Upload Photo</label>
            <input type="file" id="profile-picture-upload" name="profile_picture" accept="image/*">
        </div>
        <p><strong>Name:</strong> <?php echo $profile['name']; ?></p>
        <p><strong>Surname:</strong> <?php echo $profile['surname']; ?></p>
        <p><strong>Industry:</strong> <?php echo $profile['industry']; ?></p>
        <p><strong>Location:</strong> <?php echo $profile['location']; ?></p>
        <p><strong>Skills:</strong> <?php echo $profile['skills']; ?></p>
        <p><strong>Interests:</strong> <?php echo $profile['interests']; ?></p>
        <p><strong>LinkedIn:</strong> <a href="<?php echo $profile['linkedin_url']; ?>" target="_blank"><?php echo $profile['linkedin_url']; ?></a></p>
        <p><strong>Bio:</strong> <?php echo $profile['bio']; ?></p>
        <br><br>
    </div>
<?php } ?>
        <br>
        <div class="button-container">
    <a href="/Networking/Profiles/edit_mentor_profile.php" class="btn btn-primary">Edit Profile</a>
    <a href="logout.php" class="btn btn-danger">Log Out</a>
</div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>