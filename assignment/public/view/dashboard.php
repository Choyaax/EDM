<?php
session_start();
require_once '../../src/auth_check.php';
requireLogin();

// Display session data for debugging
echo "<h2>Debug Information</h2>";
echo "<p>Session data:</p>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

// Check if the user is logged in
if (!isLoggedIn()) {
    echo "<p style='color: red;'>User not logged in. Redirecting to login page...</p>";
    header('Location: login.php');
    exit();
}

echo "<p style='color: green;'>User is logged in. Proceeding to display dashboard.</p>";

$username = $_SESSION['username'] ?? 'Unknown User';
echo "<h1>Welcome, " . htmlspecialchars($username) . "!</h1>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }
        header {
            background: #35424a;
            color: white;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }
        header a {
            color: #ffffff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header .logout {
            float: right;
            margin-top: 10px;
        }
        header .logout a {
            background: #e8491d;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .dashboard-content {
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Welcome to Your Dashboard</h1>
            <div class="logout">
                <a href="login.php">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-content">
            <h2>Hello, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Your session details:</p>
            <pre><?php print_r($_SESSION); ?></pre>
            <p>Your choices are:</p>
            <ul>
                <li>NIGGA 1</li>
                <li>NIGGA 2</li>
                <li>NIGGA 3</li>
            </ul>
        </div>
    </div>

    <script>
    console.log('Dashboard loaded. Session data:', <?php echo json_encode($_SESSION); ?>);
    </script>
</body>
</html>
