<?php
$userName = isset($_GET['userName']) ? htmlspecialchars($_GET['userName']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Sign Up</h1>
    </header>
    <main>
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

            <!-- Hidden field to store the user's name -->
            <input type="hidden" id="userName" name="userName" value="<?php echo $userName; ?>">

            <button type="submit">Sign Up</button>
        </form>
    </main>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sign Up Successful! Welcome, <span id="userNameDisplay"></span>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script to show the modal if the userName field is set -->
    <script>
        const userName = document.getElementById('userName').value;
        if (userName) {
            document.getElementById('userNameDisplay').innerText = userName;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            document.getElementById('successModal').addEventListener('hidden.bs.modal', function () {
                window.location.href = 'login.php';
            });
        }
    </script>
</body>
</html>