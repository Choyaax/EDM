<?php

require_once '../src/controller/userController.php';

$uri = $_SERVER['REQUEST_URI'];

$controller = new UserController();

switch ($uri) {
    case '/register':
        $result = $controller->register();
        break;
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->login();
            if ($result === 200) {
                // Redirect to a dashboard or home page after successful login
                header('Location: /dashboard');
                exit;
            } else {
                // Handle login errors
                $error = "Login failed. Please try again.";
            }
        }
        // Display login form for GET requests
        include 'view/login.php';
        break;
    case '/dashboard':
        // Add logic to check if user is logged in
        // If not, redirect to login page
        // If yes, display dashboard
        break;
    // Add other routes here 
    
    default:
        // Handle 404 Not Found
        break;
}
