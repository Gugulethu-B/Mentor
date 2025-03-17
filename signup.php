<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Sign Up</h1>
    </header>
    <main>
        <!-- Error Message -->
        <?php if (isset($_GET['error'])) { ?>
            <div class="error-message" style="color: red; margin-bottom: 10px;">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php } ?>

        <form action="signup_process.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="role">I am a:</label>
            <select id="role" name="role" required>
                <option value="founder">Startup Founder / Small Business Owner</option>
                <option value="mentor">Mentor / Investor</option>
            </select><br><br>

            <button type="submit">Sign Up</button>
        </form>
    </main>
</body>
</html>