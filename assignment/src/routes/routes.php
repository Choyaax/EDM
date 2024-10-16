<?php
session_start();
include_once('../static/query.php'); 
include_once('../controller/database.php');
include_once('../controller/userController.php'); 
include_once('../auth_check.php');

// Generate a CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CSRF protection for POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit();
    }
}

if (isset($_POST['type'])) {
    $ctr = new userController();
    
    switch ($_POST['type']) {
        case 'register':
            if (isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email'])) {
                // Proceed with registration logic
                $registrationResult = $ctr->register($_POST['user'], $_POST['pass'], $_POST['email']);
                echo $registrationResult; // Return the registration result
            } else {
                echo json_encode(['success' => false, 'message' => 'Missing registration information']);
            }
            break;

        case 'login':
            if (isset($_POST['user']) && isset($_POST['pass'])) {
                // Log the login attempt
                debug_log("Attempting to log in with username: " . $_POST['user']);
                
                $loginResult = $ctr->login($_POST['user'], $_POST['pass']);
                $result = json_decode($loginResult, true);
                
                if (isset($result['success']) && $result['success']) {
                    // Set session variables
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['username'] = $_POST['user'];
                    $_SESSION['loggedin'] = true;

                    debug_log("User logged in: " . $_POST['user']);
                    
                    // Redirect to dashboard
                    header("Location: /xampp/assignment/public/view/dashboard.php");
                    exit();
                } else {
                    debug_log("Login failed: " . $result['message']);
                    echo json_encode($result);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Missing username or password']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid request type']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No request type specified']);
}

// Generate a new CSRF token for the next request
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
