<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Log In</h1>
    </header>
    <main>
        <form action="login_process.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Log In</button>
        </form>
    </main>
</body>
</html>