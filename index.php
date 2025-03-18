<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Networking Platform</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center content vertically */
    align-items: center; /* Center content horizontally */
    height: 100vh; /* Full viewport height */
}

.top-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color:black; /* Semi-transparent black */
    color: white;
    padding: 10px 20px;
    text-align: center;
    z-index: 3; /* Ensure it's above everything */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); /* Add a subtle shadow */
}

header {
    text-align: center;
    z-index: 2; /* Bring header above background images */
}

h1, p {
    color: black;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

main {
    display: flex;
    justify-content: center;
    gap: 10px;
    z-index: 2; /* Bring buttons above background images */
    margin-top: 20px; /* Space between header and buttons */
}

button {
    background-color:grey;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: darkgrey;
}

.background-container {
    position: absolute;
    top: 100px; /* Start below the header (adjust based on header height) */
    left: 0;
    width: 300%; /* Adjust for three images */
    height: calc(100vh - 60px); /* Full viewport height minus header height */
    display: flex;
    animation: slide 30s linear infinite; /* Adjust duration for speed */
    z-index: 1; /* Ensure background is behind content */
}

.background-image {
    width: 33.3333%; /* Divide width for three images */
    height: 100%; /* Full height of the container */
    background-size: cover;
    background-repeat: no-repeat;
}

@keyframes slide {
    0% { transform: translateX(0); }
    100% { transform: translateX(-66.6666%); } /* Move two images to the left */
}

.image1 { background-image: url('uploads/image2.jpg'); }
.image2 { background-image: url('uploads/coop.jpg'); }
.image3 { background-image: url('uploads/image1.jpg'); }
    </style>
</head>
<body>
    <div class="top-header">
        <h2>Startup Connect</h2>
    </div>
    <div class="background-container">
        <div class="background-image image1"></div>
        <div class="background-image image2"></div>
        <div class="background-image image3"></div>
    </div>
    <header>
        <h1>Welcome to the Networking Platform!</h1>
        <p>Connect with mentors, investors, and collaborators.</p>
    </header>
    <main>
        <a href="signup.php"><button>Sign Up</button></a>
        <a href="login.php"><button>Log In</button></a>
    </main>
</body>
</html>