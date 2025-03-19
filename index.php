<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startup Savvy - Networking Platform</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            color: #333;
        }

        h1, h2, h3 {
            margin: 0;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header */
        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(14, 173, 179, 0.8);
            color: white;
            padding: 10px 20px;
            text-align: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 50px; /* Adjust the height as needed */
            width: auto; /* Maintain aspect ratio */
        }

        .header-links {
            display: flex;
            gap: 20px;
            align-items: center; /* Align links vertically with the logo */
        }

        .header-links a {
            color: white;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .header-links a:hover {
            color: #007BFF;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            z-index: 2; /* Ensure hero content is above the background */
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .hero-buttons button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .hero-buttons button:hover {
            background-color: #0056b3;
        }

        /* Scrolling Background */
        .background-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 300%; /* Adjust for three images */
            height: 100vh; /* Full viewport height */
            display: flex;
            animation: slide 30s linear infinite; /* Adjust duration for speed */
            z-index: 1; /* Ensure background is behind content */
        }

        .background-image {
            width: 33.3333%; /* Divide width for three images */
            height: 100%; /* Full height of the container */
            background-size: cover;
            background-repeat: no-repeat;
            /* Add linear gradient overlay */
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
        }

        @keyframes slide {
            0% { transform: translateX(0); }
            100% { transform: translateX(-66.6666%); } /* Move two images to the left */
        }

        .image1 { 
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                       url('uploads/image2.jpg') no-repeat center center/cover;
        }
        .image2 { 
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                       url('uploads/coop.jpg') no-repeat center center/cover;
        }
        .image3 { 
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                       url('uploads/image1.jpg') no-repeat center center/cover;
        }

        /* About Section */
        .about {
            padding: 60px 20px;
            background-color: #f9f9f9;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure content is above the background */
        }

        .about h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .about p {
            font-size: 1rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Features Section */
        .features {
            padding: 60px 20px;
            background-color: white;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure content is above the background */
        }

        .features h2 {
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 60px 20px;
            background-color: #f9f9f9;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure content is above the background */
        }

        .testimonials h2 {
            font-size: 2rem;
            margin-bottom: 40px;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial-card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .testimonial-card p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .testimonial-card span {
            font-weight: bold;
            color: #007BFF;
        }

        /* Footer */
        footer {
            background-color: lightblue;
            color: white;
            padding: 40px 20px;
            text-align: center;
            position: relative;
            z-index: 2; /* Ensure content is above the background */
        }

        footer a {
            color: #007BFF;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .footer-links {
            margin-bottom: 20px;
        }

        .footer-links a {
            margin: 0 10px;
        }

        .social-media {
            margin-top: 20px;
        }

        .social-media a {
            margin: 0 10px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <!-- Top Header -->
    <div class="top-header">
        <!-- Logo -->
        <img src="/Networking/uploads/logo.png" alt="Startup Connect Logo" class="logo">
        <!-- Header Links -->
        <div class="header-links">
            <a href="#">Home</a>
            <a href="#about">About Us</a>
            <a href="#features">Services</a>
            <a href="#testimonials">Testimonials</a>
        </div>
    </div>

    <!-- Scrolling Background -->
    <div class="background-container">
        <div class="background-image image1"></div>
        <div class="background-image image2"></div>
        <div class="background-image image3"></div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Welcome to StartupSavvy</h1>
            <p>Your gateway to mentorship, networking, and collaboration.</p>
            <div class="hero-buttons">
                <a href="signup.php"><button>Sign Up</button></a>
                <a href="login.php"><button>Log In</button></a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <h2>About Us</h2>
        <p>
            StartupSavvy is a platform designed to bring together founders, mentors, and investors. 
            Whether you're looking for guidance, partnerships, or funding, we're here to help you succeed.
        </p>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <h2>Services</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>Mentorship</h3>
                <p>Connect with experienced mentors who can guide you through your startup journey.</p>
            </div>
            <div class="feature-card">
                <h3>Networking</h3>
                <p>Build meaningful connections with like-minded entrepreneurs and investors.</p>
            </div>
            <div class="feature-card">
                <h3>Resources</h3>
                <p>Access a library of resources to help you grow your startup.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
        <h2> Testimonials</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p>"StartupSavvy helped me find the perfect mentor for my business. Highly recommended!"</p>
                <span>- John Doe</span>
            </div>
            <div class="testimonial-card">
                <p>"The networking opportunities here are unmatched. I've met so many amazing people!"</p>
                <span>- Jane Smith</span>
            </div>
            <div class="testimonial-card">
                <p>"The resources available on this platform are invaluable for any startup founder."</p>
                <span>- Mike Johnson</span>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="social-media">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">LinkedIn</a>
        </div>
        <p>&copy; 2025 StartupSavvy. All rights reserved.</p>
    </footer>
</body>
</html>