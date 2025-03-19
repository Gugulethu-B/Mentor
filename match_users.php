<?php
// Start the session
session_start();

// Include the database connection file
require_once 'dbconnect.php';

// Fetch the logged-in user's profile
$loggedInUserId = $_SESSION['user_id'];
$loggedInUserRole = $_SESSION['role'];

// Fetch the logged-in user's details from the appropriate table
if ($loggedInUserRole === 'founder') {
    $query = "SELECT f.*, u.name, u.surname FROM founders f
              JOIN users u ON f.user_id = u.id
              WHERE f.user_id = ?";
} elseif ($loggedInUserRole === 'mentor') {
    $query = "SELECT m.*, u.name, u.surname FROM mentor_profiles m
              JOIN users u ON m.user_id = u.id
              WHERE m.user_id = ?";
}
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();
$loggedInUser = $result->fetch_assoc();
$stmt->close();

// Fetch all other users based on the logged-in user's role
if ($loggedInUserRole === 'founder') {
    $query = "SELECT m.*, u.name, u.surname FROM mentor_profiles m
              JOIN users u ON m.user_id = u.id";
} elseif ($loggedInUserRole === 'mentor') {
    $query = "SELECT f.*, u.name, u.surname FROM founders f
              JOIN users u ON f.user_id = u.id";
}
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$allUsers = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Define weights for matching criteria
$weights = [
    'industry' => 20,
    'location' => 15,
    'skills' => 5,
    'interests' => 5,
];

// Calculate match scores
$matches = [];
foreach ($allUsers as $user) {
    $matchScore = 0;

    // Industry match
    if ($user['industry'] === $loggedInUser['industry']) {
        $matchScore += $weights['industry'];
    } elseif (isRelatedIndustry($user['industry'], $loggedInUser['industry'])) {
        $matchScore += $weights['industry'] / 2;
    }

    // Location match
    if ($user['location'] === $loggedInUser['location']) {
        $matchScore += $weights['location'];
    } elseif (isNearbyLocation($user['location'], $loggedInUser['location'])) {
        $matchScore += $weights['location'] / 2;
    }

    // Skills match
    $loggedInUserSkills = explode(',', $loggedInUser['skills']);
    $userSkills = explode(',', $user['skills']);
    $commonSkills = array_intersect($loggedInUserSkills, $userSkills);
    $matchScore += count($commonSkills) * $weights['skills'];

    // Interests match
    $loggedInUserInterests = explode(',', $loggedInUser['interests']);
    $userInterests = explode(',', $user['interests']);
    $commonInterests = array_intersect($loggedInUserInterests, $userInterests);
    $matchScore += count($commonInterests) * $weights['interests'];

    // Add match to the list if score is above threshold
    if ($matchScore >= 30) {
        $matches[] = [
            'user_id' => $user['user_id'],
            'name' => $user['name'],
            'surname' => $user['surname'],
            'role' => ($loggedInUserRole === 'founder') ? 'mentor' : 'founder',
            'match_score' => $matchScore,
        ];
    }
}

// Sort matches by score (highest first)
usort($matches, function ($a, $b) {
    return $b['match_score'] - $a['match_score'];
});

// Store matches in the database
foreach ($matches as $match) {
    // Check if the match already exists
    $checkQuery = "SELECT * FROM matches WHERE (user_id_1 = ? AND user_id_2 = ?) OR (user_id_1 = ? AND user_id_2 = ?)";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("iiii", $loggedInUserId, $match['user_id'], $match['user_id'], $loggedInUserId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    // If the match does not exist, insert it
    if ($checkResult->num_rows === 0) {
        $insertQuery = "INSERT INTO matches (user_id_1, user_id_2, match_score) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("iii", $loggedInUserId, $match['user_id'], $match['match_score']);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $checkStmt->close();
}

// Helper functions
function isRelatedIndustry($industry1, $industry2) {
    // Define related industries (e.g., tech and software are related)
    $relatedIndustries = [
        'tech' => ['software', 'hardware', 'AI'],
        'healthcare' => ['biotech', 'pharma'],
    ];
    return in_array($industry2, $relatedIndustries[$industry1] ?? []);
}

function isNearbyLocation($location1, $location2) {
    // Define nearby locations (e.g., same country or region)
    $nearbyLocations = [
        'New York' => ['New Jersey', 'Connecticut'],
        'London' => ['Manchester', 'Birmingham'],
    ];
    return in_array($location2, $nearbyLocations[$location1] ?? []);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Matches</title>
    <link rel="stylesheet" href="\Networking\CSS\mentor.css">
</head>
<body>
    <h1>Your Matches</h1>
    <div class="matches-container">
        <?php if (!empty($matches)): ?>
            <?php foreach ($matches as $match): ?>
                <div class="match-card">
                    <h2><?php echo $match['name'] . ' ' . $match['surname']; ?></h2>
                    <p><strong>Role:</strong> <?php echo $match['role']; ?></p>
                    <p><strong>Match Score:</strong> <?php echo $match['match_score']; ?></p>
                    <a href="/Networking/profile.php?user_id=<?php echo $match['user_id']; ?>" class="btn btn-primary">View Profile</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No matches found. Try updating your profile to improve matches.</p>
        <?php endif; ?>
    </div>
</body>
</html>